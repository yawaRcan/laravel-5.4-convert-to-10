<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveMaatschappijRequest;
use App\Maatschappij;
use Illuminate\Http\Request;

class MaatschappijenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index() {
        $maatschappijen = Maatschappij::orderBy('naam')->paginate(5);
        return view('maatschappijen.index', ['maatschappijen'=>$maatschappijen]);
    }

    public function create() {
        return view('maatschappijen.create');
    }

    public function store(SaveMaatschappijRequest $request) {
        $this->validate($request, [
            'naam' => 'required|unique:maatschappijen'
        ]);

        $maatschappij = new Maatschappij();
        $maatschappij->naam = $request->naam;
        $maatschappij->telefoon = $request->telefoon;
        $maatschappij->website = $request->website;
        $maatschappij->save();

        return redirect(route('maatschappijen.home'));
    }

    public function edit($id) {
        $maatschappij = Maatschappij::findOrFail($id);
        return view('maatschappijen.edit', compact('maatschappij'));
    }

    public function update(SaveMaatschappijRequest $request, $id) {
        $maatschappij = Maatschappij::findOrFail($id);
        $maatschappij->naam = $request->naam;
        $maatschappij->telefoon = $request->telefoon;
        $maatschappij->website = $request->website;
        $maatschappij->save();
        return redirect(route('maatschappijen.home'));
    }

    public function destroy($id) {
        $maatschappij = Maatschappij::findOrFail($id);
        $maatschappij->delete();
        return redirect(route('maatschappijen.home'));
    }
}
