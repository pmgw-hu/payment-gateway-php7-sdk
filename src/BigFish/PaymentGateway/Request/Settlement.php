<?php

namespace BigFish\PaymentGateway\Request;


class Settlement extends SettlementBaseAbstract
{
	const REQUEST_TYPE = 'Settlement';

	/**
	 * @param string $transferNotice
	 * @return $this
	 */
	public function setTransferNotice(string $transferNotice): self
	{
		return $this->setData($transferNotice, 'transferNotice');
	}

	/**
	 * @param string $date
	 * @return $this
	 */
	public function setSettlementDate(string $date): self
	{
		return $this->setData($date, 'settlementDate');
	}

	/**
	 * Set settlement transaction currency
	 *
	 * @param string $currency Three-letter ISO currency code (e.g. HUF, USD etc.)
	 * @return $this
	 */
	public function setTransactionCurrency(string $currency): self
	{
		return $this->setData($currency, 'transactionCurrency');
	}
}
