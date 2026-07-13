<?php

namespace Nevogate\Tests\PaymentGateway\Request;

use Nevogate\PaymentGateway\Data\Wallet;
use Nevogate\PaymentGateway\Request\InitWallet;

class InitWalletTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @return array
	 */
	public function dataProviderFor_parameterTest()
	{
		return array(
			array('TestProvider', 'setProviderName'),
			array('http://test.hu', 'setResponseUrl'),
			array('http://test.hu', 'setNotificationUrl'),
			array(100, 'setAmount'),
			array(12345, 'setOrderId'),
			array(54321, 'setUserId'),
			array('EUR', 'setCurrency'),
			array('US', 'setLanguage'),
			array(true, 'setOneClickPayment'),
			array(true, 'setOneClickForcedRegistration'),
			array(true, 'setGatewayPaymentPage'),
			array('7612312312', 'setOneClickReferenceId'),
			array('something', 'setStoreName'),
		);
	}

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
	 * @dataProvider dataProviderFor_parameterTest
	 * @param $testData
	 * @param $method
	 */
	public function parameterSetTest($testData, $method)
	{
		$init = $this->getRequest();
		$result = $init->$method($testData);

		$variableName = lcfirst(substr($method, 3));

		$this->assertInstanceOf(get_class($init), $result);
		$this->assertArrayHasKey($variableName, $init->getData());
		$this->assertEquals($testData, $init->getData()[$variableName]);
	}

	/**
	 * @test
	 */
	public function setAutocommit_false()
	{
		$init = $this->getRequest();
		$result = $init->setAutoCommit(false);

		$this->assertInstanceOf(get_class($init), $result);
		$this->assertArrayHasKey('autoCommit', $init->getData());
		$this->assertEquals('false', $init->getData()['autoCommit']);
	}

	/**
	 * @test
	 */
	public function setMultipleParameterTest()
	{
		$init = $this->getRequest();
		$init->setAmount(10);
		$init->setCurrency('EUR');
		$init->setProviderName('test');

		$this->assertArraySubset(
			array(
				'amount' => 10,
				'currency' => 'EUR',
				'providerName' => 'test',
			),
			$init->getData()
		);
	}

	/**
	 * @test
	 */
	public function setAmount_isZero()
	{
		$amount = 0;

		$request = $this->getRequest();
		$request->setAmount($amount);
		$this->assertEquals($amount, $request->getData()['amount']);
	}

	/**
	 * @test
	 * @expectedException \Nevogate\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setNotificationUrl_invalidUrl()
	{
		$request = $this->getRequest();
		$request->setNotificationUrl('invalidUrl');
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
