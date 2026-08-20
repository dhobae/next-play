<?php

namespace App\Http\Controllers\Admin\TentangKami;

use App\Http\Controllers\Controller;
use App\Models\TentangkamiVisimisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisiMisiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $visimisis = TentangkamiVisimisi::latest()->get();

        return view('admin.ttgkami.visimisi.index', compact('visimisis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['visi'] = $this->removeInlineStyles($validated['visi']);
        $validated['misi'] = $this->removeInlineStyles($validated['misi']);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('gambar_visimisi', 'public');
        }

        TentangkamiVisimisi::create($validated);

        return back()->with('success', 'Visi & Misi berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $visimisi = TentangkamiVisimisi::findOrFail($id);

        $validated = $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['visi'] = $this->removeInlineStyles($validated['visi']);
        $validated['misi'] = $this->removeInlineStyles($validated['misi']);

        if ($request->hasFile('gambar')) {
            if ($visimisi->gambar && Storage::disk('public')->exists($visimisi->gambar)) {
                Storage::disk('public')->delete($visimisi->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('gambar_visimisi', 'public');
        }

        $visimisi->update($validated);

        return back()->with('success', 'Visi & Misi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $visimisi = TentangkamiVisimisi::findOrFail($id);

        if ($visimisi->gambar && Storage::disk('public')->exists($visimisi->gambar)) {
            Storage::disk('public')->delete($visimisi->gambar);
        }

        $visimisi->delete();

        return back()->with('success', 'Visi & Misi berhasil dihapus.');
    }

    private function removeInlineStyles(string $html): string
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach ($document->getElementsByTagName('*') as $element) {
            if ($element instanceof \DOMElement) {
                $element->removeAttribute('style');
            }
        }

        $cleanHtml = $document->saveHTML();
        libxml_clear_errors();

        return preg_replace('/^<\?xml[^>]+>/', '', $cleanHtml) ?? $html;
    }
}
