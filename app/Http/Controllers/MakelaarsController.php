<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveMakelaarRequest;
use App\Makelaar;
use Illuminate\Http\Request;

class MakelaarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $makelaars = Makelaar::orderBy('naam')->paginate(5);
        return view('makelaars.index', ['makelaars'=>$makelaars]);
    }

    public function create() {
        return view('makelaars.create');
    }

    public function store(SaveMakelaarRequest $request) {
        $this->validate($request, [
            'naam' => 'required|unique:makelaars'
        ]);

        $makelaar = new Makelaar();
        $makelaar->naam = $request->naam;
        $makelaar->telefoon = $request->telefoon;
        $makelaar->website = $request->website;
        $makelaar->save();

        return redirect(route('makelaars.home'));
    }

    public function edit($id) {
        $makelaar = Makelaar::findOrFail($id);
        return view('makelaars.edit', compact('makelaar'));
    }

    public function update(SaveMakelaarRequest $request, $id) {
        $makelaar = Makelaar::findOrFail($id);
        $makelaar->naam = $request->naam;
        $makelaar->telefoon = $request->telefoon;
        $makelaar->website = $request->website;
        $makelaar->save();
        return redirect(route('makelaars.home'));
    }

    public function destroy($id) {
        $makelaar = Makelaar::findOrFail($id);
        $makelaar->delete();
        return redirect(route('makelaars.home'));
    }
}
