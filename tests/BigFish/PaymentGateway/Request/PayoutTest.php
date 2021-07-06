<?php

namespace BigFish\Tests\Request;

use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\Payout;

class PayoutTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @return array
	 */
	public function dataProviderFor_parameterTest()
	{
		return array(
			array(PaymentGateway::PAYOUT_TYPE_FUNDS_DISBURSEMENT, 'setPayoutType'),
			array('23234', 'setReferenceTransactionId'),
			array(100, 'setAmount'),
			array(12345, 'setOrderId'),
		);
	}

	/**
	 * @return Payout
	 */
	protected function getRequest()
	{
		return new Payout();
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
		$this->assertEquals($testData, $request->getData()[$variableName]);
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setAmount_isZero()
	{
		$request = $this->getRequest();
		$request->setAmount(0);
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setAmount_isNegativ()
	{
		$request = $this->getRequest();
		$request->setAmount(-1);
	}

	/**
	 * @test
	 */
	public function defaultData()
	{
		$request = $this->getRequest();
		$this->assertEquals(PaymentGateway::NAME, $request->getData()['moduleName']);
		$this->assertEquals(PaymentGateway::VERSION, $request->getData()['moduleVersion']);
	}

	/**
	 * @test
	 */
	public function setModuleName()
	{
		$request = $this->getRequest();
		$request->setModuleName('test');

		$this->assertArrayHasKey('moduleName', $request->getData());
		$this->assertEquals('test', $request->getData()['moduleName']);
	}

	/**
	 * @test
	 */
	public function setModuleVersion()
	{
		$request = $this->getRequest();
		$request->setModuleVersion('42');

		$this->assertArrayHasKey('moduleVersion', $request->getData());
		$this->assertEquals('42', $request->getData()['moduleVersion']);
	}
}
