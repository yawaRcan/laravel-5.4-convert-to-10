@extends('layouts.main')

@section('title', 'Dossiers Import')

@section('content')
    <p>{{ $aantalniet }} nieuwe dossiers<br>
        {{ $aantalwel }} bestaande dossiers
    </p>

    @if($latestactivities)
        <h2>Dossiers Import Log</h2>
        <table class="table table-striped log">

        @foreach($latestactivities->sortBy('created_at') as $la)
            <tr>
                <td>
                    {{ $la->created_at }}
                </td>
                <td>
                    {{ $la->description }}
                </td>
            </tr>
        @endforeach
        </table>
    @endif

@endsection