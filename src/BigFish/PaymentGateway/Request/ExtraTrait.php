<?php

namespace BigFish\PaymentGateway\Request;


use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Exception\PaymentGatewayException;

trait ExtraTrait
{
	/**
	 * Extra data
	 *
	 * @var string
	 * @access public
	 */
	public $extra;

	/**
	 * @var string
	 */
	protected $encryptPublicKey;

	/**
	 * @param array $extra
	 * @return $this
	 */
	public function setExtra(array $extra = []): self
	{
		$providerName = (string)($this->data['providerName'] ?? '');

		if (in_array($providerName, PaymentGateway::$oneClickProviders) && isset($this->data['oneClickForcedRegistration'])) {
			$extra['oneClickForcedRegistration'] = true;
		}

		if (!empty($extra)) {
			$this->data['extra'] = $this->urlSafeEncode(json_encode($extra));
		}

		$this->removeSensitiveInformation($providerName);

		return $this;
	}

	protected function getPaymentPageProperty(): bool
	{
		if (property_exists($this, 'data')) {
			return $this->data['gatewayPaymentPage'] ?? false;
		}

		return false;
	}

	/**
	 * @param array $data
	 * @return bool
	 * @throws PaymentGatewayException
	 *
	 * @deprecated deprecated since version 3.18.1
	 */
	protected function encryptExtra(array $data = []): bool
	{
		if (!function_exists('openssl_public_encrypt')) {
			throw new PaymentGatewayException('OpenSSL PHP module is not loaded');
		}

		$encrypted = null;

		$extra = serialize($data);
		$result = openssl_public_encrypt($extra, $encrypted, $this->encryptPublicKey);
		$this->data['extra'] = $this->urlSafeEncode($encrypted);
		return $result;
	}

	/**
	 * @param string $encryptPublicKey
	 * @return $this
	 */
	public function setEncryptKey(string $encryptPublicKey): self
	{
		$this->encryptPublicKey = $encryptPublicKey;
		return $this;
	}

	/**
	 * @param $providerName
	 */
	protected function removeSensitiveInformation(string $providerName)
	{
		if (!($providerName == PaymentGateway::PROVIDER_OTP && !empty($this->data['otpCardPocketId']))) {
			unset($this->data['otpCardPocketId']);
		}

		if (!(in_array($providerName, PaymentGateway::$oneClickProviders) && isset($this->data['oneClickPayment']))) {
			unset($this->data['oneClickPayment']);
		}

		if (!(in_array($providerName, PaymentGateway::$oneClickProviders) && isset($this->data['oneClickReferenceId']))) {
			unset($this->data['oneClickReferenceId']);
		}

		if (isset($this->data['oneClickForcedRegistration'])) {
			unset($this->data['oneClickForcedRegistration']);
		}

		if (!(in_array($providerName, PaymentGateway::$oneClickProviders) && isset($this->data['paymentRegistration']))) {
			unset($this->data['paymentRegistration']);
		}

		if (!(in_array($providerName, PaymentGateway::$oneClickProviders) && isset($this->data['paymentRegistrationType']))) {
			unset($this->data['paymentRegistrationType']);
		}

		if (!(in_array($providerName, PaymentGateway::$oneClickProviders) && isset($this->data['referenceTransactionId']))) {
			unset($this->data['referenceTransactionId']);
		}

		unset($this->data['otpCardNumber']);
		unset($this->data['otpExpiration']);
		unset($this->data['otpCvc']);
		unset($this->data['otpConsumerRegistrationId']);
		unset($this->data['mkbSzepCardNumber']);
		unset($this->data['mkbSzepCvv']);
	}
}