<?php

namespace App\Domains\BillTypes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBillType extends FormRequest
{ 

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório!',
            'unique' => 'Tipo já existe!'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:bill_types',
            'default_price' => 'nullable|numeric'
        ];
    }
}
