<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway\Request\Close;
use BigFish\PaymentGateway\Request\RequestInterface;

class CloseTest extends SimpleTransactionRequestAbstract
{
	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new Close())->setTransactionId($transactionId)->setApprove(true)->setApprovedAmount(1);
	}

	protected function getDataKeys(): array
	{
		$result = parent::getDataKeys();
		$result['approved'] = 'true';
		$result['approvedAmount'] = 1;
		return $result;
	}
}
