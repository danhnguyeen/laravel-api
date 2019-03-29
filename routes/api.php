<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Buyer
 */
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
/**
 * Categories
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
/**
 * Product
 */
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);
/**
 * seller
 */
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
/**
 * Transaction
 */
Route::resource('transactions', 'TranSaction\TranSactionController', ['only' => ['index', 'show']]);
// transactions/{transaction_id}/categories
Route::resource('transactions.categories', 'TranSaction\TransactionCategoryController', ['only' => ['index']]);
Route::resource('transactions.sellers', 'TranSaction\TransactionSellerController', ['only' => ['index']]);
/**
 * User
 */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);