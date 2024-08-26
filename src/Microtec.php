<?php

namespace Alsaloul\Microtec;

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
}
