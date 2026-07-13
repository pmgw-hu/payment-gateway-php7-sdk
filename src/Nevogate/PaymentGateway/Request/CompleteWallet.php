<?php

namespace Nevogate\PaymentGateway\Request;


class CompleteWallet extends SimpleRequestAbstract
{
	const REQUEST_TYPE = 'CompleteWallet';

	/**
	 * @param string $walletAuthenticationResult Wallet authentication result
	 * @return $this
	 */
	public function setWalletAuthenticationResult(string $walletAuthenticationResult): self
	{
		return $this->setData($walletAuthenticationResult, 'walletAuthenticationResult');
	}

	/**
	 * @param string $walletAuthenticationMessage Wallet authentication message
	 * @return $this
	 */
	public function setWalletAuthenticationMessage(string $walletAuthenticationMessage): self
	{
		return $this->setData($walletAuthenticationMessage, 'walletAuthenticationMessage');
	}
}
