<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id' => (int)$transaction->id,
            'quantity' => (int)$transaction->quantity,
            'buyer' => (int)$transaction->buyer_id,
            'product' => (int)$transaction->product_id,
            'createdAt' => (string)$transaction->created_at,
            'updatedAt' => (string)$transaction->updated_at,
            'deletedAt' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null
        ];
    }
}
