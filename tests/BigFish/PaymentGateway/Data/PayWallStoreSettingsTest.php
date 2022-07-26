<?php

namespace BigFish\Tests\PaymentGateway\Data;

use BigFish\PaymentGateway\Data\PayWallStoreSettings;
use PHPUnit\Framework\TestCase;

class PayWallStoreSettingsTest extends TestCase
{
	/**
	 * @param array $data
	 * @param array $expected
	 * @test
	 * @dataProvider getDataFromStoreSettingsObjectDataProvider
	 */
	public function getDataFromStoreSettingsObject(array $data, array $expected): void
	{
		self::assertEquals($expected, $this->createPayWallSettingsObject($data)->getData());
	}

	public function getDataFromStoreSettingsObjectDataProvider(): array
	{
		return [
			[
				[],
				[],
			],
			[
				['brandName' => 'MhbKyogfSbaZzHyMhbKyogfSbaZzHy'],
				['BrandName' => 'MhbKyogfSbaZzHyMhbKyogfSbaZzHy'],
			],
			[
				['companyName' => 'utFoPwvQzYajzrLutFoPwvQzYajzrL'],
				['CompanyName' => 'utFoPwvQzYajzrLutFoPwvQzYajzrL'],
			],
			[
				['phone' => 'bhigZsPNwYvbifTbhigZsPNwYvbifT'],
				['Phone' => 'bhigZsPNwYvbifTbhigZsPNwYvbifT'],
			],
			[
				['email' => 'ogeyKgDwPQOSLEHogeyKgDwPQOSLEH'],
				['Email' => 'ogeyKgDwPQOSLEHogeyKgDwPQOSLEH'],
			],
			[
				['generalTermsAndConditionsUrl' => 'ozYajzrLutFoLEHoyogfSbaZzHQOSLEH'],
				['GeneralTermsAndConditionsUrl' => 'ozYajzrLutFoLEHoyogfSbaZzHQOSLEH'],
			],
			[
				['generalTermsAndConditionsCheckboxEnabled' => true],
				['GeneralTermsAndConditionsCheckboxEnabled' => true],
			],
			[
				['privacyPolicyUrl' => 'LEHoozPQOSzrLutoPwHoyogfSbaZzOSLELEH'],
				['PrivacyPolicyUrl' => 'LEHoozPQOSzrLutoPwHoyogfSbaZzOSLELEH'],
			],
			[
				['privacyPolicyCheckboxEnabled' => true],
				['PrivacyPolicyCheckboxEnabled' => true],
			],
			[
				['implicitlyAcceptNoticeEnabled' => true],
				['ImplicitlyAcceptNoticeEnabled' => true],
			],
		];
	}

	protected function createPayWallSettingsObject(array $data = []): PayWallStoreSettings
	{
		$settings = new PayWallStoreSettings();

		foreach ($data as $key => $value) {
			if (property_exists($settings, $key)) {
				$settings->{$key} = $value;
			}
		}
		return $settings;
	}
}
