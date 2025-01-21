<?php

namespace Alsaloul\Microtec\Data;

class OrderData
{
    public $id;
    public $date;
    public $name;
    public $phone;
    public $deliveryPrice;
    public $totalTax;
    public $totalPrice;
    public $products;

    public function __construct($id, $date, $name, $phone, $deliveryPrice, $totalTax, $totalPrice, $products)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->phone = $phone;
        $this->deliveryPrice = $deliveryPrice;
        $this->totalTax = $totalTax;
        $this->totalPrice = $totalPrice;
        $this->products = $products;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'name' => $this->name,
            'phone' => $this->phone,
            'delivaryPrice' => $this->deliveryPrice,
            'totalTax' => $this->totalTax,
            'totalPrice' => $this->totalPrice,
            'products' => $this->products,
        ];
    }
}
