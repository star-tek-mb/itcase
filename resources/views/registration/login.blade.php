@extends('site.layouts.app')


@section('title')
    Войти
@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')
    <div class="primary-page">
        <div class="container">
            <div class="sign-up">
                <div class="sign-up-header">
                    <h2>Мы рады видеть вас снова!
                    </h2>
                    <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрируйтесь!</a></p>
                </div>
                <div class="form-sign-up">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @error('username')
                        <div class="text-error">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <div class="input-group-icons">
                            <input class="form-control @error('username') is-invalid @enderror" type="text"
                                   placeholder="Email адрес или номер телефона" name="username"
                                   value="{{ old('username') }}" autocomplete="username"><span
                                    class="prepend-icon"><i class="fas fa-at"></i></span>

                        </div>
                        @error('password')
                        <div class="text-error" >
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <div class="input-group-icons">
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                   placeholder="Пароль" name="password"
                                   autocomplete="current-password"><span class="prepend-icon"><i class="fas fa-key"></i></span>

                        </div>
                        <div class="text-password">
                            <div class="text-remeber">
                                <input type="checkbox" id="txt-remeber">
                                <label for="txt-remeber">Запомнить меня</label>
                            </div>
                            <a href="{{ route('password.request') }}">Забыли пароль?</a>
                        </div>
                        <button class="btn btn-light-green w-100" type="submit">Вход</button>
                    </form>
                </div>
                <div class="sign-up-other">
                    <div class="text-or">Или</div>
                    <div class="sign-in-social row row-md">
                        <div class="col-md-12"><a class="sign-in-btn sign-in-btn-google-p"
                                                  href="{{ url('auth/google') }}"> <i class="fab fa-google-plus-g"></i>Вход
                                через Google</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
