<header class="header-site" id="header">
    <div class="container-fluid">
        <div class="header-wrap">
            <div class="header-left">
                <div class="header-main-toggle">
                    <button class="btn-toggle" type="button" data-toggle="offcanvas"><i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="header-logo"><a class="qdesk-logo" href="{{ route('site.catalog.index') }}" title="VID"><img
                            class="qdesk-logo-white"
                            src="{{ asset('front/images/VID.png') }}"
                            alt="VID"><img
                            class="qdesk-logo-black" src="{{ asset('front/images/VID-black.png') }}" alt="VID"></a>
                </div>
                <div class="navigation" id="navigation">
                    <ul class="main-menu">
                        <li class="active"><a href="/">{{ __('Главная') }}</a></li>
                        <li class="header-menu-item"><a href="{{ route('site.tenders.index') }}">{{ __('Конкурсы') }} <i
                                    class="fas fa-caret-down"></i></a>
                            <ul class="sub-menu">
                                @foreach($needs as $need)
                                    <li class="menu-item dropdown-submenu">
                                        <a class="d-flex justify-content-between align-items-center">{{ $need->ru_title }}
                                            <i class="fas fa-caret-right ml-2 mr-3"></i></a>
                                        <ul class="sub-menu">
                                            @foreach($need->menuItems as $item)
                                                <li class="menu-item dropdown-submenu">
                                                    <a href="{{ route('site.tenders.category', $item->ru_slug) }}"
                                                       class="d-flex justify-content-between align-items-center">{{ $item->ru_title }}
                                                        <i class="fas fa-caret-right ml-2 mr-3"></i></a>
                                                    <ul class="sub-menu">
                                                        @foreach($item->categories as $category)
                                                            <li>
                                                                <a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{ $category->getTitle() }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="header-menu-item"><a href="{{ route('site.contractors.index') }}">{{ __('Исполнители') }} <i
                                    class="fas fa-caret-down"></i></a>
                            <ul class="sub-menu">
                                @foreach($needs as $need)
                                    <li class="menu-item dropdown-submenu">
                                        <a class="d-flex justify-content-between align-items-center">{{ $need->ru_title }}
                                            <i class="fas fa-caret-right ml-2 mr-3"></i></a>
                                        <ul class="sub-menu">
                                            @foreach($need->menuItems as $item)
                                                <li class="menu-item dropdown-submenu">
                                                    <a href="{{ route('site.catalog.main', $item->ru_slug) }}"
                                                       class="d-flex justify-content-between align-items-center">{{ $item->ru_title }}
                                                        <i class="fas fa-caret-right ml-2 mr-3"></i></a>
                                                    <ul class="sub-menu">
                                                        @foreach($item->categories as $category)
                                                            <li>
                                                                <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->getTitle() }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header-right-mobile d-lg-none">
                <ul>
                    @guest
                        <li><a href="{{ route('site.tenders.common.create') }}"><i class="fas fa-plus-circle"></i>
                               {{ __('Добавить заказ') }}</a></li>
                    @else
                        @if (auth()->user()->hasRole('customer'))
                            <li><a href="{{ route('site.tenders.common.create') }}"><i class="fas fa-plus-circle"></i>
                            {{ __('Добавить заказ') }}</a></li>@endif
                        <li>
                            <div class="notification-item">
                                <a role="button" id="page-header-notifications" class="notification-button"
                                   data-toggle="dropdown" class="" aria-haspopup="true">
                                    <i class="far fa-bell"></i>
                                    @if (auth()->user()->unreadNotifications->count() > 0)<span
                                        class="numeric">{{ auth()->user()->unreadNotifications->count() }}</span> @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right notifications-dropdown"
                                     aria-labelledby="page-header-notifications">
                                    <h5 class="h6 text-center py-10 mb-0 border-bottom text-uppercase">{{ __('Оповещения') }}</h5>
                                    <ul>
                                        @foreach(auth()->user()->unreadNotifications as $notification)
                                            <li class="ml-0">
                                                @if ($notification->type == 'App\Notifications\NewRequest')
                                                    <a href="{{ route('site.account.tenders.candidates', $notification->data['tenderSlug']) }}">
                                                        <div class="icon">
                                                            <small><i class="fas fa-info text-primary"></i></small>
                                                        </div>
                                                        <div class="notification-item-body">
                                                            <p class="mb-0">{{ __('Новая заявка на участие в конкурсе') }} <span
                                                                    class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                                от исполнителя <span
                                                                    class="font-weight-bold">{{ $notification->data['contractorName'] }}</span>
                                                            </p>
                                                            <small
                                                                class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\InviteRequest')
                                                    <a href="{{ route('site.tenders.category', $notification->data['tenderSlug']) }}">
                                                        <div class="icon">
                                                            <small><i class="fas fa-info text-primary"></i></small>
                                                        </div>
                                                        <div class="notification-item-body">
                                                            <p class="mb-0">{{ __('Заказчик') }} <span
                                                                    class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                                {{ __('приглашает вас принять участие в конкурсе') }} <span
                                                                    class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                                {{ __('и добавил вас в список участников') }}</p>
                                                            <small
                                                                class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\RequestAction')
                                                    <a href="{{ route('site.tenders.category', $notification->data['tenderSlug']) }}">
                                                        <div class="icon">
                                                            @if ($notification->data['type'] === 'rejected')
                                                                <small><i class="fas fa-times text-danger"></i></small>
                                                            @elseif ($notification->data['type'] === 'accepted')
                                                                <small><i class="fas fa-check text-success"></i></small>
                                                            @endif
                                                        </div>
                                                        <div class="notification-item-body">
                                                            @if ($notification->data['type'] === 'rejected')
                                                                <p class="mb-0">Заказчик <span
                                                                        class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                                    {{ __('отклонил вашу заявку на участие в конкурсе') }} <span
                                                                        class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                                </p>
                                                            @elseif ($notification->data['type'] === 'accepted')
                                                                <p class="mb-0">{{ __('Заказчик') }}<span
                                                                        class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                                    {{ __('выбрал Вас в качестве исполнителя на конкурс') }} <span
                                                                        class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                                </p>
                                                            @endif
                                                            <small
                                                                class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\TenderPublished')
                                                    <a href="{{ route('site.tenders.category', $notification->data['tender']['slug']) }}">
                                                        <div class="icon">
                                                            <small><i class="fas fa-info text-primary"></i></small>
                                                        </div>
                                                        <div class="notification-item-body">
                                                            <p class="mb-0">
                                                                {{ __('Ваш конкурс') }} <span class="font-weight-bold">{{ $notification->data['tender']['title'] }}</span> {{ __('опубликован!') }}
                                                            </p>
                                                            <small class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
            <div class="header-right">
                <ul>

                    @guest
                        <li><a href="{{ route('site.tenders.common.create') }}"><i class="fas fa-plus-circle"></i>
                                {{ __('Добавить заказ') }}</a></li>
                        <li>
                            <a href="https://t.me/gde_podeshevle"><i class="fab fa-telegram" style="font-size:25px"></i></a>
                            <a href="https://www.instagram.com/vid.market/"><i class="fab fa-instagram pl-3"
                                                                               style="font-size:25px"></i></a>
                        </li>
                        <li><a href="{{ route('login') }}"><i class="fas fa-sign-out-alt"></i>
                                {{ __('Вход') }}</a><span> / </span><a
                                href="{{ route('register') }}">{{ __('Регистрация') }}</a></li>
                    @else
                        @if (auth()->user()->hasRole('customer'))
                            <li><a href="{{ route('site.tenders.common.create') }}"><i class="fas fa-plus-circle"></i>
                            {{ __('Добавить заказ') }}</a></li>@endif
                        <li>
                            <div class="notification-item">
                                <a role="button" id="page-header-notifications" class="notification-button"
                                   data-toggle="dropdown" class="" aria-haspopup="true">
                                    <i class="far fa-bell"></i>
                                    @if (auth()->user()->unreadNotifications->count() > 0)<span
                                        class="numeric">{{ auth()->user()->unreadNotifications->count() }}</span> @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right notifications-dropdown"
                                     aria-labelledby="page-header-notifications">
                                    <h5 class="h6 text-center py-10 mb-0 border-bottom text-uppercase">{{ __('Оповещения') }}</h5>
                                    <ul>
                                        @foreach(auth()->user()->unreadNotifications as $notification)
                                            <li class="ml-0">
                                                @if ($notification->type == 'App\Notifications\NewRequest')
                                                    <a href="{{ route('site.account.tenders.candidates', $notification->data['tenderSlug']) }}">
                                                        <div class="icon">
                                                            <small><i class="fas fa-info text-primary"></i></small>
                                                        </div>
                                                        <div class="notification-item-body">
                                                            <p class="mb-0">{{ __('Новая заявка на участие в конкурсе') }} <span
                                                                    class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                                от исполнителя <span
                                                                    class="font-weight-bold">{{ $notification->data['contractorName'] }}</span>
                                                            </p>
                                                            <small
                                                                class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\InviteRequest')
                                                    <a href="{{ route('site.tenders.category', $notification->data['tenderSlug']) }}">
                                                        <div class="icon">
                                                            <small><i class="fas fa-info text-primary"></i></small>
                                                        </div>
                                                        <div class="notification-item-body">
                                                            <p class="mb-0">{{ __('Заказчик') }}<span
                                                                    class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                                {{ __('приглашает вас принять участие в конкурсе') }} <span
                                                                    class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                                {{ __('и добавил вас в список участников') }}</p>
                                                            <small
                                                                class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\RequestAction')
                                                    <a href="{{ route('site.tenders.category', $notification->data['tenderSlug']) }}">
                                                        <div class="icon">
                                                            @if ($notification->data['type'] === 'rejected')
                                                                <small><i class="fas fa-times text-danger"></i></small>
                                                            @elseif ($notification->data['type'] === 'accepted')
                                                                <small><i class="fas fa-check text-success"></i></small>
                                                            @endif
                                                        </div>
                                                        <div class="notification-item-body">
                                                            @if ($notification->data['type'] === 'rejected')
                                                                <p class="mb-0">{{ __('Заказчик') }} <span
                                                                        class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                                    {{ __('отклонил вашу заявку на участие в конкурсе') }} <span
                                                                        class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                                </p>
                                                            @elseif ($notification->data['type'] === 'accepted')
                                                                <p class="mb-0">{{ __('Заказчик') }} <span
                                                                        class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                                    {{ __('выбрал Вас в качестве исполнителя на конкурс') }} <span
                                                                        class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                                </p>
                                                            @endif
                                                            <small
                                                                class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($notification->type == 'App\Notifications\TenderPublished')
                                                    <a href="{{ route('site.tenders.category', $notification->data['tender']['slug']) }}">
                                                        <div class="icon">
                                                            <small><i class="fas fa-info text-primary"></i></small>
                                                        </div>
                                                        <div class="notification-item-body">
                                                            <p class="mb-0">
                                                                {{ __('Ваш конкурс') }} <span class="font-weight-bold">{{ $notification->data['tender']['title'] }}</span> {{ __('опубликован!') }}
                                                            </p>
                                                            <small class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="https://t.me/gde_podeshevle"><i class="fab fa-telegram" style="font-size:25px"></i></a>
                            <a href="https://www.instagram.com/vid.market/"><i class="fab fa-instagram pl-3"
                                                                               style="font-size:25px"></i></a>
                        </li>
                        @auth
                            @if (auth()->user()->hasRole('customer'))
                        <li> ({{auth()->user()->ownedTenders()->count()}})</li>
                            @endif
                        @endauth
                        <li>
                            <a href="#" id="navBarDropdown" class="nav-link dropdown-toggle" role="button"
                               data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                @if(auth()->user()->getImage())
                                    <span class="user-photo">
                                        <img src="{{ auth()->user()->getImage() }}" alt="" width="50px">
                                    </span>
                                @endif
                                @if(auth()->user()->name)
                                    {{ auth()->user()->name }}
                                @elseif(auth()->user()->email)
                                    {{ auth()->user()->email }}
                                @else
                                    {{ auth()->user()->phone_number }}
                                @endif
                                <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                <a href="{{ route('site.account.index') }}" class="dropdown-item user-dropdown-item"><i
                                        class="fas fa-user"></i> {{ __('Личный кабинет') }}</a>
                                <a class="dropdown-item user-dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('Выйти') }}
                                </a>
                            </div>
                        </li>
                    @endguest
                        <ul class="main-menu" style="display: inline-block;">
                            <li class="header-menu-item">
                                <a href="#" class="d-flex justify-content-between align-items-center">{{ __('Язык') }}<i class="fas fa-caret-down ml-2 mr-3"></i></a>
                                <ul class="sub-menu" style="left: -100%;">
                                    @foreach(config('app.enabled_locales') as $locale)
                                        <li class="menu-item" style="display: block; margin-left: 15px;">
                                            <a href="{{ route(request()->route()->getName(), array_merge(['locale' => $locale], request()->route()->parameters())) }}" class="d-flex justify-content-between align-items-center">
                                            {{ __($locale) }}
                                        </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>

                </ul>
            </div>
        </div>
    </div>
