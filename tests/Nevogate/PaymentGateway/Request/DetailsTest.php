<?php

namespace Nevogate\Tests\PaymentGateway\Request;

use Nevogate\PaymentGateway\Request\Details;
use Nevogate\PaymentGateway\Request\RequestInterface;

class DetailsTest extends SimpleTransactionRequestAbstract
{
	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new Details())->setTransactionId($transactionId)->setGetRelatedTransactions(false)->setGetInfoData(true)->setGetPaymentAttributes(false);
	}

	protected function getDataKeys(): array
	{
		$result = parent::getDataKeys();
		$result['getRelatedTransactions'] = false;
		$result['getInfoData'] = true;
		$result['getPaymentAttributes'] = false;

		return $result;
	}
}
