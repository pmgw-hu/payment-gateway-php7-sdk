<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway\Request\CancelPaymentRegistration;
use BigFish\PaymentGateway\Request\RequestInterface;

class CancelPaymentRegistrationTest extends SimpleTransactionRequestAbstract
{

	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new CancelPaymentRegistration())->setTransactionId($transactionId);
	}
}
