<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway\Request\RequestInterface;

abstract class SimpleRequestAbstract extends \PHPUnit\Framework\TestCase
{

	abstract protected function getDataWithRequestFunction(\Closure $function);

	/**
	 * @test
	 */
	public function getData()
	{
		$this->getDataWithRequestFunction(
			function ($dataKey, $value, RequestInterface $request) {
				$this->assertEquals($request->getData()[$dataKey], $value);
			}
		);
	}

	/**
	 * @test
	 */
	public function getUcFirstData()
	{
		$this->getDataWithRequestFunction(
			function ($dataKey, $value, RequestInterface $request) {
				$this->assertEquals($request->getUcFirstData()[ucfirst($dataKey)], $value);
			}
		);
	}

	/**
	 * URL safe encode (base64)
	 *
	 * @param string $string
	 * @return string
	 */
	public function urlSafeEncode(string $string): string
	{
		return str_replace(['+', '/', '='], ['-', '_', '.'], base64_encode($string));
	}
}
