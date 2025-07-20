<?php

namespace App\Http\Controllers;

use App\Models\Signa;
use Illuminate\Http\Request;

class SignaController extends Controller
{
    public function getSigna() {
        return Signa::where('is_deleted', 0)->get();
    }
}
