<?php

namespace App\Http\Controllers;

use App\Actions\BuildUserAnalytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __invoke(Request $request, BuildUserAnalytics $analytics)
    {
        return view('analytics', [
            'stats' => $analytics->handle($request->user()),
        ]);
    }
}
