<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\PaymentLinkCreate;

class PaymentLinkCreateTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @test
	 * @dataProvider dataProviderFor_parameterTest
	 * @param $testData
	 * @param $method
	 */
	public function parameterSetTest($testData, $method)
	{
		$init = $this->getRequest();
		$result = $init->$method($testData);

		$variableName = lcfirst(substr($method, 3));

		// test chain
		$this->assertInstanceOf(get_class($init), $result);
		$this->assertArrayHasKey($variableName, $init->getData());
		$this->assertEquals($testData, $init->getData()[$variableName]);
	}

	/**
	 * @return array
	 */
	public function dataProviderFor_parameterTest()
	{
		return array(
			array('TestProvider', 'setProviderName'),
			array('http://test.hu', 'setResponseUrl'),
			array(true, 'setMultipleTransactions'),
			array(false, 'setMultipleTransactions'),
			array(true, 'setEmailNotificationOnlySuccess'),
			array(false, 'setEmailNotificationOnlySuccess'),
			array('test@test.com', 'setNotificationEmail'),
			array('2020-01-01 01:01:01', 'setExpirationTime'),
			array(12345, 'setOrderId'),
			array(54321, 'setUserId'),
			array('http://test.hu/privacy-policy', 'setPrivacyPolicyUrl'),
			array('http://test.hu/redirect-url', 'setRedirectUrl'),
			array('product', 'setInfoForm'),
			array('service', 'setInfoForm'),
		);
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setAmount_fixPositiveNumberCheck()
	{
		$this->getRequest()->setAmount(-1);
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setAmount_fixIsZero()
	{
		$request = $this->getRequest();
		$request->setAmount(0);
	}

	/**
	 * @test
	 */
	public function setAmount_fix()
	{
		$request = $this->getRequest();
		$request->setAmount(100);

		$this->checkAmount($request->getData(), 100, null, null);
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setAmount_flexibleMinimumZeroCheck()
	{
		$request = $this->getRequest();
		$request->setFlexibleAmount(0);
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setAmount_flexibleMinimumPositiveNumberCheck()
	{
		$request = $this->getRequest();
		$request->setFlexibleAmount(-1);
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setAmount_flexibleMaximumCheck()
	{
		$request = $this->getRequest();
		$request->setFlexibleAmount(100, 100);
	}

	/**
	 * @test
	 */
	public function setAmount_flexibleMinimum()
	{
		$request = $this->getRequest();
		$request->setFlexibleAmount(100);

		$this->checkAmount($request->getData(), null, 100, null);
	}

	/**
	 * @test
	 */
	public function setAmount_flexibleMinimumMaximum()
	{
		$request = $this->getRequest();
		$request->setFlexibleAmount(100, 101);

		$this->checkAmount($request->getData(), null, 100, 101);
	}

	protected function checkAmount($data, $amount, $minimumAmount, $maximumAmount)
	{
		foreach (array('amount', 'minimumAmount', 'maximumAmount') as $variableName) {
			$this->assertArrayHasKey($variableName, $data);
			$this->assertEquals($$variableName, $data[$variableName]);
		}
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setResponseUrl_invalidUrl()
	{
		$request = $this->getRequest();
		$request->setResponseUrl('invalidUrl');
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setPrivacyPolicyUrl_invalidUrl()
	{
		$request = $this->getRequest();
		$request->setPrivacyPolicyUrl('invalidUrl');
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setRedirectUrl_invalidUrl()
	{
		$request = $this->getRequest();
		$request->setRedirectUrl('invalidUrl');
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setNotificationEmail_invalidEmail()
	{
		$request = $this->getRequest();
		$request->setNotificationEmail('test');
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setInfoForm_invalid()
	{
		$request = $this->getRequest();
		$request->setRedirectUrl('invalidInfoForm');
	}

	/**
	 * @test
	 */
	public function setExtra_MKB_SZEP()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_MKB_SZEP);
		$init->setMkbSzepCardNumber('123456');
		$init->setMkbSzepCvv('112');
		$config = new PaymentGateway\Config();
		$init->setEncryptKey($config->getEncryptPublicKey());
		$init->setExtra();

		$data = $init->getData();
		$this->assertArrayNotHasKey('extra', $data);
	}

	/**
	 * @test
	 */
	public function setExtra_extra()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_ABAQOOS);
		$config = new PaymentGateway\Config();
		$init->setEncryptKey($config->getEncryptPublicKey());
		$init->setExtra(array('test' => 'foo'));

		$data = $init->getData();
		$this->assertArrayHasKey('extra', $data);
		$this->assertNotEmpty($data['extra']);
	}

	/**
	 * @test
	 */
	public function setExtra_testUnSets()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_UNICREDIT);
		$config = new PaymentGateway\Config();
		$init->setEncryptKey($config->getEncryptPublicKey());
		$init->setMkbSzepCardNumber('23123');
		$init->setMkbSzepCvv('evc');
		$init->setExtra();

		$data = $init->getData();

		$this->assertArrayNotHasKey('otpCardNumber', $data);
		$this->assertArrayNotHasKey('otpExpiration', $data);
		$this->assertArrayNotHasKey('otpCvc', $data);
		$this->assertArrayNotHasKey('otpConsumerRegistrationId', $data);
		$this->assertArrayNotHasKey('mkbSzepCardNumber', $data);
		$this->assertArrayNotHasKey('mkbSzepCvv', $data);
	}

	/**
	 * @test
	 */
	public function setExtra_notToUnset()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_UNICREDIT);
		$config = new PaymentGateway\Config();
		$init->setEncryptKey($config->getEncryptPublicKey());
		$init->setExtra();

		$data = $init->getData();
		$this->assertArrayNotHasKey('otpCardNumber', $data);
		$this->assertArrayNotHasKey('otpExpiration', $data);
		$this->assertArrayNotHasKey('otpCvc', $data);
		$this->assertArrayNotHasKey('otpConsumerRegistrationId', $data);
		$this->assertArrayNotHasKey('mkbSzepCardNumber', $data);
		$this->assertArrayNotHasKey('mkbSzepCvv', $data);
	}

	/**
	 * @return PaymentLinkCreate
	 */
	protected function getRequest()
	{
		return new PaymentLinkCreate();
	}

	public function testCreatePaylinkDefaultData()
	{
		$initPlc = new PaymentLinkCreate();
		$this->assertEquals(PaymentGateway::NAME, $initPlc->getData()['moduleName']);
		$this->assertEquals(PaymentGateway::VERSION, $initPlc->getData()['moduleVersion']);
	}

	public function testCreatePaylinkSetModuleName()
	{
		$initPlc = new PaymentLinkCreate();
		$initPlc->setModuleName('test');

		$this->assertArrayHasKey('moduleName', $initPlc->getData());
		$this->assertEquals('test', $initPlc->getData()['moduleName']);
	}

	public function testCreatePaylinkSetModuleVersion()
	{
		$initPlc = new PaymentLinkCreate();
		$initPlc->setModuleVersion('42');

		$this->assertArrayHasKey('moduleVersion', $initPlc->getData());
		$this->assertEquals('42', $initPlc->getData()['moduleVersion']);
	}

}
