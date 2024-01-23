<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Dossier;
use App\Models\Factuur;
use App\Models\Http\Requests\SaveFactuurRequest;
use App\Models\Klant;
use App\Models\Maatschappij;
use App\Models\Makelaar;
use App\Models\VervaldagType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacturenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$facturen = Factuur::has('dossiers')->orderBy('factuurnummer')->paginate(100);
        $facturen = Factuur::orderBy('factuurnummer')->with('Klant')->paginate(100);
        // dd($facturen);
        return view('facturen.index', ['facturen' => $facturen]);
    }

    public function create()
    {
        $vervaldagtypes = ['' => 'Kies een vervaldag termijn'] + VervaldagType::pluck('type', 'id')->all();
        $merken = ['' => 'Kies een auto merk'] + Car::pluck('brand', 'id')->all();
        $makelaars = ['' => 'Kies een makelaar'] + Makelaar::pluck('naam', 'id')->all();
        $maatschappijen = ['' => 'Kies een maatschappij'] + Maatschappij::pluck('naam', 'id')->all();

        $klanten = ['' => 'Kies een klant'];
        foreach (Klant::all() as $klant) {
            //$klanten[$klant->id] = $klant->voornaam . ' ' . $klant->naam;
            $klanten[$klant->id] = $klant->naam;
        }

        $fn = Factuur::volgendFactuurNummer();

        return view(
            'facturen.create',
            [
                'vervaldagtypes' => $vervaldagtypes,
                'klanten' => $klanten,
                'merken' => $merken,
                'makelaars' => $makelaars,
                'maatschappijen' => $maatschappijen,
                'fn' => $fn,
            ]
        );
    }

    public function store(SaveFactuurRequest $request)
    {
        $this->validate($request, [
            'factuurnummer' => 'required',
        ]);

        $factuur = new Factuur();
        $factuur->factuurnummer = $request->factuurnummer;
        $factuur->datum = $request->datum;
        $factuur->vervaldagtype_id = $request->vervaldagtype_id;

        $vvt = VervaldagType::findOrFail($request->vervaldagtype_id);
        $t = Carbon::parse($request->datum);
        $factuur->vervaldag = $t->addDays($vvt->dagen);

        $factuur->klant_id = $request->klant_id;
        $factuur->bedrag = $request->bedrag;
        $factuur->betaald = $request->betaald;
        $factuur->voldaan = $request->voldaan ? true : false;
        $factuur->code = $request->code;
        $factuur->merk_id = $request->merk_id;
        $factuur->type = $request->type;
        $factuur->makelaar_id = $request->makelaar_id;
        $factuur->maatschappij_id = $request->maatschappij_id;
        $factuur->opmerkingen = $request->opmerkingen;
        $factuur->betalingswijze = $request->betalingswijze;

        $factuur->save();

        return redirect(route('facturen.home'));
    }

    public function edit($id)
    {
        $factuur = Factuur::findOrFail($id);

        /* $vervaldagtypes = ['' => 'Kies een vervaldag termijn'] + VervaldagType::pluck('type', 'id')->all();
         $merken = ['' => 'Kies een auto merk'] + Car::pluck('brand', 'id')->all();
         $makelaars = ['' => 'Kies een makelaar'] + Makelaar::pluck('naam', 'id')->all();
         $maatschappijen = ['' => 'Kies een maatschappij'] + Maatschappij::pluck('naam', 'id')->all();

 */
        $dezeklant = Klant::findOrFail($factuur->klant_id);

        /*
        $klanten = ['0' => 'Kies een klant'];
        foreach (Klant::all() as $klant) {
            //$klanten[$klant->id] = $klant->voornaam . ' ' . $klant->naam;
            $klanten[$klant->id] = $klant->naam;
        }
        */

        $dossier = $factuur->dossiers()->first();

        //dd($dossier);
        //foreach ($dossier->facturen as $fact) {
        //dd($fact);
        //dd($dossier->merk_id);
        //}

        return view('facturen.edit', compact('factuur'), [
            'klantid' => $dezeklant->id,
            'klantnaam' => $dezeklant->naam,
            'dossier' => $dossier,
        ]);
    }

    public function update(SaveFactuurRequest $request, $id)
    {
        $factuur = Factuur::findOrFail($id);

        $factuur->factuurnummer = $request->factuurnummer;
        $factuur->datum = $request->datum;
        $factuur->vervaldagtype_id = $request->vervaldagtype_id;

        $vvt = VervaldagType::findOrFail($request->vervaldagtype_id);
        $t = Carbon::parse($request->datum);
        $factuur->vervaldag = $t->addDays($vvt->dagen);

        $factuur->klant_id = $request->klant_id;
        $factuur->bedrag = $request->bedrag;
        $factuur->betaald = $request->betaald;
        $factuur->voldaan = $request->voldaan ? true : false;
        $factuur->code = $request->code;
        $factuur->merk_id = $request->merk_id;
        $factuur->type = $request->type;
        $factuur->makelaar_id = $request->makelaar_id;
        $factuur->maatschappij_id = $request->maatschappij_id;
        $factuur->opmerkingen = $request->opmerkingen;
        $factuur->betalingswijze = $request->betalingswijze;

        $factuur->save();
        return redirect(route('facturen.home'));
    }
    public function destroy()
    {

    }

}
