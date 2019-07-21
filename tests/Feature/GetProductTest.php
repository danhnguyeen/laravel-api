<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetProductsTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @group get-products
     *
     * @return void
     */
    public function testGetProducts()
    {
        $user = User::find(101);

        $response = $this->actingAsAdmin()
                        ->json('GET', '/api/products');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'detail',
                        'picture',
                        'stock',
                        'createdAt',
                        'updatedAt'
                    ]
                ]
            ]);
    }
    /**
     * @group product-not-found
     *
     * @return void
     */
    public function testFindProduct()
    {
        $response = $this->json('GET', '/api/products/invail-id');

        $response
            ->assertStatus(404);
    }
    /**
     * Test validation when create product
     * @group prdoduct-create-validation
     *
     * @return void
     */
    public function testCreateProductValidation() {
        $response = $this->json('POST', '/api/sellers/1/products');

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'title',
                    'detail',
                    'stock'
                ]
            ]);
    }

    public function testCreateProduct() {
        Storage::fake('products');
        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->json('POST', '/api/sellers/1/products', [
            'title' => 'Product Test refresh',
            'detail' => 'Product Desc',
            'stock' => 1,
            'image' => $file
        ]);

        // Storage::disk('products')->assertExists($file->name());

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'detail',
                    'picture',
                    'stock',
                    'createdAt',
                    'updatedAt',
                ]
            ])
            ->assertJson([
                'data' => [
                    'title' => 'Product Test refresh',
                    'detail' => 'Product Desc',
                    'stock' => 1
                ]
            ]);
    }
}
