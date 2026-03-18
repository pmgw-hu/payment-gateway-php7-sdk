> Repository github.com/pmgw-hu/payment-gateway-php7-sdk (pmgw/payment-gateway-php7-sdk) is abandoned, you should avoid using it.<br>
><br>
> Use https://github.com/nevogate/payment-gateway-sdk-php ([nevogate/payment-gateway-sdk](https://packagist.org/packages/nevogate/payment-gateway-sdk)) instead.
# Nevogate Payment Gateway SDK - PHP

## Version

5.1.0

## Requirements

 * PHP 7.2
 * PHP cURL extension
 * PHP OpenSSL extension
 * PHP JSON extension

## Installation

Nevogate Payment Gateway is available at packagist.org, so you can use composer to download this library.

```yml
{
    "require": {
        "nevogate/payment-gateway-sdk": "^5.0@dev"
    }
}
```

or run

```sh
composer require nevogate/payment-gateway-sdk:^5.0@dev
```

## Technical documentation

https://docs.nevogate.com/

## Source code

https://github.com/nevogate/payment-gateway-sdk-php/tree/testing

## Example usage

### Basic configuration

```php
$config = new \Nevogate\PaymentGateway\Config();
$config->storeName = "example store name";
$config->apiKey = "ExamPleApiKey";
$config->encryptPublicKey = "publicKeyGoesHere";
$config->testMode = true;

$paymentGateway = new \Nevogate\PaymentGateway($config);
```

### Init request

```php
$init = new \Nevogate\PaymentGateway\Request\Init();
$init->setProviderName(\Nevogate\PaymentGateway::PROVIDER_CIB) // the chosen payment method
    ->setResponseUrl('http://your.companys.webshop.url/payment_gateway_response') // callback url
    ->setAmount(1234)
    ->setCurrency('HUF')
    ->setOrderId('ORD-1234') // your custom order id
    ->setUserId('USER-1234') // your custom user id
    ->setLanguage('HU');

$response = $paymentGateway->send($init);
```

#### Start request

```php
if (!$response->ResultCode == "SUCCESSFUL" || !$response->TransactionId) {
    // handle error here
}

$paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\Start())->setTransactionId($response->TransactionId)
    );
```

#### Result request

```php
$result = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\Result())->setTransactionId($_GET['TransactionId'])
    );
```

#### Details request

```php
$details = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\Details())->setTransactionId($_GET['TransactionId'])
    );
```

#### Close request

```php
$response = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\Close())->setTransactionId($transactionId)
    );
```

#### Refund request

```php
$response = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\Refund())
            ->setTransactionId($transactionId)
            ->setAmount(100)
    );
```

#### Payout request

```php
$payout = new \Nevogate\PaymentGateway\Request\Payout();
$payout->setPayoutType(\Nevogate\PaymentGateway::PAYOUT_TYPE_FUNDS_DISBURSEMENT)
    ->setReferenceTransactionId("783593c87fee4d372f47f53840028682")
    ->setAmount(200)
    ->setOrderId("NEVOGATE-TEST-ORDER-REG") // your custom order id
    ->setAdditionalMessage("NEVOGATE-TEST-PAYOUT-MESSAGE");

$response = $paymentGateway->send($payout);
```

#### Get payment registrations request

```php
$response = $paymentGateway->send(
    (new \Nevogate\PaymentGateway\Request\GetPaymentRegistrations())
        ->setProviderName(\Nevogate\PaymentGateway::PROVIDER_BARION2)
        ->setUserId('User1')
    );
```

#### Get payment registration request

```php
$response = $paymentGateway->send(
    (new \Nevogate\PaymentGateway\Request\GetPaymentRegistration())
        ->setTransactionId($transactionId)
);
```

#### Cancel payment registration request

```php
$response = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\CancelPaymentRegistration())->setTransactionId($transactionId)
    );
```

#### Cancel all payment registrations request

```php
$response = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\CancelAllPaymentRegistrations())
            ->setProviderName(\Nevogate\PaymentGateway::PROVIDER_BORGUN2)
            ->setUserId('userId')
    );
```

