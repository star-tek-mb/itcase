<header class="header-site" id="header">
    <!-- <div class="container-fluid"> -->
        <div class="header-wrap">

            <div class="header-left">
                <div class="header-main-toggle">
                    <button class="btn-toggle" type="button" data-toggle="offcanvas"><i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="header-logo"><a class="qdesk-logo" href="{{ route('site.catalog.index') }}" title="VID"><img class="qdesk-logo-white" src="{{ asset('front/images/VID-black.png') }}" alt="VID"><img class="qdesk-logo-black" src="{{ asset('front/images/VID-black.png') }}" alt="VID"></a>
                </div>
                <div class="navigation" id="navigation">
                    <ul class="ml-4 main-menu">
                        <li class="header-menu-item"><a href="{{ route('site.tenders.index') }}">{{ __('Конкурсы') }} <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5.3902 5.77793L9.84025 1.3278C9.94325 1.22488 10 1.08748 10 0.940979C10 0.794476 9.94325 0.657079 9.84025 0.554153L9.51261 0.226432C9.29911 0.0131814 8.95212 0.0131814 8.73895 0.226432L5.00207 3.96331L1.26105 0.222285C1.15804 0.119359 1.02072 0.0625301 0.874302 0.0625301C0.727717 0.0625301 0.590401 0.119359 0.487312 0.222285L0.159754 0.550006C0.0567474 0.653013 -3.18131e-08 0.790329 -3.82169e-08 0.936832C-4.46208e-08 1.08333 0.0567474 1.22073 0.159754 1.32366L4.61386 5.77793C4.7172 5.8811 4.85516 5.93777 5.00183 5.93744C5.14906 5.93777 5.28695 5.8811 5.3902 5.77793Z" fill="black"/>
</svg>
</a>
                            <ul class="sub-menu">
                                @foreach($parentCategories as $parent)
                                <li class="menu-item dropdown-submenu">
                                    <a href="{{ route('site.tenders.category', $parent->ru_slug) }}" class="d-flex justify-content-between align-items-center">{{ $parent->title }}
                                        <i class="fas fa-caret-right ml-2 mr-3"></i></a>
                                    <ul class="sub-menu">
                                        @foreach($parent->categories as $category)
                                        <li>
                                            <a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="header-menu-item"><a href="{{ route('site.contractors.index') }}">{{ __('Исполнители') }} <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5.3902 5.77793L9.84025 1.3278C9.94325 1.22488 10 1.08748 10 0.940979C10 0.794476 9.94325 0.657079 9.84025 0.554153L9.51261 0.226432C9.29911 0.0131814 8.95212 0.0131814 8.73895 0.226432L5.00207 3.96331L1.26105 0.222285C1.15804 0.119359 1.02072 0.0625301 0.874302 0.0625301C0.727717 0.0625301 0.590401 0.119359 0.487312 0.222285L0.159754 0.550006C0.0567474 0.653013 -3.18131e-08 0.790329 -3.82169e-08 0.936832C-4.46208e-08 1.08333 0.0567474 1.22073 0.159754 1.32366L4.61386 5.77793C4.7172 5.8811 4.85516 5.93777 5.00183 5.93744C5.14906 5.93777 5.28695 5.8811 5.3902 5.77793Z" fill="black"/>
</svg>
</a>
                            <ul class="sub-menu">
                                @foreach($parentCategories as $parent)
                                <li class="menu-item dropdown-submenu">
                                    <a href="{{ route('site.catalog.main', $parent->ru_slug) }}" class="d-flex justify-content-between align-items-center">{{ $parent->title }}
                                        <i class="fas fa-caret-right ml-2 mr-3"></i></a>
                                    <ul class="sub-menu">
                                        @foreach($parent->categories as $category)
                                        <li>
                                            <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="enter_new_order"><a href="{{ route('site.tenders.common.create') }}">
                            {{ __('Добавить заказ') }}</a><svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.57145 4.28572H5.7143V1.42856C5.7143 1.03406 5.39451 0.714264 5 0.714264C4.6055 0.714264 4.2857 1.03406 4.2857 1.42856V4.28572H1.42859C1.03409 4.28572 0.714294 4.60551 0.714294 5.00001C0.714294 5.39452 1.03409 5.71427 1.42859 5.71427H4.28575V8.57142C4.28575 8.96593 4.60554 9.28572 5.00004 9.28572C5.39455 9.28572 5.7143 8.96588 5.7143 8.57142V5.71427H8.57145C8.96596 5.71427 9.28575 5.39447 9.28575 4.99997C9.28575 4.60547 8.96591 4.28572 8.57145 4.28572Z" fill="#FF6B01"/>
