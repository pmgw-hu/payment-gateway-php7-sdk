<?php

namespace Nevogate\PaymentGateway\Request;


class Details extends SimpleRequestAbstract
{
	const REQUEST_TYPE = 'Details';

	/**
	 * @param bool $getInfoData Get info data block (true/false)
	 * @return $this
	 */
	public function setGetInfoData(bool $getInfoData): self
	{
		return $this->setData($getInfoData, 'getInfoData');
	}

	/**
	 * @param bool $getRelatedTransactions Get related transactions (true/false)
	 * @return $this
	 */
	public function setGetRelatedTransactions(bool $getRelatedTransactions): self
	{
		return $this->setData($getRelatedTransactions, 'getRelatedTransactions');
	}

	/**
	 * @param bool $getPaymentAttributes Get payment attributes (true/false)
	 * @return $this
	 */
	public function setGetPaymentAttributes(bool $getPaymentAttributes): self
	{
		return $this->setData($getPaymentAttributes, 'getPaymentAttributes');
	}
}