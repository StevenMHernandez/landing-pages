<?php

namespace Tests\Feature;

use App\Models\LandingPage;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MainSiteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSubdomainCreated()
    {
        $user = factory(User::class)->create();

        factory(LandingPage::class)->create([
            'domain' => 'landing.app',
            'subdomain' => null,
            'user_id' => $user->id,
            'header' => "Let's get you some money!",
            'sign_up_text' => 'Sign Up Today'
        ]);

        $response = $this->get('http://landing.app');

        $response->assertStatus(200)
            ->assertSee(htmlentities("Let's get you some money!", ENT_QUOTES));
    }
}
