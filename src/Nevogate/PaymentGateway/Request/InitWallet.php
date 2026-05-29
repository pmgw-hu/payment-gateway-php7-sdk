<?php

namespace Nevogate\PaymentGateway\Request;

class InitWallet extends Init
{
	use WalletTrait;

	const REQUEST_TYPE = 'InitWallet';
}
