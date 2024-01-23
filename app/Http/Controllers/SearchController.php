<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\Factuur;
use App\Models\Klant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function executeSearch(Request $request)
    {
        $keywords = $request->keywords;
        $klanten = Klant::all();
        $searchKlanten = new \Illuminate\Database\Eloquent\Collection();

        foreach ($klanten as $klant) {
            if (
                Str::contains(Str::lower($klant->naam), Str::lower($keywords))
                or Str::contains(Str::lower($klant->straat), Str::lower($keywords))
            ) {
                $searchKlanten->add($klant);
            }
        }

        return view('search/searchKlanten')->with('searchKlanten', $searchKlanten);
    }

    public function executeSearchDossiers(Request $request)
    {

        $keywords = $request->keywords;
        //$dossiers = Dossier::all();
        $dossiers = Dossier::has('facturen')->get();
        $searchDossiers = new \Illuminate\Database\Eloquent\Collection();

        foreach ($dossiers as $dossier) {
            if (
                Str::contains(Str::lower($dossier->nummerplaat), Str::lower($keywords))
                or Str::contains(Str::lower($dossier->merk), Str::lower($keywords))
                or Str::contains(Str::lower($dossier->makelaar), Str::lower($keywords))
                or Str::contains(Str::lower($dossier->maatschappij), Str::lower($keywords))
            ) {
                $searchDossiers->add($dossier);
            }
        }

        return view('search/searchDossiersResults')->with('searchDossiers', $searchDossiers);
    }

    public function executeFacturenSearch(Request $request)
    {
        $keywords = $request->keywords;
        //$WelkeFacturen = Factuur::all();
        $facturen = Factuur::all();
        //$facturen = Factuur::has('dossiers')->get();
        $searchFacturen = new \Illuminate\Database\Eloquent\Collection();

        foreach ($facturen as $factuur) {
            if ($keywords == 1) {
                $searchFacturen->add($factuur);
            } else if ($keywords == 2) {
                if ($factuur->voldaan == true) {
                    $searchFacturen->add($factuur);
                }
            } else if ($keywords == 3) {
                if ($factuur->voldaan == false) {
                    $searchFacturen->add($factuur);
                }
            }
        }

        return view('search/searchInvoices')->with('facturen', $searchFacturen);
    }

    public function executeSearchInvoices(Request $request)
    {
        //$filtered = Factuur::all();

        $criterium = $request->data[0]['criterium'];
        $startnr = $request->data[0]['startnr'];
        $eindnr = $request->data[0]['eindnr'];
        $operator = $request->data[0]['operator'];
        $bedrag = $request->data[0]['bedrag'];
        $startdatum = $request->data[0]['factuurdatum_start'];
        $einddatum = $request->data[0]['factuurdatum_einde'];
        $klant_id = $request->data[0]['klant_id'];
        $makelaar_id = $request->data[0]['makelaar_id'];
        $selectie = $request->data[0]['selectie'];
        $sortering = $request->data[0]['sortering'];

        if ($criterium == 1) {
            $filtered = Factuur::FactuurNummer($startnr, $eindnr)
                ->Bedrag($operator, $bedrag)
                ->Klant($klant_id)
                ->Makelaar($makelaar_id)
                ->WelkeFacturen($selectie)
                ->Sortering($sortering)
                ->get();
        } elseif ($criterium == 2) {
            $filtered = Factuur::FactuurDatum($startdatum, $einddatum)
                ->Bedrag($operator, $bedrag)
                ->Klant($klant_id)
                ->Makelaar($makelaar_id)
                ->WelkeFacturen($selectie)
                ->Sortering($sortering)
                ->get();
        } else {
            $filtered = Factuur::Bedrag($operator, $bedrag)
                ->Klant($klant_id)
                ->Makelaar($makelaar_id)
                ->WelkeFacturen($selectie)
                ->Sortering($sortering)
                ->get();
        }

        return view('search/searchInvoices')->with('facturen', $filtered);
    }


    public function berekenStatistieken(Request $request)
    {
        $criterium = $request->data[0]['criterium'];

        $startdatum = $request->data[0]['startjaar'] . '-01-01'; //2017 ---> 2017-01-01
        $einddatum = $request->data[0]['eindjaar'] . '-12-31';

        //      $facturen = Factuur::where('datum','>=',date($startdatum))->where('datum','<=',date($einddatum))->OrderBy('datum','asc')->get();

        //$facturen = Factuur::has('dossiers')->orderBy('factuurnummer')->paginate(100);
        $facturen = Factuur::whereDate('datum', '>=', date($startdatum))
            ->whereDate('datum', '<=', date($einddatum))
            ->orderBy('datum', 'asc')
            ->get();


        foreach ($facturen as $factuur) {

            $tebetalen = 0;

            $dt = Carbon::parse($factuur->datum);

            $theYear = $dt->year;
            $theMonth = $dt->month . "/" . $theYear;
            $theQuarter = "Q" . $dt->quarter . "/" . $theYear;

            $b = $factuur->bedrag;
            $bt = ($factuur->betaald == NULL) ? 0 : $factuur->betaald;
            $tb = $b - $bt;

            if ($criterium == 3) {
                if (isset($totalen[$theYear])) {
                    $totfacturen[$theYear] = $totfacturen[$theYear] + 1;
                    $totaal = $totalen[$theYear]['totaal'] + $b;
                    $betaald = $totalen[$theYear]['betaald'] + $bt;
                    $tebetalen = $totalen[$theYear]['tebetalen'] + $tb;

                    $totalen[$theYear] = array('totfacturen' => $totfacturen[$theYear], 'totaal' => $totaal, 'betaald' => $betaald, 'tebetalen' => $tebetalen);
                } else {
                    $totfacturen[$theYear] = 1;
                    $totalen[$theYear] = array('totfacturen' => $totfacturen[$theYear], 'totaal' => $b, 'betaald' => $bt, 'tebetalen' => $tb);
                }
            } elseif ($criterium == 2) {
                if (isset($totalen[$theQuarter])) {
                    $totfacturen[$theQuarter] = $totfacturen[$theQuarter] + 1;
                    $totaal = $totalen[$theQuarter]['totaal'] + $b;
                    $betaald = $totalen[$theQuarter]['betaald'] + $bt;
                    $tebetalen = $totalen[$theQuarter]['tebetalen'] + $tb;

                    $totalen[$theQuarter] = array($totfacturen[$theQuarter], 'totaal' => $totaal, 'betaald' => $betaald, 'tebetalen' => $tebetalen);
                } else {
                    $totfacturen[$theQuarter] = 1;
                    $totalen[$theQuarter] = array($totfacturen[$theQuarter], 'totaal' => $b, 'betaald' => $bt, 'tebetalen' => $tb);
                }
            } elseif ($criterium == 1) {
                if (isset($totalen[$theMonth])) {
                    $totfacturen[$theMonth] = $totfacturen[$theMonth] + 1;
                    $totaal = $totalen[$theMonth]['totaal'] + $b;
                    $betaald = $totalen[$theMonth]['betaald'] + $bt;
                    $tebetalen = $totalen[$theMonth]['tebetalen'] + $tb;

                    $totalen[$theMonth] = array($totfacturen[$theMonth], 'totaal' => $totaal, 'betaald' => $betaald, 'tebetalen' => $tebetalen);
                } else {
                    $totfacturen[$theMonth] = 1;
                    $totalen[$theMonth] = array($totfacturen[$theMonth], 'totaal' => $b, 'betaald' => $bt, 'tebetalen' => $tb);

                }
            }
        }
        return view('search/statistiekenResultaat')->with('resultaten', json_encode($totalen, JSON_NUMERIC_CHECK));
    }


    public function berekenDossiersStatistieken(Request $request)
    {
        $criterium = $request->data[0]['criterium'];

        $startdatum = $request->data[0]['startjaar'] . '-01-01'; //2017 ---> 2017-01-01
        $einddatum = $request->data[0]['eindjaar'] . '-12-31';


        /* REMOVED and REPLACED 14/12 
                $dossiers = Dossier::has('facturen')
                    ->whereDate('datum', '>=', date($startdatum))
                    ->whereDate('datum', '<=', date($einddatum))
                    ->orderBy('datum', 'asc')
                    ->get();
        /**************************/
        $dossiers = Dossier::whereDate('datum', '>=', date($startdatum))
            ->whereDate('datum', '<=', date($einddatum))
            ->orderBy('datum', 'asc')
            ->get();
        /*****************************/

        $grandtotal = 0;
        $totdossiers = $dossiers->count();

        foreach ($dossiers as $dossier) {

            $tebetalen = 0;

            $dt = Carbon::parse($dossier->datum);

            $makelaar = $dossier->makelaar;
            $maatschappij = $dossier->maatschappij;

            $b = $dossier->resultaat;
            $grandtotal = $grandtotal + $b;

            /* ADDED 14/12/2019 */
            $fact = DB::table('dossier_factuur')->where('dossier_id', $dossier->id)->first();
            /*******************/

            if ($criterium == 3) {
                if ($makelaar == "") {
                    $makelaar = "ONBEKEND";
                }

                if ($maatschappij == "") {
                    $maatschappij = "ONBEKEND";
                }

                $makmaat = $makelaar . " - " . "$maatschappij";

                if (isset($totalen[$makmaat])) {

                    $totaal = $totalen[$makmaat]['totaal'] + $b;
                    $aantal = $totalen[$makmaat]['aantal'] + 1;

                    /**************************/
                    /* AANGEPAST 14/12/2019 */
                    if ($fact) {
                        $aantaldossiersgefactureerd = $totalen[$makmaat]['aantaldossiersgefactureerd'] + 1;
                        $aantaldossiersnietgefactureerd = $totalen[$makmaat]['aantaldossiersnietgefactureerd'];
                    } else {
                        $aantaldossiersnietgefactureerd = $totalen[$makmaat]['aantaldossiersnietgefactureerd'] + 1;
                        $aantaldossiersgefactureerd = $totalen[$makmaat]['aantaldossiersgefactureerd'];
                    }
                    /**************************/
                    $totbef = $totalen[$makmaat]['totbef'] + round($b * 40.3399, 2);

                    /**************************/
                    /* AANGEPAST 14/12/2019 */
                    $totalen[$makmaat] = array(
                        'totaal' => $totaal,
                        'aantal' => $aantal,
                        'totbef' => $totbef,
                        'percent' => 0,
                        'percentdossiers' => 0,
                        'aantaldossiersgefactureerd' => $aantaldossiersgefactureerd,
                        'aantaldossiersnietgefactureerd' => $aantaldossiersnietgefactureerd
                    );
                    /**************************/
                } else {
                    /**************************/
                    /* AANGEPAST 14/12/2019 */
                    if ($fact) {
                        $totalen[$makmaat] = array('totaal' => $b, 'aantal' => 1, 'totbef' => round($b * 40.3399, 2), 'percent' => 0, 'percentdossiers' => 0, 'aantaldossiersgefactureerd' => 1, 'aantaldossiersnietgefactureerd' => 0);
                    } else {
                        $totalen[$makmaat] = array('totaal' => $b, 'aantal' => 1, 'totbef' => round($b * 40.3399, 2), 'percent' => 0, 'percentdossiers' => 0, 'aantaldossiersgefactureerd' => 0, 'aantaldossiersnietgefactureerd' => 1);
                    }
                    /*************************/
                }

                $titel = "makelaar en verzekeraar";

            } elseif ($criterium == 2) {
                if ($maatschappij == "") {
                    $maatschappij = "ONBEKEND";
                }

                if (isset($totalen[$maatschappij])) {

                    /**************************/
                    /* AANGEPAST 14/12/2019 */
                    if ($fact) {
                        $aantaldossiersgefactureerd = $totalen[$maatschappij]['aantaldossiersgefactureerd'] + 1;
                        $aantaldossiersnietgefactureerd = $totalen[$maatschappij]['aantaldossiersnietgefactureerd'];
                    } else {
                        $aantaldossiersnietgefactureerd = $totalen[$maatschappij]['aantaldossiersnietgefactureerd'] + 1;
                        $aantaldossiersgefactureerd = $totalen[$maatschappij]['aantaldossiersgefactureerd'];
                    }
                    /**************************/

                    $totaal = $totalen[$maatschappij]['totaal'] + $b;
                    $aantal = $totalen[$maatschappij]['aantal'] + 1;
                    $totbef = $totalen[$maatschappij]['totbef'] + round($b * 40.3399, 2);

                    /* AANGEPAST 14/12/2019 */
                    $totalen[$maatschappij] = array('totaal' => $totaal, 'aantal' => $aantal, 'totbef' => $totbef, 'percent' => 0, 'percentdossiers' => 0, 'aantaldossiersgefactureerd' => $aantaldossiersgefactureerd, 'aantaldossiersnietgefactureerd' => $aantaldossiersnietgefactureerd);
                    /***********************/
                } else {
                    /* AANGEPAST 14/12/2019 */
                    if ($fact) {
                        $totalen[$maatschappij] = array('totaal' => $b, 'aantal' => 1, 'totbef' => round($b * 40.3399, 2), 'percent' => 0, 'percentdossiers' => 0, 'aantaldossiersgefactureerd' => 1, 'aantaldossiersnietgefactureerd' => 0);
                    } else {
                        $totalen[$maatschappij] = array('totaal' => $b, 'aantal' => 1, 'totbef' => round($b * 40.3399, 2), 'percent' => 0, 'percentdossiers' => 0, 'aantaldossiersgefactureerd' => 0, 'aantaldossiersnietgefactureerd' => 1);
                    }
                    /*************************/

                }

                $titel = "verzekeraar";

            } elseif ($criterium == 1) {

                if ($makelaar == "") {
                    $makelaar = "ONBEKEND";
                }

                if (isset($totalen[$makelaar])) {

                    /**************************/
                    /* AANGEPAST 14/12/2019 */
                    if ($fact) {
                        $aantaldossiersgefactureerd = $totalen[$makelaar]['aantaldossiersgefactureerd'] + 1;
                        $aantaldossiersnietgefactureerd = $totalen[$makelaar]['aantaldossiersnietgefactureerd'];
                    } else {
                        $aantaldossiersnietgefactureerd = $totalen[$makelaar]['aantaldossiersnietgefactureerd'] + 1;
                        $aantaldossiersgefactureerd = $totalen[$makelaar]['aantaldossiersgefactureerd'];
                    }
                    /**************************/

                    $totaal = $totalen[$makelaar]['totaal'] + $b;
                    $aantal = $totalen[$makelaar]['aantal'] + 1;
                    $totbef = $totalen[$makelaar]['totbef'] + round($b * 40.3399, 2);

                    /* AANGEPAST 14/12/2019 */
                    $totalen[$makelaar] = array(
                        'totaal' => $totaal,
                        'aantal' => $aantal,
                        'totbef' => $totbef,
                        'percent' => 0,
                        'percentdossiers' => 0,
                        'aantaldossiersgefactureerd' => $aantaldossiersgefactureerd,
                        'aantaldossiersnietgefactureerd' => $aantaldossiersnietgefactureerd
                    );
                    /**************************/

                } else {
                    /* AANGEPAST 14/12/2019 */
                    if ($fact) {
                        $totalen[$makelaar] = array('totaal' => $b, 'aantal' => 1, 'totbef' => round($b * 40.3399, 2), 'percent' => 0, 'percentdossiers' => 0, 'aantaldossiersgefactureerd' => 1, 'aantaldossiersnietgefactureerd' => 0);
                    } else {
                        $totalen[$makelaar] = array('totaal' => $b, 'aantal' => 1, 'totbef' => round($b * 40.3399, 2), 'percent' => 0, 'percentdossiers' => 0, 'aantaldossiersgefactureerd' => 0, 'aantaldossiersnietgefactureerd' => 1);
                    }
                    /*************************/
                }
                $titel = "makelaar";
            }
        }

        foreach ($totalen as $key => $val) {

            if ($totalen[$key]['aantal'] > 5) {

                $percent = round(($totalen[$key]['totaal'] / $grandtotal) * 100, 4);
                $percentdossiers = round(($totalen[$key]['aantal'] / $totdossiers) * 100, 4);

                /* CHANGED 14/12/2019 */
                $makelaarslijst[$key] = array(
                    'totaal' => $totalen[$key]['totaal'],
                    'aantal' => $totalen[$key]['aantal'],
                    'totbef' => round(($totalen[$key]['totaal'] * 40.3399), 2),
                    'percent' => $percent,
                    'percentdossiers' => $percentdossiers,
                    'aantaldossiersgefactureerd' =>
                        $totalen[$key]['aantaldossiersgefactureerd'],
                    'aantaldossiersnietgefactureerd' => $totalen[$key]['aantaldossiersnietgefactureerd']
                );
                /*********************/
            } else {
                $kleineMakelaars[$key] = $totalen[$key];

                $tot = $totalen[$key]['totaal'];
                $aant = $totalen[$key]['aantal'];
                $totbef = $totalen[$key]['totaal'] * 40.3399;

                /* ADDED 14/12/2019 */
                $totfact = $totalen[$key]['aantaldossiersgefactureerd'];
                $totnfact = $totalen[$key]['aantaldossiersnietgefactureerd'];
                /*******************/

                if (isset($makelaarslijst['ANDEREN'])) {
                    $vorigtot = $makelaarslijst['ANDEREN']['totaal'];
                    $vorigaant = $makelaarslijst['ANDEREN']['aantal'];
                    $vorigtotbef = $makelaarslijst['ANDEREN']['totbef'];

                    /* ADDED 14/12/2019 */
                    $vorigfact = $makelaarslijst['ANDEREN']['aantaldossiersgefactureerd'];
                    $vorignfact = $makelaarslijst['ANDEREN']['aantaldossiersnietgefactureerd'];
                    $nieuwfact = $totfact + $vorigfact;
                    $nieuwnfact = $totnfact + $vorignfact;
                    /*******************/

                    $nieuwtot = $tot + $vorigtot;
                    $nieuwaant = $aant + $vorigaant;
                    //$nieuwtotbef = round($totbef,2) + $vorigtotbef;
                    $nieuwtotbef = $totbef + $vorigtotbef;
                    $nieuwpercent = round(($nieuwtot / $grandtotal) * 100, 4);
                    $nieuwpercentdossiers = round(($nieuwaant / $totdossiers) * 100, 4);

                    /* CHANGED 14/12/2019 */
                    $makelaarslijst['ANDEREN'] = array(
                        'totaal' => $nieuwtot,
                        'aantal' => $nieuwaant,
                        'totbef' => round($nieuwtotbef, 2),
                        'percent' => $nieuwpercent,
                        'percentdossiers' => $nieuwpercentdossiers,
                        'aantaldossiersgefactureerd' =>
                            $nieuwfact,
                        'aantaldossiersnietgefactureerd' => $nieuwnfact
                    );
                    /**********************/
                } else {
                    $percent = round(($totalen[$key]['totaal'] / $grandtotal) * 100, 4);
                    $percentdossiers = round(($totalen[$key]['aantal'] / $totdossiers) * 100, 4);

                    /* CHANGED 14/12/2019 */
                    $makelaarslijst['ANDEREN'] = array(
                        'totaal' => $totalen[$key]['totaal'],
                        'aantal' => $totalen[$key]['aantal'],
                        'totbef' => round(($totalen[$key]['totaal'] * 40.3399), 2),
                        'percent' => $percent,
                        'percentdossiers' => $percentdossiers,
                        'aantaldossiersgefactureerd' => $totalen[$key]['aantaldossiersgefactureerd'],
                        'aantaldossiersnietgefactureerd' =>
                            $totalen[$key]['aantaldossiersnietgefactureerd']
                    );
                    /**********************/
                }

                $kleineMakelaars[$key]['percent'] = round(($tot / $grandtotal) * 100, 4);
                $kleineMakelaars[$key]['percentdossiers'] = round(($aant / $totdossiers) * 100, 4);

            }
        }

        $sorted = Arr::sortRecursive($makelaarslijst);

        return view('search/dossiersStatistiekenResultaat', ['resultaten' => json_encode($sorted, JSON_NUMERIC_CHECK), 'kleinemakelaars' => json_encode(Arr::sortRecursive($kleineMakelaars), JSON_NUMERIC_CHECK), 'grandtotal' => $grandtotal, 'titel' => $titel, 'totdossiers' => $totdossiers]);
    }

}