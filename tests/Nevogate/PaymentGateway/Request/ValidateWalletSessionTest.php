<?php

namespace Nevogate\Tests\PaymentGateway\Request;

use Nevogate\PaymentGateway\Config;
use Nevogate\PaymentGateway\Data\Wallet;
use Nevogate\PaymentGateway\Request\ValidateWalletSession;
use Nevogate\PaymentGateway\Transport\SystemTransport;

class ValidateWalletSessionTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @return array
	 */
	public function dataProviderFor_parameterTest()
	{
		return array(
			array('Barion2', 'setProviderName'),
			array('HUF', 'setCurrency'),
			array('demo_store', 'setStoreName'),
			array(
				$this->getWallet(),
				'setWallet'
			),
		);
	}

	/**
	 * @return ValidateWalletSession
	 */
	protected function getRequest()
	{
		return new ValidateWalletSession();
	}

	/**
	 * @return Wallet
	 */
	protected function getWallet()
	{
		return (new Wallet())
			->setType(Wallet::TYPE_APPLE_PAY)
			->setEnvironment(Wallet::ENVIRONMENT_WEB)
			->setValidationUrl('https://apple-pay-gateway.apple.com/paymentservices/startSession')
			->setShopUrl('https://demo.nevogate.com');
	}

	/**
	 * @test
	 * @dataProvider dataProviderFor_parameterTest
	 * @param $testData
	 * @param $method
	 */
	public function parameterSetTest($testData, $method)
	{
		$request = $this->getRequest();
		$result = $request->$method($testData);

		$variableName = lcfirst(substr($method, 3));

		// test chain
		$this->assertInstanceOf(get_class($request), $result);
		$this->assertArrayHasKey($variableName, $request->getData());
		if ($testData instanceof Wallet) {
			$this->assertEquals($testData->getUcFirstData(), $request->getData()[$variableName]);
			return;
		}

		$this->assertEquals($testData, $request->getData()[$variableName]);
	}

	/**
	 * @test
	 */
	public function setAutocommit_false()
	{
		$request = $this->getRequest();
		$result = $request->setAutoCommit(false);

		// test chain
		$this->assertInstanceOf(get_class($request), $result);
		$this->assertArrayHasKey('autoCommit', $request->getData());
		$this->assertEquals('false', $request->getData()['autoCommit']);
	}

	/**
	 * @test
	 */
	public function setAutocommit_true()
	{
		$request = $this->getRequest();
		$result = $request->setAutoCommit(true);

		$this->assertInstanceOf(get_class($request), $result);
		$this->assertArrayHasKey('autoCommit', $request->getData());
		$this->assertEquals('true', $request->getData()['autoCommit']);
	}

	/**
	 * @test
	 */
	public function transportPreparesStoreName()
	{
		$config = new Config();
		$config->storeName = 'demo_store';
		$request = $this->getRequest();

		$transport = new class($config) extends SystemTransport {
			public function prepare($request)
			{
				$this->prepareRequest($request);
			}
		};

		$transport->prepare($request);

		$this->assertSame('demo_store', $request->getData()['storeName']);
	}
}
