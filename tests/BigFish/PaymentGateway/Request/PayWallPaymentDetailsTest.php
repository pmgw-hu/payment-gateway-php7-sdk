<?php

namespace BigFish\Tests\PaymentGateway\Request;

use BigFish\PaymentGateway\Request\PayWallPaymentDetails;
use BigFish\Tests\TestHelper;
use PHPUnit\Framework\TestCase;

class PayWallPaymentDetailsTest extends TestCase
{
	/**
	 * @test
	 */
	public function getPayWallPaymentDetailsRequestData(): void
	{
		$paymentName = TestHelper::getRandomString();
		$getTransactions = TestHelper::getRandomBoolean();

		$request = $this->getRequest()
			->setPaywallPaymentName($paymentName)
			->setGetTransactions($getTransactions);

		self::assertEquals(PayWallPaymentDetails::REQUEST_TYPE, $request->getMethod());
		self::assertEquals([
			'paywallPaymentName' => $paymentName,
			'getTransactions' => $getTransactions
		], $request->getData());
		self::assertEquals([
			'PaywallPaymentName' => $paymentName,
			'GetTransactions' => $getTransactions
		], $request->getUcFirstData());
	}

	protected function getRequest(): PayWallPaymentDetails
	{
		return new PayWallPaymentDetails();
	}
}
