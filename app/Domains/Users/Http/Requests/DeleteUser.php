<?php

namespace App\Domains\Users\Http\Requests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteUser extends FormRequest
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
        return (Auth::user()->isAdmin && self::userIsNotBeingDeleted());
    }

    public function userIsNotBeingDeleted()
    {
        $items = $this->request->all();
        foreach ($items as $item) {
            if ($item['id'] == Auth::id()) {
                return false;
            }
        }
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
        ];
    }
}
