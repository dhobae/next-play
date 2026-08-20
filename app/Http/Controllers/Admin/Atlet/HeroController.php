<?php

namespace App\Http\Controllers\Admin\Atlet;

use App\Http\Controllers\Controller;
use App\Models\AtletHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $heroes = AtletHero::latest()->get();

        return view('admin.atlet.hero.index', compact('heroes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['gambar'] = $request->file('gambar')->store('gambar_hero_atlet', 'public');
        AtletHero::create($validated);

        return back()->with('success', 'Hero peringkat berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $hero = AtletHero::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($hero->gambar && Storage::disk('public')->exists($hero->gambar)) {
                Storage::disk('public')->delete($hero->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('gambar_hero_atlet', 'public');
        }

        $hero->update($validated);

        return back()->with('success', 'Hero peringkat berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $hero = AtletHero::findOrFail($id);

        if ($hero->gambar && Storage::disk('public')->exists($hero->gambar)) {
            Storage::disk('public')->delete($hero->gambar);
        }

        $hero->delete();

        return back()->with('success', 'Hero peringkat berhasil dihapus.');
    }
}