<?php

namespace Nevogate\PaymentGateway\Request;

use Nevogate\PaymentGateway\Data\Wallet;

trait WalletTrait
{
	/**
	 * @param Wallet $wallet
	 * @return $this
	 */
	public function setWallet(Wallet $wallet): self
	{
		return $this->setData($wallet->getUcFirstData(), $this->getWalletFieldName());
	}

	protected function getWalletFieldName(): string
	{
		return 'wallet';
	}
}
