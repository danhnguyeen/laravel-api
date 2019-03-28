<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Scopes\SellerScope;

class Seller extends User
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SellerScope);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
