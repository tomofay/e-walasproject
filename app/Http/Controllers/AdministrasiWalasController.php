<?php

namespace App\Http\Controllers;

use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;

class AdministrasiWalasController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();

        return view("homepagegtk.adminwalas", compact('walas'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
