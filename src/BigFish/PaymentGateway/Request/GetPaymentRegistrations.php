<?php

namespace BigFish\PaymentGateway\Request;


class GetPaymentRegistrations extends InitBaseAbstract
{
	const REQUEST_TYPE = 'GetPaymentRegistrations';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param string $userId
	 * @return $this
	 */
	public function setUserId(string $userId): self
	{
		return $this->setData($userId, 'userId');
	}

	/**
	 * @param string $paymentRegistrationType
	 * @return $this
	 */
	public function setPaymentRegistrationType(string $paymentRegistrationType): self
	{
		return $this->setData($paymentRegistrationType, 'paymentRegistrationType');
	}
}
