<?php

namespace BigFish\PaymentGateway\Request;

use BigFish\PaymentGateway\Exception\PaymentGatewayException;

class PayWallPaymentUpdate extends RequestAbstract
{
	const REQUEST_TYPE = 'PayWallPaymentUpdate';

	/**
	 * @param string $paywallPaymentName
	 * @return $this
	 */
	public function setPaywallPaymentName(string $paywallPaymentName):self
	{
		return $this->setData($paywallPaymentName, 'paywallPaymentName');
	}

	/**
	 * @param float $amount
	 * @return $this
	 */
	public function setAmount(float $amount): self
	{
		if ($amount <= 0) {
			throw new PaymentGatewayException('Only positive numbers allowed.');
		}
		return $this->setData($amount, 'amount');
	}
}
