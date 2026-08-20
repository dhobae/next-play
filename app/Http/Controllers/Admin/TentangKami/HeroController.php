<?php

namespace App\Http\Controllers\Admin\TentangKami;

use App\Http\Controllers\Controller;
use App\Models\TentangkamiHero;
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
        $heroes = TentangkamiHero::latest()->get();

        return view('admin.ttgkami.hero.index', compact('heroes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('gambar_hero', 'public');
        }

        TentangkamiHero::create($validated);

        return back()->with('success', 'Hero berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $hero = TentangkamiHero::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($hero->gambar && Storage::disk('public')->exists($hero->gambar)) {
                Storage::disk('public')->delete($hero->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('gambar_hero', 'public');
        }

        $hero->update($validated);

        return back()->with('success', 'Hero berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $hero = TentangkamiHero::findOrFail($id);

        if ($hero->gambar && Storage::disk('public')->exists($hero->gambar)) {
            Storage::disk('public')->delete($hero->gambar);
        }

        $hero->delete();

        return back()->with('success', 'Hero berhasil dihapus.');
    }
}
