<?php 

namespace App\Repositories;

use App\Interfaces\ITransactionRepository;
use App\Models\Transaction;

class TransactionRepository implements ITransactionRepository
{
    public function __construct(private Transaction $transaction) 
    {
    }
    public function getAll()
    {
        return $this->transaction->with(['transactionDetail', 'user', 'product'])->get();
    }

    public function find($uuid)
    {
        return $this->transaction->with(['transactionDetail', 'user', 'product'])->where('id', $uuid)->firstOrFail();
    }

    public function create($request)
    {
        return $this->transaction->create($request);   
    }

    public function update($id, $request)
    {
        return $this->find($id)->update($request);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}