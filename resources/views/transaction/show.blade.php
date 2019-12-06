@extends('index')

@section('content')
    <div class="row my-4">
        <div class="row mb-4 mt-4">
            <div class="media">
                <img src="/images/profile.png" class="mr-3" alt="..." width="64">
                <div class="media-body">
                    <h5 class="mt-0">{{ $users['auth']->name }}</h5>
                    Баланс: {{ $users['auth']->balance }}p. (<b>{{ $users['auth']->plannedBalance() }}p.</b>)
                </div>
            </div>
        </div>
        <div class="row">
            <div class="jumbotron mr-4">
                <h3 class="display-6">Переводы</h3>
                <p class="lead">Перевод денежных средств другому пользователю</p>
                <hr class="my-4">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ action('TransactionController@store') }}">
                    @csrf
                    <input type="hidden" value="{{ $users['auth']->id }}" name="user_id">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Сумма перевода</label>
                        <input
                            type="text"
                            name="sum"
                            class="form-control @error('sum') is-invalid @enderror"
                            id="exampleFormControlInput1"
                            placeholder="999.9 p."
                            value="{{ old('sum') }}">
                        @error('sum')
                        <div class="invalid-feedback">{{ $errors->first('sum') }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="datetime">Время перевода</label>
                        <input
                            type="datetime-local"
                            name="transaction_at"
                            class="form-control @error('transaction_at') is-invalid @enderror"
                            id="datetime"
                            value="{{ old('transaction_at') }}">
                        @error('transaction_at')
                        <div class="invalid-feedback">{{ $errors->first('transaction_at') }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Получатель денежных средств</label>
                        <select name="user_to_id" class="form-control @error('user_to_id') is-invalid @enderror" id="exampleFormControlSelect1">
                            <option value="0" selected>Выберите пользователя</option>
                            @foreach($users['list'] as $toUser)
                                <option value="{{ $toUser->id }}">{{ $toUser->name }}</option>
                            @endforeach
                        </select>
                        @error('user_to_id')
                        <div class="invalid-feedback">{{ $errors->first('user_to_id') }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
            </div>

            <div class="jumbotron">
                <h3 class="display-6">Отложенные переводы</h3>
                <p class="lead">Переводы запланированные на будущее</p>
                <hr class="my-4">
                <ul class="list-group list-group-flush">
                    @foreach($transactions as $transaction)
                        <li class="list-group-item">Перевод для <i>{{ $transaction->user_to->name }}</i>;
                            сумма: <b>{{ $transaction->sum }} p.</b> </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection
