<?php

namespace BigFish\PaymentGateway\Request;


abstract class SettlementBaseAbstract extends RequestAbstract
{
	/**
	 * @param string $storeName
	 * @return $this
	 */
	public function setStoreName(string $storeName): self
	{
		return $this->setData($storeName, 'storeName');
	}

	/**
	 * @param string $providerName
	 * @return $this
	 */
	public function setProviderName(string $providerName): self
	{
		return $this->setData($providerName, 'providerName');
	}

	/**
	 * @param string $terminalId
	 * @return $this
	 */
	public function setTerminalId(string $terminalId): self
	{
		return $this->setData($terminalId, 'terminalId');
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
	 */
	public function setLimit(int $limit): self
	{
		return $this->setData($limit, 'limit');
	}

	/**
	 * @param int $offset
	 * @return $this
	 */
	public function setOffset(int $offset): self
	{
		return $this->setData($offset, 'offset');
	}
}
