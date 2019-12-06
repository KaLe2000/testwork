<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransaction extends FormRequest
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
        $userFrom = User::findOrFail(request('user_id')); // Замена авторизованного пользователя

        $users_between = User::whereNotIn('id',[request('user_id')])->pluck('id')->min();
        $users_between .= ','.User::whereNotIn('id',[request('user_id')])->pluck('id')->max();

        return [
            'user_id' => ['required', 'numeric'],
            'sum' => ['required', 'numeric',
                'between:0.99,'.$userFrom->plannedBalance()
            ],
            'transaction_at' => ['required', 'date',
                'after_or_equal:'.date('d.m.Y H:i')
            ],
            'user_to_id' => ['required', 'numeric',
                'between:'.$users_between
            ]
        ];
    }

    public function messages()
    {
        return [
            'sum.between' => 'Недостаточно средств',
            'transaction_at.after_or_equal' => 'Выберите другую дату',
            'user_to_id.between' => 'Отправьте деньги кому-нибудь ещё'
        ];
    }
}
