@extends('layouts.main')

@section('title', 'Auto merken')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('cars.create') }}" class="btn btn-primary">Maak nieuw automerk aan</a>
        </div>
    </div>

    @if ($cars->IsEmpty())
        <p>Er zijn nog geen automerken aanwezig !</p>
    @else
        <table class="table table-striped table-condensed">
            <thead>
            <tr>
                <th>Merk</th>
            </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                    <tr>
                        <td><a href="{{ route('cars.edit', $car->id) }}">{{ $car->brand }}</a></td>
                    </tr>
                @endforeach
                {{ $cars->links() }}
            </tbody>
        </table>
    @endif

@endsection