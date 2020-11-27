<?php

namespace BigFish\PaymentGateway\Request;

use BigFish\PaymentGateway\Exception\PaymentGatewayException;

class SettlementRefund extends InitBaseAbstract
{
	const REQUEST_TYPE = 'SettlementRefund';

	/**
	 * @param string $terminalId
	 * @return $this
	 */
	public function setTerminalId(string $terminalId): self
	{
		return $this->setData($terminalId, 'terminalId');
	}

	/**
	 * @param string $date
	 * @return $this
	 */
	public function setRefundSettlementDate(string $date): self
	{
		return $this->setData($date, 'refundSettlementDate');
	}

	/**
	 * @param string $id
	 * @return $this
	 */
	public function setRefundSettlementId(string $id): self
	{
		return $this->setData($id, 'refundSettlementId');
	}

	/**
	 * @param bool $getBatches
	 * @return $this
	 */
	public function setGetBatches(bool $getBatches): self
	{
		return $this->setData($getBatches, 'getBatches');
	}

	/**
	 * @param bool $getItems
	 * @return $this
	 */
	public function setGetItems(bool $getItems): self
	{
		return $this->setData($getItems, 'getItems');
	}

	/**
	 * @param int $limit
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setLimit(int $limit): self
	{
		return $this->setData($limit, 'limit');
	}

	/**
	 * @param int $offset
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setOffset(int $offset): self
	{
		return $this->setData($offset, 'offset');
	}
}
