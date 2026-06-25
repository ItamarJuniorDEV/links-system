<?php

namespace App\Support;

use Illuminate\Http\Request;

class Visitor
{
    public static function from(Request $request): array
    {
        $referer = $request->headers->get('referer');

        return [
            'device' => str_contains(strtolower((string) $request->userAgent()), 'mobi') ? 'mobile' : 'desktop',
            'referer' => $referer ? parse_url($referer, PHP_URL_HOST) : null,
            'ip_hash' => hash('sha256', $request->ip().config('app.key')),
        ];
    }
}
