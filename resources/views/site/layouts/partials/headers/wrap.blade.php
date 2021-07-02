@extends('site.layouts.partials.mobile_main')
@section('user')
    @guest
        <li><a href="{{ route('login') }}"><i class="fas fa-sign-out-alt"></i>{{ __('Войти') }}</a></li>
        <li><a href="{{ route('register') }}"><i class="fas fa-registered"></i>{{ __('Зарегистрироваться') }}</a></li>
    @elseif(auth()->user())
        @if (auth()->user()->hasRole('customer'))
            <li><a href="{{ route('site.tenders.common.create') }}"><i class="fas fa-plus-circle"></i>
                    {{ __('Добавить заказ') }}</a></li>@endif
        <li>
            <a href="#" id="navBarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                @if(auth()->user()->getImage())
                    <span class="user-photo">
                            <img src="{{ auth()->user()->getImage() }}" alt="" width="50px">
                        </span>
                @endif
                @if(auth()->user() &&auth()->user()->name)
                    {{ auth()->user()->name }}
                @elseif(auth()->user()->email)
                    {{ auth()->user()->email }}
                @else
                    {{ auth()->user()->phone_number }}
                @endif
                <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                <a href="{{ route('site.account.index') }}" class="dropdown-item"><i
                            class="fas fa-user"></i> {{ __('Личный кабинет') }}</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Выйти') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
@endsection