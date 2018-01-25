<?php

namespace App\Domains\Bills\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class FilterBill extends FormRequest
{

    public function messages()
    {
        return [
            'paiment_situation.in' => 'Parâmetros errados para o campo de situação de pagamento!',

            'expire_date_to.after_or_equal' => "A data do campo 'Vencimento até' deve ser depois da data do campo 'Vencimento de'!",

            'pay_date_from.before_or_equal' => "'Pagamento de'... não pode ser após a data de hoje!",
            'pay_date_to.before_or_equal' => "'Vencimento até'... não pode ser após a data de hoje!",
            'pay_date_to.after_or_equal' => "A data do campo 'Pagamento até' deve ser depois da data do campo 'Pagamento de'!"

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
        $carbon = new Carbon();

        $today = $carbon->today();
        return [
            'clients' => 'array',
            'bill_type' => 'Nullable|numeric',
            'paiment_situation' => 'Nullable|in:' . 'all,only_paid,only_not_paid',
            'bills_deleted' => 'required|Boolean',

            'expire_date_from' => 'Nullable|Date',
            'expire_date_to' => 'Nullable|Date|after_or_equal:' . Input::get('expire_date_from'),

            'pay_date_from' => 'Nullable|Date|before_or_equal:' . $today,
            'pay_date_to' => 'Nullable|Date|before_or_equal:' . $today . '|after_or_equal:' . Input::get('pay_date_from')
        ];
    }
}
