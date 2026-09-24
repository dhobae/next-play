<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Klub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KlubController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Klub::query();
            if (!$request->filled('order')) {
                $query->latest();
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('gambar', fn(Klub $klub) => $klub->gambar
                    ? '<img src="' . e(asset('storage/' . $klub->gambar)) . '" alt="' . e($klub->nama_klub) . '" style="width:80px;height:60px;object-fit:cover;">'
                    : '<span class="text-muted">Tidak ada gambar</span>')
                ->addColumn('aksi', fn(Klub $klub) => view('admin.klub.partials.actions', compact('klub'))->render())
                ->rawColumns(['gambar', 'aksi'])
                ->toJson();
        }

        return view('admin.klub.index');
    }

    public function create()
    {
        return view('admin.klub.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_klub' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $validated['gambar'] = $request->file('gambar')->store('gambar_klub', 'public');
        Klub::create($validated);

        return redirect()->route('admin.klub.index')->with('success', 'Klub berhasil ditambahkan.');
    }

    public function edit(Klub $klub)
    {
        return view('admin.klub.edit', compact('klub'));
    }

    public function update(Request $request, Klub $klub)
    {
        $validated = $request->validate([
            'nama_klub' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('gambar')) {
            if ($klub->gambar && Storage::disk('public')->exists($klub->gambar)) {
                Storage::disk('public')->delete($klub->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('gambar_klub', 'public');
        }
        $klub->update($validated);

        return redirect()->route('admin.klub.index')->with('success', 'Klub berhasil diperbarui.');
    }

    public function destroy(Klub $klub)
    {
        if ($klub->gambar && Storage::disk('public')->exists($klub->gambar)) {
            Storage::disk('public')->delete($klub->gambar);
        }
        $klub->delete();

        return redirect()->route('admin.klub.index')->with('success', 'Klub berhasil dihapus.');
    }
}