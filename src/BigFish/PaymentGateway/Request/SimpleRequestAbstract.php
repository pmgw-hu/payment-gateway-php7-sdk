<?php

namespace BigFish\PaymentGateway\Request;


abstract class SimpleRequestAbstract extends RequestAbstract
{
	/**
	 * @param string $transactionId Transaction ID received from Payment Gateway
	 * @return $this
	 */
	public function setTransactionId(string $transactionId)
	{
		return $this->setData($transactionId, 'transactionId');
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