@extends('site.layouts.app')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('title', 'Подтвердите свой email')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Подтвердите свой email-адрес</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            На ваш электронный адрес была отправлена новая проверочная ссылка.
                        </div>
                    @endif

                    Прежде чем продолжить, пожалуйста, проверьте свою электронную почту на наличие проверочной ссылки. Если вы не получили это письмо, <a href="{{ route('verification.resend') }}">нажмите здесь, чтобы запросить другое</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
