<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Support\Visitor;
use Illuminate\Http\Request;

use function Illuminate\Support\defer;

class RedirectLinkController extends Controller
{
    public function __invoke(Request $request, Link $link)
    {
        $data = Visitor::from($request);

        defer(fn () => $link->clicks()->create($data));

        return redirect()->away($link->link);
    }
}
