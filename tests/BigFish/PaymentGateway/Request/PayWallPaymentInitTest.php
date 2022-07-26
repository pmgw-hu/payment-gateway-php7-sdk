<?php

namespace BigFish\Tests\PaymentGateway\Request;

use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\PayWallPaymentInit;
use BigFish\Tests\TestHelper;
use PHPUnit\Framework\TestCase;

class PayWallPaymentInitTest extends TestCase
{
	/**
	 * @test
	 */
	public function getPayWallPaymentInitRequestData(): void
	{
		$amount = TestHelper::getRandomAmount();
		$currency = TestHelper::getRandomString(3);
		$language = TestHelper::getRandomString(2);
		$orderId = TestHelper::getRandomString();
		$userId = TestHelper::getRandomString();
		$responseUrl = TestHelper::getRandomUrl();
		$notificationUrl = TestHelper::getRandomUrl();
		$cancelUrl = TestHelper::getRandomUrl();
		$autoCommit = TestHelper::getRandomBoolean();

		$settings = new PaymentGateway\Data\PayWallSettings();
		$settings->oneClickEnabled = TestHelper::getRandomBoolean();
		$settings->enabledPaymentProviders = [TestHelper::getRandomString(3)];
		$settings->userPreferredSortingEnabled = TestHelper::getRandomBoolean();

		$storeSettings = new PaymentGateway\Data\PayWallStoreSettings();
		$storeSettings->companyName = TestHelper::getRandomString();
		$storeSettings->brandName = TestHelper::getRandomString();
		$storeSettings->phone = TestHelper::getRandomString();
		$storeSettings->email = TestHelper::getRandomEmail();
		$storeSettings->generalTermsAndConditionsUrl = TestHelper::getRandomUrl();
		$storeSettings->generalTermsAndConditionsCheckboxEnabled = TestHelper::getRandomBoolean();
		$storeSettings->privacyPolicyUrl = TestHelper::getRandomUrl();
		$storeSettings->privacyPolicyCheckboxEnabled = TestHelper::getRandomBoolean();
		$storeSettings->implicitlyAcceptNoticeEnabled = TestHelper::getRandomBoolean();

		$extra = [
			'OtpCardPocketId' => TestHelper::getRandomString(),
			'MkbSzepCafeteriaId' => TestHelper::getRandomString(),
		];

		$request = $this->getRequest()
			->setAmount($amount)
			->setCurrency($currency)
			->setLanguage($language)
			->setOrderId($orderId)
			->setUserId($userId)
			->setResponseUrl($responseUrl)
			->setNotificationUrl($notificationUrl)
			->setCancelUrl($cancelUrl)
			->setAutoCommit($autoCommit)
			->setSettings($settings)
			->setStoreSettings($storeSettings)
			->setExtra($extra);

		self::assertEquals(PayWallPaymentInit::REQUEST_TYPE, $request->getMethod());
		self::assertEquals([
			'amount' => $amount,
			'currency' => $currency,
			'language' => $language,
			'orderId' => $orderId,
			'userId' => $userId,
			'responseUrl' => $responseUrl,
			'notificationUrl' => $notificationUrl,
			'cancelUrl' => $cancelUrl,
			'autoCommit' => ($autoCommit) ? 'true' : 'false',
			'settings' => TestHelper::encodeArray([
				'EnabledPaymentProviders' => $settings->enabledPaymentProviders,
				'OneClickEnabled' => $settings->oneClickEnabled,
				'UserPreferredSortingEnabled' => $settings->userPreferredSortingEnabled,
			]),
			'storeSettings' => TestHelper::encodeArray([
				'BrandName' => $storeSettings->brandName,
				'CompanyName' => $storeSettings->companyName,
				'Phone' => $storeSettings->phone,
				'Email' => $storeSettings->email,
				'GeneralTermsAndConditionsUrl' => $storeSettings->generalTermsAndConditionsUrl,
				'GeneralTermsAndConditionsCheckboxEnabled' => $storeSettings->generalTermsAndConditionsCheckboxEnabled,
				'PrivacyPolicyUrl' => $storeSettings->privacyPolicyUrl,
				'PrivacyPolicyCheckboxEnabled' => $storeSettings->privacyPolicyCheckboxEnabled,
				'ImplicitlyAcceptNoticeEnabled' => $storeSettings->implicitlyAcceptNoticeEnabled,
			]),
			'extra' => TestHelper::encodeArray($extra),
			'moduleName' => PaymentGateway::NAME,
			'moduleVersion' => PaymentGateway::VERSION,
		], $request->getData());
		self::assertEquals([
			'Amount' => $amount,
			'Currency' => $currency,
			'Language' => $language,
			'OrderId' => $orderId,
			'UserId' => $userId,
			'ResponseUrl' => $responseUrl,
			'NotificationUrl' => $notificationUrl,
			'CancelUrl' => $cancelUrl,
			'AutoCommit' => ($autoCommit) ? 'true' : 'false',
			'Settings' => TestHelper::encodeArray([
				'EnabledPaymentProviders' => $settings->enabledPaymentProviders,
				'OneClickEnabled' => $settings->oneClickEnabled,
				'UserPreferredSortingEnabled' => $settings->userPreferredSortingEnabled,
			]),
			'StoreSettings' => TestHelper::encodeArray([
				'BrandName' => $storeSettings->brandName,
				'CompanyName' => $storeSettings->companyName,
				'Phone' => $storeSettings->phone,
				'Email' => $storeSettings->email,
				'GeneralTermsAndConditionsUrl' => $storeSettings->generalTermsAndConditionsUrl,
				'GeneralTermsAndConditionsCheckboxEnabled' => $storeSettings->generalTermsAndConditionsCheckboxEnabled,
				'PrivacyPolicyUrl' => $storeSettings->privacyPolicyUrl,
				'PrivacyPolicyCheckboxEnabled' => $storeSettings->privacyPolicyCheckboxEnabled,
				'ImplicitlyAcceptNoticeEnabled' => $storeSettings->implicitlyAcceptNoticeEnabled,
			]),
			'Extra' => TestHelper::encodeArray($extra),
			'ModuleName' => PaymentGateway::NAME,
			'ModuleVersion' => PaymentGateway::VERSION,
		], $request->getUcFirstData());
	}

	/**
	 * @test
	 */
	public function setInvalidAmountForPayWallPaymentInitRequest(): void
	{
		$this->expectException(PaymentGateway\Exception\PaymentGatewayException::class);

		$this->getRequest()->setAmount(TestHelper::getRandomAmount() * -1);
	}

	/**
	 * @test
	 */
	public function setInvalidResponseUrlForPayWallPaymentInitRequest(): void
	{
		$this->expectException(PaymentGateway\Exception\PaymentGatewayException::class);

		$this->getRequest()->setResponseUrl(TestHelper::getRandomString());
	}

	/**
	 * @test
	 */
	public function setInvalidNotificationUrlForPayWallPaymentInitRequest(): void
	{
		$this->expectException(PaymentGateway\Exception\PaymentGatewayException::class);

		$this->getRequest()->setNotificationUrl(TestHelper::getRandomString());
	}

	/**
	 * @test
	 */
	public function setInvalidCancelUrlForPayWallPaymentInitRequest(): void
	{
		$this->expectException(PaymentGateway\Exception\PaymentGatewayException::class);

		$this->getRequest()->setCancelUrl(TestHelper::getRandomString());
	}

	protected function getRequest(): PayWallPaymentInit
	{
		return new PayWallPaymentInit();
	}

}
