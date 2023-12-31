<?php 

namespace App\Interfaces;

interface IProductRepository
{
    public function getAll();
    public function find($uuid);
    public function create($request);
    public function update($product, $request);
    public function delete($id);
}

?>