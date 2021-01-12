<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway\Request\SettlementRefund;

class SettlementRefundTest extends SettlementRequestAbstract
{
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
}
