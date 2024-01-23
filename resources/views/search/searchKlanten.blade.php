<table class="table table-sm table-striped">
    <tr>
        <th>Naam</th>
        <th>Adres</th>
        <th>Telefoon</th>
    </tr>

    @foreach($searchKlanten as $klant)
        <tr>
            <td><a href="{{ route('klanten.edit', $klant->id) }}">{{ ucwords(strtolower($klant->naam), " ") }}</a></td>
            <td>{{ $klant->straat }} {{ $klant->nr }} {{ $klant->postcode }} {{ $klant->gemeente }}</td>
            <td>{{ $klant->telefoon }}</td>
        </tr>
    @endforeach
</table>