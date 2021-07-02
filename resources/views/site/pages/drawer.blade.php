{{--<nav class="top-menu">--}}
{{--    <div class="top-menu__close">--}}
{{--          <span>--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1"--}}
{{--                 x="0px" y="0px" viewBox="0 0 212.982 212.982" style="enable-background:new 0 0 212.982 212.982;"--}}
{{--                 xml:space="preserve">--}}
{{--              <g id="Close">--}}
{{--                <path style="fill-rule:evenodd;clip-rule:evenodd;"--}}
{{--                      d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312   c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312   l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937   c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/>--}}
{{--              </g>--}}
{{--            </svg>--}}
{{--          </span>--}}
{{--    </div>--}}
{{--    <ul class="menu-default remove_burger">--}}
{{--        <li><a id="hover_add_text_underline" style="padding-top: 15px; padding-bottom: 15px;"--}}
{{--               href="{{ route('site.page', 'about') }}">О--}}
{{--                компании</a></li>--}}

{{--        <li class="has-submenu">--}}
{{--            <a href="{{ route('site.tenders.index') }}">{{ __('Найти задания') }}</a>--}}
{{--        </li>--}}

{{--        <li class="has-submenu">--}}
{{--            <a href="{{ route('site.contractors.index') }}">{{ __('Найти исполнителя') }}</a>--}}
{{--        <li class="color-primary add">--}}
{{--            <a href="{{ route('site.tenders.common.create') }}">{{ __('Добавить задания') }}</a>--}}
{{--        </li>--}}
{{--        @guest--}}

{{--            <li class="enter"><a href="{{ route('login') }}">{{ __('Вход') }}</a></li>--}}
{{--            <li class="color-primary user"><a href="{{ route('register') }}">{{ __('Регистрация') }}</a>--}}
{{--            </li>--}}
{{--        @endguest--}}
{{--        @auth--}}

{{--            <li class="color-primary user icon-header"><a--}}
{{--                        href="{{ route('site.account.index') }}">{{ auth()->user()->first_name ? auth()->user()->name : __('Аккаунт') }}</a>--}}
{{--            </li>--}}
{{--            <li class="enter icon-header"><a href="{{ route('logout') }}" onclick="event.preventDefault();--}}
{{--              document.getElementById('logout-form').submit();">{{ __('Выйти') }}</a></li>--}}
{{--            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                @csrf--}}
{{--            </form>--}}
{{--        @endauth--}}
{{--        <li>--}}
{{--            <a style="padding-top: 15px; padding-bottom: 15px;" href="mailto:itcase.com@yandex.ru">--}}
{{--                Почта: itcase.com@yandex.ru</a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <a style="padding-top: 15px; padding-bottom: 15px;" href="tel:+77781887708"> Телефон для--}}
{{--                справок: +77781887708</a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</nav>--}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<link rel="stylesheet" href="/css/style.css"/>

@include('site.layouts.partials.mobile_main')


