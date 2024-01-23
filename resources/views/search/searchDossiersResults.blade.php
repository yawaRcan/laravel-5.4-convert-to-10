<table class="table table-sm table-striped">
    <tr>
        <th>Nr</th>
        <th>Datum</th>
        <th>Nummerplaat</th>
        <th>Makelaar</th>
        <th>Maatschappij</th>
        <th>Bedrag</th>
    </tr>

    @foreach($searchDossiers as $dossier)
        <tr>
            <td><a href="{{ route('dossiers.show', $dossier->id) }}">{{ ucwords(strtolower($dossier->id), " ") }}</a></td>
            <td>{{ \Carbon\Carbon::parse($dossier->datum)->format('d/m/Y') }}</td>
            <td>{{ $dossier->nummerplaat}}</td>
            <td>{{ $dossier->makelaar}}</td>
            <td>{{ $dossier->maatschappij }}</td>
            <td class="rechts">{{ $dossier->resultaat }}</td>
        </tr>
    @endforeach
</table>