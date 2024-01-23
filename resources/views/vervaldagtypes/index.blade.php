@extends('layouts.main')

@section('title', 'Vervaldagtypes')

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('vervaldagtypes.create') }}" class="btn btn-primary">Maak nieuw vervaldagtype aan</a>
        </div>
    </div>

    @if ($vervaldagtypes->IsEmpty())
        <p>Er zijn nog geen vervaldagtypes aanwezig !</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Type</th>
                <th>Dagen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($vervaldagtypes as $vervaldagtype)
                <tr>
                    <td>
                        <a href="{{ route('vervaldagtypes.edit', $vervaldagtype->id) }}">{{ $vervaldagtype->type }}</a>
                    </td>
                    <td>{{ $vervaldagtype->dagen }}</td>
                </tr>
            @endforeach

            {{ $vervaldagtypes->links() }}
            </tbody>
        </table>
    @endif
@endsection