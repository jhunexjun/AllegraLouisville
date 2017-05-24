<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    private $username;
    private $password;

    public function setUp() {
        parent::setUp();

        $this->username = 'dummy_user@xyz.com';
        $this->password = '123456';
    }

    /**
     *
     * @return void
     */
    public function testBaseUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Advantage Concepts');
        });
    }

    /* If can successfully logged in. */
    public function testLogin() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Forgot Your Password?')
                    ->type('email', $this->username) // username & password have to exist in the database.
                    ->type('password', $this->password)
                    ->press('Login')
                    ->assertPathIs('/home');
        });
    }
}
