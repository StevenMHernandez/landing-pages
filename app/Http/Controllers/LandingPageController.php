<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $page = $this->getLandingPage($request)->load('features');

        if (is_null($page)) {
            abort(404, 'That landing page was not found');
        }

        return view('landing', compact('page'));
    }
}
