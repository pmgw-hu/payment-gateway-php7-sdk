<?php

namespace BigFish\PaymentGateway\Request;


class SettlementRefund extends SettlementBaseAbstract
{
	const REQUEST_TYPE = 'SettlementRefund';

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
}
