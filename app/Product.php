<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Seller;
use App\Transaction;
use App\Category;

class Product extends Model
{
    use SoftDeletes;
    
    const AVAILABE_PRODUCT = 'available';
    const UNAVAILABE_PRODUCT = 'unavailable';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'image',
        'status',
        'seller_id'
    ];

    public function isAvailable() {
        return $this->status == Product::AVAILABE_PRODUCT;
    }

    public function seller() {
        return $this->belongsTo(Seller::class);
    }

    public function tranctions() {
        return $this->hasMany(Transaction::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
