<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Transaction;
use App\Product;
use App\Seller;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        User::truncate();
        Product::truncate();
        Transaction::truncate();
        Category::truncate();
        DB::table('category_product')->truncate();

        $usersQuantity = 500;
        $categoriesQuantity = 30;
        $productsQuantity = 500;
        $transactionsQuantity = 500;

        factory(User::class, $usersQuantity)->create();
        factory(Category::class, $categoriesQuantity)->create();
        
        factory(Product::class, $productsQuantity)->create()->each(function ($product) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');

            $product->categories()->attach($categories);
        });
        factory(Transaction::class, $transactionsQuantity)->create();

    }
}
