@extends('index')

@section('content')
    <div class="row text-center my-4">
        <ul class="list-group list-group-flush">
            @foreach($userLastTransaction as $transaction)
                <li class="list-group-item">
                    Последний перевод от <b>{{ $transaction->user->name }}</b>
                    суммой <b>{{ $transaction->sum }}p.</b>
                     запланирован {{ $transaction->transaction_at->diffForHumans() }}
                </li>
            @endforeach
        </ul>
    </div>

    <div class="row text-center my-4">
    @foreach($users as $user)

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        {{ $user->name }}
                    </div>
                    <img class="card-img" src="/images/profile.png" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Баланс: {{ $user->balance }} p.</h5>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('transaction', $user) }}" class="btn btn-primary">Войти</a>
                    </div>
                </div>
            </div>

    @endforeach
    </div>
    <!-- /.row -->
@endsection
