<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankRequest;
use App\Http\Resources\BankCollection;
use App\Http\Resources\BankLoanHistoryCollection;
use App\Services\BankService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankController extends Controller
{
    public $bankService;

    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
    }
    public function getAllBanks(): JsonResource
    {
        return BankCollection::collection($this->bankService->getBanks());
    }

    public function createBank(StoreBankRequest $request): JsonResource
    {
        $this->bankService->saveOrUpdateBank($request->bank);
        return BankCollection::collection($this->bankService->getBanks());
    }

    public function updateBank(StoreBankRequest $request, int $id): JsonResource
    {
        $this->bankService->saveOrUpdateBank($request->bank, $id);
        return BankCollection::collection($this->bankService->getBanks());
    }

    public function deleteBank(int $id): JsonResource
    {
        $this->bankService->delete($id);
        return BankCollection::collection($this->bankService->getBanks());
    }

    public function getBankLoanHistory(int $id): JsonResource
    {
        return BankLoanHistoryCollection::collection($this->bankService->getLoanRecords($id));
    }

    public function addBankLoanHistory(int $id, Request $request): JsonResource
    {
        $this->bankService->addLoanRecord($id, $request->all());
        return BankLoanHistoryCollection::collection($this->bankService->getLoanRecords($id));
    }
}
