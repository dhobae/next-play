<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\BerandaCarousel;
use App\Models\BerandaSponsor;
use App\Models\EventAcara;
use App\Models\Visitor;

class BerandaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'events' => EventAcara::count(),
                'athletes' => Atlet::count(),
                'visitors' => Visitor::count(),
                'sponsors' => BerandaSponsor::count(),
            ],
            'latestEvents' => EventAcara::latest()->take(3)->get(),
        ]);
    }
}
