<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EventAcara;
use App\Models\EventAcaraHero;
use App\Models\BerandaSponsor;

class EventAcaraController extends Controller
{
   public function index()
   {
      $sponsors = BerandaSponsor::orderBy("created_at", "desc")->get();
      $eventAcara = EventAcara::orderBy("created_at", "desc")->get();
      $hero = EventAcaraHero::latest()->first();

      return view('user.events.index', compact('sponsors', 'eventAcara', 'hero'));
   }

   public function show(EventAcara $event)
   {
      $relatedEvents = EventAcara::where('id', '!=', $event->id)
         ->inRandomOrder()
         ->take(3)
         ->get();

      return view('user.events.show', compact('event', 'relatedEvents'));
   }
}
