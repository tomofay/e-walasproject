<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\JadwalKbm;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class JadwalKbmController extends Controller
{
    use HasWalasAuth;

    public function index(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswa = DB::table('siswas')
            ->where('rombels_id', $rombel->id)
            ->get();

        $rombels = Rombel::all();

        $jadwalKbms = JadwalKbm::with(['rombel', 'walas'])
            ->where('walas_id', $walas->id)
            ->get();

        $mapels = Mapel::all()->keyBy('id');
        $gurus = Guru::all()->keyBy('id');

        if ($request->input('export') === 'pdf') {
            if ($jadwalKbms->isEmpty()) {
                return back()->with('error', 'Jadwal belum tersedia, tidak bisa mengunduh PDF.');
            }

            $pdf = Pdf::loadView('pdf.jadwalkbm', compact('jadwalKbms', 'mapels', 'gurus', 'walas'))
                ->setPaper('A4', 'portrait');

            return $pdf->stream('Jadwal_KBM.pdf');
        }

        return view('admwalas.jadwalkbm.index', compact('jadwalKbms', 'mapels', 'gurus', 'walas', 'rombels', 'rombel', 'siswa'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $rombels = Rombel::all();
        $walasList = Walas::all();
        $mapels = Mapel::all();
        $gurus = Guru::all();

        return view('admwalas.jadwalkbm.create', compact('rombels', 'walasList', 'mapels', 'gurus', 'walas', 'rombel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rombels_id' => 'required|exists:rombels,id',
            'walas_id' => 'required|exists:walas,id',
            'senin' => 'nullable|array',
            'selasa' => 'nullable|array',
            'rabu' => 'nullable|array',
            'kamis' => 'nullable|array',
            'jumat' => 'nullable|array',
        ]);

        JadwalKbm::create([
            'rombels_id' => $request->rombels_id,
            'walas_id' => $request->walas_id,
            'senin' => json_encode($this->prepareScheduleData($request->senin)),
            'selasa' => json_encode($this->prepareScheduleData($request->selasa)),
            'rabu' => json_encode($this->prepareScheduleData($request->rabu)),
            'kamis' => json_encode($this->prepareScheduleData($request->kamis)),
            'jumat' => json_encode($this->prepareScheduleData($request->jumat)),
        ]);

        return redirect()->route('jadwalkbm.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $jadwalKbm = JadwalKbm::find($id);

        if (! $jadwalKbm) {
            abort(404);
        }

        foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $hari) {
            $rawSchedule = $jadwalKbm->$hari ?? null;
            $jadwalKbm->$hari = is_string($rawSchedule) ? (json_decode($rawSchedule, true) ?? []) : (is_array($rawSchedule) ? $rawSchedule : []);
        }

        $rombels = Rombel::all();
        $walasList = Walas::all();
        $mapels = Mapel::all();
        $gurus = Guru::all();

        return view('admwalas.jadwalkbm.edit', compact('jadwalKbm', 'rombels', 'walasList', 'mapels', 'gurus', 'walas', 'rombel'));
    }

    public function update(Request $request, $id)
    {
        $jadwalKbm = JadwalKbm::find($id);

        if (! $jadwalKbm) {
            return redirect()->route('jadwalkbm.index')->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'rombels_id' => 'required|exists:rombels,id',
            'walas_id' => 'required|exists:walas,id',
        ]);

        $jadwalKbm->rombels_id = $request->rombels_id;
        $jadwalKbm->walas_id = $request->walas_id;
        $jadwalKbm->senin = json_encode($this->prepareScheduleData($request->input('senin')));
        $jadwalKbm->selasa = json_encode($this->prepareScheduleData($request->input('selasa')));
        $jadwalKbm->rabu = json_encode($this->prepareScheduleData($request->input('rabu')));
        $jadwalKbm->kamis = json_encode($this->prepareScheduleData($request->input('kamis')));
        $jadwalKbm->jumat = json_encode($this->prepareScheduleData($request->input('jumat')));
        $jadwalKbm->save();

        return redirect()->route('jadwalkbm.index')->with('success', 'Data jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalKbm $jadwalKbm)
    {
        $jadwalKbm->delete();

        return redirect()->route('jadwalkbm.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    private function prepareScheduleData($scheduleData)
    {
        if (! is_array($scheduleData) || empty($scheduleData)) {
            return [];
        }

        $preparedData = [];
        foreach ($scheduleData as $jam => $detail) {
            if (isset($detail['mapel']) && isset($detail['guru'])) {
                $preparedData[] = [
                    'jam' => $jam,
                    'mapel_id' => $detail['mapel'],
                    'guru_id' => $detail['guru'],
                ];
            }
        }

        return $preparedData;
    }
}
