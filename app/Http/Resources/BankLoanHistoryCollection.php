<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankLoanHistoryCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'initial_loan'      => $this->initial_loan,
            'down_payment'      => $this->down_payment,
            'monthly_payment'   => $this->monthly_payment / 100,
            'interest_rate'     => $this->interest_rate / 100,
            'loan_term'         => $this->loan_term
        ];
    }
}
