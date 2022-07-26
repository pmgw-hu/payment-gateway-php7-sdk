<?php

namespace BigFish\Tests\PaymentGateway\Data;

use BigFish\PaymentGateway\Data\PayWallSettings;
use PHPUnit\Framework\TestCase;

class PayWallSettingsTest extends TestCase
{
	/**
	 * @param array $data
	 * @param array $expected
	 * @test
	 * @dataProvider getDataFromSettingsObjectDataProvider
	 */
	public function getDataFromSettingsObject(array $data, array $expected): void
	{
		self::assertEquals($expected, $this->createPayWallSettingsObject($data)->getData());
	}

	public function getDataFromSettingsObjectDataProvider(): array
	{
		return [
			[
				[],
				[],
			],
			[
				['hostedSuccessPage' => true],
				['HostedSuccessPage' => true],
			],
			[
				['enabledPaymentProviders' => ['ABC', 'DEF']],
				['EnabledPaymentProviders' => ['ABC', 'DEF']],
			],
			[
				['disabledPaymentProviders' => ['DEF', 'GHI']],
				['DisabledPaymentProviders' => ['DEF', 'GHI']],
			],
			[
				['paymentProviderOrder' => ['GHI', 'JKL']],
				['PaymentProviderOrder' => ['GHI', 'JKL']],
			],
			[
				['hidePaymentProviderOnDowntime' => false],
				['HidePaymentProviderOnDowntime' => false],
			],
			[
				['fallbackPaymentProviders' => ['GHI' => 'ABC', 'JKL' => 'DEF']],
				['FallbackPaymentProviders' => ['GHI' => 'ABC', 'JKL' => 'DEF']],
			],
			[
				['customPaymentOptionName' => ['GHI' => ['method' => 'ABC'], 'JKL' => ['method' => 'DEF']]],
				['CustomPaymentOptionName' => ['GHI' => ['method' => 'ABC'], 'JKL' => ['method' => 'DEF']]],
			],
			[
				['oneClickEnabled' => true],
				['OneClickEnabled' => true],
			],
			[
				['userPreferredSortingEnabled' => true],
				['UserPreferredSortingEnabled' => true],
			],
		];
	}

	protected function createPayWallSettingsObject(array $data = []): PayWallSettings
	{
		$settings = new PayWallSettings();

		foreach ($data as $key => $value) {
			if (property_exists($settings, $key)) {
				$settings->{$key} = $value;
			}
		}
		return $settings;
	}
}
