<?php

namespace BigFish\PaymentGateway\Data;

class PayWallSettings extends PayWallAbstract
{
	/**
	 * Success page hosted by Payment Gateway
	 *
	 * @var bool
	 * @access public
	 */
	public $hostedSuccessPage;

	/**
	 * Enabled payment provider list (eg: [CIB, OTP])
	 *
	 * @var array
	 * @access public
	 */
	public $enabledPaymentProviders;

	/**
	 * Disabled payment provider list (eg: [CIB, OTP])
	 *
	 * @var array
	 * @access public
	 */
	public $disabledPaymentProviders;

	/**
	 * Payment provider order (eg: [CIB, OTP])
	 *
	 * @var array
	 * @access public
	 */
	public $paymentProviderOrder;

	/**
	 * Hide providers from payment options in case of provider outage
	 *
	 * @var bool
	 * @access public
	 */
	public $hidePaymentProviderOnDowntime;

	/**
	 * Fallback payment provider list (eg: [CIB => OTP])
	 * @var array
	 * @access public
	 */
	public $fallbackPaymentProviders;

	/**
	 * Custom payment provider name (eg: [CIB => [card => 'Custom Payment options name']])
	 * @var array
	 * @access public
	 */
	public $customPaymentOptionName;

	/**
	 * Enable one click payment on payment page
	 *
	 * @var bool
	 * @access public
	 */
	public $oneClickEnabled;

	/**
	 * Enable User preferred sorting on payment page by last success payment
	 *
	 * @var bool
	 * @access public
	 */
	public $userPreferredSortingEnabled;
}
