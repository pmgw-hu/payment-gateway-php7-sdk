<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway\Request\Cancel;
use BigFish\PaymentGateway\Request\RequestInterface;

class CancelTest extends SimpleTransactionRequestAbstract
{
	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new Cancel())->setTransactionId($transactionId);
	}
}
