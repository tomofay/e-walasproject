<?php

namespace App\Http\Controllers;
use App\Models\Walas;
use App\Models\Siswa;
use App\Models\DetailJadwalPiket;
use App\Models\Rombel;
use App\Models\JadwalPiket;
use App\Models\Kurikulum;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class JadwalPiketController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $piket = JadwalPiket::where('walas_id', $walas->id)->get();
        $detailpiket = DetailJadwalPiket::whereIn('jadwalpikets_id', $piket->pluck('id'))->get();
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        $data = $piket->map(function ($item) use ($detailpiket) {
            $siswas = $detailpiket->where('jadwalpikets_id', $item->id)->map(function ($detailpiket) {
                return \App\Models\Siswa::find($detailpiket->siswas_id);
            })->filter();

            return [
                'id' => $item->id,
                'nama_hari' => $item->nama_hari,
                'siswas' => $siswas,
            ];
        })->toArray();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.jadwalpiket', compact('walas', 'data', 'siswas', 'rombel'));

            return $pdf->stream('Jadwal_Piket.pdf');
        }

        return view('admwalas.jadwalpiket.index', compact('walas', 'data', 'siswas', 'rombel'));
    }

    public function create()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        if ($siswas->isEmpty()) {
            $dataSiswa = 'Tidak ada siswa di kelompok ini';
        } else {
            $dataSiswa = $siswas;
        }

        $piket = JadwalPiket::select('nama_hari')
            ->where('walas_id', $walas->id)
            ->distinct()
            ->get();

        if ($piket->isEmpty()) {
            $data = [
                ['nama_hari' => 'Senin', 'siswas' => '0'],
                ['nama_hari' => 'Selasa', 'siswas' => '0'],
                ['nama_hari' => 'Rabu', 'siswas' => '0'],
                ['nama_hari' => 'Kamis', 'siswas' => '0'],
                ['nama_hari' => 'Jumat', 'siswas' => '0'],
            ];
        } else {
            $data = $piket->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_hari' => $item->nama_hari,
                    'siswas' => $item->siswas_id,
                ];
            })->toArray();
        }

        $piket = JadwalPiket::where('walas_id', $walas->id)->with('siswas')->get();

        return view('admwalas.jadwalpiket.create', compact('walas', 'piket', 'dataSiswa', 'siswas', 'data'));
    }

    public function store(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();

        $validatedData = $request->validate([
            'nama_hari' => 'required|string|max:255',
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'nullable',
        ]);

        $piket = JadwalPiket::create([
            'nama_hari' => $validatedData['nama_hari'],
            'walas_id' => $validatedData['walas_id'],
        ]);

        if (! empty($validatedData['siswas_id'])) {
            $piket->siswas()->attach($validatedData['siswas_id']);
        }

        return redirect()->route('jadwalpiket.index')->with('success', 'Jadwal Piket berhasil dibuat!');
    }

    public function showSiswa($kelompokId)
    {
        $piket = JadwalPiket::find($kelompokId);
        $siswas = Siswa::whereDoesntHave('kelompok', function ($query) use ($kelompokId) {
            $query->where('jadwalpikets_id', $kelompokId);
        })->get();

        return view('/createpiket', compact('kelompok', 'siswas'));
    }

    public function addSiswa(Request $request, $id)
    {
        $piket = JadwalPiket::findOrFail($id);

        if ($piket->siswas->count() >= 7) {
            return redirect()->back()->with('error', 'Maksimal 7 siswa per hari.');
        }

        $piket->siswas()->attach($request->siswas_id);

        return redirect('/jadwalpiket')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function simpan(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();

        $request->validate([
            'jadwalpikets_id' => 'required|exists:jadwal_pikets,id',
            'siswas_id' => 'required|exists:siswas,id',
        ]);

        $existingSiswa = DetailJadwalPiket::where('jadwalpikets_id', $request->jadwalpikets_id)
            ->where('siswas_id', $request->siswas_id)
            ->exists();

        if ($existingSiswa) {
            return redirect()->back()->with('error', 'Siswa sudah ada dalam hari ini.');
        }

        DetailJadwalPiket::create([
            'jadwalpikets_id' => $request->jadwalpikets_id,
            'siswas_id' => $request->siswas_id,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke hari.');
    }

    public function edit($id) {}

    public function update(Request $request, $id)
    {
        $detailpiket = DetailJadwalPiket::find($id);

        if ($detailpiket) {
            $detailpiket->siswas_id = $request->siswas_id;
            $detailpiket->save();

            return redirect('/jadwalpiket')->with('success', 'Siswa berhasil diupdate');
        }

        return redirect('/jadwalpiket')->with('error', 'Siswa tidak ditemukan');
    }

    public function hapussiswapiket(string $siswas_id)
    {
        $siswas = DetailJadwalPiket::where('siswas_id', $siswas_id)->first();

        if ($siswas) {
            $siswas->delete();

            return redirect('/jadwalpiket')->with('success', 'Siswa Berhasil Dihapus');
        }

        return redirect('/jadwalpiket')->with('error', 'Siswa tidak ditemukan!');
    }
}

