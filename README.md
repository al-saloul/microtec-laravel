# Microtec Laravel Integration Package

This package integrates with the Microtec ERP system for sending invoices, returns, and other order types seamlessly.

## Installation

1. Install via composer:

    ```bash
    composer require alsaloul/microtec
    ```

2. Publish the configuration file:

    ```bash
    php artisan vendor:publish --provider="Alsaloul\Microtec\MicrotecServiceProvider"
    ```

3. Set up your `.env` file with the following:

    ```env
    MICROTEC_ENABLED=true
    MICROTEC_BASE_URL=https://intmicrotec.neat-url.com:7874
    MICROTEC_CLIENT_ID=your-client-id
    MICROTEC_SECURITY_KEY=your-security-key
    ```

## Usage

### Sending Orders

To send an order to Microtec, use the `OrderData` class and the `Microtec::sendOrder` method:

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
    '+967774411357',
    10,
    15,
    125,
    $products
);

$response = Microtec::sendOrder($orderData);
return $response;
```

### Sending Invoice Orders

To send multiple invoice orders, use the `InvoiceOrdersData` class and the `Microtec::sendInvoiceOrders` method:

```php
use Alsaloul\Microtec\Data\InvoiceOrdersData;
use Alsaloul\Microtec\Microtec;

$ordersData = [
    new InvoiceOrdersData([
        'id' => 1,
        'date' => '2024-08-20T12:12:01.310Z',
        'Mohammed Alsaloul',
        '+967774411357',
        'deliveryPrice' => 20,
        'totalTax' => 5,
        'totalPrice' => 105,
        'totalDiscount' => 10,
        'deliveryDiscount' => 5,
        'isDeliveryTaxable' => true,
        'referenceId' => 'INV12345',
        'products' => [
            [
                'id' => 101,
                'name' => 'Product 1',
                'itemPrice' => 50,
                'qty' => 2,
                'totalPrice' => 100,
            ]
        ]
    ]),
    // Add more InvoiceOrdersData objects as needed
];

$responses = Microtec::sendInvoiceOrders($ordersData);
return $responses;
```

### Sending Return Orders

To send multiple return orders, use the `ReturnOrdersData` class and the `Microtec::sendReturnOrders` method:

```php
use Alsaloul\Microtec\Data\ReturnOrdersData;
use Alsaloul\Microtec\Microtec;

$returnOrdersData = [
    new ReturnOrdersData([
        'id' => 2,
        'date' => '2024-08-21T14:15:00.000Z',
        'Mohammed Alsaloul',
        '+967774411357',
        'deliveryPrice' => 10,
        'totalTax' => 2,
        'totalPrice' => 50,
        'totalDiscount' => 5,
        'deliveryDiscount' => 2,
        'isDeliveryTaxable' => false,
        'referenceId' => 'RET67890',
        'sourceIntegrationId' => 'SRC98765',
        'products' => [
            [
                'id' => 102,
                'name' => 'Returned Product',
                'itemPrice' => 25,
                'qty' => 2,
                'totalPrice' => 50,
                'sourceLineId' => 'SL123'
            ]
        ]
    ]),
    // Add more ReturnOrdersData objects as needed
];

$responses = Microtec::sendReturnOrders($returnOrdersData);
return $responses;
```

## Notes

- Make sure your `.env` variables are properly set to ensure successful communication with the Microtec ERP system.
- For additional customization or error handling, refer to the `MicrotecClient` class methods.

## Support

For issues or feature requests, please create an issue on the [GitHub repository](https://github.com/al-saloul/microtec).

