<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class LoginTest extends TestCase
{

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
                'message',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'no_phone',
                    'avatar',
                    'address',
                    'created_at',
                    'updated_at'
                ],
                'access_token'
            ]);
        $this->assertAuthenticated();
    }

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

    public function test_requiered_email_login()
    {
        $user = User::factory()->create([
            'email' => 'sample@test.com',
            'password' =>  Hash::make('sample123'),
        ]);

        $loginData = [
            'email' => '',
            "password" => "sample123"
        ];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'message' => 'The email field is required.'
            ]);
    }

    public function test_requiered_password_login()
    {
        $user = User::factory()->create([
            'email' => 'sample@test.com',
            'password' =>  Hash::make('sample123'),
        ]);

        $loginData = [
            'email' => 'sample@test.com',
            "password" => ""
        ];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'message' => 'The password field is required.'
            ]);
    }
}
