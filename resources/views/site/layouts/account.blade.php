@extends('site.layouts.app')
@section('content')
    <div class="wrapper-admin">
        <div class="sidebar-admin">
            <div class="header-user">
                <div class="avatar"><a href="#"><img src="{{ $user->getImage() }}" alt="Image"></a></div>
                <div class="info-user">
                    <h3><a href="{{ route('site.account.index') }}">{{ $user->getCommonTitle() }}</a></h3>
                </div>
            </div>
            <ul class="nav-sidebar-admin">
                <li @if ($accountPage == 'personal') class="active" @endif><a href="{{ route('site.account.index') }}"><i class="fas fa-user"></i> Профиль</a></li>
                @if ($user->hasRole('contractor'))
                    <li><a href="{{ route('site.account.contractor.professional') }}"><i class="fas fa-suitcase"></i> Проф. данные</a></li>
                    <li><a href="{{ route('site.account.tenders') }}"><i class="fas fa-file-alt"></i> Мои конкурсы</a></li>
                    <li><a href="{{ route('site.account.portfolio') }}"><i class="far fa-images"></i>Портфолио</a></li>
                @endif
                @if ($user->hasRole('customer'))
                    <li><a href="{{ route('site.account.tenders') }}"><i class="fas fa-file-alt"></i> Мои конкурсы</a></li>
                @endif
                <li><a href="{{ route('site.account.chats') }}"><i class="fas fa-comments"></i>Чаты</a></li>
                <li><a href="{{ route('site.account.comment') }}"><i class="fas fa-comment-alt"></i>Оставить комментарий</a></li>
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
