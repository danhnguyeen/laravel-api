<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsTest extends TestCase
{
    use DatabaseTransactions;

    protected $product;
    protected $seller;

    public function setUp(): void
    {
        parent::setUp();
        // your init data is here
        $this->seller = factory(User::class)->create();

        $this->product = factory(Product::class)->create([
            'seller_id' => $this->seller->id
        ]);
    }

    /**
     * @group product-list
     *
     * @return void
     */
    public function testGetProducts()
    {
        $response = $this->signIn($this->seller)
                        ->get('/api/products');

        $response->assertStatus(200)
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
     * @group product-find-id
     *
     * @return void
     */
    public function testProductNotFound()
    {
        $response = $this->actingAsAdmin()
                        ->get('/api/products/invail-id');

        $response->assertStatus(404);
    }
    /**
     * @group product-find-id
     *
     * @return void
     */
    public function testFindProduct()
    {
        $response = $this->actingAsAdmin()
                        ->get("/api/products/{$this->product->id}");

        $response->assertStatus(200)
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
                    'id' => $this->product->id,
                    'title' => $this->product->name
                ]
            ]);
    }
    /**
     * Test validation when create product
     * @group prdoduct-create-validation
     *
     * @return void
     */
    public function testCreateProductValidation() {
        $response = $this->actingAsAdmin()
                        ->post("/api/sellers/{$this->seller->id}/products");

        $response->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'name',
                    'description',
                    'quantity'
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

        $product = factory(Product::class)->make([
            'image' => $file
        ]);
        
        $response = $this->actingAsAdmin()
                        ->post("/api/sellers/{$this->seller->id}/products", $product->toArray());

        Storage::assertExists($file->hashName());

        $response->assertStatus(201)
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
                    'title' => $product->name,
                    'stock' => $product->quantity,
                    'seller' => $this->seller->id
                ]
            ]);

            $this->assertDatabaseHas('products', ['name' => $product->name]);;
    }
    /**
     * @group product-delete
     *
     * @return void
     */
    public function testShouldDeleteProduct() {
        $response = $this->actingAsAdmin()
                        ->delete("/api/sellers/{$this->seller->id}/products/{$this->product->id}");

        $response->assertStatus(200);
            
        $this->assertSoftDeleted('products', ['id' => $this->product->id]);
        // Storage::assertMissing($this->product->image);
    }
}
