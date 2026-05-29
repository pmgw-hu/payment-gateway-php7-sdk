<?php

namespace Nevogate\Tests\PaymentGateway\Request;


use Nevogate\PaymentGateway\Request\CompleteWallet;
use Nevogate\PaymentGateway\Request\RequestInterface;

class CompleteWalletTest extends SimpleTransactionRequestAbstract
{
	protected function getRequest(string $transactionId): RequestInterface
	{
		return (new CompleteWallet())
			->setTransactionId($transactionId)
			->setWalletAuthenticationResult('authenticated')
			->setWalletAuthenticationMessage('3DS authentication succeeded');
	}

	protected function getDataKeys(): array
	{
		$result = parent::getDataKeys();
		$result['walletAuthenticationResult'] = 'authenticated';
		$result['walletAuthenticationMessage'] = '3DS authentication succeeded';
		return $result;
	}
}