### Init Recurring Payment - InitRP

```php
$initRP = new \Nevogate\PaymentGateway\Request\InitRP();
$initRP->setReferenceTransactionId("783593c87fee4d372f47f53840028682")
    ->setResponseUrl("http://your.companys.webshop.url/payment_gateway_response") // callback url
    ->setAmount(200)
    ->setCurrency("HUF")
    ->setOrderId("NEVOGATE-TEST-ORDER-REG") // your custom order id
    ->setUserId("NEVOGATE-TEST-USER-REG");

$response = $paymentGateway->send($initRP);
```

#### StartRP request

```php
if (!$response->ResultCode == "SUCCESSFUL" || !$response->TransactionId) {
    // handle error here
}

$result = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\StartRP())->setTransactionId($response->TransactionId)
    );
```

### Create Payment Link - PaymentLinkCreate

```php
$paymentLink = new \Nevogate\PaymentGateway\Request\PaymentLinkCreate();
$paymentLink->setProviderName(\Nevogate\PaymentGateway::PROVIDER_CIB) // the chosen payment method
    ->setAmount(1234)
    ->setCurrency('HUF')
    ->setOrderId('ORD-1234') // your custom order id
    ->setUserId('USR-1234') // your customer id
    ->setLanguage('HU');

$response = $paymentGateway->send($paymentLink);
```

#### Cancel request

```php
$response = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\PaymentLinkCancel())->setPaymentLinkName($paymentLinkName)
    );
```

#### Details request

```php
$response = $paymentGateway->send(
        (new \Nevogate\PaymentGateway\Request\PaymentLinkDetails())->setPaymentLinkName($paymentLinkName)
    );
```

### Info data

#### Basic usage

```php
$infoObject = new \Nevogate\PaymentGateway\Data\Info();

$infoCustomerGeneral = new \Nevogate\PaymentGateway\Data\Info\Customer\InfoCustomerGeneral();
$infoCustomerGeneral->setFirstName("John")
    ->setLastName("Doe")
    ->setEmail("test@testmail.com");

$infoObject->setObject($infoCustomerGeneral); //add $infoCustomerGeneral to $infoObject
 
$infoShipping = new \Nevogate\PaymentGateway\Data\Info\Order\InfoOrderShippingData();
$infoShipping->setFirstName("John")
    ->setLastName("Doe")
    ->setEmail("test@testmail.com")
    ->setPhoneCc("36")
    ->setPhone("801234567")
    ->setCity("Budapest");

$infoObject->setObject($infoShipping); //add $infoShipping to $infoObject
 
$infoOrderProductItem = new \Nevogate\PaymentGateway\Data\Info\Order\InfoOrderProductItem();
$infoOrderProductItem->setSku("PMG055005")
    ->setName("Product11")
    ->setQuantity("10")
    ->setQuantityUnit("db")
    ->setUnitPrice("22.00")
    ->setImageUrl("http://webhsop/product11.jpg")
    ->setDescription("Product11 desc.");

$infoObject->setObject($infoOrderProductItem); //add $infoOrderProductItem to $infoObject
 
$infoOrderProductItem = new \Nevogate\PaymentGateway\Data\Info\Order\InfoOrderProductItem();
$infoOrderProductItem->setSku("PMG055008")
    ->setName("Product12")
    ->setQuantity("10")
    ->setQuantityUnit("db")
    ->setUnitPrice("22.00")
    ->setImageUrl("http://webhsop/product12.jpg")
    ->setDescription("Product12 desc.");

$infoObject->setObject($infoOrderProductItem); //add $infoOrderProductItem to $infoObject
```

#### Init

```php
...
    $init->setInfo($infoObject);
...
```

#### Payout

```php
...
    $payout->setInfo($infoObject);
...
```

#### InitRP

```php
...
    $initRP->setInfo($infoObject);
...
```

#### Payment Link

```php
...
    $paymentLink->setInfo($infoObject);
...
```
