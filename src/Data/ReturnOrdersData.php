<?php

namespace Alsaloul\Microtec\Data;

class ReturnOrdersData
{
    public $id;
    public $date;
    public $name;
    public $phone;
    public $deliveryPrice;
    public $totalTax;
    public $totalPrice;
    public $totalDiscount;
    public $deliveryDiscount;
    public $isDeliveryTaxable;
    public $referenceId;
    public $sourceIntegrationId;
    public $products;

    public function __construct(
        string $id,
        string $date,
        string $name,
        string $phone,
        float $deliveryPrice,
        float $totalTax,
        float $totalPrice,
        float $totalDiscount,
        float $deliveryDiscount,
        bool $isDeliveryTaxable,
        string $referenceId,
        string $sourceIntegrationId,
        array $products
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->phone = $phone;
        $this->deliveryPrice = $deliveryPrice;
        $this->totalTax = $totalTax;
        $this->totalPrice = $totalPrice;
        $this->totalDiscount = $totalDiscount;
        $this->deliveryDiscount = $deliveryDiscount;
        $this->isDeliveryTaxable = $isDeliveryTaxable;
        $this->referenceId = $referenceId;
        $this->sourceIntegrationId = $sourceIntegrationId;
        $this->products = $products;
    }
}
