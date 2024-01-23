<?php

namespace App\Http\Controllers;

use App\Imports\ActivityLogs;
use App\Models\Car;
use App\Models\Dossier;
use App\Models\DossierFactuur;
use App\Models\Factuur;
use App\Models\Klant;
use App\Models\Maatschappij;
use App\Models\Makelaar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;
use Maatwebsite\Excel\Concerns\ToModel;
use app\Imports\ActivityLogImport;



class ExportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('export.index');
    }

    public function export(Request $request)
    {
        $facturen = Factuur::all();
        $tot_record_found = 0;
        if (count($facturen) > 0) {
            $tot_record_found = 1;

            $CsvData = array('Factuurnummer,Datum,Bedrag');
            $nu = \Carbon\Carbon::now();

            foreach ($facturen as $value) {

                $klant = Klant::findOrFail($value->klant_id);
                $makelaar = Makelaar::findOrFail($value->makelaar_id);
                $maatschappij = Maatschappij::findOrFail($value->maatschappij_id);
                $car = Car::findOrFail($value->merk_id);
                $euro = 40.3399;
                $vervaldag = Carbon::parse($value->vervaldag)->format('d/m/Y');
                $vervallen = 0;

                if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($value->vervaldag))) {
                    $vervallen = 1;
                }

                $CsvData[] = ',' .
                    $value->factuurnummer . ',' .
                    $value->datum . ',' .
                    //$klant->naam . ' ' . $klant->voornaam . ',' .
                    $klant->naam .
                    $klant->telefoon . ',' .
                    $value->datum . ',' .
                    $value->vervaldagtype_id . ',' .
                    $vervaldag . ',' .
                    $value->bedrag * $euro . ',' .
                    $value->betaald * $euro . ',' .
                    ($value->bedrag - $value->betaald) * $euro . ',' .
                    $value->bedrag . ',' .
                    $value->betaald . ',' .
                    ($value->bedrag - $value->betaald) . ',' .
                    $value->voldaan . ',' .
                    str_replace(array('.', ','), '', $value->opmerkingen) . ',' .
                    ($klant->btw == 1 ? 'BTW' : '') . ',' .
                    ',,,,,,,,,,,,,,,' .
                    $vervallen . ',' .
                    ',' . //Vrijstellingsbedrag ?
                    $value->betalingswijze . ',' .
                    $makelaar->naam . ',' .
                    $maatschappij->naam . ',' .
                    ',' . //Autocode ?
                    $car->brand . ',' .
                    $value->type;
            }

            $filename = date('Y-m-d') . ".csv";
            $file_path = base_path() . '/' . $filename;

            $file = fopen($file_path, "w+");
            foreach ($CsvData as $exp_data) {
                fputcsv($file, explode(',', $exp_data));
            }
            fclose($file);

            $headers = ['Content-Type' => 'application/csv'];
            return response()->download($file_path, $filename, $headers);

        }

        return view('/export', ['record_found' => $tot_record_found]);
    }

    public function import(Request $request)
    {
        return view('export/dossiers_file_import');
    }

    public function importExportExcelORCSV()
    {
        return view('export/file_import');
    }

    public function importFileIntoDB(Request $request)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '700M');

        if ($request->hasFile('sample_file')) {
            $path = $request->file('sample_file')->getRealPath();
            $import = new Factuur;
            $data = Excel::import($import, $path);
            $sheet = Excel::toArray(new ActivityLogs, $request->file('sample_file'));
            $numberOfRows = count($sheet[0]);

            $aantalwel = 0;
            $aantalniet = 0;
            $aantalaangepast = 0;
            $aangepastefacturen = 0;
            $aantallogs = 0;

            activity('Import')->log('Import gestart');
            $aantallogs++;

            if ($data) {

                $facturen = Factuur::all();
                $klanten = Klant::all();

                activity('Import')->log('Aantal lijnen gevonden in Excel file = ' . $numberOfRows);
                $aantallogs++;

                foreach ($data as $key => $value) {

                    if ($value->nummer != "") {

                        $f = Factuur::where('factuurnummer', $value->nummer)->first();

                        if ($f == null) {

                            $aantalniet++;

                            $nieuwfactuur = new Factuur();
                            $nieuwfactuur->factuurnummer = $value->nummer;
                            $nieuwfactuur->datum = $value->datum;

                            $nieuwfactuur->bedrag = $value['bedrag_incl.'];
                            $nieuwfactuur->betaald = $value['bedrag_incl.'] - $value->niet_betaald;

                            $nieuwfactuur->vervaldag = $value->vervaldatum;
                            $nieuwfactuur->voldaan = $value->niet_betaald > 0 ? false : true;
                            $nieuwfactuur->code = $value->nummerplaat;
                            $nieuwfactuur->opmerkingen = $value->opmerkingen . "\n" . $value->opmerkingen2 . "\n" . $value->opmerkingen_ho;
                            //$nieuwfactuur->merk_id = 0;

                            activity('Import')->log("Nieuw factuur " . $value->nummer . " aangemaakt");
                            $aantallogs++;

                            $klant = Klant::where('klantnummer', $value->klantnummer)->first();

                            if ($klant == null) {
                                $nieuweklant = new Klant();

                                $nieuweklant->naam = $value->klant;
                                $nieuweklant->straat = $value->adres . ($value->adres_2 == null ? "" : " " . $value->adres_2);
                                $nieuweklant->postcode = $value->postcode;
                                $nieuweklant->gemeente = $value->gemeente;
                                $nieuweklant->klantnummer = $value->klantnummer;
                                $nieuweklant->telefoon = $value->telefoon_nr;
                                $nieuweklant->gsm = $value->gsm;
                                $nieuweklant->fax = $value->fax;

                                if ($value->btw_nummer != "") {
                                    $nieuweklant->btw = 1;
                                    $nieuweklant->btwnr = $value->btw_nummer;
                                } else {
                                    $nieuweklant->btw = 0;
                                }

                                $nieuweklant->save();

                                activity('Import')->log("Nieuwe klant " . $value->klant . " aangemaakt");
                                $aantallogs++;

                                $nieuwfactuur->klant_id = $nieuweklant->id;
                            } else {
                                $nieuwfactuur->klant_id = $klant->id;
                            }

                            $nieuwfactuur->save();

                            /*
                             * Koppel factuur aan dossier
                             */

                            $doss = DB::table('dossiers')->where('dossiernummer', $value->klantnummer)->first();

                            if ($doss <> null) {
                                $nieuwfactuur->dossiers()->attach($doss->id);
                            }

                        } else {

                            $aangepast = 0;

                            if ($f->bedrag != $value['bedrag_incl.']) {

                                activity('Import')->log("Factuur " . $value->nummer . ": Bedrag Incl. aangepast van " . $f->bedrag . " naar " . $value['bedrag_incl.']);
                                $aantallogs++;

                                $f->bedrag = $value['bedrag_incl.'];
                                $aangepast = 1;
                            }

                            $vvv = $value['bedrag_incl.'] - $value->niet_betaald;
                            if ($f->betaald != $vvv) {

                                activity('Import')->log("Factuur " . $value->nummer . ": Betaald bedrag aangepast van " . $f->betaald . " naar " . $vvv);
                                $aantallogs++;

                                $f->betaald = $vvv;
                                $aangepast = 1;
                            }

                            if ($f->voldaan != $value->niet_betaald > 0 ? false : true) {

                                activity('Import')->log("Factuur " . $value->nummer . ": Voldaan aangepast van " . $f->voldaan . " naar " . $value->niet_betaald > 0 ? false : true);
                                $aantallogs++;

                                $f->voldaan = $value->niet_betaald > 0 ? false : true;
                                $aangepast = 1;
                            }

                            if ($aangepast == 1) {
                                $aangepastefacturen = $aangepastefacturen . "\n" . $value->nummer;
                                $aantalaangepast++;
                                $f->save();
                            } else {
                                $aantalwel++;
                            }
                        }
                    }
                }
            }

            activity('Import')->log("Import beeindigd");
            $aantallogs++;

            $latestActivities = Activity::orderBy('id', 'desc')->take($aantallogs)->get();
            //dd ($latestActivities);
            //$la = $latestActivities->orderBy('created_at', 'desc');
        }
        return view('export.import_results', ['aantalniet' => $aantalniet, 'aantalwel' => $aantalwel, 'aantalaangepast' => $aantalaangepast, 'aangepastefacturen' => $aangepastefacturen, 'latestactivities' => $latestActivities]);
    }

    public function importDossiersIntoDB(Request $request)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '700M');

        if ($request->hasFile('dossier_file')) {

            $path = $request->file('dossier_file')->getRealPath();
            $import = new ActivityLogs;
            $data = Excel::import($import, $path);
            $sheet = Excel::toArray(new ActivityLogs, $request->file('dossier_file'));
            $aantalniet = 0;
            $aantalwel = 0;
            $aantalaangepast = 0;
            $aangepastedossiers = "";
            $aantallogs = 0;
            $numberOfRows = count($sheet[0]);
            activity('Import')->log('Import van dossiers gestart');
            $aantallogs++;

            if ($data) {

                $dossiers = Dossier::all();
                $facturen = Factuur::all();

                activity('Import')->log('Aantal lijnen gevonden in Excel file = ' . $numberOfRows);
                $aantallogs++;

                foreach ($data as $key => $value) {
                    if ($value->nummer != "") {

                        $d = Dossier::where('dossiernummer', $value->nummer)->first();

                        if ($d == null) {
                            $aantalniet++;

                            $nieuwdossier = new Dossier();
                            $nieuwdossier->dossiernummer = $value->nummer;
                            $nieuwdossier->datum = $value['datum_creatie'];
                            $nieuwdossier->nummerplaat = $value->nummerplaat;

                            // CHECK OF CAR BESTAAT
                            /*$c = Car::where('brand', $value->merk)->first();

                            if ($c == null) {
                                $nieuweauto = new Car();
                                $nieuweauto->brand = $value->merk;
                                $nieuweauto->save();

                                activity('Import')->log("Nieuw automerk " . $value->merk . " aangemaakt");
                                $aantallogs++;

                                $nieuwdossier->merk_id = $nieuweauto->id;
                            } else {
                                $nieuwdossier->merk_id = $c->id;
                            }
                            */

                            $nieuwdossier->merk = $value->merk;
                            $nieuwdossier->model = $value->model;

                            // CHECK OF VERZEKERING BESTAAT
                            /*$m = Maatschappij::where('naam', $value->Verzekeraar)->first();

                            if ($m == null) {
                                $nieuwemaatschappij = new Maatschappij();

                                if ($value->Verzekeraar == "")
                                {
                                    $nieuwemaatschappij->naam = "onbekend";
                                }
                                else
                                {
                                    $nieuwemaatschappij->naam = $value->Verzekeraar;
                                }

                                $nieuwemaatschappij->telefoon = "";
                                $nieuwemaatschappij->website = "";
                                $nieuwemaatschappij->save();

                                activity('Import')->log("Nieuwe verzekeringsmaatschappij " . $value->Verzekeraar . " aangemaakt");
                                $aantallogs++;

                                $nieuwdossier->verzekering_id = $nieuwemaatschappij->id;
                            } else {
                                $nieuwdossier->verzekering_id = $m->id;
                            }
                            */

                            $nieuwdossier->maatschappij = $value->verzekeraar;

                            // CHECK OF MAKELAAR BESTAAT
                            /*$mak = Makelaar::where('naam', $value->makelaar)->first();

                            if ($mak == null) {

                                $nieuwemakelaar = new Makelaar();

                                if ($value->makelaar == "")
                                {
                                    $nieuwemakelaar->naam = "onbekend";
                                }
                                else
                                {
                                    $nieuwemakelaar->naam = $value->makelaar;
                                }

                                $nieuwemakelaar->telefoon = "";
                                $nieuwemakelaar->website = "";
                                $nieuwemakelaar->save();

                                activity('Import')->log("Nieuwe makelaar " . $value->makelaar . " aangemaakt");
                                $aantallogs++;

                                $nieuwdossier->makelaar_id = $nieuwemakelaar->id;
                            } else {
                                $nieuwdossier->makelaar_id = $mak->id;
                            }
                            */

                            $nieuwdossier->makelaar = $value->makelaar;
                            $nieuwdossier->resultaat = $value->resultaat;
                            $nieuwdossier->opmerkingen = $value->opmerkingen . "\n" . $value->opmerkingen2 . "\n" . $value->opmerkingen_ho;

                            /* Added 04/12/2019 */
                            $nieuwdossier->status = $value->status;
                            /*******************/

                            $nieuwdossier->save();

                            if ($value->facturen <> "") {
                                $factuurids = explode(',', $value->facturen);

                                foreach ($factuurids as $fi) {
                                    $fact = DB::table('facturen')->where('factuurnummer', $fi)->first();

                                    if ($fact <> null) {
                                        $nieuwdossier->facturen()->attach($fact->id);
                                    }
                                }

                                $nieuwdossier->save();
                            }

                            activity('Import')->log("Nieuw dossier " . $value->nummer . " aangemaakt");
                            $aantallogs++;
                        } else {
                            $aangepast = 0;

                            if ($d->merk != $value->merk) {
                                activity('Import')->log("Dossier " . $value->nummer . ": Merk aangepast van " . $d->merk . " naar " . $value->merk);
                                $aantallogs++;

                                $d->merk = $value->merk;
                                $aangepast = 1;
                            }

                            if ($d->model != $value->model) {
                                activity('Import')->log("Dossier " . $value->nummer . ": Model aangepast van " . $d->model . " naar " . $value->model);
                                $aantallogs++;

                                $d->model = $value->model;
                                $aangepast = 1;
                            }

                            if ($d->makelaar != $value->makelaar) {
                                activity('Import')->log("Dossier " . $value->nummer . ": Makelaar aangepast van " . $d->makelaar . " naar " . $value->makelaar);
                                $aantallogs++;

                                $d->makelaar = $value->makelaar;
                                $aangepast = 1;
                            }

                            if ($d->maatschappij != $value->verzekeraar) {
                                activity('Import')->log("Dossier " . $value->nummer . ": Maatschappij aangepast van " . $d->maatschappij . " naar " . $value->verzekeraar);
                                $aantallogs++;

                                $d->maatschappij = $value->verzekeraar;
                                $aangepast = 1;
                            }

                            if ($d->resultaat != $value->resultaat) {
                                activity('Import')->log("Dossier " . $value->nummer . ": Resultaat aangepast van " . $d->resultaat . " naar " . $value->resultaat);
                                $aantallogs++;

                                $d->resultaat = $value->resultaat;
                                $aangepast = 1;
                            }

                            if ($d->opmerkingen != $value->opmerkingen . "\n" . $value->opmerkingen2 . "\n" . $value->opmerkingen_ho) {
                                $opmerkingenStr = "Dossier " . $value->nummer . ": Opmerkingen aangepast van " . $d->opmerkingen . " naar " . $value->opmerkingen . "\n" . $value->opmerkingen2 . "\n" . $value->opmerkingen_ho;
                                activity('Import')->log(str_limit($opmerkingenStr, 185));
                                $aantallogs++;

                                $d->opmerkingen = str_limit($value->opmerkingen . "\n" . $value->opmerkingen2 . "\n" . $value->opmerkingen_ho, 185);
                                $aangepast = 1;
                            }

                            /* Added 04/12/2019 */
                            if ($d->status != $value->status) {
                                activity('Import')->log("Dossier " . $value->nummer . ": Status aangepast van " . $d->status . " naar " . $value->status);
                                $aantallogs++;

                                $d->status = $value->status;
                                $aangepast = 1;
                            }
                            /*******************/

                            if ($value->facturen <> "") {
                                $factarr = [];
                                $factuurids = explode(',', $value->facturen);

                                foreach ($factuurids as $fi) {
                                    $fact = DB::table('facturen')->where('factuurnummer', $fi)->first();

                                    if ($fact <> null) {
                                        $factarr[] = $fact->id;
                                    }
                                }

                                $d->facturen()->sync($factarr);
                            }


                            if ($aangepast == 1) {
                                $aangepastedossiers = $aangepastedossiers . "\n" . $value->nummer;
                                $aantalaangepast++;
                                $d->save();
                            } else {
                                $aantalwel++;
                            }
                        }
                    }
                }
            }

            activity('Import')->log("Import dossiers beeindigd");
            $aantallogs++;

            $latestActivities = Activity::orderBy('id', 'desc')->take($aantallogs)->get();
        }

        return view('export.import_dossiers_results', ['aantalniet' => $aantalniet, 'aantalwel' => $aantalwel, 'aantalaangepast' => $aantalaangepast, 'aangepastedossiers' => $aangepastedossiers, 'latestactivities' => $latestActivities]);
    }

}
