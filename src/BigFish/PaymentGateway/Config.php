<?php

namespace BigFish\PaymentGateway;

use BigFish\PaymentGateway\Exception\PaymentGatewayException;
use BigFish\PaymentGateway;

/**
 * Class Config
 * @package BigFish
 *
 * @property bool $testMode
 * @property string $storeName
 * @property string $apiKey
 * @property string $outCharset
 * @property string $encryptPublicKey
 * @property string $moduleName
 * @property string $moduleVersion
 * @property string $gatewayProxy
 */
class Config
{
	/**
	 * Default store name
	 */
	const SDK_TEST_STORE_NAME = 'sdk_test';

	/**
	 * Default API key
	 */
	const SDK_TEST_API_KEY = '86af3-80e4f-f8228-9498f-910ad';

	/**
	 * Production service URL
	 */
	const API_URL_PRODUCTION = 'https://system.paymentgateway.hu';

	/**
	 * Test service URL
	 */
	const API_URL_TESTING = 'https://system-test.paymentgateway.hu';

	/**
	 * Default public key used for encryption
	 */
	const SDK_TEST_ENCRYPT_PUBLIC_KEY = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCpRN6hb8pQaDen9Qjt18P2FqSc
F2uhjKfd0DZ1t0HWtvYMmJGfM6+wgjQGDHHc4LAcLIHF1TQVLCYdbyLzsOTRUhi4
UFsW18IBznoEAx2wxiTCyzxtONpIkr5HD2E273UbXvVKA2hig2BgpOA2Poil9xtO
XIm63iVw6gjP2qDnNwIDAQAB
-----END PUBLIC KEY-----';

	/**
	 * Charsets
	 */
	const CHARSET_UTF8 = 'UTF-8';
	const CHARSET_LATIN1 = 'iso-8859-1';
	const CHARSET_LATIN2 = 'iso-8859-2';

	/**
	 * Default lang
	 */
	const DEFAULT_LANG = 'hu';

	/**
	 * Default currency
	 */
	const DEFAULT_CURRENCY = 'HUF';

	/**
	 * Test mode
	 *
	 * @var bool
	 * @access protected
	 */
	protected $testMode = true;

	/**
	 * Store name
	 *
	 * @var string
	 * @access protected
	 */
	protected $storeName = self::SDK_TEST_STORE_NAME;

	/**
	 * API key
	 *
	 * @var string
	 * @access protected
	 */
	protected $apiKey = self::SDK_TEST_API_KEY;

	/**
	 * Charset response
	 *
	 * @var string
	 * @access public
	 */
	public $outCharset = self::CHARSET_UTF8;

	/**
	 * Public key to encrypt
	 *
	 * @var string
	 * @access protected
	 */
	protected $encryptPublicKey = self::SDK_TEST_ENCRYPT_PUBLIC_KEY;

	/**
	 * Module name
	 *
	 * @var string
	 * @access protected
	 */
	protected $moduleName = PaymentGateway::NAME;

	/**
	 * Module version
	 *
	 * @var string
	 * @access protected
	 */
	protected $moduleVersion = PaymentGateway::VERSION;

	/**
	 * Proxy address used for the api requests
	 *
	 * @var string
	 * @access protected
	 */
	protected $gatewayProxy = '';

    /**
     * Add debug information to the Response object
     *
     * @var bool
     */
    public $debugCommunication = false;

	/**
	 * @return bool
	 */
	public function isTestMode(): bool
	{
		return (bool) $this->testMode;
	}

	/**
	 * @return string
	 */
	public function getApiKey(): string
	{
		return (string) $this->apiKey;
	}

	/**
	 * @return string
	 */
	public function getStoreName(): string
	{
		return (string) $this->storeName;
	}

	/**
	 * @return string
	 */
	public function getOutCharset(): string
	{
		return (string) $this->outCharset;
	}

	/**
	 * @return string
	 */
	public function getEncryptPublicKey(): string
	{
		return (string) $this->encryptPublicKey;
	}

	/**
	 * @return string
	 */
	public function getGatewayProxy(): string
	{
		return (string) $this->gatewayProxy;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		if ($this->isTestMode()) {
			return static::API_URL_TESTING;
		}

		return static::API_URL_PRODUCTION;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 * @throws PaymentGatewayException
	 */
	public function __set(string $name, $value)
	{
		if (!property_exists($this, $name)) {
			throw new PaymentGatewayException(sprintf('%s property is unknown', $name));
		}
		$this->$name = $value;
	}
}