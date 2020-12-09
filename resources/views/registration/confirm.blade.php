@extends('site.layouts.app')


@section('title')
Войти
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
        <h2>Пожалуйста, подтвердите ваш пароль, прежде чем продолжить.</h2>

      </div>
      <div class="form-sign-up">
        <form method="POST" action="{{ route('password.confirm') }}">
          @csrf
        <div class="input-group-icons">
            <input id="password" type="password" placeholder="Пароль" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"><span class="prepend-icon"><i class="fas fa-at"></i></span>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="text-password">
          <a href="{{ route('password.request') }}">Забыли пароль?</a>
        </div>

        <button class="btn btn-light-green w-100" type="submit">Подтвердить пароль</button>
      </form>
      </div>

      </div>
    </div>
    </div>
   </main>

</div>
@endsection
