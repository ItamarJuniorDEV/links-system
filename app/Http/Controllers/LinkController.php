<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;

class LinkController extends Controller
{
    public function create()
    {
        return view('links.create');
    }

    public function store(StoreLinkRequest $request)
    {
        $user = $request->user();

        $next = ($user->links()->max('sort') ?? 0) + 1;

        $user->links()->create(array_merge(
            $request->validated(),
            ['sort' => $next]
        ));

        return to_route('dashboard');
    }

    public function edit(Link $link)
    {
        return view('links.edit', compact('link'));
    }

    public function update(UpdateLinkRequest $request, Link $link)
    {
        $link->fill($request->validated())->save();

        return to_route('dashboard')->with('success', 'Alterado com sucesso!');
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return to_route('dashboard')->with('success', 'Deletado com sucesso!');
    }

    public function up(Link $link)
    {
        $link->moveUp();

        return back();
    }

    public function down(Link $link)
    {
        $link->moveDown();

        return back();
    }
}
