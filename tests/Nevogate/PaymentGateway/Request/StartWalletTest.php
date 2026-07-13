<?php

namespace Nevogate\Tests\PaymentGateway\Request;


use Nevogate\PaymentGateway\Request\RequestInterface;
use Nevogate\PaymentGateway\Request\StartWallet;

class StartWalletTest extends SimpleTransactionRequestAbstract
{
	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new StartWallet())->setTransactionId($transactionId);
	}
}
