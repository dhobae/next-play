<?php

namespace App\Http\Controllers\Admin\Klub;

use App\Http\Controllers\Controller;
use App\Models\Klub;
use App\Models\KlubRiwayatLiga;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RiwayatLigaController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('admin.klub-riwayat.index', [
			'klubs' => Klub::query()->orderBy('nama_klub')->get(),
		]);
	}

	public function manage(Request $request, Klub $klub)
	{
		if ($request->ajax()) {
			$query = $klub->riwayatLiga();
			if (!$request->filled('order')) {
				$query->latest('created_at')->latest('id');
			}

			return DataTables::eloquent($query)
				->addIndexColumn()
				->editColumn('tanggal_liga', fn (KlubRiwayatLiga $riwayat) => $riwayat->tanggal_liga?->format('d-m-Y'))
				->addColumn('aksi', function (KlubRiwayatLiga $riwayat) use ($klub) {
					return view('admin.klub-riwayat.partials.actions', compact('klub', 'riwayat'))->render();
				})
				->rawColumns(['aksi'])
				->toJson();
		}

		return view('admin.klub-riwayat.manage', compact('klub'));
	}

	public function store(Request $request, Klub $klub)
	{
		$klub->riwayatLiga()->create($this->validateRiwayat($request));

		return redirect()->route('admin.klub-riwayat.manage', $klub)
			->with('success', 'Riwayat liga berhasil ditambahkan.');
	}

	public function edit(Klub $klub, KlubRiwayatLiga $riwayat)
	{
		$this->ensureBelongsToKlub($klub, $riwayat);

		return view('admin.klub-riwayat.edit', compact('klub', 'riwayat'));
	}

	public function update(Request $request, Klub $klub, KlubRiwayatLiga $riwayat)
	{
		$this->ensureBelongsToKlub($klub, $riwayat);
		$riwayat->update($this->validateRiwayat($request));

		return redirect()->route('admin.klub-riwayat.manage', $klub)
			->with('success', 'Riwayat liga berhasil diperbarui.');
	}

	public function destroy(Klub $klub, KlubRiwayatLiga $riwayat)
	{
		$this->ensureBelongsToKlub($klub, $riwayat);
		$riwayat->delete();

		return redirect()->route('admin.klub-riwayat.manage', $klub)
			->with('success', 'Riwayat liga berhasil dihapus.');
	}

	private function validateRiwayat(Request $request): array
	{
		return $request->validate([
			'nama_liga' => 'required|string|max:255',
			'hasil_liga' => 'required|string|max:255',
			'tanggal_liga' => 'required|date',
			'poin_liga' => 'required|integer',
		]);
	}

	private function ensureBelongsToKlub(Klub $klub, KlubRiwayatLiga $riwayat): void
	{
		abort_unless($riwayat->klub_id === $klub->id, 404);
	}
}
