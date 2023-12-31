<?php 

namespace App\Interfaces;

interface ITransactionDetailRepository
{
    public function getAll();
    public function find($uuid);
    public function create($request);
    public function update($transaction, $request);
    public function delete($id);
}

?>