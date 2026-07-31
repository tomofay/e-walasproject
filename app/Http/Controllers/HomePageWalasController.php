<?php

namespace App\Http\Controllers;

use App\Http\Concerns\HasWalasAuth;

class HomePageWalasController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        return view('homepagegtk.index', compact('walas'));
    }

    public function create() {}
    public function store() {}
    public function show() {}
    public function edit() {}
    public function update() {}
    public function destroy() {}
}
