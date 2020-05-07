<?php

namespace BigFish\PaymentGateway\Request;

use BigFish\PaymentGateway\Exception\PaymentGatewayException;

class PaymentLinkCreate extends InitAbstract
{
	use ExtraTrait, SzepCardTrait;

	const REQUEST_TYPE = 'PaymentLinkCreate';

	const INFO_FORM_PRODUCT = 'product';

	const INFO_FORM_SERVICE = 'service';

	public function __construct()
	{
		parent::__construct();
		$this->setEmailNotificationOnlySuccess(false);
	}

	/**
	 * Allow to start multiple transaction at the same time
	 *
	 * @param bool $multipleTransactions
	 * @return $this
	 */
	public function setMultipleTransactions(bool $multipleTransactions): self
	{
		return $this->setData($multipleTransactions, 'multipleTransactions');
	}

	/**
	 * Set payment transaction amount
	 *
	 * @param float $amount Transaction amount
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setAmount(float $amount): InitAbstract
	{
		parent::setAmount($amount);

		$this->setData(null, 'minimumAmount');
		$this->setData(null, 'maximumAmount');

		return $this;
	}

	/**
	 * Set payment transaction flexible amount
	 *
	 * @param float $minimumAmount Transaction minimum amount
	 * @param float|null $maximumAmount Transaction maximum amount
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setFlexibleAmount(float $minimumAmount, ?float $maximumAmount = null): self
	{
		if ($minimumAmount <= 0) {
			throw new PaymentGatewayException('Only positive numbers allowed.');
		}

		if ($maximumAmount !== null && $maximumAmount <= $minimumAmount) {
			throw new PaymentGatewayException('Maximum amount must be greater than minimum amount');
		}

		$this->setData(null, 'amount');
		$this->setData($minimumAmount, 'minimumAmount');
		$this->setData($maximumAmount, 'maximumAmount');

		return $this;
	}

	/**
	 * @param string $notificationEmail
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setNotificationEmail(string $notificationEmail): self
	{
		if (filter_var($notificationEmail, FILTER_VALIDATE_EMAIL) === false) {
			throw new PaymentGatewayException('Invalid notification email');
		}

		return $this->setData($notificationEmail, 'notificationEmail');
	}

	/**
	 * @param bool $emailNotificationOnlySuccess
	 * @return $this
	 */
	public function setEmailNotificationOnlySuccess(bool $emailNotificationOnlySuccess): self
	{
		return $this->setData($emailNotificationOnlySuccess, 'emailNotificationOnlySuccess');
	}

	/**
	 * @param string $expirationTime
	 * @return $this
	 */
	public function setExpirationTime(string $expirationTime): self
	{
		return $this->setData($expirationTime, 'expirationTime');
	}

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
	 * Set information form
	 *
	 * @param string $infoForm
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setInfoForm(string $infoForm): self
	{
		if (!in_array($infoForm, [static::INFO_FORM_PRODUCT, static::INFO_FORM_SERVICE], true)) {
			throw new PaymentGatewayException('Invalid information form');
		}

		return $this->setData($infoForm, 'infoForm');
	}

	/**
	 * Set general terms and conditions url
	 *
	 * @param string $gtcUrl
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setGtcUrl(string $gtcUrl): self
	{
		if (filter_var($gtcUrl, FILTER_VALIDATE_URL) === false) {
			throw new PaymentGatewayException('Invalid general terms and conditions url');
		}

		return $this->setData($gtcUrl, 'gtcUrl');
	}

	/**
	 * Set privacy policy url
	 *
	 * @param string $privacyPolicyUrl
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setPrivacyPolicyUrl(string $privacyPolicyUrl): self
	{
		if (filter_var($privacyPolicyUrl, FILTER_VALIDATE_URL) === false) {
			throw new PaymentGatewayException('Invalid privacy policy url');
		}

		return $this->setData($privacyPolicyUrl, 'privacyPolicyUrl');
	}

	/**
	 * Set redirect url
	 *
	 * @param string $redirectUrl
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setRedirectUrl(string $redirectUrl): self
	{
		if (filter_var($redirectUrl, FILTER_VALIDATE_URL) === false) {
			throw new PaymentGatewayException('Invalid redirect url');
		}

		return $this->setData($redirectUrl, 'redirectUrl');
	}
}
