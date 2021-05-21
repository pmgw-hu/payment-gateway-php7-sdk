<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\CancelAllPaymentRegistrations;
use BigFish\PaymentGateway\Request\RequestInterface;

class CancelAllPaymentRegistrationsTest extends OneClickTokenCancelAllTest
{

	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new CancelAllPaymentRegistrations())->setProviderName(PaymentGateway::PROVIDER_BORGUN2)->setUserId('14741');
	}
}
