<?php

namespace App\Http\Controllers;

use App\Models\Obatalkes;
use App\Models\Signa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ObatalkesController extends Controller
{
    public function index() {
        return Inertia::render('Resep/Index', [
            'obat' => Obatalkes::where('is_deleted', 0)->get(),
            'signa' => Signa::where('is_deleted', 0)->get()
        ]);
    }
}
