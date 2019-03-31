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
            'picture' => isset($product->image) ? url("img/{$product->image}") : null,
            'seller' => (int)$product->seller_id,
            'createdAt' => (string)$product->created_at,
            'updatedAt' => (string)$product->updated_at,
            'deletedAt' => isset($product->deleted_at) ? (string)$product->deleted_at : null
        ];
    }

    public static function originalAttribute($index) 
    {
        $attributes = [
            'id' => 'id',
            'title' => 'name',
            'detail' => 'description',
            'stock' => 'quantity',
            'situation' => 'status',
            'picture' => 'image',
            'seller' => 'seller_id',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
            'deletedAt' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index) 
    {
        $attributes = [
            'id' => 'id',
            'name' => 'title',
            'description' => 'detail',
            'quantity' => 'stock',
            'status' => 'situation',
            'image' => 'picture',
            'seller_id' => 'seller',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
            'deleted_at' => 'deletedAt'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
