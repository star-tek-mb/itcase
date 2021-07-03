<header class="header">

    <link rel="stylesheet" href="">

    <div id="remove_max_width" class="container">
        <div class="row justify-content-between align-items-center set_max_width">
            <div class="header__left d-flex align-items-center">
                <div class="container-media">
                    <a href="/" class="logo">
                        <img src="/resources/images/logo.png" alt="">
                    </a>
                    <div class="header-main-toggle">
                        <div class="toggle-button burger-btn btn-toggle">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <ul class="header__menu menu">
                    <li class="has-submenu">
                        <a @if(Route::currentRouteName()== 'site.tenders.index') id="active-header" @endif href="{{ route('site.tenders.index') }}">{{ __('Найти задания') }}</a>
                        <ul>
                            @foreach($parentCategories as $parent)
                                <li class="has-submenu">
                                    <a>{{ $parent->title }}</a>
                                    <ul>
                                        @foreach ($parent->categories as $category)
                                            <li>
                                                <a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{$category->title}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a  @if(Route::currentRouteName()== 'site.contractors.index') id="active-header" @endif href="{{ route('site.contractors.index') }}">{{ __('Найти исполнителя') }}</a>
                        <ul class="has-submenu">
                            @foreach($parentCategories as $parent)
                                <li class="has-submenu">
                                    <a>{{ $parent->title }}</a>
                                    <ul>
                                        @foreach ($parent->categories as $category)
                                            <li>
                                                <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>

                    <li class="color-primary add " id="change-color-a">
                        <a @if(Route::currentRouteName()== 'site.tenders.common.create') id="active-header" @endif  href="{{ route('site.tenders.common.create') }}">{{ __('Добавить задания') }}</a>
                    </li>
                </ul>
            </div>
            <div class="header__right d-flex align-items-center">
                {{--<div class="languages has-submenu">
                  <span>{{ Str::upper(config('app.locale')) }}</span>
                  <ul class="languages__menu">
                    @foreach (config('app.enabled_locales') as $locale)
                    <li>
                      <a href="{{ route(request()->route()->getName(), array_merge(['locale' => $locale], request()->route()->parameters())) }}">
                        {{ Str::upper($locale) }}
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>--}}

                @guest
                    <ul class="header__menu">
                        <li class="enter"><a href="{{ route('login') }}">{{ __('Вход') }}</a></li>
                        <li class="color-primary user"><a href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                        </li>
                    </ul>
                @endguest
                @auth
                    <ul class="header__menu">
                        <li class="color-primary user"><a
                                    href="{{ route('site.account.index') }}">{{ auth()->user()->first_name ? auth()->user()->name : __('Аккаунт') }}</a>
                        </li>
                        <li class="enter"><a href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">{{ __('Выйти') }}</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                @endauth

            </div>

        </div>
        <div class="back-color-header">
            <div class="row justify-content-between align-items-center set_max_width_second">
                <div class="header__left d-flex align-items-center">
                    <ul class="header__menu menu">
                        <li><a id="hover_add_text_underline" style="padding-top: 15px; padding-bottom: 15px;"
                               href="{{ route('site.page', 'about') }}">О
                                компании</a></li>
                    </ul>
                </div>
                <div class="header__right d-flex align-items-center">
                    <ul class="header__menu menu info-company">
                        <li>
                            <a style="padding-top: 15px; padding-bottom: 15px;" href="mailto:itcase.com@yandex.ru">
                                Почта: itcase.com@yandex.ru</a>
                        </li>
                        <li>
                            <a style="padding-top: 15px; padding-bottom: 15px;" href="tel:+77781887708"> Телефон для
                                справок: +77781887708</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</header>
@include('site.pages.drawer')