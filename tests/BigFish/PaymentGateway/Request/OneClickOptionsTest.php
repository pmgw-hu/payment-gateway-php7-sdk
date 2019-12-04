<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\OneClickOptions;
use BigFish\PaymentGateway\Request\RequestInterface;

class OneClickOptionsTest extends SimpleTransactionRequestAbstract
{

	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new OneClickOptions())->setProviderName(PaymentGateway::PROVIDER_BORGUN2)->setUserId('12345');
	}

	protected function getDataKeys():array
	{
		return array(
			'providerName' => PaymentGateway::PROVIDER_BORGUN2,
			'userId' => '12345'
		);
	}
}
