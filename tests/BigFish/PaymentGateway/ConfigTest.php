<?php

namespace BigFish\Tests\PaymentGateway;

use BigFish\PaymentGateway\Config;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @test
	 * @dataProvider DataProviderFor_setDataViaMagicAndValidate
	 * @param mixed $testData
	 * @param string $propertyName
	 * @param string $method
	 */
	public function setDataViaMagicAndValidate_storeName($testData, string $propertyName, string $method)
	{
		$config = $this->getConfig();
		$config->$propertyName = $testData;
		$this->assertEquals($testData, $config->$method());
	}

	/**
	 * @return array
	 */
	public function DataProviderFor_setDataViaMagicAndValidate(): array
	{
		return [
			[
				'something', 'storeName', 'getStoreName',
			],
			[
				'thisIsTheApuKeyWithX$ˆ1d', 'apiKey', 'getApiKey',
			],
			[
				"-------\n\rt*rXdFed#Y#ˇag\n\r-------", 'encryptPublicKey', 'getEncryptPublicKey',
			],
			[
				Config::CHARSET_LATIN1, 'outCharset', 'getOutCharset'
			],
			[
				true, 'testMode', 'isTestMode'
			],
			[
				'1.1.1.1:80', 'gatewayProxy', 'getGatewayProxy'
			],
		];
	}

	/**
	 * @test
	 */
	public function isTestMode_defaultIsTrue()
	{
		$this->assertTrue($this->getConfig()->isTestMode());
	}

	/**
	 * @test
	 */
	public function isTestMode_setNonBooleanValue_string()
	{
		$this->assertIsTestMode(true, 'yes');
	}

	/**
	 * @test
	 */
	public function isTestMode_setNonBooleanValue_int()
	{
		$this->assertIsTestMode(true, 1);
	}

	/**
	 * @test
	 */
	public function isTestMode_setNonBooleanValue_zero()
	{
		$this->assertIsTestMode(false, 0);
	}

	/**
	 * @test
	 */
	public function isTestMode_setNonBooleanValue_null()
	{
		$this->assertIsTestMode(false, null);
	}

	/**
	 * @test
	 */
	public function isTestMode_setNonBooleanValue_emptyString()
	{
		$this->assertIsTestMode(false, '');
	}

	/**
	 * @param bool $excepted
	 * @param mixed $value
	 */
	protected function assertIsTestMode(bool $excepted, $value)
	{
		$config = $this->getConfig();
		$config->testMode = $value;
		$this->assertEquals($excepted, $config->isTestMode());
	}

	/**
	 * @test
	 */
	public function defaultIsTestValue_apiKey()
	{
		$this->assertEquals(
			Config::SDK_TEST_API_KEY,
			$this->getConfig()->getApiKey()
		);
	}

	/**
	 * @test
	 */
	public function defaultIsTestValue_storeName()
	{
		$this->assertEquals(
			Config::SDK_TEST_STORE_NAME,
			$this->getConfig()->getStoreName()
		);
	}

	/**
	 * @test
	 */
	public function defaultIsTestValue_encryptPublicKey()
	{
		$this->assertEquals(
				Config::SDK_TEST_ENCRYPT_PUBLIC_KEY,
				$this->getConfig()->getEncryptPublicKey()
		);
	}

	/**
	 * @test
	 */
	public function getUrl_production()
	{
		$this->getUrlTest(false, Config::API_URL_PRODUCTION);
	}

	/**
	 * @test
	 */
	public function getUrl_testing()
	{
		$this->getUrlTest(true, Config::API_URL_TESTING);
	}

	/**
	 * @param bool $testMode
	 * @param string $url
	 */
	protected function getUrlTest(bool $testMode, string $url)
	{
		$config = $this->getConfig();
		$config->testMode = $testMode;

		$this->assertEquals($url, $config->getUrl());
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function throwExceptionWhenTryToSetAnUnknownVariable()
	{
		$this->getConfig()->unknownProperty = 'hey';
	}

	/**
	 * @return Config
	 */
	protected function getConfig()
	{
		return new Config();
	}
}
