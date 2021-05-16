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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Favicons -->
  <link rel="shortcut icon" href="favicon.ico" />

  <meta name="author" content="" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <title>@yield('title') | ITCASE.com</title>
  <link rel="stylesheet" href="/resources/css/plugins/swiper.min.css" />
  <link rel="stylesheet" href="/resources/css/plugins/magnific-popup.min.css" />

  <link rel="stylesheet" href="/resources/css/style.css" />
</head>

<body>

  <header class="header">
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="header__left d-flex align-items-center">
          <a href="#" class="logo">
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
          <div class="languages has-submenu">
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
          </div>

          @guest
          <ul class="header__menu">
            <li class="enter"><a href="{{ route('login') }}">{{ __('Вход') }}</a></li>
            <li class="color-primary user"><a href="{{ route('register') }}">{{ __('Регистрация') }}</a></li>
          </ul>
          @endguest
          @auth
          <ul class="header__menu">
            <li class="color-primary user"><a href="{{ route('site.account.index') }}">{{ auth()->user()->name }}</a></li>
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

  <div class="wrapper">
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
    </div>
  </div>



  <footer class="footer">
    <div class="container">
      <div class="row footer__row">
        <div class="col">
          <h4>Аккаунт</h4>

          <ul>
            <li>
              <a href="#">Каталог заданий</a>
            </li>

            <li>
              <a href="#">Как стать исполнителем</a>
            </li>

            <li>
              <a href="#">Как стать заказчиком</a>
            </li>

            <li>
              <a href="#">Частые вопросы</a>
            </li>

            <li>
              <a href="#">Вакансии</a>
            </li>
          </ul>
        </div>

        <div class="col">
          <h4>Компания</h4>

          <ul>
            <li>
              <a href="#">Отзывы заказчиков</a>
            </li>

            <li>
              <a href="#">itcase для бизнеса</a>
            </li>

            <li>
              <a href="#">Наш блог</a>
            </li>

            <li>
              <a href="#">Контакты</a>
            </li>

            <li>
              <a href="#">Служба поддержки</a>
            </li>
          </ul>
        </div>

        <div class="col">
          <h4>Скоро в itcase.com</h4>

          <ul>
            <li>
              <a href="#">ittaxi - сервис агрегатор такси</a>
            </li>

            <li>
              <a href="#">itmoney - универсальная
                платежная система</a>
            </li>

            <li>
              <a href="#">itcar - краткосрочная аренда, прокат машины</a>
            </li>
          </ul>
        </div>


        <div class="col">
          <h4>Скачайте наше приложение</h4>

          <div class="app-info">
            <ul class="app-info__list">
              <li>
                <a href="#">
                  <img src="/resources/images/appstore-black.svg" alt="">
                </a>
              </li>

              <li>
                <a href="#">
                  <img src="/resources/images/googleplay-black.svg" alt="">
                </a>
              </li>
            </ul>

            <div class="qr-code">
              <img src="/resources/images/qr.png" alt="">
            </div>

          </div>
        </div>
      </div>
    </div>


    <hr>

    <div class="container footer__bottom">
      <div class="row align-items-center">
        <div class="col col--25">
          <p>© 2021 itcase.com</p>
        </div>

        <div class="col text-center">
          <p>
            <a href="#">Правила сервиса</a>
            <a href="#"> Оферта</a>
            <a href="#">Политика конфиденциальности</a>
          </p>
        </div>

        <div class="col col--25 d-flex justify-content-end align-items-center">
          <ul>
            <li>
              <a href="#">
                <img src="/resources/images/facebook.svg" alt="">
              </a>
            </li>

            <li>
              <a href="#">
                <img src="/resources/images/instagram.svg" alt="">
              </a>
            </li>

            <li>
              <a href="#">
                <img src="/resources/images/youtube.svg" alt="">
              </a>
            </li>


            <li>
              <a href="#">
                <img src="/resources/images/telegram.svg" alt="">
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!--<div id="scrollTop" class="scrollToTop">
    <img src="/resources/images/artop.svg" alt="" class="third arrow">
    <img src="/resources/images/artop.svg" alt="" class="second arrow">
    <img src="/resources/images/artop.svg" alt="" class="first arrow">
  </div>-->


  <!-- -->


  <script src="/resources/js/jquery.min.js"></script>
  <script src="/resources/js/swiper.min.js"></script>
  <script src="/resources/js/wow.min.js"></script>
  <script src="/resources/js/isotope.pkgd.js"></script>
  <script src="/resources/js/jquery.magnific-popup.min.js"></script>
  <script src="/resources/js/main.js"></script>



</body>

</html>