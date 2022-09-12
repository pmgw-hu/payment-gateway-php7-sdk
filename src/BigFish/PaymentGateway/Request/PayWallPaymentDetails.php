<?php

namespace BigFish\PaymentGateway\Request;

class PayWallPaymentDetails extends RequestAbstract
{
	const REQUEST_TYPE = 'PayWallPaymentDetails';

	/**
	 * @param string $paywallPaymentName
	 * @return $this
	 */
	public function setPaywallPaymentName(string $paywallPaymentName): self
	{
		return $this->setData($paywallPaymentName, 'paywallPaymentName');
	}

	/**
	 * @param bool $getTransactions Get transactions (true/false)
	 * @return $this
	 */
	public function setGetTransactions(bool $getTransactions): self
	{
		return $this->setData($getTransactions, 'getTransactions');
	}
}
