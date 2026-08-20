<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TentangkamiHero;
use App\Models\TentangkamiVisimisi;

class TentangKamiController extends Controller
{
    public function index()
    {
        $hero = TentangkamiHero::latest()->first();
        $visimisi = TentangkamiVisimisi::latest()->first();
        return view('user.tentang-kami.index', compact('hero', 'visimisi'));
    }
}
