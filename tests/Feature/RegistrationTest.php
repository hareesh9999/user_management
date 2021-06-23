<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;


class RegistrationTest extends TestCase
{
    use RefreshDatabase;



public function test_registration_screen_can_be_rendered()
{
    $response= $this->get('/register');
    $response->assertStatus(200);

}

public function test_new_users_can_register()
{
    $response = $this->post('/register',['name'=>'test user','email'=>'test@gmail.com','password' => '654321','password_confirmation' => '654321']);
    $user= factory(User::class)->create();;
   $this->actingAs($user);
    $response = $this->get('/home');
    $this->assertAuthenticated();
   $response->assertStatus(200);
    //$response = $this->post('/register',['name'=>'test user','email'=>'test@gmail.com','password' => '654321','password_confirmation' => '654321']);
    //$response->assertRedirect('/');

}

}