</header>

<div class="menu-mobile-wrap">
    <div class="menu-mobile-content">
        <div class="menu-mobile-profile">
            <div class="line">
                <button class="button btn-menu-close" type="button"></button>
            </div>
            <ul class="user-profile">

                @guest
                    <li><a href="{{ route('login') }}"><i class="fas fa-sign-out-alt"></i>{{ __('Войти') }}</a></li>
                    <li><a href="{{ route('register') }}"><i class="fas fa-registered"></i>{{ __('Зарегистрироваться') }}</a></li>
                @else
                    @if (auth()->user()->hasRole('customer'))
                        <li><a href="{{ route('site.tenders.common.create') }}"><i class="fas fa-plus-circle"></i>
                                {{ __('Добавить заказ') }}</a></li>@endif
                    <li>
                        <a href="#" id="navBarDropdown" class="nav-link dropdown-toggle" role="button"
                           data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            @if(auth()->user()->getImage())
                                <span class="user-photo">
                                    <img src="{{ auth()->user()->getImage() }}" alt="" width="50px">
                                </span>
                            @endif
                            @if(auth()->user()->name)
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
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Выйти') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <li>
                    <a href="https://t.me/gde_podeshevle"><i class="fab fa-telegram" style="font-size:25px"></i></a>
                    <a href="https://www.instagram.com/vid.market/"><i class="fab fa-instagram pl-3"
                                                                       style="font-size:25px"></i></a>
                </li>
            </ul>
        </div>
        <div class="menu-mobile">
            <ul class="main-menu-mobile">

                <li>
                    <div class="row">
                        <div class="col-9"><a class="style_a stretched-link" href="{{ route('site.tenders.index') }}">{{ __('Конкурсы') }}</a>
                        </div>
                        <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#sub-1"
                                              aria-expanded="false" aria-controls="sub-1" style="color:#383838;"><i
                                    class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                    </div>
                    <div class="collapse" id="sub-1">
                        @foreach($needs as $need)
                            <ul class="main-menu-mobile">

                                <li>

                                <li><a data-toggle="collapse" href="#a{{ $need->id }}" aria-expanded="false"
                                       aria-controls="a{{ $need->id }}">{{ $need->ru_title }}</a>
                                    <div class="collapse" id="a{{ $need->id }}">
                                        <ul class="main-menu-mobile">
                                            @foreach($need->menuItems as $item)
                                                <li>
                                                    <div class="row">
                                                        <div class="col-9"><a class="style_a stretched-link"
                                                                              href="{{ route('site.tenders.category', $item->ru_slug) }}">{{ $item->ru_title }}</a>
                                                        </div>
                                                        <div class="col-3"><a class="text-left stretched-link"
                                                                              data-toggle="collapse"
                                                                              href="#b{{ $item->id }}"
                                                                              aria-expanded="false"
                                                                              aria-controls="b{{ $item->id }}"
                                                                              style="color:#383838;"><i
                                                                    class="fas fa-chevron-right"
                                                                    style="transform: rotate(90deg);"></i></a></div>
                                                    </div>
                                                    <div class="collapse" id="b{{ $item->id }}">
                                                        <ul class="sub-menu-mobile">
                                                            @foreach($item->categories as $category)
                                                                <li>
                                                                    <a style="color: #63ba16; font-weight: 600;"
                                                                       href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{ $category->getTitle() }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                </li>


                            </ul>
                        @endforeach
                    </div>
                </li>

                <li>
                    <div class="row">
                        <div class="col-9"><a class="style_a stretched-link"
                                              href="{{ route('site.contractors.index') }}">{{ __('Исполнители') }}</a></div>
                        <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#sub-2"
                                              aria-expanded="false" aria-controls="sub-2" style="color:#383838;"><i
                                    class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                    </div>
                    <div class="collapse" id="sub-2">
                        @foreach($needs as $need)
                            <ul class="main-menu-mobile">

                                <li>

                                <li><a data-toggle="collapse" href="#d{{ $need->id }}" aria-expanded="false"
                                       aria-controls="d{{ $need->id }}">{{ $need->ru_title }}</a>
                                    <div class="collapse" id="d{{ $need->id }}">
                                        <ul class="main-menu-mobile">
                                            @foreach($need->menuItems as $item)
                                                <li>
                                                    <div class="row">
                                                        <div class="col-9"><a class="style_a stretched-link"
                                                                              href="{{ route('site.catalog.main', $item->ru_slug) }}">{{ $item->ru_title }}</a>
                                                        </div>
                                                        <div class="col-3"><a class="text-left stretched-link"
                                                                              data-toggle="collapse"
                                                                              href="#c{{ $item->id }}"
                                                                              aria-expanded="false"
                                                                              aria-controls="c{{ $item->id }}"
                                                                              style="color:#383838;"><i
                                                                    class="fas fa-chevron-right"
                                                                    style="transform: rotate(90deg);"></i></a></div>
                                                    </div>
                                                    <div class="collapse" id="c{{ $item->id }}">
                                                        <ul class="sub-menu-mobile">
                                                            @foreach($item->categories as $category)
                                                                <li>
                                                                    <a style="color: #63ba16; font-weight: 600;"
                                                                       href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->getTitle() }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                </li>


                            </ul>
                        @endforeach
                    </div>
                </li>

        </div>
    </div>
</div>
