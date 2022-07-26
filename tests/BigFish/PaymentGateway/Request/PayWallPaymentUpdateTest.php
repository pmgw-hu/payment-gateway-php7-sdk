<?php

namespace BigFish\Tests\PaymentGateway\Request;

use BigFish\PaymentGateway\Request\PayWallPaymentUpdate;
use BigFish\Tests\TestHelper;
use PHPUnit\Framework\TestCase;

class PayWallPaymentUpdateTest extends TestCase
{
	/**
	 * @test
	 */
	public function getPayWallPaymentUpdateRequestData(): void
	{
		$amount = TestHelper::getRandomAmount();
		$paymentName = TestHelper::getRandomString();

		$request = $this->getRequest()
			->setAmount($amount)
			->setPaywallPaymentName($paymentName);

		self::assertEquals(PayWallPaymentUpdate::REQUEST_TYPE, $request->getMethod());
		self::assertEquals([
			'amount' => $amount,
			'paywallPaymentName' => $paymentName,
		], $request->getData());
		self::assertEquals([
			'Amount' => $amount,
			'PaywallPaymentName' => $paymentName,
		], $request->getUcFirstData());
	}

	protected function getRequest(): PayWallPaymentUpdate
	{
		return new PayWallPaymentUpdate();
	}
}
