<?php

namespace ConfiSis\Http\Requests;

use ConfiSis\Http\Requests\Request;

class PersonaFormRequest extends Request
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
          'nombre_apellido'=>'|max:100',
            'dni'=>'|max:20',
            'domicilio'=>'max:70',
            'telefono'=>'max:15'
        ];
    }
}
