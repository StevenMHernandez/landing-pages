<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $subdomain = $this->getSubdomain($request->getHost());

        $page = LandingPage::where('subdomain', $subdomain)->first();

        if (is_null($page)) {
            abort(404, 'That landing page was not found');
        }

        return view('landing', compact('page'));
    }

    protected function getSubdomain($host)
    {
        return str_replace('.' . env('APP_DOMAIN'), '', $host);
    }
}
