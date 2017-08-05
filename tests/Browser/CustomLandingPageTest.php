<?php

namespace Tests\Browser;

use App\Models\LandingPage;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomLandingPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\Models\User
     */
    public $user;

    public function testSubdomainCreated()
    {
        $this->user = factory(User::class)->create([
            'email' => 'subdomaincreator@landing.app',
        ]);

        factory(LandingPage::class)->create([
            'subdomain' => 'test',
            'domain' => null,
            'user_id' => $this->user->id,
            'header' => 'Welcome to your doom!',
            'sign_up_text' => 'Sign On Up'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('http://test.landing.app')
                ->assertSee('Welcome to your doom!')
                ->assertSee('Sign On Up');
        });
    }

    public function testUnknownSubdomainReturns404()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://test.landing.app')
                ->assertSee('Let\'s create your own landing page');

            $this->getStatus(404);
        });
    }

    public function testFullDomain()
    {
        $this->user = factory(User::class)->create([
            'email' => '1337webmasterxXxX@landing.app',
        ]);

        factory(LandingPage::class)->create([
            'domain' => 'landing.app',
            'subdomain' => null,
            'user_id' => $this->user->id,
            'header' => "Let's get you some money!",
            'sign_up_text' => 'Sign Up Today'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('http://landing.app')
                ->assertSee("Let's get you some money!");
        });
    }
}