</svg>

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

                    <ul class="main-menu" style="display: inline-block;">
                        <li class="header-menu-item">
                            <a href="#" class="d-flex justify-content-between align-items-center"><span>{{ __('ru') }} <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5.3902 5.83709L9.84025 1.29221C9.94325 1.1871 10 1.04677 10 0.897152C10 0.74753 9.94325 0.607207 9.84025 0.50209L9.51261 0.167391C9.29911 -0.0503999 8.95212 -0.0503999 8.73895 0.167391L5.00207 3.98384L1.26105 0.163156C1.15804 0.0580382 1.02072 -5.8482e-07 0.874302 -5.94356e-07C0.727717 -6.03903e-07 0.590401 0.0580382 0.487312 0.163156L0.159754 0.497854C0.0567474 0.603055 -2.18057e-08 0.743295 -2.61951e-08 0.892917C-3.05845e-08 1.04254 0.0567474 1.18286 0.159754 1.28798L4.61386 5.83709C4.7172 5.94246 4.85516 6.00033 5.00183 6C5.14906 6.00033 5.28695 5.94246 5.3902 5.83709Z" fill="white"/>
</svg>
</span></a>
                            <ul class="sub-menu">
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

                    @guest
                    <!-- <li><a href="{{ route('site.tenders.common.create') }}">
                            {{ __('Добавить заказ') }}</a><i class="fas fa-plus-circle"></i></li> -->
                    <li class="registration_li">
                        <a href="{{ route('login') }}"><span class="account_icons"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.3125 20H10.5859C8.00125 20 5.89844 17.8972 5.89844 15.3125V14.4922C5.89844 14.0607 6.2482 13.7109 6.67969 13.7109C7.11117 13.7109 7.46094 14.0607 7.46094 14.4922V15.3125C7.46094 17.0356 8.86281 18.4375 10.5859 18.4375H15.3125C17.0356 18.4375 18.4375 17.0356 18.4375 15.3125V4.6875C18.4375 2.96438 17.0356 1.5625 15.3125 1.5625H10.5859C8.86281 1.5625 7.46094 2.96438 7.46094 4.6875V5.46875C7.46094 5.90023 7.11117 6.25 6.67969 6.25C6.2482 6.25 5.89844 5.90023 5.89844 5.46875V4.6875C5.89844 2.10281 8.00125 0 10.5859 0H15.3125C17.8972 0 20 2.10281 20 4.6875V15.3125C20 17.8972 17.8972 20 15.3125 20Z" fill="#00366D" />
                                    <path d="M10.0391 13.75C9.83875 13.75 9.63852 13.6735 9.4859 13.5205C9.18121 13.215 9.18188 12.7203 9.48738 12.4156L11.2955 10.6122C11.4426 10.4657 11.5234 10.2712 11.5234 10.0644C11.5234 9.85841 11.4432 9.66454 11.2973 9.51829L9.49164 7.74489C9.18383 7.44255 9.17934 6.94794 9.48168 6.64009C9.78402 6.33223 10.2786 6.32778 10.5865 6.63012L12.3946 8.40594C12.3961 8.40731 12.3974 8.40868 12.3988 8.41005C12.8419 8.8518 13.0859 9.43934 13.0859 10.0644C13.0859 10.6894 12.8419 11.2769 12.3988 11.7187L10.5907 13.522C10.4383 13.674 10.2386 13.75 10.0391 13.75ZM10 10C10 9.56852 9.65023 9.21876 9.21875 9.21876H0.78125C0.349766 9.21876 0 9.56852 0 10C0 10.4315 0.349766 10.7813 0.78125 10.7813H9.21875C9.65023 10.7813 10 10.4315 10 10Z" fill="#00366D" />
                                </svg></span>{{ __('Вход') }}</a>
                        <!-- <span> / </span> -->
                        <a href="{{ route('register') }}">
                            <span class="account_icons"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.13671 19.0575H2.37081C2.0373 19.0575 1.83608 18.8714 1.74585 18.7604C1.59007 18.5687 1.52972 18.3194 1.58038 18.076C2.39167 14.1791 5.83074 11.3332 9.80089 11.2409C9.86703 11.2434 9.93332 11.245 10 11.245C10.0673 11.245 10.1341 11.2433 10.2009 11.2408C11.1717 11.263 12.12 11.4455 13.0226 11.7844C13.4265 11.9362 13.8769 11.7316 14.0286 11.3277C14.1803 10.9238 13.9758 10.4734 13.5718 10.3217C13.4425 10.2731 13.3123 10.2276 13.1814 10.1845C14.4744 9.21457 15.3125 7.66957 15.3125 5.9325C15.3125 3.0032 12.9293 0.619995 10 0.619995C7.07066 0.619995 4.68749 3.0032 4.68749 5.9325C4.68749 7.67113 5.52702 9.21734 6.82199 10.1871C5.63562 10.5777 4.52234 11.185 3.54804 11.9864C1.76163 13.4558 0.51956 15.5054 0.0506929 17.7576C-0.0962603 18.4633 0.0797554 19.1882 0.533623 19.7462C0.985186 20.3015 1.65483 20.62 2.37081 20.62H5.13671C5.5682 20.62 5.91796 20.2702 5.91796 19.8387C5.91796 19.4073 5.5682 19.0575 5.13671 19.0575ZM6.24999 5.9325C6.24999 3.86472 7.93222 2.1825 10 2.1825C12.0678 2.1825 13.75 3.86472 13.75 5.9325C13.75 7.93902 12.1659 9.58242 10.1826 9.678C10.1218 9.67691 10.0609 9.67597 10 9.67597C9.9389 9.67597 9.87785 9.67687 9.81683 9.67796C7.83382 9.5821 6.24999 7.93882 6.24999 5.9325Z" fill="#FF6B01" />
                                    <path d="M19.4017 14.0812C19.0673 13.3332 18.314 12.8485 17.4808 12.8466H15.0443C15.0426 12.8466 15.0409 12.8466 15.0392 12.8466C14.1602 12.8466 13.3934 13.3645 13.0849 14.1671C13.0438 14.2739 12.9936 14.4085 12.9413 14.5653H7.82618C7.61497 14.5653 7.41278 14.6508 7.26563 14.8023L5.9236 16.1847C5.62802 16.4891 5.6295 16.9739 5.92692 17.2765L7.29411 18.6676C7.44099 18.817 7.64177 18.9012 7.8513 18.9012H10.3904C10.8218 18.9012 11.1716 18.5514 11.1716 18.12C11.1716 17.6885 10.8218 17.3387 10.3904 17.3387H8.17888L7.57622 16.7255L8.15657 16.1278H13.5273C13.8872 16.1278 14.2006 15.8819 14.2861 15.5323C14.3493 15.2743 14.4286 15.0261 14.5433 14.7278C14.619 14.5311 14.8089 14.4091 15.041 14.4091C15.0415 14.4091 15.042 14.4091 15.0426 14.4091H17.4789C17.6999 14.4096 17.89 14.5283 17.9752 14.7189C18.1849 15.1881 18.4354 15.9145 18.4372 16.7105C18.4391 17.5125 18.189 18.2555 17.9787 18.7376C17.8939 18.9321 17.7022 19.0575 17.4881 19.0575C17.4876 19.0575 17.4872 19.0575 17.4868 19.0575H15.0209C14.8048 19.057 14.6024 18.9179 14.5172 18.7115C14.4258 18.49 14.3467 18.237 14.2751 17.9382C14.1747 17.5185 13.753 17.2598 13.3335 17.3602C12.9139 17.4606 12.6551 17.8822 12.7556 18.3018C12.8462 18.6807 12.95 19.0096 13.0728 19.3072C13.4009 20.1027 14.1642 20.618 15.0192 20.6199H17.485C17.4867 20.6199 17.4882 20.6199 17.4899 20.6199C18.3239 20.6199 19.0777 20.1266 19.411 19.3621C19.681 18.7429 20.0023 17.7796 19.9997 16.7068C19.9972 15.6369 19.6731 14.6885 19.4017 14.0812Z" fill="#FF6B01" />
                                    <path d="M16.8357 17.495C17.2672 17.495 17.6169 17.1452 17.6169 16.7137C17.6169 16.2823 17.2672 15.9325 16.8357 15.9325C16.4042 15.9325 16.0544 16.2823 16.0544 16.7137C16.0544 17.1452 16.4042 17.495 16.8357 17.495Z" fill="#FF6B01" />
                                </svg>
                            </span>
                            {{ __('Регистрация') }}</a>
                    </li>
                    @else
                    @if (auth()->user()->hasRole('customer'))
                    <li><a href="{{ route('site.tenders.common.create') }}"><i class="fas fa-plus-circle"></i>
                            {{ __('Добавить заказ') }}</a></li>@endif
                    <li>
                        <div class="notification-item">
                            <a role="button" id="page-header-notifications" class="notification-button" data-toggle="dropdown" class="" aria-haspopup="true">
                                <i class="far fa-bell"></i>
                                @if (auth()->user()->unreadNotifications->count() > 0)<span class="numeric">{{ auth()->user()->unreadNotifications->count() }}</span> @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right notifications-dropdown" aria-labelledby="page-header-notifications">
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
                                                <p class="mb-0">{{ __('Новая заявка на участие в конкурсе') }} <span class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                    от исполнителя <span class="font-weight-bold">{{ $notification->data['contractorName'] }}</span>
                                                </p>
                                                <small class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </a>
                                        @endif
                                        @if ($notification->type == 'App\Notifications\InviteRequest')
                                        <a href="{{ route('site.tenders.category', $notification->data['tenderSlug']) }}">
                                            <div class="icon">
                                                <small><i class="fas fa-info text-primary"></i></small>
                                            </div>
                                            <div class="notification-item-body">
                                                <p class="mb-0">{{ __('Заказчик') }}<span class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                    {{ __('приглашает вас принять участие в конкурсе') }} <span class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                    {{ __('и добавил вас в список участников') }}
                                                </p>
                                                <small class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
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
                                                <p class="mb-0">{{ __('Заказчик') }} <span class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                    {{ __('отклонил вашу заявку на участие в конкурсе') }} <span class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                </p>
                                                @elseif ($notification->data['type'] === 'accepted')
                                                <p class="mb-0">{{ __('Заказчик') }} <span class="font-weight-bold">{{ $notification->data['customerName'] }}</span>
                                                    {{ __('выбрал Вас в качестве исполнителя на конкурс') }} <span class="font-weight-bold">{{ $notification->data['tenderName'] }}</span>
                                                </p>
                                                @endif
                                                <small class="text-muted font-italic">{{ $notification->created_at->diffForHumans() }}</small>
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
                    @auth
                    @if (auth()->user()->hasRole('customer'))
                    <li> ({{auth()->user()->ownedTenders()->count()}})</li>
                    @endif
                    @endauth
                    <li>
                        <a href="#" id="navBarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <a href="{{ route('site.account.index') }}" class="dropdown-item user-dropdown-item"><i class="fas fa-user"></i> {{ __('Личный кабинет') }}</a>
                            <a class="dropdown-item user-dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Выйти') }}
                            </a>
                        </div>
                    </li>
                    @endguest

                </ul>
            </div>
        </div>
    <!-- </div> -->
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
                    <a href="#" id="navBarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a href="{{ route('site.account.index') }}" class="dropdown-item"><i class="fas fa-user"></i> {{ __('Личный кабинет') }}</a>
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
                <li>
                    <a href="https://t.me/gde_podeshevle"><i class="fab fa-telegram" style="font-size:25px"></i></a>
                    <a href="https://www.instagram.com/vid.market/"><i class="fab fa-instagram pl-3" style="font-size:25px"></i></a>
                </li>
            </ul>
        </div>
        <div class="menu-mobile">
            <ul class="main-menu-mobile">

                <li>
                    <div class="row">
                        <div class="col-9"><a class="style_a stretched-link" href="{{ route('site.tenders.index') }}">{{ __('Конкурсы') }}</a>
                        </div>
                        <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#sub-1" aria-expanded="false" aria-controls="sub-1" style="color:#383838;"><i class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                    </div>
                    <div class="collapse" id="sub-1">
                        <ul class="main-menu-mobile">
                            @foreach($parentCategories as $parent)
                            <li>
                                <div class="row">
                                    <div class="col-9"><a class="style_a stretched-link" href="{{ route('site.tenders.category', $parent->ru_slug) }}">{{ $parent->title }}</a>
                                    </div>
                                    <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#b{{ $parent->id }}" aria-expanded="false" aria-controls="b{{ $parent->id }}" style="color:#383838;"><i class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                                </div>
                                <div class="collapse" id="b{{ $parent->id }}">
                                    <ul class="sub-menu-mobile">
                                        @foreach($parent->categories as $category)
                                        <li>
                                            <a style="color: #63ba16; font-weight: 600;" href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>

                <li>
                    <div class="row">
                        <div class="col-9"><a class="style_a stretched-link" href="{{ route('site.contractors.index') }}">{{ __('Исполнители') }}</a></div>
                        <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#sub-2" aria-expanded="false" aria-controls="sub-2" style="color:#383838;"><i class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                    </div>
                    <div class="collapse" id="sub-2">
                        <ul class="main-menu-mobile">
                            @foreach($parentCategories as $parent)
                            <li>
                                <div class="row">
                                    <div class="col-9"><a class="style_a stretched-link" href="{{ route('site.catalog.main', $parent->ru_slug) }}">{{ $parent->title }}</a>
                                    </div>
                                    <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#c{{ $parent->id }}" aria-expanded="false" aria-controls="c{{ $parent->id }}" style="color:#383838;"><i class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                                </div>
                                <div class="collapse" id="c{{ $parent->id }}">
                                    <ul class="sub-menu-mobile">
                                        @foreach($parent->categories as $category)
                                        <li>
                                            <a style="color: #63ba16; font-weight: 600;" href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>

        </div>
    </div>
</div>