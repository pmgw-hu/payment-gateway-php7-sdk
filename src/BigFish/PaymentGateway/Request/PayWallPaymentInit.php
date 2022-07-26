<?php

namespace BigFish\PaymentGateway\Request;

use BigFish\PaymentGateway\Data\PayWallSettings;
use BigFish\PaymentGateway\Data\PayWallStoreSettings;
use BigFish\PaymentGateway\Exception\PaymentGatewayException;

class PayWallPaymentInit extends InitAbstract
{
	const REQUEST_TYPE = 'PayWallPaymentInit';

	/**
	 * @param string $notificationUrl
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setNotificationUrl(string $notificationUrl): self
	{
		if (filter_var($notificationUrl, FILTER_VALIDATE_URL) === false) {
			throw new PaymentGatewayException('Invalid notification url');
		}

		return $this->setData($notificationUrl, 'notificationUrl');
	}

	/**
	 * @param string $cancelUrl
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setCancelUrl(string $cancelUrl): self
	{
		if (filter_var($cancelUrl, FILTER_VALIDATE_URL) === false) {
			throw new PaymentGatewayException('Invalid cancel url');
		}

		return $this->setData($cancelUrl, 'cancelUrl');
	}


	/**
	 * @param string $language
	 * @return $this
	 */
	public function setLanguage(string $language): self
	{
		return $this->setData($language, 'language');
	}

	/**
	 * @param bool $autoCommit
	 * @return $this
	 */
	public function setAutoCommit(bool $autoCommit = true): self
	{
		return $this->setData($autoCommit ? 'true' : 'false', 'autoCommit');
	}

	/**
	 * @param PayWallSettings $settings
	 * @return $this
	 */
	public function setSettings(PayWallSettings $settings): self
	{
		return $this->setData($this->urlSafeEncode(json_encode($settings->getData())), 'settings');
	}

	/**
	 * @param PayWallStoreSettings $storeSettings
	 * @return $this
	 */
	public function setStoreSettings(PayWallStoreSettings $storeSettings): self
	{
		return $this->setData($this->urlSafeEncode(json_encode($storeSettings->getData())), 'storeSettings');
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function setExtra(array $data): self
	{
		return $this->setData($this->urlSafeEncode(json_encode($data)), 'extra');
	}
}
