<?php

namespace App\Domains\Bills\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PayBill extends FormRequest
{

    public function messages()
    {
        return [
            'paymentDate.required' => 'É preciso selecionar uma data!',
            'paymentDate.before_or_equal' => 'A data não pode ser depois de hoje!'
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
            'paymentDate' => 'required|date|before_or_equal:' . date("Y-m-d")
        ];
    }
}
