<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\LandingPage
     */
    protected function getLandingPage(Request $request)
    {
        $host = $request->getHost();

        $subdomain = str_replace('.' . env('APP_DOMAIN'), '', $host);

        return LandingPage::where('subdomain', $subdomain)
            ->orWhere('domain', $host)
            ->first();
    }
}
