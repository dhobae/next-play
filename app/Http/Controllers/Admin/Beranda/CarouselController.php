<?php

namespace App\Http\Controllers\Admin\Beranda;

use App\Http\Controllers\Controller;
use App\Models\BerandaCarousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $carousels = BerandaCarousel::latest()->get();

        return view('admin.beranda.carousel.index', compact('carousels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('gambar_carousel', 'public');
        }

        BerandaCarousel::create($validated);

        return back()->with('success', 'Carousel berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $carousel = BerandaCarousel::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($carousel->gambar && Storage::disk('public')->exists($carousel->gambar)) {
                Storage::disk('public')->delete($carousel->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('gambar_carousel', 'public');
        }

        $carousel->update($validated);

        return back()->with('success', 'Carousel berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $carousel = BerandaCarousel::findOrFail($id);

        if ($carousel->gambar && Storage::disk('public')->exists($carousel->gambar)) {
            Storage::disk('public')->delete($carousel->gambar);
        }

        $carousel->delete();

        return back()->with('success', 'Carousel berhasil dihapus.');
    }
}
