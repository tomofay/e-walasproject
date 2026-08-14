<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\BiodataSiswa;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GrafikJarakTempuhController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $dataJarak = $this->getDataJarak($walas->id);

        return view("admwalas.grafikjaraktempuh.index", compact('walas', 'dataJarak'));
    }

    public function generatePDF(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $dataJarak = $this->getDataJarak($walas->id);
        $chartImage = $request->input('chartImage');

        $pdf = Pdf::loadView('pdf.grafikjaraktempuh', compact('walas', 'dataJarak', 'chartImage'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('Jarak_rumah_Siswa.pdf');
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}

    private function getDataJarak(int $walasId): array
    {
        $dataJarak = [
            'Kurang dari 1 km' => 0,
            '1 km - 3 km' => 0,
            '3 km - 5 km' => 0,
            '5 km - 10 km' => 0,
            '10 km - 25 km' => 0,
            '25 km - 50 km' => 0,
            'Lebih dari 50 km' => 0,
        ];

        $jarakSiswa = BiodataSiswa::where('walas_id', $walasId)->pluck('jarak_rumah');

        foreach ($jarakSiswa as $jarak) {
            preg_match('/\d+(\.\d+)?/', $jarak, $matches);
            $km = isset($matches[0]) ? floatval($matches[0]) : null;

            if ($km === null) {
                continue;
            }

            if ($km < 1) {
                $dataJarak['Kurang dari 1 km']++;
            } elseif ($km < 3) {
                $dataJarak['1 km - 3 km']++;
            } elseif ($km < 5) {
                $dataJarak['3 km - 5 km']++;
            } elseif ($km < 10) {
                $dataJarak['5 km - 10 km']++;
            } elseif ($km < 25) {
                $dataJarak['10 km - 25 km']++;
            } elseif ($km < 50) {
                $dataJarak['25 km - 50 km']++;
            } else {
                $dataJarak['Lebih dari 50 km']++;
            }
        }

        return $dataJarak;
    }
}
