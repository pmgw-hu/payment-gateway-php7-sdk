<?php

namespace Nevogate\PaymentGateway\Request;

class ValidateWalletSession extends RequestAbstract
{
	use WalletTrait;

	const REQUEST_TYPE = 'ValidateWalletSession';

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
	 * @param string $currency
	 * @return $this
	 */
	public function setCurrency(string $currency): self
	{
		return $this->setData($currency, 'currency');
	}

	/**
	 * @param bool $autoCommit
	 * @return $this
	 */
	public function setAutoCommit(bool $autoCommit = true): self
	{
		return $this->setData($autoCommit ? 'true' : 'false', 'autoCommit');
	}

}
