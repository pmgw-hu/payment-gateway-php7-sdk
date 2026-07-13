<?php

namespace Nevogate\Tests\PaymentGateway\Data;

use Nevogate\PaymentGateway\Data\Wallet;

class WalletTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @test
	 * @dataProvider dataProviderFor_parameterTest
	 * @param $testData
	 * @param $method
	 * @param $variableName
	 */
	public function parameterSetTest($testData, $method, $variableName)
	{
		$wallet = new Wallet();
		$result = $wallet->$method($testData);

		$this->assertInstanceOf(get_class($wallet), $result);
		$this->assertArrayHasKey($variableName, $wallet->getUcFirstData());
		$this->assertEquals($testData, $wallet->getUcFirstData()[$variableName]);
	}

	/**
	 * @return array
	 */
	public function dataProviderFor_parameterTest()
	{
		return array(
			array(Wallet::TYPE_APPLE_PAY, 'setType', 'Type'),
			array(Wallet::TYPE_GOOGLE_PAY, 'setType', 'Type'),
			array(Wallet::ENVIRONMENT_WEB, 'setEnvironment', 'Environment'),
			array('https://apple-pay-gateway.apple.com/paymentservices/startSession', 'setValidationUrl', 'ValidationUrl'),
			array('https://demo.nevogate.com', 'setShopUrl', 'ShopUrl'),
			array('google-token', 'setGooglePayToken', 'GooglePayToken'),
			array('apple-token', 'setApplePayToken', 'ApplePayToken'),
			array('buyer@example.com', 'setPayerEmailAddress', 'PayerEmailAddress'),
		);
	}

	/**
	 * @test
	 * @expectedException \Nevogate\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setType_invalid()
	{
		(new Wallet())->setType('invalid');
	}

	/**
	 * @test
	 * @expectedException \Nevogate\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setEnvironment_invalid()
	{
		(new Wallet())->setEnvironment('invalid');
	}

	/**
	 * @test
	 */
	public function setValidationUrl_invalidUrl()
	{
		$this->expectException(\Nevogate\PaymentGateway\Exception\PaymentGatewayException::class);
		(new Wallet())->setValidationUrl('invalidUrl');
	}

	/**
	 * @test
	 */
	public function setShopUrl_invalidUrl()
	{
		$this->expectException(\Nevogate\PaymentGateway\Exception\PaymentGatewayException::class);
		(new Wallet())->setShopUrl('invalidUrl');
	}
}
