<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;



class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_login()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/login');

        $response->assertStatus(200);
    }
    
    public function test_login_user_can_be_aunteticated_using_token()
    {
        $user = User::factory()->create;
        $role = Auth::user()->role;
        $checkrole = explode(',', $role); 

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        $response->assertAuthenticated();

        if (in_array('TALENT', $checkrole)) {
            Session::put('isTalent', 'talent') -> assertRedirect(RouteServiceProvider::HOMETALENT);
        } else {
            Session::put('isUMKM', 'umkm') -> assertRedirect(RouteServiceProvider::HOMEUMKM);
        }

        
    }

    public function test_login_user_with_wrong_password()
    {
        $user = User::factory()->create;
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $response->assertStatus(401);

        $response->assertGuest();
    }
}
