<?php

namespace App\Http\Resources\Setting;

use App\Http\Resources\Contact\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'headquarter' => $this->getHQ(),
//            'postal' => $this->getPostal(),
            'phone' => $this->phones->first() ? $this->phones->first()->value : null,
            'email' => $this->emails->first() ? $this->emails->first()->value : null,
            'website' => $this->websites->first() ? $this->websites->first()->value : null,
        ];
    }

    private function getHQ()
    {
        $hq = $this->addresses->firstWhere('address_type', 'headquarter');
        return $hq == null ? [] : new Address($hq);
    }

//    private function getPostal()
//    {
//        $postal = $this->addresses->firstWhere('address_type', 'postal');
//        return $postal === null ? [] : new Address($postal);
//    }
}
