<?php

namespace BigFish\PaymentGateway\Request;

class Close extends SimpleRequestAbstract
{
	const REQUEST_TYPE = 'Close';

	/**
	 * @param bool $approve Approve or decline transaction (true/false)
	 * @return $this
	 */
	public function setApprove(bool $approve): self
	{
		return $this->setData($approve ? 'true' : 'false', 'approved');
	}

	/**
	 * Set approved amount
	 *
	 * @param float $approvedAmount Approved amount
	 * @return $this
	 */
	public function setApprovedAmount(float $approvedAmount): self
	{
		return $this->setData($approvedAmount, 'approvedAmount');
	}
}