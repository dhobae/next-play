<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BerandaCarousel;
use App\Models\BerandaSponsor;
use App\Models\EventAcara;


class BerandaController extends Controller
{
  public function index()
  {
    $carousels = BerandaCarousel::orderBy("created_at", "asc")->get();
    $sponsors = BerandaSponsor::orderBy("created_at", "desc")->get();
    $events = EventAcara::latest()->take(3)->get();

    return view('user.beranda.index', compact('sponsors', 'carousels', 'events'));
  }
}
