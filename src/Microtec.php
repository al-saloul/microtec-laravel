<?php

namespace Alsaloul\Microtec;

use Alsaloul\Microtec\Data\InvoiceOrdersData;
use Alsaloul\Microtec\Data\OrderData;
use Alsaloul\Microtec\Data\ReturnOrdersData;

class Microtec
{
    public static function sendOrder(OrderData $orderData)
    {
        $microtecClient = new MicrotecClient();
        $authResponse = $microtecClient->authenticate();

        $authToken = $authResponse['success'] ?? false ? $authResponse['data']['token'] : null;

        if (!$authToken) {
            return response()->json(['error' => 'Authentication failed'], 401);
        }

        $orderArray = $orderData->toArray();
        $response = $microtecClient->syncOrder($orderArray, $authToken);

        return response()->json($response);
    }

    /**
     * Send multiple Invoice Orders to the external system for SyncOrder.
     *
     * @param InvoiceOrdersData $ordersData
     * @return array
     */
    public static function sendInvoiceOrders(InvoiceOrdersData $ordersData)
    {
        $microtecClient = new MicrotecClient();
        $authResponse = $microtecClient->authenticate();
        $authToken = $authResponse['success'] ?? false ? $authResponse['data']['token'] : null;

        if (!$authToken) {
            return response()->json(['error' => 'Authentication failed'], 401);
        }

        $responses = [];
        foreach ($ordersData as $orderData) {
            $orderData['type'] = 'Invoice';

            $orderData['sourceIntegrationId'] = null;
            foreach ($orderData['products'] as &$product) {
                $product['sourceLineId'] = null;
            }

            $response = $microtecClient->syncOrderV2($orderData, $authToken);
            $responses[] = $response;
        }

        return $responses;
    }
    
    /**
     * Send multiple Return Orders to the external system for SyncOrder.
     *
     * @param ReturnOrdersData $ordersData
     * @return array
     */
    public static function sendReturnOrders(ReturnOrdersData $ordersData)
    {
        $microtecClient = new MicrotecClient();
        $authResponse = $microtecClient->authenticate();
        $authToken = $authResponse['success'] ?? false ? $authResponse['data']['token'] : null;

        if (!$authToken) {
            return response()->json(['error' => 'Authentication failed'], 401);
        }

        $responses = [];
        foreach ($ordersData as $orderData) {
            $orderData['type'] = 'Return';

            if (!isset($orderData['sourceIntegrationId']) || empty($orderData['sourceIntegrationId'])) {
                $responses[] = [
                    'error' => 'Missing sourceIntegrationId for return order',
                    'data' => $orderData
                ];
                continue;
            }

            foreach ($orderData['products'] as &$product) {
                if (!isset($product['sourceLineId'])) {
                    $responses[] = [
                        'error' => 'Missing sourceLineId for product in return order',
                        'data' => $product
                    ];
                    continue 2;
                }
            }

            $response = $microtecClient->syncOrderV2($orderData, $authToken);
            $responses[] = $response;
        }

        return $responses;
    }
}
