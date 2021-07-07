@extends('site.layouts.account')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('title', 'Оплата за профиль')

@section('account.title.h1', 'Оплата')

@section('account.content')
    <p>Вы ещё не заплатили за свой акаунт и через 10 секунд будете перенапавлены на оплату! Спасибо за ваше
        понимание!</p>
@endsection

@section('js')
    <script>
        function booom() {
            window.location.href = {{$url}};
        }

        setTimeout(booom, 4000);
    </script>
@endsection
