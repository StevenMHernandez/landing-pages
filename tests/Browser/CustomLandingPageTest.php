<?php

namespace Tests\Browser;

use App\Models\EmailContent;
use App\Models\Feature;
use App\Models\LandingPage;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
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
            'name' => 'Doom Homepage 1994',
            'header' => 'Welcome to your doom!',
            'sign_up_text' => 'Sign On Up',
            'quote' => 'Such fresh, such clean',
            'full_description' => '# Markdown Description\nOk',
            'form_text' => 'Drop us a line and we can talk about what you need from us.',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('http://test.landing.app')
                ->driver->executeScript('window.scrollTo(0, 2200);');
            $browser->assertSee('Doom Homepage 1994')
                ->assertSee(strtoupper('Welcome to your doom!'))
                ->assertSee(strtoupper('Such fresh, such clean'))
                ->assertSee('Markdown Description')
                ->assertDontSee('# Markdown Description')
                ->assertSee('Drop us a line and we can talk about what you need from us.')
                ->assertValue('input[type="submit"]', 'Sign On Up')
                ->assertDontSeeIn('.g-recaptcha', '');
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
            'header' => "Get money!",
            'sign_up_text' => 'Sign Up Today'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('http://landing.app')
                ->assertSee(strtoupper("Get money!"));
        });
    }

    public function testFormSubmit()
    {
        $this->user = factory(User::class)->create([
            'email' => 'subdomaincreator@landing.app',
        ]);

        $landingPage = factory(LandingPage::class)->create([
            'subdomain' => 'test',
            'domain' => null,
            'user_id' => $this->user->id,
            'header' => 'Welcome to your doom!',
            'sign_up_text' => 'Sign On Up',
            'thanks_text' => 'Aye, Thanks!',
            'thanks_full_text' => 'We will let you know as things happen!',
        ]);

        factory(EmailContent::class)->create([
            'landing_page_id' => $landingPage->id,
            'thanks_text' => 'Thanks for your doom',
            'description_text' => 'Mwahahaha',
        ]);

        $this->browse(function (Browser $browser) use ($landingPage) {
            Notification::fake();

            $browser->visit('http://test.landing.app')
                ->pause(100)
                ->assertSee(strtoupper('Welcome to your doom!'))
                ->assertValue('input[type="submit"]', 'Sign On Up')
                ->type('email', 'user@example.com')
                ->type('description', 'We are an example company')
                ->press('Sign On Up')
                ->assertSee('Aye, Thanks!')
                ->assertSee('We will let you know as things happen!')
                ->refresh()
                ->assertRouteIs('show_subscription');

            $subscribers = $landingPage->subscribers()->get();

            $this->assertCount(1, $subscribers);
        });
    }

    public function testFormSubmitFail()
    {
        $this->user = factory(User::class)->create([
            'email' => 'subdomaincreator@landing.app',
        ]);

        $landingPage = factory(LandingPage::class)->create([
            'subdomain' => 'test',
            'domain' => null,
            'user_id' => $this->user->id,
            'header' => 'Welcome to your doom!',
            'sign_up_text' => 'Sign On Up',
            'thanks_text' => 'Aye, Thanks!',
            'thanks_full_text' => 'We will let you know as things happen!',
        ]);

        factory(EmailContent::class)->create([
            'landing_page_id' => $landingPage->id,
            'thanks_text' => 'Thanks for your doom',
            'description_text' => 'Mwahahaha',
        ]);

        $this->browse(function (Browser $browser) use ($landingPage) {
            Notification::fake();

            // Don't type email or description
            $browser->visit('http://test.landing.app')
                ->driver->executeScript('window.scrollTo(0, 2200);');
            $browser->pause(100)
                ->assertSee(strtoupper('Welcome to your doom!'))
                ->assertValue('input[type="submit"]', 'Sign On Up')
                ->press('Sign On Up')
                ->waitForText('Email required')
                ->assertRouteIs('landing_page');

            // Don't type email
            $browser->visit('http://test.landing.app')
                ->driver->executeScript('window.scrollTo(0, 2200);');
            $browser->pause(100)
                ->assertSee(strtoupper('Welcome to your doom!'))
                ->assertValue('input[type="submit"]', 'Sign On Up')
                ->type('description', 'We are an example company')
                ->press('Sign On Up')
                ->waitForText('Email required')
                ->assertRouteIs('landing_page');

            // Don't type description
            $browser->visit('http://test.landing.app')
                ->driver->executeScript('window.scrollTo(0, 2200);');
            $browser->pause(100)
                ->assertSee(strtoupper('Welcome to your doom!'))
                ->assertValue('input[type="submit"]', 'Sign On Up')
                ->type('email', 'user@example.com')
                ->press('Sign On Up')
                ->waitForText('Description required')
                ->assertRouteIs('landing_page');

            $subscribers = $landingPage->subscribers()->get();

            $this->assertCount(0, $subscribers);
        });
    }

    public function testIconFeatures()
    {
        $this->user = factory(User::class)->create([
            'email' => 'subdomaincreator@landing.app',
        ]);

        $landingPage = factory(LandingPage::class)->create([
            'subdomain' => 'test',
            'domain' => null,
            'user_id' => $this->user->id,
            'header' => 'Testing Icon Features',
            'sign_up_text' => 'Sign On Up',
            'thanks_text' => 'Aye, Thanks!',
            'thanks_full_text' => 'We will let you know as things happen!',
        ]);

        factory(Feature::class)->create([
            'landing_page_id' => $landingPage->id,
            'icon' => 'fa-file-excel-o',
            'header' => 'Pulling in your excel files.',
            'body' => 'We make it easy.'
        ]);

        factory(Feature::class)->create([
            'landing_page_id' => $landingPage->id,
            'icon' => 'fa-space-shuttle',
            'header' => 'Get ready for orbit',
            'body' => 'We\'ll help push your reports into space.'
        ]);

        factory(Feature::class)->create([
            'landing_page_id' => $landingPage->id,
            'icon' => 'fa-stethoscope',
            'header' => 'Keeping your company healthy',
            'body' => 'Watching the status of your business.'
        ]);

        $this->browse(function (Browser $browser) use ($landingPage) {
            $browser->visit('http://test.landing.app')
                ->driver->executeScript('window.scrollTo(0, 900);');
            $browser
                ->waitFor('.fa-file-excel-o')
                ->assertSee(strtoupper('Pulling in your excel files.'))
                ->assertSee('We make it easy')
                ->waitFor('.fa-space-shuttle')
                ->assertSee(strtoupper('Get ready for orbit'))
                ->assertSee('We\'ll help push your reports into space.')
                ->waitFor('.fa-stethoscope')
                ->assertSee(strtoupper('Keeping your company healthy'))
                ->assertSee('Watching the status of your business.');
        });
    }

    public function testSocialIcons()
    {
        $this->user = factory(User::class)->create([
            'email' => 'subdomaincreator@landing.app',
        ]);

        $landingPage = factory(LandingPage::class)->create([
            'subdomain' => 'test',
            'domain' => null,
            'user_id' => $this->user->id,
            'header' => 'Testing Icon Features',
            'sign_up_text' => 'Sign On Up',
            'thanks_text' => 'Aye, Thanks!',
            'thanks_full_text' => 'We will let you know as things happen!',
        ]);

        factory(SocialLink::class)->create([
            'landing_page_id' => $landingPage->id,
            'icon' => 'icon-facebook',
            'url' => 'http://facebook.com',
        ]);

        factory(SocialLink::class)->create([
            'landing_page_id' => $landingPage->id,
            'icon' => 'icon-tumblr',
            'url' => 'http://tumblr.com',
        ]);

        $this->browse(function (Browser $browser) use ($landingPage) {
            $browser->visit('http://test.landing.app')
                ->driver->executeScript('window.scrollTo(0, 2200);');
            $browser->waitFor('.icon-facebook')
                ->click('.icon-facebook');

            $this->assertEquals('https://www.facebook.com/', $browser->driver->getCurrentURL());

            $browser
                ->back()
                ->click('.icon-tumblr');

            $this->assertEquals('https://www.tumblr.com/', $browser->driver->getCurrentURL());
        });
    }
}
