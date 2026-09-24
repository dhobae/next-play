<?php

namespace App\Http\Controllers\Admin\Atlet;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Klub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AtletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Atlet::with('klub');
            if (!$request->filled('order')) {
                $query->latest();
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('foto_atlet', function (Atlet $atlet) {
                    return $atlet->foto_atlet
                        ? '<img src="' . asset('storage/' . $atlet->foto_atlet) . '" alt="' . e($atlet->nama_atlet) . '" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">'
                        : '<span class="text-muted">Tidak ada foto</span>';
                })
                ->editColumn('jenis_kelamin', fn(Atlet $atlet) => $atlet->jenis_kelamin === 0 ? 'Laki-laki' : 'Perempuan')
                ->addColumn('klub_nama', fn(Atlet $atlet) => $atlet->klub?->nama_klub ?: '-')
                ->filterColumn('jenis_kelamin', function ($query, $keyword) {
                    $gender = strtolower($keyword);
                    if (str_contains('laki-laki', $gender)) {
                        $query->where('jenis_kelamin', 0);
                    } elseif (str_contains('perempuan', $gender)) {
                        $query->where('jenis_kelamin', 1);
                    }
                })
                ->filterColumn('klub_nama', function ($query, $keyword) {
                    $query->whereHas('klub', fn($clubQuery) => $clubQuery->where('nama_klub', 'like', "%{$keyword}%"));
                })
                ->orderColumn('klub_nama', function ($query, $direction) {
                    $query->orderBy(
                        Klub::select('nama_klub')->whereColumn('klub.id', 'atlet.klub_id'),
                        $direction
                    );
                })
                ->addColumn('aksi', function (Atlet $atlet) {
                    return view('admin.atlet.partials.actions', compact('atlet'))->render();
                })
                ->rawColumns(['foto_atlet', 'aksi'])
                ->toJson();
        }

        return view('admin.atlet.index');
    }

    public function create()
    {
        return view('admin.atlet.create', ['klubs' => Klub::orderBy('nama_klub')->get()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateAtlet($request, true);
        $validated['foto_atlet'] = $request->file('foto_atlet')->store('foto_atlet', 'public');

        Atlet::create($validated);

        return redirect()->route('admin.atlet.index')->with('success', 'Atlet berhasil ditambahkan.');
    }

    public function show(Request $request, Atlet $atlet)
    {
        if ($request->ajax()) {
            $query = $atlet->riwayatTurnamen();
            if (!request()->filled('order')) {
                $query->latest('tanggal_turnamen')->latest('id');
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('tanggal_turnamen', fn($riwayat) => $riwayat->tanggal_turnamen?->format('d-m-Y') ?: '-')
                ->addColumn('hasil_display', fn($riwayat) => '<span class="badge text-bg-secondary">' . e($riwayat->hasil_turnamen) . '</span>')
                ->editColumn('poin_turnamen', fn($riwayat) => '+' . (int) $riwayat->poin_turnamen)
                ->filterColumn('hasil_display', fn($query, $keyword) => $query->where('hasil_turnamen', 'like', "%{$keyword}%"))
                ->orderColumn('hasil_display', 'hasil_turnamen $1')
                ->rawColumns(['hasil_display'])
                ->toJson();
        }

        return view('admin.atlet.show', compact('atlet'));
    }

    public function edit(Atlet $atlet)
    {
        return view('admin.atlet.edit', [
            'atlet' => $atlet,
            'klubs' => Klub::orderBy('nama_klub')->get(),
        ]);
    }

    public function update(Request $request, Atlet $atlet)
    {
        $validated = $this->validateAtlet($request);

        if ($request->hasFile('foto_atlet')) {
            if ($atlet->foto_atlet && Storage::disk('public')->exists($atlet->foto_atlet)) {
                Storage::disk('public')->delete($atlet->foto_atlet);
            }

            $validated['foto_atlet'] = $request->file('foto_atlet')->store('foto_atlet', 'public');
        }

        $atlet->update($validated);

        return redirect()->route('admin.atlet.index')->with('success', 'Data atlet berhasil diperbarui.');
    }

    public function destroy(Atlet $atlet)
    {
        if ($atlet->foto_atlet && Storage::disk('public')->exists($atlet->foto_atlet)) {
            Storage::disk('public')->delete($atlet->foto_atlet);
        }

        $atlet->delete();

        return redirect()->route('admin.atlet.index')->with('success', 'Data atlet berhasil dihapus.');
    }

    private function validateAtlet(Request $request, bool $isCreate = false): array
    {
        return $request->validate([
            'nama_atlet' => 'required|string|max:255',
            'foto_atlet' => ($isCreate ? 'required' : 'nullable') . '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'level' => 'required|in:Bronze,Silver,Elektrum,Beginner',
            'jenis_kelamin' => 'required|integer|in:0,1',
            'klub_id' => 'required|exists:klub,id',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'kebangsaan' => 'required|string|max:255',
        ]);
    }
}
