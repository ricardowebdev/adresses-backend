<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdressRequest extends FormRequest
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
            'cep' => 'required|string',
            'estado' => 'required|string',
            'cidade' => 'required|string',
            'bairro' => 'required|string',
            'endereco' => 'required|string',
            'numero' => 'required|string',
            'nome_contato' => 'required|string',
            'email_contato' => 'required|string',
            'telefone_contato' => 'required|string',
            'active' => 'boolean'
        ];
    }
}
