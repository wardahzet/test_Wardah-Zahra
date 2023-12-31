<?php 

namespace App\Interfaces;

interface ITransactionRepository
{
    public function getAll();
    public function find($uuid);
    public function create($request);
    public function update($transactionDetail, $request);
    public function delete($id);
}

?>