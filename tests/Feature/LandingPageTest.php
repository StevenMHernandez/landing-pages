<?php

namespace Tests\Feature;

use App\Models\LandingPage;
use App\Models\User;
use App\Notifications\NewSubscriber;
use App\Notifications\Subscribed;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LandingPageTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * @var \App\Models\User
     */
    public $user;

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

    public function testNotificationsSent()
    {
        Notification::fake();

        $this->user = factory(User::class)->create([
            'email' => 'subdomaincreator@landing.app',
        ]);

        $otherUser = factory(User::class)->create([
            'email' => 'otheruser@landing.app',
        ]);

        $landingPage = factory(LandingPage::class)->create([
            'subdomain' => 'test',
            'domain' => null,
            'user_id' => $this->user->id,
            'header' => 'Welcome to your doom!',
            'sign_up_text' => 'Sign On Up',
            'thanks_text' => 'Aye, Thanks!',
        ]);

        $this->post("http://test." . env('APP_DOMAIN') . route('create_subscription', [], false), [
            'email' => 'user@example.com',
            'description' => 'We are an example company',
        ])
            ->assertRedirect("http://test." . env('APP_DOMAIN') . route('show_subscription', [], false))
            ->assertStatus(302);

        $subscribers = $landingPage->subscribers()->get();

        $this->assertCount(1, $subscribers);

        Notification::assertSentTo($landingPage->owner()->get(), NewSubscriber::class);
        Notification::assertNotSentTo([$otherUser], NewSubscriber::class);
        Notification::assertSentTo([$subscribers[0]], Subscribed::class);
    }
}
