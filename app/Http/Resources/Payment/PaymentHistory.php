<?php

namespace App\Http\Resources\Payment;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentHistory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date ? Carbon::parse($this->payment_date)->format('d/m/Y') : null,
            'payment_note' => $this->payment_note,
        ];
    }
}
