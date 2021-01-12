<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway\Request\Settlement;

class SettlementTest extends SettlementRequestAbstract
{
	/**
	 * @return array
	 */
	public function dataProviderFor_parameterTest()
	{
		return array(
			array('TestProvider', 'setProviderName'),
			array('store-name', 'setStoreName'),
			array(110, 'setLimit'),
			array(10, 'setOffset'),
			array(false, 'setGetItems'),
			array(false, 'setGetBatches'),
			array('transfer-notice', 'setTransferNotice'),
			array('2020-01-01', 'setSettlementDate'),
			array('MID-8822', 'setTerminalId'),
			array('EUR', 'setTransactionCurrency'),
		);
	}

	/**
	 * @return Settlement
	 */
	protected function getRequest()
	{
		return new Settlement();
	}
}
