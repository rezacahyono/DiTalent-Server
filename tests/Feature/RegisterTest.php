<?php

namespace Tests\Feature;

use PDO;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_requiered_email_registration()
    {
        $registerData = [
            "name" => "John Doe",
            "role" => "UMKM",
            "no_phone" => "098297289282",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'message' => 'The email field is required.'
            ]);
    }

    public function test_requiered_name_registration()
    {
        $registerData = [
            // "name" => "John Doe",
            "email" => "doe@example.com",
            "role" => "UMKM",
            "no_phone" => "098297289282",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'message' => 'The name field is required.'
            ]);
    }

    public function test_requiered_role_registration()
    {
        $registerData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            // "role" => "UMKM",
            "no_phone" => "098297289282",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'message' => 'The role field is required.'
            ]);
    }

    public function test_requiered_no_phone_registration()
    {
        $registerData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "role" => "UMKM",
            // "no_phone" => "098297289282",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'message' => 'The no phone field is required.'
            ]);
    }

    public function test_requiered_password_registration()
    {
        $registerData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "role" => "UMKM",
            "no_phone" => "098297289282",
            // "password" => "demo12345"
        ];

        $this->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'message' => 'The password field is required.'
            ]);
    }

    public function test_success_registration()
    {
        $registerData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "role" => "UMKM",
            "no_phone" => "098297289282",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'message' => 'User created'
            ]);
    }
}
