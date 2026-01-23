<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EnderecoListRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'cep'        => 'nullable|max:10',
            'uf'         => 'nullable|max:30|min:2',
            'cidade'     => "nullable|max:50",
            'bairro'     => "nullable|max:50",
            'logradouro' => 'nullable|max:100',
            'numero'     => "nullable|max:10",
            'nome'       => 'nullable|max:100',
            'telefone'   => "nullable|max:15",
            'email'      => "nullable|max:150"
        ];
    }

    public function messages()
    {
        return [
            'cep.max'        => trans('validation.max', ['attribute' => 'cep', 'max' => '150']),
            'uf.max'         => trans('validation.max', ['attribute' => 'uf', 'max' => '10']),
            'uf.min'         => trans('validation.min', ['attribute' => 'uf', 'min' => '2']),
            'cidade.max'     => trans('validation.max', ['attribute' => 'cidade', 'max' => '50']),
            'bairro.max'     => trans('validation.max', ['attribute' => 'bairro', 'max' => '50']),
            'logradouro.max' => trans('validation.max', ['attribute' => 'logradouro', 'max' => '100']),
            'numero.max'     => trans('validation.max', ['attribute' => 'numero', 'max' => '10']),
            'nome.max'       => trans('validation.max', ['attribute' => 'nome', 'max' => '100']),
            'telefone.max'   => trans('validation.max', ['attribute' => 'telefone', 'max' => '15']),
            'email.email'    => trans('validation.email', ['attribute' => 'email']),
            'email.max'      => trans('validation.max', ['attribute' => 'email', 'max' => '150']),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => trans('forms.invalid_requuest'),
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }    
}
