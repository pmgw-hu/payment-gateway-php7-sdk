<?php

namespace Nevogate\Tests\PaymentGateway\Request;

use Nevogate\PaymentGateway\Data\Wallet;
use Nevogate\PaymentGateway\Request\InitWallet;

class InitWalletTest extends InitTest
{
	protected function getRequest()
	{
		return new InitWallet();
	}

	/**
	 * @test
	 */
	public function requestType()
	{
		$this->assertEquals('InitWallet', (new InitWallet())->getMethod());
	}

	/**
	 * @test
	 */
	public function setWallet()
	{
		$wallet = (new Wallet())
			->setType(Wallet::TYPE_GOOGLE_PAY)
			->setEnvironment(Wallet::ENVIRONMENT_WEB)
			->setGooglePayToken('google-token')
			->setPayerEmailAddress('buyer@example.com');

		$request = (new InitWallet())->setWallet($wallet);

		$this->assertEquals($wallet->getUcFirstData(), $request->getData()['wallet']);
	}
}
