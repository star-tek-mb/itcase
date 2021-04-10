<!-- Header Menu -->
<!--media: 960; show-on-up: true; animation: uk-animation-slide-top; cls-active: uk-navbar-sticky; sel-target: .uk-navbar-container;-->
<!--bottom: #offset; cls-active: uk-navbar-sticky; sel-target: .uk-navbar-container;-->
<div class="uk-light ad-v6">
    <div uk-sticky="animation: uk-animation-slide-top; media: 960; show-on-up: true; cls-active: uk-navbar-sticky; sel-target: .uk-navbar-container;" class="uk-sticky header" style="">
        <div class="uk-navbar-container">
            <div class="uk-container uk-container-expand">
                <nav uk-navbar class="uk-navbar header-top">
                    <div class="uk-navbar-left">
                        <div class="uk-navbar-item  content-header-item ">
                            <a class="link-effect font-w700" href="{{ route('site.catalog.index') }}">
                                <span class="icon">
                                    <iconify-icon data-icon="simple-line-icons:fire"></iconify-icon>
                                </span>
                                <span class="font-size-xl text-dual-primary-dark"></span><span class="font-size-xl text-primary">{{ __('Porta') }}</span>
                            </a>
                        </div>
                    <!--
                        <a class="uk-navbar-item uk-logo " href="{{ route('site.catalog.index') }}">
                            <img src="/site/images/yootheme-logo.svg" width="134" height="30" alt="YOOtheme Logo" uk-svg="" hidden="true">
                        </a>
    -->

                    </div>

                    <div class="uk-navbar-right">
                        <div class="uk-navbar-item uk-hidden@m ">
                            <form class="header_top_right_search_btn ">
                                <div class="uk-inline">
                                    <span class="uk-form-icon" uk-icon="icon: search"></span>
                                    <input id="search-input" class="header_top_right_search_btn_bar uk-input" name="search_bar" type="search">
                                </div>
                            </form>
                        </div>
                        <div class="show-hed-search uk-navbar-item uk-visible@m">
                            @include('site.components.search')
                        </div>
                        <ul class="uk-navbar-nav uk-visible@m">
    <!--                        <li ><a href="{{ route('site.catalog.index') }}">Главная</a></li>-->
                            <li ><a href="#">Регистрация</a></li>
                            <li ><a href="">Войти</a></li>
                        </ul>
                        <div class="uk-navbar-nav">
                        <a class="uk-button uk-button-primary uk-visible@m " href="#">{{ __('Добавить компанию') }}</a>
                        </div>
                        <a class="uk-navbar-toggle uk-hidden@m uk-icon uk-navbar-toggle-icon" href="#offcanvas" uk-navbar-toggle-icon="" uk-toggle=""><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="navbar-toggle-icon"><rect y="9" width="20" height="2"></rect><rect y="3" width="20" height="2"></rect><rect y="15" width="20" height="2"></rect></svg></a>




                    </div>
                <!--
                <div class="contact">
                    <button uk-toggle ="target:#phone" type="button" class="contact-buttons">
                        <div class="contact_img">
                            <img src="{{ asset('assets/img/phone-receiver.png') }}" alt="">
                        </div>
                        <h2>
                            Контакты
                        </h2>
                    </button>
                    <a href="{{ route('home.cgu.ad') }}" class="contact-buttons">
                        <div class="contact_img">
                            <img src="{{ asset('assets/img/photo228.png') }}" alt="">
                        </div>
                        <h2>
                            Реклама в Цгу
                        </h2>
                    </a>
                </div>
                <div id="phone" uk-modal>
                    <div class="uk-modal-dialog uk-modal-body">
                        <div class="container-pop">
                            <h2>
                                <img src="{{ asset('assets/img/phone-receiver.png') }}" alt="">
                                размещение web сайтов и рекламы в цгу:
                            </h2>
                            <div class="phone-numbers">
                                    <a href="tel:+998953411717" class="contacts_popup_inner_link">
                                        +99895 341 17 17
                                    </a>
                                    <a href="tel:+998954781717" class="contacts_popup_inner_link">
                                        +99895 478 17 17
                                    </a>
                                    <a href="tel:+998954761717" class="contacts_popup_inner_link">
                                        +99895 476 17 17
                                    </a>
                                    <a href="tel:+998954791717" class="contacts_popup_inner_link">
                                        +99895 479 17 17
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
    -->
                </nav>

            </div>
        </div>


    </div>
    <div class="header" >
        <div class="uk-navbar-container ">
            <div class="uk-container uk-container-expand">
                <nav uk-navbar class="uk-navbar header-search">
                    <div class="uk-navbar-center">
                        <div class="uk-navbar-item uk-visible@m">
                            @include('site.components.search')
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!--  top: 0; bottom: #offset; offset: 75; cls-active: uk-navbar-sticky; sel-target: .uk-navbar-container;  -->
    <!--  top: 0; offset: 75; media: 960; show-on-up: true; cls-active: uk-navbar-sticky; sel-target: .uk-navbar-container;  -->

    <div uk-sticky="animation: uk-animation-slide-top; top: 0; offset: 75; media: 960; show-on-up: true; cls-active: uk-navbar-sticky; sel-target: .uk-navbar-container;" class="header andir uk-visible@m" style="">
        <div class="uk-navbar-container " style="">
            <div class="uk-container uk-container-expand">
                <nav uk-navbar class="uk-navbar header-bottom">
                    <div class="uk-navbar-center">
                        <ul class="uk-navbar-nav uk-visible@m">
                            <!--class="uk-active"-->
                            <li ><a href="{{ route('site.catalog.index') }}">{{ __('Главная') }}</a></li>
                            @foreach ($needs as $need)
                                <li class="uk-parent">
                                    <a href="#">{{ $need->ru_title }}</a>
                                    <div class="code-dropdown uk-dropdown uk-dropdown-width-4 uk-dropdown-stack uk-dropdown-bottom-left" data-uk-dropdown="{delay: 500}" style="left: 108.65625px; top: 32px;">
                                        <div class="uk-grid-collapse uk-grid uk-child-width-1-4" uk-grid>
                                            @foreach ($need->menuItems as $menu)
                                                <div class="padding-15 ">
                                                    <ul class="uk-nav">
                                                        <div class="dropdown_wrapper">
                                                            <img src="{{ $menu->getImage() }}" alt="">
                                                            <a href="">{{ $menu->ru_title }}</a>
                                                        </div>
                                                        @foreach ($menu->categories as $category)
                                                            <li>
                                                                <a href="{{ route('site.catalog.category', $category->id) }}">{!! $category->ru_title !!}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

<!--show-hed-search-->


<!-- Header Menu end-->
