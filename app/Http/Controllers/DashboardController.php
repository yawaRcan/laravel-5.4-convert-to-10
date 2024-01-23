<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Models\Makelaar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $makelaars = ['' => 'Kies een makelaar'] + Makelaar::pluck('naam', 'id')->all();

        $klanten = ['' => 'Kies een klant'];
        foreach (Klant::all() as $klant) {
            //$klanten[$klant->id] = $klant->voornaam . ' ' . $klant->naam;
            $klanten[$klant->id] = $klant->naam;
        }

        return view('dashboard.index', ['klanten' => $klanten, 'makelaars' => $makelaars]);
    }

    public function statistieken()
    {
        return view('dashboard.statistieken');
    }

    public function ossiersstatistieken()
    {
        return view('dashboard.dossiersstatistieken');
    }
    /*
        public function berekenStatistieken(Request $request)
        {
            $facturen = Factuur::all();

            $criterium  = $request->data[0]{'criterium'};
            $startjaar  = $request->data[0]{'startjaar'};
            $eindjaar   = $request->data[0]{'eindjaar'};

            $filtered = Factuur::Jaar($startjaar, $eindjaar)->get();

            return view('search.statistiekenResultaat')->with('facturen', $filtered);
        }*/
}
