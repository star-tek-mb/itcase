@extends('site.layouts.app')


@section('title')
Востановление пароля
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

      <div class="form-sign-up">
        <form method="POST" action="{{ route('password.email') }}">
          @csrf
        <div class="input-group-icons">
          <input class="form-control @error('email') is-invalid @enderror" type="email" placeholder="Email адресс" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus><span class="prepend-icon"><i class="fas fa-at"></i></span>
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <button class="btn btn-light-green w-100" type="submit">Отправить ссылку на востановление пароля</button>
      </form>
      </div>

      </div>
    </div>
    </div>
   </main>

</div>
@endsection
