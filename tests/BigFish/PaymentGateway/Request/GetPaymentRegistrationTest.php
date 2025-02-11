<?php

namespace BigFish\Tests\PaymentGateway\Request;


use BigFish\PaymentGateway;
use BigFish\PaymentGateway\Request\GetPaymentRegistration;
use BigFish\PaymentGateway\Request\RequestInterface;

class GetPaymentRegistrationTest extends SimpleTransactionRequestAbstract
{

    protected function getRequest(string $transactionId): RequestInterface
    {
        return (new GetPaymentRegistration())->setTransactionId("127df1d1a8acdf8fd637d48bc884ccfe");
    }

    protected function getDataKeys():array
    {
        return array(
            'transactionId' => '127df1d1a8acdf8fd637d48bc884ccfe',
        );
    }
}
