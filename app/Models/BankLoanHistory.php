<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankLoanHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relationship
     **/
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
