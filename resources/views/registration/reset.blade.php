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
        <h2>Сброс пароля</h2>

      </div>
      <div class="form-sign-up">
        <form method="POST" action="{{ route('password.update') }}">
          @csrf
        <div class="input-group-icons">
          <input type="email" placeholder="Email адресс" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus><span class="prepend-icon"><i class="fas fa-at"></i></span>
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="input-group-icons">
          <input id="password" type="password" placeholder="Пароль" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"><span class="prepend-icon"><i class="fas fa-key"></i></span>
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="input-group-icons">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"><span class="prepend-icon"><i class="fas fa-key"></i></span>
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <button class="btn btn-light-green w-100" type="submit">Сбросить пароль</button>
      </form>
      </div>

      </div>
    </div>
    </div>
   </main>

</div>
@endsection
