<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank.bank_name'         => 'required|string|max:255',
            'bank.interest_rate'     => 'required|numeric',
            'bank.max_loan'          => 'required|numeric',
            'bank.min_down_payment'  => 'required|numeric',
            'bank.loan_term'         => 'required|numeric',
        ];
    }


    /**
     * Custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'bank.bank_name.required'         => 'Bank name is required field',
            'bank.interest_rate.required'     => 'Interest rate is required field',
            'bank.max_loan.required'          => 'Max loan is required field',
            'bank.min_down_payment.required'  => 'Minimum down payment is required field',
            'bank.loan_term.required'         => 'Loan term is required field',
        ];
    }
}
