<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class LoginTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic test example.
     *~
     * @return void
     */

    public function test_success_login()
    {
        $user = User::factory()->create([
            'email' => 'sample@test.com',
            'password' =>  Hash::make('sample123'),
        ]);

        $loginData = ['email' => 'sample@test.com', 'password' => 'sample123'];

        $this->json('POST', '/api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'no_phone',
                    'created_at',
                    'updated_at'
                ],
                'access_token'
            ]);
        $this->assertAuthenticated();
    }

    // public function test_login_user_can_be_aunteticated_using_token()
    // {
    //     $user = User::factory()->create;
    //     $role = Auth::user()->role;
    //     $checkrole = explode(',', $role); 

    //     $response = $this->post('/api/login', [
    //         'email' => $user->email,
    //         'password' => 'password'
    //     ]);

    //     $response->assertStatus(200);

    //     $response->assertAuthenticated();

    //     if (in_array('TALENT', $checkrole)) {
    //         Session::put('isTalent', 'talent') -> assertRedirect(RouteServiceProvider::HOMETALENT);
    //     } else {
    //         Session::put('isUMKM', 'umkm') -> assertRedirect(RouteServiceProvider::HOMEUMKM);
    //     }


    // }

    public function test_login_user_with_wrong_password()
    {
        $user = User::factory()->create([
            'email' => 'sample@test.com',
            'password' =>  Hash::make('sample123'),
        ]);

        $loginData = ['email' => 'sample@test.com', 'password' => 'wrong_password'];

        $this->json('POST', '/api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "message" => "the credential is not found",
            ]);
    }
}
