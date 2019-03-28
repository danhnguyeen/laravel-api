<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;
use App\Scopes\BuyerScope;

class Buyer extends User
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope);
    }
    
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
