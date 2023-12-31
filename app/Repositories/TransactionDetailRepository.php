<?php 

namespace App\Repositories;

use App\Interfaces\ITransactionDetailRepository;
use App\Models\TransactionDetail;

class TransactionDetailRepository implements ITransactionDetailRepository
{
    public function __construct(private TransactionDetail $transactionDetail) 
    {
    }

    public function getAll()
    {
        return $this->transactionDetail->with('transaction')->get();
    }

    public function find($uuid)
    {
        return $this->transactionDetail->with('transaction')->where('id', $uuid)->firstOrFail();
    }

    public function create($request)
    {
        return $this->transactionDetail->create($request);   
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