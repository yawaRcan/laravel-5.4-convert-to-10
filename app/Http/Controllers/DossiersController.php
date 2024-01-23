<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use Illuminate\Http\Request;

class DossiersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $dossiers = Dossier::has('facturen')->orderBy('dossiernummer')->paginate(100);
        return view('dossiers.index', ['dossiers' => $dossiers]);
    }

    public function show($id)
    {
        $dossier = Dossier::findOrFail($id);
        return view('dossiers.view', compact('dossier'));
    }
}
