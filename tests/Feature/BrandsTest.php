<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Shop\Brand;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BrandsTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * can list brands.
     *
     * @test
     * @group brands
     */
    public function can_list_brands()
    {
        $user = User::factory()->create();
        Brand::factory(15)->create();
        Passport::actingAs($user, ['manage-brands']);
        $response = $this->get('/api/brands?page[size]=5&page[number]=2');
        $response->assertOk()->assertJson(['meta' => [
            'current_page' => 2,
            'total' => 15,
            'per_page' => 5,
        ]]);
        $this->assertCount(5, $response->json('data'));
    }

    /**
     * can show brands.
     *
     * @test
     * @group brands
     */
    public function can_show_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        Passport::actingAs($user, ['manage-brands']);
        $response = $this->get('/api/brands/'.$brand->id);
        $response->assertOk()->assertJson(['data' => $brand->toArray()]);
    }

    /**
     * can create brands.
     *
     * @test
     * @group brands
     */
    public function can_create_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->make();
        Passport::actingAs($user, ['manage-brands']);
        $response = $this->post('/api/brands', $brand->toArray());
        // $response->dd();
        $response->assertCreated()->assertJson(['data' => [
            'name' => $brand->name,
            'slug' => $brand->slug,
            'website' => $brand->website,
            'position' => $brand->position,
            'description' => $brand->description,
            'is_visible' => $brand->is_visible,
        ]]);
    }

    /**
     * can update brands.
     *
     * @test
     * @group brands
     * 
     */
    public function can_update_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $newBrand = Brand::factory()->make();
        Passport::actingAs($user, ['manage-brands']);
        $response = $this->put('/api/brands/'.$brand->id, $newBrand->toArray());
        $response->assertOk()->assertJson(['data' => [
            'name' => $newBrand->name,
            'slug' => $newBrand->slug,
            'website' => $newBrand->website,
            'position' => $newBrand->position,
            'description' => $newBrand->description,
            'is_visible' => $newBrand->is_visible,
        ]]);
    }

    
    /**
     * can delete brands.
     *
     * @test
     * @group brands
     */
    public function can_delete_brand()
    {
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        Passport::actingAs($user, ['manage-brands']);
        $response = $this->delete('/api/brands/'.$brand->id);
        $response->assertNoContent();
    }
}
