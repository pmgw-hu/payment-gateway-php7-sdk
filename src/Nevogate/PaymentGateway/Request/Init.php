<?php

namespace Nevogate\PaymentGateway\Request;

class Init extends InitCommonAbstract
{
	use SzepCardTrait;

	const REQUEST_TYPE = 'Init';

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
}
