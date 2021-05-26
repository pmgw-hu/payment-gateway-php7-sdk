<?php

namespace BigFish\PaymentGateway\Request;


class CancelAllPaymentRegistrations extends InitBaseAbstract
{
	const REQUEST_TYPE = 'CancelAllPaymentRegistrations';

	/**
	 * @param string $userId
	 * @return $this
	 */
	public function setUserId(string $userId): self
	{
		return $this->setData($userId, 'userId');
	}
}
