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

{{--                <li>--}}
{{--                    <a href="https://t.me/gde_podeshevle"><i class="fab fa-telegram" style="font-size:25px"></i></a>--}}
{{--                    <a href="https://www.instagram.com/vid.market/"><i class="fab fa-instagram pl-3" style="font-size:25px"></i></a>--}}
{{--                </li>--}}
            </ul>
        </div>
        <div class="menu-mobile">
            <ul class="main-menu-mobile">

                <li>
                    <div class="row">
                        <div class="col-9"><a class="style_a stretched-link" href="{{ route('site.tenders.index') }}">{{ __('Задания') }}</a>
                        </div>
                        <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#sub-1" aria-expanded="false" aria-controls="sub-1" style="color:#383838;"><i class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                    </div>
                    <div class="collapse" id="sub-1">
                        <ul class="main-menu-mobile">
                            @foreach($parentCategories as $parent)
                                <li>
                                    <div class="row">
                                        <div class="col-9"><a class="style_a stretched-link"  data-toggle="collapse" href="#b{{ $parent->id }}" aria-expanded="false" aria-controls="b{{ $parent->id }}">{{ $parent->title }}</a>
                                        </div>
                                        <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#b{{ $parent->id }}" aria-expanded="false" aria-controls="b{{ $parent->id }}" style="color:#383838;"><i class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                                    </div>
                                    <div class="collapse" id="b{{ $parent->id }}">
                                        <ul class="sub-menu-mobile">
                                            @foreach($parent->categories as $category)
                                                <li>
                                                    <a  href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
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
                                        <div class="col-9"><a class="style_a stretched-link" data-toggle="collapse" href="#c{{ $parent->id }}" aria-expanded="false" aria-controls="c{{ $parent->id }}" >{{ $parent->title }}</a>
                                        </div>
                                        <div class="col-3"><a class="text-left stretched-link" data-toggle="collapse" href="#c{{ $parent->id }}" aria-expanded="false" aria-controls="c{{ $parent->id }}" style="color:#383838;"><i class="fas fa-chevron-right" style="transform: rotate(90deg);"></i></a></div>
                                    </div>
                                    <div class="collapse" id="c{{ $parent->id }}">
                                        <ul class="sub-menu-mobile">
                                            @foreach($parent->categories as $category)
                                                <li>
                                                    <a  href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="about-company"><a href="{{ route('site.page', 'about') }}">О
                        компании</a></li>
                <li>
            </ul>
        </div>

    </div>
</div>