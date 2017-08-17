<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Notifications\NewSubscriber;
use App\Notifications\Subscribed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $page = $this->getLandingPage($request);

        return view('thanks', compact('page'));
    }

    public function create(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'description' => 'required',
        ];

        if (!app()->environment('test')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $this->validate($request, $rules);

        $page = $this->getLandingPage($request);

        $subscriber = new Subscriber();
        $subscriber->email = $request->input('email');
        $subscriber->landingPage()->associate($page);
        $subscriber->save();

        Notification::send($page->owner()->get(), new NewSubscriber($subscriber));
        Notification::send([$subscriber], new Subscribed($subscriber));

        return redirect()->route('show_subscription');
    }
}
