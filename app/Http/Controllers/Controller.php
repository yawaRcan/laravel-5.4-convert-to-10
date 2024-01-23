<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Klant;
use App\Models\Dossier;
use App\Models\Factuur;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function index()
    {

        $aantalklanten = Klant::count();
        $aantaldossiers = Dossier::count();
        $aantalfacturen = Factuur::count();

        return view('index', ['aantalklanten' => $aantalklanten, 'aantaldossiers' => $aantaldossiers, 'aantalfacturen' => $aantalfacturen]);
    }
}
