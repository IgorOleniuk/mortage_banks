<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'bank_name'         => $this->bank_name,
            'interest_rate'     => $this->interest_rate / 100,
            'max_loan'          => $this->max_loan,
            'min_down_payment'  => $this->min_down_payment,
            'loan_term'         => $this->loan_term
        ];
    }
}
