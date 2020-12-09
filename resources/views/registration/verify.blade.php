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
        <h2>Подтвердите адресс Email</h2>
        <p>Свежая ссылка была отправлена вам на почту</p>
      </div>
      <div class="form-sign-up">
        <form method="POST" action="{{ route('verification.resend') }}">
          @csrf
          <button class="btn btn-light-green w-100" type="submit">Отправить еще раз</button>
      </form>
      </div>

      </div>
    </div>
    </div>
   </main>

</div>
@endsection
