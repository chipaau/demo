<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Shop\Brand;
use App\Models\Shop\Product;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * can list products.
     *
     * @test
     * @group products
     */
    public function can_list_products()
    {
        $user = User::factory()->create();
        Product::factory(15)->create();
        Passport::actingAs($user, ['manage-products']);
        $response = $this->get('/api/products?page[size]=5&page[number]=2');
        $response->assertOk()->assertJson(['meta' => [
            'current_page' => 2,
            'total' => 15,
            'per_page' => 5,
        ]]);
        $this->assertCount(5, $response->json('data'));
    }

    /**
     * can show products.
     *
     * @test
     * @group products
     */
    public function can_show_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Passport::actingAs($user, ['manage-products']);
        $response = $this->get('/api/products/'.$product->id);
        $response->assertOk()->assertJson(['data' => [
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'description' => $product->description,
            'qty' => $product->qty,
            'security_stock' => $product->security_stock,
            'featured' => $product->featured,
            'is_visible' => $product->is_visible,
            'old_price' => $product->old_price,
            'price' => $product->price,
            'cost' => $product->cost,
            'type' => $product->type,
            'published_at' => $product->published_at->format('Y-m-d H:i:s'),
        ]]);
    }

    /**
     * can show products.
     *
     * @test
     * @group products
     */
    public function can_show_product_with_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $product = Product::factory()->create(['shop_brand_id' => $brand->id ]);
        Passport::actingAs($user, ['manage-products']);
        $response = $this->get('/api/products/'.$product->id.'?include=brand');
        $response->assertOk()->assertJson(['data' => [
            'name' => $product->name,
            'brand' => $brand->toArray(),
            'slug' => $product->slug,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'description' => $product->description,
            'qty' => $product->qty,
            'security_stock' => $product->security_stock,
            'featured' => $product->featured,
            'is_visible' => $product->is_visible,
            'old_price' => $product->old_price,
            'price' => $product->price,
            'cost' => $product->cost,
            'type' => $product->type,
            'published_at' => $product->published_at->format('Y-m-d H:i:s'),
        ]]);
    }

    /**
     * can create products.
     *
     * @test
     * @group products
     */
    public function can_create_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->make();
        Passport::actingAs($user, ['manage-products']);
        $response = $this->post('/api/products', $product->toArray());
        $response->assertCreated()->assertJson(['data' => [
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'description' => $product->description,
            'qty' => $product->qty,
            'security_stock' => $product->security_stock,
            'featured' => $product->featured,
            'is_visible' => $product->is_visible,
            'old_price' => $product->old_price,
            'price' => $product->price,
            'cost' => $product->cost,
            'type' => $product->type,
            'published_at' => $product->published_at->format('Y-m-d H:i:s'),
        ]]);
    }

    /**
     * can update products.
     *
     * @test
     * @group products
     * 
     */
    public function can_update_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $newProduct = Product::factory()->make();
        Passport::actingAs($user, ['manage-products']);
        $response = $this->put('/api/products/'.$product->id, $newProduct->toArray());
        $response->assertOk()->assertJson(['data' => [
            'name' => $newProduct->name,
            'slug' => $newProduct->slug,
            'sku' => $newProduct->sku,
            'barcode' => $newProduct->barcode,
            'description' => $newProduct->description,
            'qty' => $newProduct->qty,
            'security_stock' => $newProduct->security_stock,
            'featured' => $newProduct->featured,
            'is_visible' => $newProduct->is_visible,
            'old_price' => $newProduct->old_price,
            'price' => $newProduct->price,
            'cost' => $newProduct->cost,
            'type' => $newProduct->type,
            'published_at' => $newProduct->published_at->format('Y-m-d H:i:s'),
        ]]);
    }

    /**
     * can upload image to products.
     *
     * @test
     * @group products
     * @group now
     */
    public function can_upload_image_to_product()
    {
        Storage::fake('products');
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Passport::actingAs($user, ['manage-products']);
        $response = $this->put('/api/products/'.$product->id.'/upload', [
            'image' => UploadedFile::fake()->image($product->id.'.jpg')
        ]);
        $response->assertOk();
        // Assert the file was stored...
        $this->assertTrue(file_exists(storage_path("app/products/{$product->id}.jpg")));
    }

    
    /**
     * can delete products.
     *
     * @test
     * @group products
     * 
     */
    public function can_delete_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Passport::actingAs($user, ['manage-products']);
        $response = $this->delete('/api/products/'.$product->id);
        $response->assertNoContent();
    }
}
