<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveKlantRequest;
use App\Models\Klant;
use Illuminate\Http\Request;

class KlantenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $klanten = Klant::orderBy('naam')->paginate(50);
        return view('klanten.index', ['klanten' => $klanten]);
    }

    public function create()
    {
        return view('klanten.create');
    }

    public function store(SaveKlantRequest $request)
    {
        $this->validate($request, [
            'naam' => 'required',
        ]);

        $klant = new Klant();
        $klant->naam = $request->naam;
        //$klant->voornaam = $request->voornaam;
        $klant->straat = $request->straat;
        //$klant->nr = $request->nr;
        $klant->postcode = $request->postcode;
        $klant->gemeente = $request->gemeente;
        $klant->telefoon = $request->telefoon;
        $klant->gsm = $request->gsm;
        $klant->fax = $request->fax;
        $klant->email = $request->email;
        $klant->btw = $klant->btw ? true : false;
        $klant->btwnr = $request->btwnr;
        $klant->opmerking = $request->opmerking;

        $klant->save();

        return redirect(route('klanten.home'));
    }

    public function edit($id)
    {
        $klant = Klant::findOrFail($id);
        return view('klanten.edit', compact('klant'));
    }

    public function update(SaveKlantRequest $request, $id)
    {
        $klant = Klant::findOrFail($id);
        $klant->naam = $request->naam;
        //$klant->voornaam = $request->voornaam;
        $klant->straat = $request->straat;
        //$klant->nr = $request->nr;
        $klant->postcode = $request->postcode;
        $klant->gemeente = $request->gemeente;
        $klant->telefoon = $request->telefoon;
        $klant->gsm = $request->gsm;
        $klant->fax = $request->fax;
        $klant->email = $request->email;
        $klant->btw = $request->btw ? true : false;
        $klant->btwnr = $request->btwnr;
        $klant->opmerking = $request->opmerking;

        $klant->save();
        return redirect(route('klanten.home'));
    }

    public function destroy($id)
    {
        $klant = Klant::findOrFail($id);
        $klant->delete();
        return redirect(route('klanten.home'));
    }

}
