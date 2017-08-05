<?php

namespace Tests\Feature;

use App\Models\LandingPage;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LandingPageTest extends TestCase
{
    use DatabaseMigrations;

    public function testSubdomainCreated()
    {
        $user = factory(User::class)->create([
            'email' => 'subdomaincreator@landing.app',
        ]);

        factory(LandingPage::class)->create([
            'subdomain' => 'test',
            'domain' => null,
            'user_id' => $user->id,
            'header' => 'Welcome to your doom!',
            'sign_up_text' => 'Sign On Up'
        ]);

        $response = $this->get('http://test.landing.app');

        $response->assertStatus(200)
            ->assertSee('Welcome to your doom!')
            ->assertSee('Sign On Up');
    }

    public function testUnknownSubdomainReturns404()
    {
        $response = $this->get('http://unknown.landing.app');
        $response->assertStatus(404)
            ->assertSee('Let\'s create your own landing page');
    }
}
