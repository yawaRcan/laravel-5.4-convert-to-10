<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveKlantRequest extends FormRequest
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
            'naam' => 'required',
            'straat' => 'required',
            'postcode' => 'required',
            'telefoon' => 'required_if:email,',
            'email' => 'required_if:telefoon,',
            'btwnr' => 'required_if:btw,1'
        ];
    }
}
