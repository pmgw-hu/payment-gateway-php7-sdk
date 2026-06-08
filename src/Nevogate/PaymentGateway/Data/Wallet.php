<?php

namespace Nevogate\PaymentGateway\Data;

use Nevogate\PaymentGateway\Common\BaseAbstract;
use Nevogate\PaymentGateway\Exception\PaymentGatewayException;

class Wallet extends BaseAbstract
{
	const TYPE = 'type';
	const ENVIRONMENT = 'environment';
	const VALIDATION_URL = 'validationUrl';
	const SHOP_URL = 'shopUrl';
	const GOOGLE_PAY_TOKEN = 'googlePayToken';
	const APPLE_PAY_TOKEN = 'applePayToken';
	const PAYER_EMAIL_ADDRESS = 'payerEmailAddress';

	const TYPE_APPLE_PAY = 'apple_pay';
	const TYPE_GOOGLE_PAY = 'google_pay';
	const ENVIRONMENT_WEB = 'web';

	/**
	 * @throws PaymentGatewayException
	 */
	public function setType(string $type): self
	{
		if (!in_array($type, [self::TYPE_APPLE_PAY, self::TYPE_GOOGLE_PAY], true)) {
			throw new PaymentGatewayException('Invalid wallet type');
		}

		return $this->setData($type, self::TYPE);
	}

	/**
	 * @throws PaymentGatewayException
	 */
	public function setEnvironment(string $environment): self
	{
		if ($environment !== self::ENVIRONMENT_WEB) {
			throw new PaymentGatewayException('Invalid wallet environment');
		}

		return $this->setData($environment, self::ENVIRONMENT);
	}

	public function setValidationUrl(string $validationUrl): self
	{
		if (filter_var($validationUrl, FILTER_VALIDATE_URL) === false) {
			throw new PaymentGatewayException('Invalid validation url');
		}

		return $this->setData($validationUrl, self::VALIDATION_URL);
	}

	public function setShopUrl(string $shopUrl): self
	{
		if (filter_var($shopUrl, FILTER_VALIDATE_URL) === false) {
			throw new PaymentGatewayException('Invalid shop url');
		}

		return $this->setData($shopUrl, self::SHOP_URL);
	}

	public function setGooglePayToken(string $googlePayToken): self
	{
		return $this->setData($googlePayToken, self::GOOGLE_PAY_TOKEN);
	}

	public function setApplePayToken(string $applePayToken): self
	{
		return $this->setData($applePayToken, self::APPLE_PAY_TOKEN);
	}

	public function setPayerEmailAddress(string $payerEmailAddress): self
	{
		return $this->setData($payerEmailAddress, self::PAYER_EMAIL_ADDRESS);
	}

}
