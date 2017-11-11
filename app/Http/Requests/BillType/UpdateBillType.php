<?php

namespace App\Http\Requests\BillType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBillType extends FormRequest
{

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório!',
            'email' => 'O email deve ter um formato válido!',
            'min' => 'A senha deve conter no mínimo :min caracteres!',
            'unique' => 'Email já foi utilizado!'
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->route('user')->id,
            'password' => 'required|min:6',
        ];
    }
}
