<div class="row">
    <table>
        <tr>
            <td>
                {{ Form::label ('criterium', 'Selectie criteria:&nbsp;', ['class'=>'label-control']) }}
            </td>
            <td>{{ Form::radio('criterium', '1') }} &nbsp;Per Makelaar&nbsp;
                {{ Form::radio('criterium', '2') }} &nbsp;Per Verzekeraar&nbsp;
                {{ Form::radio('criterium', '3', true) }} &nbsp;Per Makelaar en verzekeraar&nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                {{ Form::label ('startjaar', 'Start jaar:&nbsp;', ['class'=>'label-control']) }}
            </td>
            <td>
                {{ Form::text('startjaar', null, ['class'=>'form-control']) }}
            </td>
            <td>
                {{ Form::label ('eindjaar', 'Eind jaar:&nbsp;', ['class'=>'label-control']) }}
            </td>
            <td>
                {{ Form::text('eindjaar', null, ['class'=>'form-control']) }}
            </td>
            <td>
                <a href="#" onClick = "berekenen()" class="btn btn-primary">Bereken</a>
            </td>
        </tr>
    </table>
</div>

<hr>
