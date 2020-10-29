<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $guarded = ['id'];
    protected $appends = ['formatted_address'];

    public function getFormattedAddressAttribute()
    {
        $address_line = $this->address_line_1;
        if ($this->address_line_2) {
            $address_line .= ' ' . $this->address_line_2;
        }
        return $this->attributes['formatted_address'] =
            $address_line
            . ', ' . $this->city
            . ', ' . $this->state
            . ' ' . $this->postcode;
    }
}
