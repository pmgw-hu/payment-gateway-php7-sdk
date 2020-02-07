<?php

namespace BigFish\Tests\PaymentGateway\Request;

use BigFish\PaymentGateway\Request\Refund;
use BigFish\PaymentGateway\Request\RequestInterface;

class RefundTest extends SimpleTransactionRequestAbstract
{
	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new Refund())->setTransactionId($transactionId)->setAmount(1000)->setExtra(array('test' => 'foo'));
	}

	protected function getDataKeys(): array
	{
		$result = parent::getDataKeys();
		$result['amount'] = 1000;
		$result['extra'] = 'eyJ0ZXN0IjoiZm9vIn0.';
		return $result;
	}
}
