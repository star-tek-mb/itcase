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
        {{--console.log(atob("{{$url}}"));--}}
        function booom() {
            console.log("{{$url}}");
            window.location.href = atob("{{$url}}");
        }

        setTimeout(booom, 1000);
    </script>
@endsection
