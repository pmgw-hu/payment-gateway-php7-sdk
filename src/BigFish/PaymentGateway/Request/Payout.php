<?php

namespace BigFish\PaymentGateway\Request;

use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Data\Info;
use BigFish\PaymentGateway\Exception\PaymentGatewayException;

class Payout extends RequestAbstract
{
	const REQUEST_TYPE = 'Payout';

	/**
	 * Set the default values from the constants.
	 *
	 * Payout constructor
	 */
	public function __construct()
	{
		$this->setModuleName(PaymentGateway::NAME);
		$this->setModuleVersion(PaymentGateway::VERSION);
	}

	/**
	 * Set payout type
	 *
	 * @param string $payoutType
	 * @return $this
	 */
	public function setPayoutType(string $payoutType): self
	{
		return $this->setData($payoutType, 'payoutType');
	}

	/**
	 * Set the reference Payment Gateway transaction ID
	 *
	 * @param string $referenceTransactionId Identifier of the reference transaction ID
	 * @return $this
	 */
	public function setReferenceTransactionId(string $referenceTransactionId): self
	{
		return $this->setData($referenceTransactionId, 'referenceTransactionId');
	}

	/**
	 * Set payout amount
	 *
	 * @param float $amount Payout amount
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setAmount(float $amount): self
	{
		if ($amount <= 0) {
			throw new PaymentGatewayException('Only positive numbers allowed.');
		}
		return $this->setData($amount, 'amount');
	}

	/**
	 * Set the identifier of the order in your system
	 *
	 * @param mixed $orderId Order identifier
	 * @return $this
	 */
	public function setOrderId(string $orderId): self
	{
		return $this->setData($orderId, 'orderId');
	}

	/**
	 * Additional message that the card acceptor might want to provide
	 *
	 * @param mixed $additionalMessage Additional message
	 * @return $this
	 */
	public function setAdditionalMessage(string $additionalMessage): self
	{
		return $this->setData($additionalMessage, 'additionalMessage');
	}

	/**
	 * @param Info $info
	 * @return $this
	 */
	public function setInfo(Info $info): self
	{
		return $this->setData($this->urlSafeEncode(json_encode($info->getData())), 'info');
	}

	/**
	 * Save module name under the 'moduleName' key of the $data array.
	 *
	 * @param string $moduleName
	 * @return $this
	 * @access public
	 */
	public function setModuleName(string $moduleName): self
	{
		return $this->setData($moduleName, 'moduleName');
	}

	/**
	 * Save module version under the 'moduleVersion' key of the $data array.
	 *
	 * @param string $moduleVersion
	 * @return $this
	 * @access public
	 */
	public function setModuleVersion(string $moduleVersion): self
	{
		return $this->setData($moduleVersion, 'moduleVersion');
	}
}