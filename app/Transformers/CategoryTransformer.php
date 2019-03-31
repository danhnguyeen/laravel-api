<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => (int)$category->id,
            'title' => (string)$category->name,
            'detail' => (string)$category->description,
            'createdAt' => $category->created_at,
            'updatedAt' => $category->updated_at,
            'deletedAt' => $category->deleted_at
        ];
    }
}
