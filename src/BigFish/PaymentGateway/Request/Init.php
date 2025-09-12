<?php

namespace BigFish\PaymentGateway\Request;

use BigFish\PaymentGateway\Exception\PaymentGatewayException;

class Init extends InitAbstract
{
	use ExtraTrait, SzepCardTrait;

	const REQUEST_TYPE = 'Init';

	/**
	 * Set payment transaction amount
	 *
	 * @param float $amount Transaction amount
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setAmount(float $amount): InitAbstract
	{
		if ($amount < 0) {
			throw new PaymentGatewayException('Only positive or zero numbers allowed.');
		}
		return $this->setData($amount, 'amount');
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
	 * @param string $mppPhoneNumber
	 * @return $this
	 */
	public function setMppPhoneNumber(string $mppPhoneNumber): self
	{
		return $this->setData($mppPhoneNumber, 'mppPhoneNumber');
	}

	/**
	 * @param string $otpCardNumber
	 * @return $this
	 */
	public function setOtpCardNumber(string $otpCardNumber): self
	{
		return $this->setData($otpCardNumber, 'otpCardNumber');
	}

	/**
	 * @param string $otpExpiration
	 * @return $this
	 */
	public function setOtpExpiration(string $otpExpiration): self
	{
		return $this->setData($otpExpiration, 'otpExpiration');
	}

	/**
	 * @param string $otpCvc
	 * @return $this
	 */
	public function setOtpCvc(string $otpCvc): self
	{
		return $this->setData($otpCvc, 'otpCvc');
	}

	/**
	 * @param string $otpConsumerRegistrationId
	 * @return $this
	 */
	public function setOtpConsumerRegistrationId(string $otpConsumerRegistrationId): self
	{
		return $this->setData($otpConsumerRegistrationId, 'otpConsumerRegistrationId');
	}

	public function setOneClickPayment(): self
	{
		return $this->setData(true, 'oneClickPayment');
	}

	/**
	 * @return $this
	 */
	public function setOneClickForcedRegistration(): self
	{
		return $this->setData(true, 'oneClickForcedRegistration');
	}

	/**
	 * @param string $oneClickReferenceId
	 * @return $this
	 */
	public function setOneClickReferenceId(string $oneClickReferenceId): self
	{
		return $this->setData($oneClickReferenceId, 'oneClickReferenceId');
	}

	/**
	 * @param bool | null $paymentRegistration
	 * @return $this
	 */
	public function setPaymentRegistration($paymentRegistration = true): self
	{
		$paymentRegistration = is_null($paymentRegistration) ? null : (int)filter_var($paymentRegistration, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

		return $this->setData($paymentRegistration, 'paymentRegistration');
	}

	/**
	 * @param string $paymentRegistrationType
	 * @return $this
	 */
	public function setPaymentRegistrationType(string $paymentRegistrationType): self
	{
		return $this->setData($paymentRegistrationType, 'paymentRegistrationType');
	}

	/**
	 * @param string $referenceTransactionId
	 * @return $this
	 */
	public function setReferenceTransactionId(string $referenceTransactionId): self
	{
		return $this->setData($referenceTransactionId, 'referenceTransactionId');
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
	 * Card data handling on BIG FISH Payment Gateway payment page or Merchant website
	 * Works with MKBSZEP provider
	 *
	 * @param boolean $gatewayPaymentPage true or false
	 * @return $this
	 * @access public
	 */
	public function setGatewayPaymentPage(bool $gatewayPaymentPage): self
	{
		return $this->setData($gatewayPaymentPage, 'gatewayPaymentPage');
	}

	/**
	 * @param array $paymentMethods
	 * @return $this
	 */
	public function setPaymentMethods(array $paymentMethods): self
	{
		return $this->setData($paymentMethods, 'paymentMethods');
	}
}
