<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\OneClickTokenCancelAll;
use BigFish\PaymentGateway\Request\RequestInterface;

class OneClickTokenCancelAllTest extends CancelAllPaymentRegistrationsTest
{

	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new OneClickTokenCancelAll())->setProviderName(PaymentGateway::PROVIDER_BORGUN2)->setUserId('14741');
	}
}
