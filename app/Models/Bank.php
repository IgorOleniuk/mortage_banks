<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relationship
     **/
    public function loans_history()
    {
        return $this->hasMany(BankLoanHistory::class);
    }
}
