<?php

namespace App\Services;

use App\Models\Bank;

class BankService
{
    /**
     * Get all banks in DESC order
     */
    public function getBanks()
    {
        return Bank::latest()->get();
    }


    /**
     * Update or Create a bank
     */
    public function saveOrUpdateBank($bank, int $id = null)
    {
        return Bank::updateOrCreate(
            ['id' => $id],
            [
                'bank_name'         => $bank['bank_name'],
                'interest_rate'     => $bank['interest_rate'] * 100,
                'max_loan'          => $bank['max_loan'],
                'min_down_payment'  => $bank['min_down_payment'],
                'loan_term'         => $bank['loan_term']
            ]
        );
    }

    /**
     * Delete a bank
     */
    public function delete(int $id)
    {
        return Bank::findOrFail($id)->delete();
    }

    /**
     * Get bank's loan history
     */
    public function getLoanRecords(int $id)
    {
        return Bank::findOrFail($id)->loans_history()->latest()->get();
    }

    /**
     * Save a loan to bank history
     */
    public function addLoanRecord(int $id, $data)
    {
        return Bank::findOrFail($id)->loans_history()->create([
            'initial_loan' => $data['initial_loan'],
            'down_payment' => $data['down_payment'],
            'monthly_payment' => $data['monthly_payment'] * 100,
            'interest_rate' => $data['interest_rate'] * 100,
            'loan_term' => $data['loan_term']
        ]);
    }
}
