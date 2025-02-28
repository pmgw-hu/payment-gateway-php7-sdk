<?php

namespace BigFish\PaymentGateway\Transport;

use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Config;
use BigFish\PaymentGateway\Exception\PaymentGatewayException;
use BigFish\PaymentGateway\Request\Close;
use BigFish\PaymentGateway\Request\Refund;
use BigFish\PaymentGateway\Request\RequestInterface;
use BigFish\PaymentGateway\Transport\Response\ResponseInterface;
use BigFish\PaymentGateway\Transport\Response\Response;

class SystemTransport
{
	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * TransportInterface constructor.
	 * @param Config $config
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Get user agent string
	 *
	 * @param $method string
	 * @return string
	 * @access private
	 * @static
	 */
	protected function getUserAgent(string $method): string
	{
		return sprintf('%s | %s | %s | %s', $method, $this->getHttpHost(), 'PHP', phpversion());
	}

	/**
	 * @return string
	 */
	protected function getHttpHost(): string
	{
		return $_SERVER['HTTP_HOST'] ?? function_exists('php_uname') ? php_uname('n') : 'localhost';
	}

	/**
	 * @param RequestInterface $request
	 */
	protected function prepareRequest(RequestInterface $request)
	{
		if (
			$request instanceof PaymentGateway\Request\InitAbstract ||
			$request instanceof PaymentGateway\Request\Providers ||
			$request instanceof PaymentGateway\Request\OneClickOptions ||
			$request instanceof PaymentGateway\Request\GetPaymentRegistrations ||
			$request instanceof PaymentGateway\Request\OneClickTokenCancelAll ||
			$request instanceof PaymentGateway\Request\CancelAllPaymentRegistrations ||
			$request instanceof PaymentGateway\Request\Settlement ||
			$request instanceof PaymentGateway\Request\SettlementRefund
		) {
			$request->setStoreName($this->config->getStoreName());
		}

		if ($request instanceof PaymentGateway\Request\Init) {
			$request->setEncryptKey($this->config->getEncryptPublicKey());
			$request->setExtra();
		}
	}

	/**
	 * @param ResponseInterface $response
	 */
	protected function convertOutResponse(ResponseInterface $response)
	{
		$charset = $this->config->getOutCharset();
		if ($charset != Config::CHARSET_UTF8) {
			$response->convert($charset);
		}
	}

	/**
	 * @param RequestInterface $request
	 * @return ResponseInterface
	 * @throws PaymentGatewayException
	 */
	public function sendRequest(RequestInterface $request): ResponseInterface
	{
		if (!function_exists('curl_init')) {
			throw new PaymentGatewayException('cURL PHP module is not loaded');
		}

		$url = $this->config->getUrl() . '/api/payment/';

		$this->prepareRequest($request);

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, [$this->getAuthorizationHeader()]);
		curl_setopt($curl, CURLOPT_REFERER, $this->getHttpHost());
		curl_setopt($curl, CURLOPT_MAXREDIRS, 4);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$this->setTimeout($request, $curl);

		$postData = [
			'method' => $request->getMethod(),
			'json' => $this->prepareData($request),
		];

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->getUserAgent($request->getMethod()));

        if ($this->config->debugCommunication) {
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        }

		if ($this->config->getGatewayProxy() != '') {
			curl_setopt($curl, CURLOPT_PROXY, $this->config->getGatewayProxy());
		}

		$httpResponse = curl_exec($curl);

		if ($httpResponse === false) {
			$exception = new PaymentGatewayException(sprintf('Communication error: %s', curl_error($curl)));
			curl_close($curl);
			throw $exception;
		}

        $sdkDebugInfo = [];

        if ($this->config->debugCommunication) {
            $sdkDebugInfo = array(
                'curl_getinfo' => curl_getinfo($curl),
                'post_data' => $postData
            );
        }

		curl_close($curl);

		$response = Response::createFromJson($httpResponse);
        if (count($sdkDebugInfo) > 0) {
            $response->setSdkDebugInfo($sdkDebugInfo);
        }
		$this->convertOutResponse($response);
		return $response;
	}

	protected function getAuthorizationHeader(): string
	{
		return 'Authorization: Basic ' . base64_encode($this->config->getStoreName() . ':' . $this->config->getApiKey());
	}

	protected function prepareData(RequestInterface $requestInterface): string
	{
		return json_encode($requestInterface->getUcFirstData());
	}

	/**
	 * @param RequestInterface $requestInterface
	 * @param $curl
	 */
	protected function setTimeout(RequestInterface $requestInterface, $curl)
	{
		if (
			$requestInterface->getMethod() == Close::REQUEST_TYPE ||
			$requestInterface->getMethod() == Refund::REQUEST_TYPE
		) {
			// OTPay close and refund (extra timeout)
			curl_setopt($curl, CURLOPT_TIMEOUT, 600);
			return;
		}

		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	}
}
