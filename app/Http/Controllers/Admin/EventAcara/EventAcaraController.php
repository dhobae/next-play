<?php

namespace App\Http\Controllers\Admin\EventAcara;

use App\Http\Controllers\Controller;
use App\Models\EventAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EventAcaraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = EventAcara::query();
            if (!$request->filled('order')) {
                $query->latest();
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('gambar', function (EventAcara $event) {
                    return $event->gambar
                        ? '<img src="' . asset('storage/' . $event->gambar) . '" alt="' . e($event->judul) . '" class="img-fluid" style="width: 100px; height: 65px; object-fit: cover;">'
                        : '<span class="text-muted">Tidak ada gambar</span>';
                })
                ->editColumn('deskripsi', fn(EventAcara $event) => str($event->deskripsi)->limit(80))
                ->filterColumn('deskripsi', fn($query, $keyword) => $query->where('deskripsi', 'like', "%{$keyword}%"))
                ->addColumn('aksi', function (EventAcara $event) {
                    return view('admin.eventacara.partials.actions', compact('event'))->render();
                })
                ->rawColumns(['gambar', 'aksi'])
                ->toJson();
        }

        return view('admin.eventacara.index');
    }

    public function create()
    {
        return view('admin.eventacara.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
        ]);

        $validated['gambar'] = $request->file('gambar')->store('gambar_event', 'public');

        EventAcara::create($validated);

        return redirect()->route('admin.eventacara.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(EventAcara $eventacara)
    {
        return view('admin.eventacara.edit', compact('eventacara'));
    }

    public function update(Request $request, EventAcara $eventacara)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
        ]);

        if ($request->hasFile('gambar')) {
            if ($eventacara->gambar && Storage::disk('public')->exists($eventacara->gambar)) {
                Storage::disk('public')->delete($eventacara->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('gambar_event', 'public');
        }

        $eventacara->update($validated);

        return redirect()->route('admin.eventacara.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(EventAcara $eventacara)
    {
        if ($eventacara->gambar && Storage::disk('public')->exists($eventacara->gambar)) {
            Storage::disk('public')->delete($eventacara->gambar);
        }

        $eventacara->delete();

        return redirect()->route('admin.eventacara.index')->with('success', 'Event berhasil dihapus.');
    }
}
