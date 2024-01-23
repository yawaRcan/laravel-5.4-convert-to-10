@extends('layouts.main')

@section('title', 'Acties')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('acties.create') }}" class="btn btn-primary">Maak nieuwe actie aan</a>
        </div>
    </div>

    @if ($acties->IsEmpty())
        <p>Er zijn nog geen acties aanwezig !</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Actie</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            @foreach($acties as $actie)
                <tr>
                    <td>{{ $actie->actie }}</td>
                    <td><a href="{{ route('acties.edit', $actie->id) }}" class="btn btn-default">Edit</a>
                        <a href="{{ route('acties.destroy', $actie->id) }}" class="btn btn-danger">Delete</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif

@endsection