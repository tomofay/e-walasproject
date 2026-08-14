<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\BiodataSiswa;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PendapatanOrtuController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();

        $dataPendapatan = $this->getRentangPendapatan($walas->id);

        $pendapatan = BiodataSiswa::select('id', 'nama_lengkap', 'pendapatan_ortu')
            ->where('walas_id', $walas->id)
            ->get();

        return view("admwalas.pendapatanortu.index", compact('pendapatan', 'walas', 'dataPendapatan'));
    }

    public function generatePDF(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();

        $pendapatan = BiodataSiswa::select('id', 'nama_lengkap', 'pendapatan_ortu')
            ->where('walas_id', $walas->id)
            ->get();

        $dataPendapatan = $this->getRentangPendapatan($walas->id);
        $chartImage = $request->input('chartImage');

        $pdf = Pdf::loadView('pdf.pendapatanortu', compact('pendapatan', 'walas', 'dataPendapatan', 'chartImage'));

        return $pdf->stream('Pendapatan_Orang_Tua.pdf');
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}

    private function getRentangPendapatan(int $walasId): array
    {
        $rentang = [
            'Kurang dari Rp1.000.000,00',
            'Rp1.000.000,00 - Rp3.000.000,00',
            'Rp3.000.000,00 - Rp5.000.000,00',
            'Rp5.000.000,00 - Rp10.000.000,00',
            'Rp10.000.000,00 - Rp25.000.000,00',
            'Rp25.000.000,00 - Rp50.000.000,00',
            'Lebih dari Rp50.000.000,00',
        ];

        $result = [];
        foreach ($rentang as $r) {
            $result[$r] = BiodataSiswa::where('pendapatan_ortu', $r)
                ->where('walas_id', $walasId)
                ->count();
        }

        return $result;
    }
}
