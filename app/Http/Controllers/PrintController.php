<?php

namespace App\Http\Controllers;

use App\Models\Factuur;
use Barryvdh\DomPDF\Facade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PDF;

class PrintController extends Controller
{
    public function printFacturen(Request $request)
    {

        $option = $request->get('optionID');

        /*$facturen = Factuur::all();*/
        $facturen = Factuur::orderBy('factuurnummer')->get();
        //$facturen = Factuur::has('dossiers')->get();
        $searchFacturen = new \Illuminate\Database\Eloquent\Collection();

        if ($option == 1) {
            $searchFacturen = $facturen;
            $title = "Alle facturen";
        } else if ($option == 2) {
            $searchFacturen = $facturen->where('voldaan', true);
            $title = "Betaalde facturen";
        } else if ($option == 3) {
            $searchFacturen = $facturen->where('voldaan', false);
            $title = "Onbetaalde facturen";
        }

        $dt = Carbon::now();
        $vandaag = $dt->format('d/m/Y');

        view()->share('facturen', $searchFacturen);
        view()->share('title', $title);
        view()->share('datum', $vandaag);

        //ini_set("memory_limit", "999M");
        ini_set("max_execution_time", "300");

        $pdf = PDF::loadView('pdf.facturen');
        //dd($pdf);
        return view('pdf.facturen');
        //return $pdf->download('invoice.pdf');
    }

}