<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Shop\Customer;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomersTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * can list customers.
     *
     * @test
     * @group customers
     */
    public function can_list_customers()
    {
        $user = User::factory()->create();
        Customer::factory(15)->create();
        Passport::actingAs($user, ['manage-customers']);
        $response = $this->get('/api/customers?page[size]=5&page[number]=2');
        $response->assertOk()->assertJson(['meta' => [
            'current_page' => 2,
            'total' => 15,
            'per_page' => 5,
        ]]);
        $this->assertCount(5, $response->json('data'));
    }

    /**
     * can search customers.
     *
     * @test
     * @group customers
     * @group now
     */
    public function can_search_customers()
    {
        $user = User::factory()->create();
        Customer::factory(14)->create();
        Customer::factory()->create(['name' => 'xxxx']);
        Passport::actingAs($user, ['manage-customers']);
        $response = $this->get('/api/customers?page[size]=5&page[number]=1&filter[name]=xxx');
        $response->assertOk()->assertJson(['meta' => [
            'current_page' => 1,
            'total' => 1,
            'per_page' => 5,
        ]]);
        $this->assertCount(1, $response->json('data'));
    }

    /**
     * can show customers.
     *
     * @test
     * @group customers
     */
    public function can_show_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        Passport::actingAs($user, ['manage-customers']);
        $response = $this->get('/api/customers/'.$customer->id);
        $response->assertOk()->assertJson(['data' => $customer->toArray()]);
    }

    /**
     * can create customers.
     *
     * @test
     * @group customers
     */
    public function can_create_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->make();
        Passport::actingAs($user, ['manage-customers']);
        $response = $this->post('/api/customers', $customer->toArray());
        // $response->dd();
        $response->assertCreated()->assertJson(['data' => [
            'gender' => $customer->gender,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'birthday' => $customer->birthday->format('Y-m-d'),
        ]]);
    }

    /**
     * can update customers.
     *
     * @test
     * @group customers
     */
    public function can_update_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $newCustomer = Customer::factory()->make();
        Passport::actingAs($user, ['manage-customers']);
        $response = $this->put('/api/customers/'.$customer->id, $newCustomer->toArray());
        $response->assertOk()->assertJson(['data' => [
            'gender' => $newCustomer->gender,
            'name' => $newCustomer->name,
            'phone' => $newCustomer->phone,
            'birthday' => $newCustomer->birthday->format('Y-m-d'),
        ]]);
    }

    
    /**
     * can delete customers.
     *
     * @test
     * @group customers
     */
    public function can_delete_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        Passport::actingAs($user, ['manage-customers']);
        $response = $this->delete('/api/customers/'.$customer->id);
        $response->assertNoContent();
    }
}
