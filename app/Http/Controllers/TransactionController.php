<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use App\Http\Requests\StoreTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('transaction_at', 'desc')
            ->get();

        $users = [
            'auth' => $user, // Замена авторизации
            'list' => User::whereNotIn('id', $user)->get()
        ];

        return view('transaction.show')->with(compact('users', 'transactions'));
    }

    /**
     * @param StoreTransaction $request
     * @return mixed
     */
    public function store(StoreTransaction $request)
    {
        $validRequest = $request->validated();

        //Из-за мутации в модели - при создании записи была ошибка. Не успел разобраться(
        $validRequest['transaction_at'] = Carbon::make($validRequest['transaction_at']);

        Transaction::create($validRequest);

        return redirect()->back()->withSuccess('Перевод успешно запланирован');
    }
}
