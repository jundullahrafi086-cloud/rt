<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Berita;
use App\Models\VideoProfil;
use App\Models\Setting;

class BerandaController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderByDesc('id')->get();

        return view('/index', [
            'sliders'     => $sliders,
            'beritas'     => Berita::where('status_id', 2)->latest()->take(3)->get(),
            'videoProfil' => VideoProfil::first()
        ]);
    }
}
