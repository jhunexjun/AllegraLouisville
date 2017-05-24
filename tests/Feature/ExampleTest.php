<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBaseURL()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testLogin() {
        $user = factory(User::class)->make(['email' => 'gdgdf@yahoo.com.ph']);

        $this->startSession();        
        $response = $this->actingAs($user, 'web')
                        ->withSession(['email' => 'gdgdf@yahoo.com.phll;'])
                        ->post('/login');

        $response->assertRedirect('home');

        $response->assertStatus(302);
    }

    public function testHomePage() {
        $user = factory(User::class)->make(['email' => 'gdgdf@yahoo.com.ph']);

        $this->startSession();
        $response = $this->actingAs($user, 'web')
                        ->withSession(['email' => 'gdgdf@yahoo.com.phll;'])
                        ->get('/home');

        $response->assertStatus(200);
    }

    public function testShowUsersAuthorized() {
        $user = factory(User::class)->make();

        // $user->username = $user->email;

        $this->startSession();        
        $response = $this->actingAs($user)
                        // ->withSession(['username' => $user->email, 'password' => $user->password])
                        ->get('/showUsers')
                        ;

        $response->assertStatus(200);
    }

}
