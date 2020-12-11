@extends('site.layouts.app')


@section('title')
    Регистрация
@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')
    <div class="primary-page">
        <div class="container">
            <div class="sign-up">
                <div class="sign-up-header">
                    <h2>Давайте создадим ваш аккаунт!</h2>
                    <p>Уже есть аккаунт? <a href="{{ route('login') }}">Вход</a></p>
                </div>
                <div class="form-sign-up">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="user_role" value="contractor">
                        <div class="input-group-icons">
                            <input class="form-control @error('username') is-invalid @enderror" type="text"
                                   placeholder="Email адрес или номер телефона"
                                   name="username" value="{{ old('username') }}" required
                                   autocomplete="text"><span class="prepend-icon"><i
                                    class="fas fa-at"></i></span>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group-icons">
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                   placeholder="Пароль"
                                   name="password" required autocomplete="new-password"><span
                                class="prepend-icon"><i class="fas fa-key"></i></span>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="input-group-icons">
                            <input class="form-control" type="password" placeholder="Повторите Пароль"
                                   name="password_confirmation" required
                                   autocomplete="new-password"><span class="prepend-icon"><i
                                    class="fas fa-lock"></i></span>
                        </div>
                        <button class="btn btn-light-green w-100" type="submit">Зарегистрировать
                        </button>
                    </form>

                </div>
                <div class="sign-up-other">
                    <div class="text-or">Или</div>
                    <div class="sign-in-social row row-md">
                        <div class="col-md-12"><a class="sign-in-btn sign-in-btn-google-p" href="{{ url('auth/google') }}"> <i class="fab fa-google-plus-g"></i>Вход через Google</a></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
