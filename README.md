# Microtec Laravel Integration Package

This package integrates with the Microtec ERP system for sending invoices.

## Installation

1. Install via composer:

    ```
    composer require alsaloul/microtec
    ```

2. Publish the configuration file:

    ```
    php artisan vendor:publish --provider="Alsaloul\Microtec\MicrotecServiceProvider"
    ```

3. Set up your `.env` file with the following:

    ```
    MICROTEC_ENABLED=true
    MICROTEC_BASE_URL=https://intmicrotec.neat-url.com:7874
    MICROTEC_CLIENT_ID=your-client-id
    MICROTEC_SECURITY_KEY=your-security-key
    ```

## Usage

```php
use Alsaloul\Microtec\OrderData;
use Alsaloul\Microtec\Microtec;

$products = [
    [
        'id' => 122,
        'name' => 'product name',
        'itemPrice' => 100,
        'qty' => 1,
        'totalPrice' => 100,
    ]
];

$orderData = new OrderData(
    1212,
    '2024-08-20T12:12:01.310Z',
    'Mohammed Alsaloul',
    '+967775511357',
    10,
    15,
    125,
    $products
);

$microtec = Microtec::sendOrder($orderData);
return $microtec;
