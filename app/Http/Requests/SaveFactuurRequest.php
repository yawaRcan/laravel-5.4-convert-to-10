<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveFactuurRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'factuurnummer'=>'required|unique:facturen',
          //  'factuurnummer'=> ['required', Rule::unique('facturen')->ignore($this->factuurnummer)],
            'datum'=>'required|date',
            'vervaldagtype_id'=>'required',
            'klant_id'=>'required',
            'bedrag'=>'required|numeric',
        //    'code'=>'required',
            'merk_id'=>'required',
            'type'=>'required',
            'makelaar_id'=>'required',
            'maatschappij_id'=>'required',
        ];
    }
}