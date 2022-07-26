<?php

namespace BigFish\Tests;

class TestHelper
{
	public static function getRandomInteger(int $min = 0, int $max = PHP_INT_MAX): int
	{
		return random_int($min, $max);
	}

	public static function getRandomAmount(int $min = 100, int $max = 100000): float
	{
		return (float)self::getRandomInteger($min, $max);
	}

	public static function getRandomString(int $length = 16): string
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$str = '';

		for ($i = 0; $i < $length; $i++) {
			$str .= $chars[random_int(0, strlen($chars) - 1)];
		}
		return $str;
	}

	public static function getRandomEmail(): string
	{
		return sprintf('%s@%s.%s', self::getRandomString(), self::getRandomString(), self::getRandomString(2));
	}

	public static function getRandomUrl(): string
	{
		return sprintf('https://%s.%s', self::getRandomString(), self::getRandomString(2));
	}

	public static function getRandomBoolean(): bool
	{
		return (bool)self::getRandomInteger(0, 1);
	}

	public static function encodeArray(array $data)
	{
		return str_replace(['+', '/', '='], ['-', '_', '.'], base64_encode(json_encode($data)));
	}
}
