@extends('layouts.main')

@section('title', 'Makelaars')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('makelaars.create') }}" class="btn btn-primary">Maak nieuwe makelaar aan</a>
        </div>
    </div>

    @if ($makelaars->IsEmpty())
        <p>Er zijn nog geen makelaars aanwezig !</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Makelaar</th>
                <th>Telefoon</th>
                <th>Website</th>
            </tr>
            </thead>
            <tbody>
            @foreach($makelaars as $makelaar)
                <tr>
                    <td><a href="{{ route('makelaars.edit', $makelaar->id) }}">{{ $makelaar->naam }}</a></td>
                    <td>{{ $makelaar->telefoon }}</td>
                    <td>{{ $makelaar->website }}</td>
                </tr>
            @endforeach

            {{ $makelaars->links() }}
            </tbody>
        </table>
    @endif

@endsection