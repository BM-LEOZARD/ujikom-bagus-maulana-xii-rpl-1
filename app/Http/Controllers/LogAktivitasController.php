<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $log = LogAktivitas::with('user')
            ->latest()
            ->get();
        return view('log-aktivitas.index', compact('log'));
    }
}
