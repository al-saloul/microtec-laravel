<?php

namespace Alsaloul\Microtec;

use Alsaloul\Microtec\Data\InvoiceOrdersData;
use Alsaloul\Microtec\Data\OrderData;
use Alsaloul\Microtec\Data\ReturnOrdersData;

class Microtec
{
    private static function authenticateClient()
    {
        $microtecClient = new MicrotecClient();
        $authResponse = $microtecClient->authenticate();

        if (!$authResponse['Success'] ?? false) {
            throw new \Exception('Authentication failed');
        }

        return [
            'client' => $microtecClient,
            'token' => $authResponse['Data']['Token'],
        ];
    }

    private static function syncOrder(array $orderData, string $type)
    {
        $authData = self::authenticateClient();
        $orderData['type'] = $type;

        if ($type === 'Return' && empty($orderData['sourceIntegrationId'])) {
            throw new \InvalidArgumentException('Missing sourceIntegrationId for return order');
        }

        foreach ($orderData['products'] as &$product) {
            if ($type === 'Return' && empty($product['sourceLineId'])) {
                throw new \InvalidArgumentException('Missing sourceLineId for product in return order');
            }

            $product['sourceLineId'] ?? null; 
        }
        
        return $authData['client']->syncOrderV2($orderData, $authData['token']);
    }

    /**
     * Sends order data to the Microtec system.
     *
     * @param OrderData $orderData The order data to be sent.
     * @return \Illuminate\Http\JsonResponse The response from the Microtec system.
     */
    public static function sendOrder(OrderData $orderData)
    {
        try {
            $orderArray = $orderData->toArray();
            $response = self::syncOrder($orderArray, 'Order');
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Sends invoice orders to the Microtec system.
     *
     * @param InvoiceOrdersData $orderData The order data to be sent.
     * @return \Illuminate\Http\JsonResponse The response from the Microtec system.
     */
    public static function sendInvoiceOrders(InvoiceOrdersData $orderData)
    {
        try {
            $orderArray = $orderData->toArray();
            $response = self::syncOrder($orderArray, 'Invoice');
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Sends return orders to the Microtec system.
     *
     * @param ReturnOrdersData $orderData The order data to be sent.
     * @return \Illuminate\Http\JsonResponse The response from the Microtec system.
     */
    public static function sendReturnOrders(ReturnOrdersData $orderData)
    {
        try {
            $orderArray = $orderData->toArray();
            $response = self::syncOrder($orderArray, 'Return');
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
