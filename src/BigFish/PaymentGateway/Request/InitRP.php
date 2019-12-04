<?php

namespace BigFish\PaymentGateway\Request;

use BigFish\PaymentGateway\Exception\PaymentGatewayException;

class InitRP extends InitAbstract
{
	const REQUEST_TYPE = 'InitRP';

	/**
	 * Set the reference Payment Gateway transaction ID
	 *
	 * @param string $referenceTransactionId Identifier of the reference transaction ID
	 * @return InitRP
	 */
	public function setReferenceTransactionId(string $referenceTransactionId)
	{
		return $this->setData($referenceTransactionId, 'referenceTransactionId');
	}

	/**
	 * @param string $notificationUrl
	 * @return $this
	 * @throws PaymentGatewayException
	 */
	public function setNotificationUrl(string $notificationUrl): self
	{
		if (filter_var($notificationUrl, FILTER_VALIDATE_URL) === false) {
			throw new PaymentGatewayException('Invalid notification url');
		}

		return $this->setData($notificationUrl, 'notificationUrl');
	}
}