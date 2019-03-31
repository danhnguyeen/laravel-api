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
            'createdAt' => (string)$category->created_at,
            'updatedAt' => (string)$category->updated_at,
            'deletedAt' => isset($category->deleted_at) ? (string)$category->deleted_at : null
        ];
    }

    public static function originalAttribute($index) 
    {
        $attributes = [
            'id' => 'id',
            'title' => 'name',
            'detail' => 'description',
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
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
            'deleted_at' => 'deletedAt'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
