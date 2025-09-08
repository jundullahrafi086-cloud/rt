<?php

namespace App\Http\Controllers;

use App\Models\Lkd;

class LkdPublicController extends Controller
{
    public function index()
    {
        $items = Lkd::published()->latest()->paginate(9);
        return view('lkd.index', compact('items'));
    }

    public function show(Lkd $lkd)
    {
        if (!$lkd->published) {
            abort(404);
        }
        $lkd->load(['members' => fn($q) => $q->ordered()]);
        return view('lkd.show', compact('lkd'));
    }
}
