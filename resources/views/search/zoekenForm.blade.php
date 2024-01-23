<div class="row">
    <div class="col-lg-7">

        <h5>Opzoek criterium</h5>

        <div class="form-group">
            <table>
                <tr>
                    <td>{{ Form::radio('criterium', '1') }} Factuur nr tussen: &nbsp;</td>
                    <td>{{ Form::text('factuurnr_start', null, ['class'=>'form-control']) }}</td>
                    <td>&nbsp;en&nbsp;</td>
                    <td>{{ Form::text('factuurnr_einde', null, ['class'=>'form-control']) }}</td>
                </tr>
                <tr>
                    <td>{{ Form::radio('criterium', '2') }} Factuurdatum tussen: &nbsp;</td>
                    <td>{{ Form::date('factuurdatum_start', null, ['class'=>'form-control']) }}</td>
                    <td>&nbsp;en&nbsp;</td>
                    <td>{{ Form::date('factuurdatum_einde', null, ['class'=>'form-control']) }}</td>
                </tr>
                <tr>
                    <td>Bedrag:</td>
                    <td>
                        <select name="operator" id="operator">
                            <option value="less"><</option>
                            <option value="more">></option>
                            <option value="equal">=</option>
                        </select>
                    </td>
                    <td></td>
                    <td>{{ Form::number('bedrag', null, ['class'=>'form-control'])}}</td>
                </tr>
                <tr>
                    <td>Naam: &nbsp;</td>
                    <td>{!! Form::select('klant_id', $klanten, null, ['id'=>'klant_id','class'=>'form-control']) !!}</td>
                    <td></td>
                    <td>{{ Form::text('zoekklant', null, ['id'=>'zoekklant', 'class'=>'form-control', 'placeholder'=>'Type een naam']) }}</td>
                </tr>

                <tr style="display: none;">
                    <td>Makelaar:&nbsp;</td>
                    <td>{!! Form::select('makelaar_id', $makelaars, null, ['id'=>'makelaar_id', 'class'=>'form-control']) !!}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-lg-3">
        <h5>Selectie</h5>
        {{ Form::radio('facturen_selectie', '1', true) }} &nbsp;Alle facturen&nbsp;<br>
        {{ Form::radio('facturen_selectie', '2') }} &nbsp;Betaalde facturen&nbsp;<br>
        {{ Form::radio('facturen_selectie', '3') }} &nbsp;Onbetaalde facturen&nbsp;<br>
        {{ Form::radio('facturen_selectie', '4') }} &nbsp;Vervallen facturen&nbsp;
    </div>

    <div class="col-lg-2">
        <h5>Sorteervolgorde</h5>
        {{ Form::radio('facturen_sortering', '1', true) }} &nbsp;Factuurnummer&nbsp;<br>
        {{ Form::radio('facturen_sortering', '2') }} &nbsp;Naam&nbsp;<br>
        {{ Form::radio('facturen_sortering', '3') }} &nbsp;Datum factuur&nbsp;<br>
        {{ Form::radio('facturen_sortering', '4') }} &nbsp;Datum vervaldag&nbsp;<br>
        {{ Form::radio('facturen_sortering', '5') }} &nbsp;Bedrag
    </div>

</div>

<a href="#" onClick = "zoekFacturen();" class="btn btn-primary">Zoeken</a>
<hr>

