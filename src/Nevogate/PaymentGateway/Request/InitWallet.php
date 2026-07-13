<?php

namespace Nevogate\PaymentGateway\Request;

class InitWallet extends InitCommonAbstract
{
	use WalletTrait;

	const REQUEST_TYPE = 'InitWallet';
}
