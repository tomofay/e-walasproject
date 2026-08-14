<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Http\Concerns\HasWalasAuth;
use App\Models\DetailPresensi;
use Illuminate\Http\Request;

class DetailPresensiController extends Controller
{
    use HasWalasAuth;

    public function index($presensiId)
    {
        $walas = $this->getAuthenticatedWalas();

        $presensi = Presensi::with('detailPresensis.siswa')->findOrFail($presensiId);

        return view('admwalas.detailpresensi.index', compact('presensi', 'walas'));
    }

    public function create($presensi_id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $presensi = Presensi::findOrFail($presensi_id);
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.detailpresensi.create', compact('presensi', 'siswas', 'walas', 'rombel'));
    }

    public function store(Request $request, $presensi_id)
    {
        $request->validate([
            'siswas_id' => 'required|exists:siswas,id',
            'status' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        DetailPresensi::create([
            'presensis_id' => $presensi_id,
            'siswas_id' => $request->siswas_id,
            'status' => $request->status,
        ]);

        return redirect()->route('detailpresensi.index', $presensi_id)->with('success', 'Detail presensi berhasil ditambahkan!');
    }

    public function edit($presensi_id, $detail_id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $presensi = Presensi::findOrFail($presensi_id);
        $detail = DetailPresensi::findOrFail($detail_id);
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        return view('admwalas.detailpresensi.edit', compact('presensi', 'detail', 'siswas', 'walas', 'rombel'));
    }

    public function update(Request $request, $presensi_id, $detail_id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        $detail = DetailPresensi::findOrFail($detail_id);
        $detail->update(['status' => $request->status]);

        return redirect()->route('detailpresensi.index', $presensi_id)->with('success', 'Detail presensi berhasil diperbarui!');
    }

    public function destroy($presensi_id, $detail_id)
    {
        $detail = DetailPresensi::findOrFail($detail_id);
        $detail->delete();

        return redirect()->route('detailpresensi.index', $presensi_id)->with('success', 'Detail presensi berhasil dihapus!');
    }
}
