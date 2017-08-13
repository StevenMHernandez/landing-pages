<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $page = $this->getLandingPage($request);

        if (is_null($page)) {
            abort(404, 'That landing page was not found');
        }

        $page->load([
            'features',
            'socialLinks'
        ]);

        return view('landing', compact('page'));
    }
}
