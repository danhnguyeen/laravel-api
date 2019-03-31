<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'id' => (int)$seller->id,
            'name' => (string)$seller->name,
            'email' => (string)$seller->email,
            'isVerified' => (int)$seller->verified,
            'createdAt' => (string)$seller->created_at,
            'updatedAt' => (string)$seller->updated_at,
            'deletedAt' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null
        ];
    }
}
