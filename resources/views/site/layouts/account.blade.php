@extends('site.layouts.app')
@section('content')
    <div class="wrapper-admin">
        <div class="sidebar-admin">
            <div class="header-user">
                <div class="avatar"><a href="#"><img src="{{ $user->getImage() }}" alt="Image" width=""></a></div>
                <div class="info-user">
                    <h3>{{__("Статус:")}} <span style="color: #ff6b01">{{$user->getTypeUser()}}</span></h3>
                    <h3><a id="name_of_user" style="font-size: 14px"
                           href="{{ route('site.account.index') }}">{{ $user->getCommonTitle() }}</a></h3>
                    @auth
                        @if (auth()->user()->hasRole('customer'))
                            ({{$user->ownedTenders()->count()}})
                        @endif
                    @endauth
                </div>
            </div>
            <ul class="nav-sidebar-admin">
                <li @if ($accountPage == 'personal')   @endif><a
                            @if(Route::currentRouteName() == 'site.account.index') id="selected_a"
                            @endif href="{{ route('site.account.index') }}"><i
                                class="fas fa-user"></i> {{ __('Профиль') }}</a></li>
                @if ($user->hasRole('contractor'))
                    <li><a @if(Route::currentRouteName() == 'site.account.professional') id="selected_a"
                           @endif  href="{{ route('site.account.contractor.professional') }}"><i
                                    class="fas fa-suitcase"></i> {{ __('Проф. данные') }}</a></li>
                    <li><a @if(Route::currentRouteName()== 'site.account.tenders.requests') id="selected_a"
                           @endif href="{{ route('site.account.tenders.requests') }}"><i
                                    class="fas fa-file-alt"></i> {{ __('Мои заявки на задания') }}</a></li>
                    <li><a @if(Route::currentRouteName()== 'site.account.portfolio') id="selected_a"
                           @endif href="{{ route('site.account.portfolio') }}"><i
                                    class="far fa-images"></i>{{ __('Портфолио') }}</a></li>
                @endif
                @if ($user->hasRole('customer'))
                    <li><a @if(Route::currentRouteName()== 'site.account.tenders') id="selected_a"
                           @endif  href="{{ route('site.account.tenders') }}"><i
                                    class="fas fa-file-alt"></i> {{ __('Мои задания') }}</a></li>
                @endif
                <li><a @if(Route::currentRouteName()== 'site.account.chats') id="selected_a"
                       @endif href="{{ route('site.account.chats') }}"><i class="fas fa-comments"></i>{{ __('Чаты') }}
                    </a></li>
                <li><a @if(Route::currentRouteName() == 'site.account.comment') id="selected_a"
                       @endif href="{{ route('site.account.comment') }}"><i
                                class="fas fa-comment-alt"></i>{{ __('Оставить комментарий') }}</a></li>
            </ul>
        </div>
        <button class="toggle-sidebar-admin"><i class="fas fa-long-arrow-alt-right"></i></button>
        <div class="main-content-admin">
            <main class="main-content">
                @include('site.components.account_alerts')
                <div class="header-page">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="section-heading">
                                <h1 class="title-page">@yield('account.title.h1')</h1>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('account.content')
            </main>
        </div>
    </div>
@endsection
