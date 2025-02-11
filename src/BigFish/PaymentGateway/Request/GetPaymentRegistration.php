<?php

namespace BigFish\PaymentGateway\Request;


class GetPaymentRegistration extends InitBaseAbstract
{
    const REQUEST_TYPE = 'GetPaymentRegistration';

    /**
     * @param string $transactionId
     * @return $this
     */
    public function setTransactionId(string $transactionId): self
    {
        return $this->setData($transactionId, 'transactionId');
    }
}
