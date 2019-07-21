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
        $response = $this->actingAsAdmin()
                        ->get('/api/products');

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
        $response = $this->actingAsAdmin()
                        ->get('/api/products/invail-id');

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
        $response = $this->actingAsAdmin()
                        ->post('/api/sellers/1/products');

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
    /**
     * @group product-create
     *
     * @return void
     */
    public function testShouldCreateProduct() {
        Storage::fake('products');
        $file = UploadedFile::fake()->image('product.jpg');

        $product = [
            'title' => '_product_test',
            'detail' => 'Product Desc',
            'stock' => 1,
            'image' => $file
        ];
        $response = $this->actingAsAdmin()
                        ->post("/api/sellers/1/products", $product);

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
                    'title' => $product['title'],
                    'detail' => $product['detail'],
                    'stock' => $product['stock']
                ]
            ]);

            $this->assertDatabaseHas('products', ['name' => $product['title']]);;
    }
    /**
     * @group product-delete
     *
     * @return void
     */
    public function testShouldDeleteProduct() {
        $response = $this->actingAsAdmin()
                        ->delete("/api/sellers/1/products/1");

        $response
            ->assertStatus(200);
            
        $this->assertSoftDeleted('products', ['id' => 1]);;
    }
}
