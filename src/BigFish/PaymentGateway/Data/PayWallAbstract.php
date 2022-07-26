<?php

namespace BigFish\PaymentGateway\Data;

abstract class PayWallAbstract
{
	/**
	 * @return array
	 * @access public
	 */
	public function getData()
	{
		$data = array();

		foreach (array_keys(get_object_vars($this)) as $var) {
			if ($this->{$var} === null) {
				continue;
			}
			$data[ucfirst($var)] = $this->{$var};
		}
		return $data;
	}
}
