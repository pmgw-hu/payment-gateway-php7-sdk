<?php

namespace BigFish\Tests\PaymentGateway\Request;

use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\Init;

class InitTest extends InitRPTest
{
	/**
	 * @return array
	 */
	public function dataProviderFor_parameterTest()
	{
		return array(
			array('TestProvider', 'setProviderName'),
			array('http://test.hu', 'setResponseUrl'),
			array('http://test.hu', 'setNotificationUrl'),
			array(100, 'setAmount'),
			array(12345, 'setOrderId'),
			array(54321, 'setUserId'),
			array('EUR', 'setCurrency'),
			array('US', 'setLanguage'),
			array('+36305551234', 'setMppPhoneNumber'),
			array('4908366099900425', 'setOtpCardNumber'),
			array('1014', 'setOtpExpiration'),
			array('823', 'setOtpCvc'),
			array('07', 'setOtpCardPocketId'),
			array('&#!aBd2', 'setOtpConsumerRegistrationId'),
			array('823', 'setMkbSzepCafeteriaId'),
			array('1122-3344-5566-777', 'setMkbSzepCardNumber'),
			array('823', 'setMkbSzepCvv'),
			array(true, 'setOneClickPayment'),
			array(true, 'setOneClickForcedRegistration'),
			array(true, 'setGatewayPaymentPage'),
			array('7612312312', 'setOneClickReferenceId'),
			array('something', 'setStoreName')
		);
	}

	/**
	 * @test
	 */
	public function setAutocommit_false()
	{
		$init = $this->getRequest();
		$result = $init->setAutoCommit(false);

		// test chain
		$this->assertInstanceOf(get_class($init), $result);
		$this->assertArrayHasKey('autoCommit', $init->getData());
		$this->assertEquals('false', $init->getData()['autoCommit']);
	}

	/**
	 * @test
	 */
	public function setMultipleParameterTest()
	{
		$init = $this->getRequest();
		$init->setAmount(10);
		$init->setCurrency('EUR');
		$init->setProviderName('test');

		$this->assertArraySubset(
			array(
				'amount' => 10,
				'currency' => 'EUR',
				'providerName' => 'test',
			),
			$init->getData()
		);
	}

	/**
	 * @test
	 */
	public function setAmount_isZero()
	{
		$amount = 0;

		$request = $this->getRequest();
		$request->setAmount($amount);
		$this->assertEquals($amount, $request->getData()['amount']);
	}

	/**
	 * @test
	 * @expectedException \BigFish\PaymentGateway\Exception\PaymentGatewayException
	 */
	public function setNotificationUrl_invalidUrl()
	{
		$request = $this->getRequest();
		$request->setNotificationUrl('invalidUrl');
	}

	/**
	 * @test
	 */
	public function setExtra_OTPConsumerConsumerReg()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_OTP);
		$init->setOtpConsumerRegistrationId("test");
		$config = new PaymentGateway\Config();
		$init->setEncryptKey($config->getEncryptPublicKey());
		$init->setExtra();

		$data = $init->getData();
		$this->assertArrayNotHasKey('extra', $data);
		$this->assertArrayNotHasKey('otpCardPocketId', $data);
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
		$init->setProviderName(PaymentGateway::PROVIDER_BARION2);
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
	public function setExtra_noOneClickProvider()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_FHB);
		$config = new PaymentGateway\Config();
		$init->setEncryptKey($config->getEncryptPublicKey());
		$init->setOneClickPayment();
		$init->setOneClickReferenceId('testData');
		$init->setOneClickForcedRegistration();
		$init->setPaymentRegistration();
		$init->setPaymentRegistrationType(PaymentGateway::PAYMENT_REGISTRATION_TYPE_MERCHANT_INITIATED);
		$init->setReferenceTransactionId('testData');
		$init->setExtra();

		$data = $init->getData();
		$this->assertArrayNotHasKey('oneClickPayment', $data);
		$this->assertArrayNotHasKey('oneClickReferenceId', $data);
		$this->assertArrayNotHasKey('oneClickForcedRegistration', $data);
		$this->assertArrayNotHasKey('paymentRegistration', $data);
		$this->assertArrayNotHasKey('paymentRegistrationType', $data);
		$this->assertArrayNotHasKey('referenceTransactionId', $data);
	}

	/**
	 * @test
	 */
	public function setExtra_noOneClickProvider_paymentRegistrationIsNull()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_FHB);
		$config = new PaymentGateway\Config();
		$init->setEncryptKey($config->getEncryptPublicKey());
		$init->setPaymentRegistration(null);
		$init->setExtra();

		$data = $init->getData();
		$this->assertArrayNotHasKey('paymentRegistration', $data);
	}

	/**
	 * @test
	 */
	public function setExtra_OneClickProvider()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_BORGUN2);
		$init->setOneClickPayment();
		$init->setOneClickReferenceId('testData');
		$init->setOneClickForcedRegistration();
		$init->setPaymentRegistration();
		$init->setPaymentRegistrationType(PaymentGateway::PAYMENT_REGISTRATION_TYPE_MERCHANT_INITIATED);
		$init->setReferenceTransactionId('testData');
		$init->setExtra();

		$data = $init->getData();
		$this->assertArrayHasKey('oneClickPayment', $data);
		$this->assertArrayHasKey('oneClickReferenceId', $data);
		$this->assertArrayNotHasKey('oneClickForcedRegistration', $data);
		$this->assertArrayHasKey('paymentRegistration', $data);
		$this->assertArrayHasKey('paymentRegistrationType', $data);
		$this->assertArrayHasKey('referenceTransactionId', $data);
	}

	/**
	 * @test
	 */
	public function setExtra_OneClickProvider_paymentRegistrationIsNull()
	{
		$init = $this->getRequest();
		$init->setProviderName(PaymentGateway::PROVIDER_BORGUN2);
		$init->setPaymentRegistration(null);
		$init->setExtra();

		$data = $init->getData();
		$this->assertArrayNotHasKey('paymentRegistration', $data);
	}

	/**
	 * @return Init
	 */
	protected function getRequest()
	{
		return new Init();
	}

	public function testInitDefaultData()
	{
		$init = new Init();
		$this->assertEquals(PaymentGateway::NAME, $init->getData()['moduleName']);
		$this->assertEquals(PaymentGateway::VERSION, $init->getData()['moduleVersion']);
	}

	public function testInitSetModuleName()
	{
		$init = new Init();
		$init->setModuleName('test');

		$this->assertArrayHasKey('moduleName', $init->getData());
		$this->assertEquals('test', $init->getData()['moduleName']);
	}

	public function testInitSetModuleVersion()
	{
		$init = new Init();
		$init->setModuleVersion('42');

		$this->assertArrayHasKey('moduleVersion', $init->getData());
		$this->assertEquals('42', $init->getData()['moduleVersion']);
	}
}
