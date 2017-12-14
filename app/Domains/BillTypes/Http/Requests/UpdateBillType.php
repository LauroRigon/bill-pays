<?php

namespace App\Domains\BillTypes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBillType extends FormRequest
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
    //'required|email|unique:users,email,'.$this->route('user')->id
    public function rules()
    {
        return [
            //'name' => 'required',
            'name' => [
                'required',
                Rule::unique('bill_types')->ignore($this->route()->parameter('bill_type'))
            ],
        ];
    }
}
