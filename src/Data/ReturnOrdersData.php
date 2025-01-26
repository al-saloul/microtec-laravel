<?php

namespace Alsaloul\Microtec\Data;

class ReturnOrdersData
{
    protected $attributes = [];

    public function __construct(array $data)
    {
        $this->attributes = $data;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
