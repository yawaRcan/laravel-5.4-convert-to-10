@extends('layouts.main')

@section('title', 'Import')

@section('content')
    <p>{{ $aantalniet }} nieuwe facturen<br>
        {{ $aantalaangepast }} aangepaste facturen<br>
        {{ $aantalwel }} bestaande facturen
    </p>

    @if($latestactivities)
        <h2>Import Log</h2>
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