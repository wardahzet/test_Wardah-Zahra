<?php 

namespace App\Repositories;

use App\Interfaces\IProductRepository;
use App\Models\Product;

class ProductRepository implements IProductRepository
{
    public function __construct(private Product $product) 
    {
    }

    public function getAll()
    {
        return $this->product->all();
    }

    public function find($uuid)
    {
        return $this->product->findOrFail($uuid);
    }

    public function create($request)
    {
        return $this->product->create($request);
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