<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => (int)$product->id,
            'title' => (string)$product->name,
            'detail' => (string)$product->description,
            'stock' => (int)$product->quantity,
            'situation' => (string)$product->status,
            'picture' => url("img/{$product->status}"),
            'seller' => (int)$product->seller_id,
            'createdAt' => $product->created_at,
            'updatedAt' => $product->updated_at,
            'deletedAt' => $product->deleted_at
        ];
    }
}
