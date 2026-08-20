<?php

namespace App\Http\Controllers\Admin\Beranda;

use App\Http\Controllers\Controller;
use App\Models\BerandaSponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sponsors = BerandaSponsor::latest()->get();

        return view('admin.beranda.sponsor.index', compact('sponsors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sponsor' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('gambar_sponsor', 'public');
        }

        BerandaSponsor::create($validated);

        return back()->with('success', 'Sponsor berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $sponsor = BerandaSponsor::findOrFail($id);

        $validated = $request->validate([
            'nama_sponsor' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($sponsor->gambar && Storage::disk('public')->exists($sponsor->gambar)) {
                Storage::disk('public')->delete($sponsor->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('gambar_sponsor', 'public');
        }

        $sponsor->update($validated);

        return back()->with('success', 'Sponsor berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $sponsor = BerandaSponsor::findOrFail($id);

        if ($sponsor->gambar && Storage::disk('public')->exists($sponsor->gambar)) {
            Storage::disk('public')->delete($sponsor->gambar);
        }

        $sponsor->delete();

        return back()->with('success', 'Sponsor berhasil dihapus.');
    }
}
