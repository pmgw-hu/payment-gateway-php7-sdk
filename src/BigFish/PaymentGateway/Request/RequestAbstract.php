<?php

namespace BigFish\PaymentGateway\Request;

use BigFish\PaymentGateway\Common\BaseAbstract;

abstract class RequestAbstract extends BaseAbstract implements RequestInterface
{
	const REQUEST_TYPE = 'RequestAbstract';

	/**
	 * @return null|string
	 */
	public function getMethod(): string
	{
		return static::REQUEST_TYPE;
	}

	/**
	 * URL safe encode (base64)
	 *
	 * @param string $string
	 * @return string
	 */
	protected function urlSafeEncode(string $string): string
	{
		return str_replace(['+', '/', '='], ['-', '_', '.'], base64_encode($string));
	}
}
