<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $userLastTransaction = Transaction::lasttransactions()->get();
        $users = User::all();
        return view('profile.list')->with(compact('users', 'userLastTransaction'));
    }
}
