<?php

namespace App\Domains\Bills\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBill extends FormRequest
{

    public function messages()
    {
        return [
            'clients.required' => 'Selecione os clientes para cadastrar as contas!',
            'type.required' => 'Selecione o tipo das contas!',
            'price.required' => 'Digite um preço para as contas!',
            'price.numeric' => 'sa porra precisa ser numerico'
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
            'clients' => 'required|array|min:1',
            'type' => 'required|numeric',
            'price' => 'required|numeric',
        ];
    }
}
