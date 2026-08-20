<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HubungiKami;
use Illuminate\Http\Request;

class HubungiKamiController extends Controller
{
    public function index()
    {
        $hubungiKami = HubungiKami::first();

        return view('admin.hubungikami.index', compact('hubungiKami'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'link_wa' => 'required|url|max:2048',
        ]);

        HubungiKami::create($validated);

        return back()->with('success', 'Link WhatsApp berhasil disimpan.');
    }

    public function update(Request $request, HubungiKami $hubungiKami)
    {
        $validated = $request->validate([
            'link_wa' => 'required|url|max:2048',
        ]);

        $hubungiKami->update($validated);

        return back()->with('success', 'Link WhatsApp berhasil diperbarui.');
    }
}
