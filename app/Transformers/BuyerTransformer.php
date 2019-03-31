<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'id' => (int)$buyer->id,
            'name' => (string)$buyer->name,
            'email' => (string)$buyer->email,
            'isVerified' => (int)$buyer->verified,
            'createdAt' => (string)$buyer->created_at,
            'updatedAt' => (string)$buyer->updated_at,
            'deletedAt' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null
        ];
    }
}
