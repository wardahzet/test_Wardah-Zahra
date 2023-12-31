<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id', 'transactions_id', 'quantity', 'status', 'total'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }


}
