<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\SettlementRefund;

class SettlementRefundTest extends \PHPUnit\Framework\TestCase
{
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

		// test chain
		$this->assertInstanceOf(get_class($init), $result);
		$this->assertArrayHasKey($variableName, $init->getData());
		$this->assertEquals($testData, $init->getData()[$variableName]);
	}

	/**
	 * @return array
	 */
	public function dataProviderFor_parameterTest()
	{
		return array(
			array('sdk_test', 'setStoreName'),
			array('MKBSZEP', 'setProviderName'),
			array('111111', 'setTerminalId'),
			array('2020-11-26', 'setRefundSettlementDate'),
			array('72ab2a61', 'setRefundSettlementId'),
			array(false, 'setGetBatches'),
			array(false, 'setGetItems'),
			array(10, 'setLimit'),
			array(20, 'setOffset'),
		);
	}

	/**
	 * @return SettlementRefund
	 */
	protected function getRequest()
	{
		return new SettlementRefund();
	}

	public function testSettlementRefundDefaultData()
	{
		$settlementRefund = $this->getRequest();
		$this->assertEquals(PaymentGateway::NAME, $settlementRefund->getData()['moduleName']);
		$this->assertEquals(PaymentGateway::VERSION, $settlementRefund->getData()['moduleVersion']);
	}

	public function testSettlementRefundSetModuleName()
	{
		$settlementRefund = $this->getRequest();
		$settlementRefund->setModuleName('test');

		$this->assertArrayHasKey('moduleName', $settlementRefund->getData());
		$this->assertEquals('test', $settlementRefund->getData()['moduleName']);
	}

	public function testSettlementRefundSetModuleVersion()
	{
		$settlementRefund = $this->getRequest();
		$settlementRefund->setModuleVersion('42');

		$this->assertArrayHasKey('moduleVersion', $settlementRefund->getData());
		$this->assertEquals('42', $settlementRefund->getData()['moduleVersion']);
	}
}
