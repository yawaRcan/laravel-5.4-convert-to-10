<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\SaveCarRequest;
use Illuminate\Http\Request;
use App\Http\Requests;

class CarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $cars = Car::orderBy('brand')->paginate(5);
        return view('cars.index', ['cars'=>$cars]);
    }

    public function create() {
        return view('cars.create');
    }

    public function store(SaveCarRequest $request) {
        $this->validate($request, [
            'brand' => 'unique:cars|required'
        ]);

        $car = new Car();
        $car->brand = $request->brand;
        $car->save();

        return redirect(route('cars.home'));
    }

    public function edit($id) {
        $car = Car::findOrFail($id);
        return view('cars.edit', compact('car'));
    }

    public function update(SaveCarRequest $request, $id) {
        $car = Car::findOrFail($id);
        $car->brand = $request->brand;
        $car->save();
        return redirect(route('cars.home'));
    }

    public function destroy($id) {
        $car = Car::findOrFail($id);
        $car->delete();
        return redirect(route('cars.home'));
    }
}
