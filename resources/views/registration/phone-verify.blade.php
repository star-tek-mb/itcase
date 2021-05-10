@extends('site.layouts.app')


@section('title')
Подтверждение
@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')
<div class="wrapper" id="wrapper">


  <main class="main-content">
    <div class="primary-page">
    <div class="container">
      <div class="sign-up">
      <div class="sign-up-header">
        <h2>Подтвердите номер телефона для дальнейшего использования ресурса</h2>
        <p>Код с подтверждением был отправлен на ваш номер телефона</p>
      </div>
      <div class="form-sign-up">
        <form method="POST" action="{{ route('phone.verification.verify') }}">
          @csrf
          <div class="row no-gutters">
            <div class="col input-group-icons">
                <input class="form-control @error('code') is-invalid @enderror" type="text" placeholder="Код с подтверждением" name="code">
                <span class="prepend-icon"><i class="fas fa-lock"></i></span>
                @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-auto">
                <button class="btn btn-light-green w-100" type="submit">Проверить</button>
            </div>
          </div>
        </form>
        <form method="POST" action="{{ route('phone.verification.resend') }}">
          @csrf
          <button class="btn btn-light-green w-100" type="submit">Отправить еще раз</button>
        </form>
        <div class="text-center mt-2">
          Указали не тот номер телефона? Поменяйте его в своем <a href="/account">аккаунте</a>
        </div>
      </div>

      </div>
    </div>
    </div>
   </main>

</div>
@endsection
