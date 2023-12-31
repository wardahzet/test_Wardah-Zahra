<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Interfaces\IProductRepository;
use App\Interfaces\ITransactionRepository;
use App\Interfaces\ITransactionDetailRepository;

class TransactionService
{
    public function __construct(
        private ITransactionRepository $transaction, 
        private ITransactionDetailRepository $transactionDetail,
        private IProductRepository $product,
        ) {}

    public function createTransaction($request) {
        return DB::transaction(function () use ($request) {
            $product = $this->product->find($request['products_id']);
            if ($product->stock - $request['quantity'] < 0) throw new \Exception('quantity more than stock items');

            $this->product->update($request['products_id'], ['stock' => $product->stock - $request['quantity']]);
            $transaction = $this->transaction->create(collect($request)->put('id', Str::uuid())->all());
            $this->transactionDetail->create([
                'id' => Str::uuid(), 
                'total' => $request['quantity'] * $product->price,
                'transactions_id' => $transaction->id,
                'quantity' => $request['quantity']
            ]);
            return $this->transaction->find($transaction->id);
        });
    }

    public function cancelTransaction($request) {
        return DB::transaction(function() use ($request) {
            $transaction = $this->transaction->find($request['id']);
            $transactionDetail = $transaction->transactionDetails;
            if ($transactionDetail->status != 'Created') {
                throw new \Exception('Transaction can not be canceled in '. $transactionDetail->status.' status');
            }
            $product = $transaction->product;
            $this->product->update($product, ['stock' => $product->stock + $transactionDetail->quantity]);
            $this->transactionDetail->update($transactionDetail, ['status' => 'Cancelled']);
            $this->transaction->delete($transaction);
        });
    }
}