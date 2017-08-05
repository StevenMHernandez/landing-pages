<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $page = $this->getLandingPage($request);

        return view('thanks', compact('page'));
    }

    public function create()
    {
        return redirect()->route('show_subscription');
    }
}
