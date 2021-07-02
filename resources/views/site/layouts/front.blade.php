<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=1024" />
  <!-- Favicons -->
  <link rel="shortcut icon" href="/favicon.ico" />

  <meta name="author" content="" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <title>@yield('title') | itcase.com</title>

  <link rel="stylesheet" href="/resources/css/plugins/swiper.min.css" />
  <link rel="stylesheet" href="/resources/css/plugins/magnific-popup.min.css" />
  <link rel="stylesheet" href="/resources/css/style.css" />
  @stack('css')
</head>

<body>

  <header class="header">
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="header__left d-flex align-items-center">
          <a href="{{ route('site.catalog.index') }}" class="logo">
            <img src="/resources/images/logo.png" alt="">
          </a>

          <ul class="header__menu menu">
            <li class="has-submenu">
              <a href="{{ route('site.tenders.index') }}">{{ __('Найти задания') }}</a>
              <ul>
                @foreach($parentCategories as $parent)
                <li class="has-submenu">
                  <a>{{ $parent->title }}</a>
                  <ul>
                  @foreach ($parent->categories as $category)
                    <li><a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a></li>
                  @endforeach
                  </ul>
                </li>
                @endforeach
              </ul>
            </li>

            <li class="has-submenu">
              <a href="{{ route('site.contractors.index') }}">{{ __('Найти исполнителя') }}</a>
              <ul class="has-submenu">
                @foreach($parentCategories as $parent)
                <li class="has-submenu">
                  <a>{{ $parent->title }}</a>
                  <ul>
                  @foreach ($parent->categories as $category)
                    <li><a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a></li>
                  @endforeach
                  </ul>
                </li>
                @endforeach
              </ul>

            <li class="color-primary add">
              <a href="{{ route('site.tenders.common.create') }}">{{ __('Добавить задания') }}</a>
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
            <li class="color-primary user"><a href="{{ route('register') }}">{{ __('Регистрация') }}</a></li>
          </ul>
          @endguest
          @auth
          <ul class="header__menu">
            <li class="color-primary user"><a href="{{ route('site.account.index') }}">{{ auth()->user()->first_name ? auth()->user()->name : __('Аккаунт') }}</a></li>
            <li class="enter"><a href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">{{ __('Выйти') }}</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </ul>
          @endauth
        </div>

        <div class="toggle-button">
          <span></span>
          <span></span>
          <span></span>
        </div>

      </div>
    </div>
  </header>

  <div class="wrapper" style="padding-bottom: 30px;">
    <div class="container">

      <!-- КАТАЛОГ ИСПОЛНИТЕЛЕЙ - ФОРМА-->
      @hasSection('search-box')
      <section class="main search-block">
        @yield('search-box')
      </section>
      @endif

      <!-- ХЛЕБНЫЕ КРОШКИ-->
      <p class="breadcrumbs">
        <a href="/" class="home">{{ __('Главная') }}</a>
        @yield('breadcrumbs')
      </p>

      @hasSection('sidebar')
        <div class="row mt35">
          <aside class="sidebar">
            @yield('sidebar')
          </aside>
          <div class="right-block">
            <div class="right-block__inner">
              @yield('content')
            </div>
          </div>
        </div>

      @else
        <div class="mt35">
          <div class="right-block__inner" style="padding: 0px;">
            @yield('content')
          </div>
        </div>
      @endif

      </div>
    </div>
  </div>



  @include('site.pages.footer')

  <!--<div id="scrollTop" class="scrollToTop">
    <img src="/resources/images/artop.svg" alt="" class="third arrow">
    <img src="/resources/images/artop.svg" alt="" class="second arrow">
    <img src="/resources/images/artop.svg" alt="" class="first arrow">
  </div>-->


  <!-- -->
  @yield('modal')
  <div class="cover"></div>

  <script src="/front/js/popper.min.js"></script>
  <script src="/resources/js/jquery.min.js"></script>
  <script src="/front/js/bootstrap.min.js"></script>
  <script src="/resources/js/swiper.min.js"></script>
  <script src="/resources/js/wow.min.js"></script>
  <script src="/resources/js/isotope.pkgd.js"></script>
  <script src="/resources/js/jquery.magnific-popup.min.js"></script>
  <script src="/resources/js/main.js"></script>
  @stack('js')


</body>

</html>