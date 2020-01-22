<?php

namespace BigFish\Tests\PaymentGateway\Request;

use BigFish\PaymentGateway\Request\Refund;
use BigFish\PaymentGateway\Request\RequestInterface;

class RefundTest extends SimpleTransactionRequestAbstract
{
	protected function getRequest(string $transactionId): RequestInterface
	{
		$refund = (new Refund())->setTransactionId($transactionId)->setAmount(1000);
		$refund->setExtra(array('test' => 'foo'));
		return $refund;
	}

	protected function getDataKeys(): array
	{
		$result = parent::getDataKeys();
		$result['amount'] = 1000;
		$result['extra'] = $this->urlSafeEncode(json_encode(array('test' => 'foo')));
		return $result;
	}
}
