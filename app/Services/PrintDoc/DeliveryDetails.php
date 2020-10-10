<?php


namespace App\Services\PrintDoc;


class DeliveryDetails
{
    /**
     * Party constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->{$key} ?? null;
    }
}
