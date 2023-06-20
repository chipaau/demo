<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * can get authenticated user.
     *
     * @test
     */
    public function can_get_authenticated_user()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->get('/api/user');
        $response->assertOk()->assertJson(['data' => $user->toArray()]);
    }
}
