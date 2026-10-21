<?php

namespace App\Http\Controllers\Admin\Atlet;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\AtletRiwayat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AtletRiwayatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.atlet-riwayat.index', [
            'atlets' => Atlet::query()->latest()->get(),
        ]);
    }

    public function manage(Request $request, Atlet $atlet)
    {
        if ($request->ajax()) {
            $query = $atlet->riwayatTurnamen();
            if (!$request->filled('order')) {
                $query->latest('created_at')->latest('id');
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('tanggal_turnamen', fn(AtletRiwayat $riwayat) => $riwayat->tanggal_turnamen?->format('d-m-Y'))
                ->addColumn('aksi', function (AtletRiwayat $riwayat) use ($atlet) {
                    return view('admin.atlet-riwayat.partials.actions', compact('atlet', 'riwayat'))->render();
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        return view('admin.atlet-riwayat.manage', [
            'atlet' => $atlet,
        ]);
    }

    public function store(Request $request, Atlet $atlet)
    {
        $atlet->riwayatTurnamen()->create($this->validateRiwayat($request));

        return redirect()->route('admin.atlet-riwayat.manage', $atlet)
            ->with('success', 'Riwayat turnamen berhasil ditambahkan.');
    }

    public function edit(Atlet $atlet, AtletRiwayat $riwayat)
    {
        $this->ensureBelongsToAtlet($atlet, $riwayat);

        return view('admin.atlet-riwayat.edit', [
            'atlet' => $atlet,
            'riwayat' => $riwayat,
        ]);
    }

    public function update(Request $request, Atlet $atlet, AtletRiwayat $riwayat)
    {
        $this->ensureBelongsToAtlet($atlet, $riwayat);
        $riwayat->update($this->validateRiwayat($request));

        return redirect()->route('admin.atlet-riwayat.manage', $atlet)
            ->with('success', 'Riwayat turnamen berhasil diperbarui.');
    }

    public function destroy(Atlet $atlet, AtletRiwayat $riwayat)
    {
        $this->ensureBelongsToAtlet($atlet, $riwayat);
        $riwayat->delete();

        return redirect()->route('admin.atlet-riwayat.manage', $atlet)
            ->with('success', 'Riwayat turnamen berhasil dihapus.');
    }

    private function validateRiwayat(Request $request): array
    {
        return $request->validate([
            'nama_turnamen' => 'required|string|max:255',
            'tanggal_turnamen' => 'required|date',
            'hasil_turnamen' => 'required|string|max:255',
            'poin_turnamen' => 'required|integer',
        ]);
    }

    private function ensureBelongsToAtlet(Atlet $atlet, AtletRiwayat $riwayat): void
    {
        abort_unless($riwayat->atlet_id === $atlet->id, 404);
    }
}
