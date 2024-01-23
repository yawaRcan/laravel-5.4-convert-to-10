<?php

namespace App\Http\Controllers;

use App\Models\Actie;
use App\Http\Requests\SaveActieRequest;
use Illuminate\Http\Request;

class ActiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $acties = Actie::all()->sortBy('actie');
        return view('acties.index', ['acties'=>$acties]);
    }

    public function create() {
        return view('acties.create');
    }

    public function store(SaveActieRequest $request) {
        $actie = new Actie();
        $actie->actie = $request->actie;
        $actie->save();

        return redirect(route('acties.home'));
    }

    public function edit($id) {
        $actie = Actie::findOrFail($id);
        return view('acties.edit', compact('actie'));
    }

    public function update(SaveActieRequest $request, $id) {
        $actie = Actie::findOrFail($id);
        $actie->actie = $request->actie;
        $actie->save();
        return redirect(route('acties.home'));
    }

    public function destroy($id) {
        $actie = Actie::findOrFail($id);
        $actie->delete();
        return redirect(route('acties.home'));
    }
}
