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

  <title>ITCASE</title>
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

  <!-- ГЛАВНАЯ СЕКЦИЯ-->
  <section class="main">
    <div class="container">
      <div class="color-white text-center main__caption">
        <h1>{{ __('Два лучших способа найти специалиста для продвижения вашего бизнеса') }}</h1>
        <p>
          <strong>{{ __('Поможем найти надежного исполнителя для любых задач') }}</strong>
        </p>

      </div>

      <form action="#" class="main__form">
        <div class="input-holder">
          <input type="text" placeholder="Чем вам помочь ? .......">
          <input type="submit" value="">
        </div>
      </form>

      <ul class="buttons-list">
        <li>
          <a href="#" class="button">{{ __('Добавить задание') }}</a>
        </li>

        <li>
          <a href="#" class="button">{{ __('Выполнить задание') }}</a>
        </li>
      </ul>
    </div>
  </section>

  <!-- ВЫБРАТЬ ИСПОЛНИТЕЛЯ-->
  <section class="services">
    <div class="container">
      <div class="text-center">
        <h2>Выбрать исполнителя</h2>
        <div class="mt20 color-grey">
          <p>Поможем вам найти исполнителя в решении самых разнообразных задач</p>
        </div>
      </div>


      <div class="row services__row">

        <!-- -->
        @foreach($parentCategories as $parent)
        <div class="col service">
          <div class="service__count">
            <span>{{ $parent->descendants->reduce(fn($carry, $item) => $carry + $item->tenders->count(), 0) }}</span> Заданий
          </div>

          <img style="fill: #fff;" src="{{ $category->getImage() }}" alt="">
          <h3>{{ $parent->title }}</h3>

          <ul class="service__list">
            @foreach ($parent->categories->take(4) as $category)
            <li>
              <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
            </li>
            @endforeach
          </ul>
        </div>
        @endforeach
        <!-- -->
      </div>
      <div class="text-center mt73">
        <a href="{{ route('site.contractors.index') }}" class="button button--secondary">Посмотреть все категории</a>
      </div>
    </div>
  </section>


  <!-- ПОПУЛЯРНЫЕ УСЛУГИ-->
  <section class="popular-services">
    <div class="container">
      <div class="text-center">
        <h2>Популярные услуги</h2>
      </div>


      <div class="swiper-container carousel">
        <div class="swiper-wrapper">

          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <img src="/resources/images/slide_1.jpg" alt="">
            </a>
          </div>
          <!-- -->

          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <img src="/resources/images/slide_2.jpg" alt="">
            </a>
          </div>
          <!-- -->

          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <img src="/resources/images/slide_3.jpg" alt="">
            </a>
          </div>
          <!-- -->

          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <img src="/resources/images/slide_1.jpg" alt="">
            </a>
          </div>
          <!-- -->

          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <img src="/resources/images/slide_2.jpg" alt="">
            </a>
          </div>
          <!-- -->

          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <img src="/resources/images/slide_3.jpg" alt="">
            </a>
          </div>
          <!-- -->
        </div>

        <div id="prev" class="carousel__arrow carousel__arrow--left"></div>
        <div id="next" class="carousel__arrow carousel__arrow--right"></div>

      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        <div class="swiper-container slider">
          <div class="swiper-wrapper">

            <!-- -->
            <div class="swiper-slide">
              <div class="row">
                <div class="col col--50 slide-left">
                  <img src="/resources/images/slide.jpg" alt="">
                </div>

                <div class="col col--50 slide-right">
                  <div>
                    <h3>Создайте задание</h3>
                    <p>Опишите своими словами задачу, которую требуется выполнить.</p>
                    <a href="#" class="button button--secondary">Создать задание</a>
                  </div>
                </div>
              </div>

            </div>
            <!-- -->



            <!-- -->
            <div class="swiper-slide">
              <div class="row">
                <div class="col col--50 slide-left">
                  <img src="/resources/images/slide.jpg" alt="">
                </div>

                <div class="col col--50 slide-right">
                  <div>
                    <h3>Создайте задание</h3>
                    <p>Опишите своими словами задачу, которую требуется выполнить.</p>
                    <a href="#" class="button button--secondary">Создать задание</a>
                  </div>

                </div>
              </div>

            </div>
            <!-- -->



            <!-- -->
            <div class="swiper-slide">
              <div class="row">
                <div class="col col--50 slide-left">
                  <img src="/resources/images/slide.jpg" alt="">
                </div>

                <div class="col col--50 slide-right">
                  <div>
                    <h3>Создайте задание</h3>
                    <p>Опишите своими словами задачу, которую требуется выполнить.</p>
                    <a href="#" class="button button--secondary">Создать задание</a>
                  </div>
                </div>
              </div>

            </div>
            <!-- -->


            <!-- -->
            <div class="swiper-slide">
              <div class="row">
                <div class="col col--50 slide-left">
                  <img src="/resources/images/slide.jpg" alt="">
                </div>

                <div class="col col--50 slide-right">
                  <div>
                    <h3>Создайте задание</h3>
                    <p>Опишите своими словами задачу, которую требуется выполнить.</p>
                    <a href="#" class="button button--secondary">Создать задание</a>
                  </div>
                </div>
              </div>

            </div>
            <!-- -->


            <!-- -->
            <div class="swiper-slide">
              <div class="row">
                <div class="col col--50 slide-left">
                  <img src="/resources/images/slide.jpg" alt="">
                </div>

                <div class="col col--50 slide-right">
                  <div>
                    <h3>Создайте задание</h3>
                    <p>Опишите своими словами задачу, которую требуется выполнить.</p>
                    <a href="#" class="button button--secondary">Создать задание</a>
                  </div>
                </div>
              </div>

            </div>
            <!-- -->


            <!-- -->
            <div class="swiper-slide">
              <div class="row">
                <div class="col col--50 slide-left">
                  <img src="/resources/images/slide.jpg" alt="">
                </div>

                <div class="col col--50 slide-right">
                  <div>
                    <h3>Создайте задание</h3>
                    <p>Опишите своими словами задачу, которую требуется выполнить.</p>
                    <a href="#" class="button button--secondary">Создать задание</a>
                  </div>
                </div>
              </div>

            </div>
            <!-- -->


          </div>
        </div>

        <div class="swiper-pagination slider-pagination"></div>
      </div>
    </div>
  </section>

  <div class="text-center mt70 section-title">
    <h2>Как решать задачи на itcase.com</h2>
    <div class="mt18">
      <p>Идеально подходит для бизнеса и для себя</p>
    </div>
  </div>

  <section class="background process">
    <div class="container">
      <div class="row process__row">
        <div class="col col--25 process__item">
          <div class="process__item-inner">
            <div class="img-holder">
              <img src="/resources/images/image_1.png" alt="">
            </div>

            <h4>Выберите услугу</h4>

            <p>В сервисе itcase представлен
              большой выбор услуг
              разного рода задач и специалистов до профессионалов своего дела.</p>
          </div>
        </div>

        <div class="col col--25 process__item">
          <div class="process__item-inner">
            <div class="img-holder">
              <img src="/resources/images/image_2.png" alt="">
            </div>
            <h4>Выберите оплату</h4>

            <p>В itcase удобный способ оплат картой или наличными средствами. Деньги будут перечислены исполнителю
              после того, как он выполнит работу, и вы её одобрите.</p>
          </div>
        </div>


        <div class="col col--25 process__item">
          <div class="process__item-inner">
            <div class="img-holder">
              <img src="/resources/images/image_3.png" alt="">
            </div>
            <h4>Выберите исполнителя</h4>

            <p>
              В itcase только надежные исполнители, которые подтвердили свой номер телефона, почту и свои документы.
            </p>
          </div>
        </div>

        <div class="col col--25 process__item">
          <div class="process__item-inner">
            <div class="img-holder">
              <img src="/resources/images/image_4.png" alt="">
            </div>
            <h4>Получите результат</h4>

            <p>
              Получите результат оцените выполненную работы, 100% гарантия возврата средств
              если вы выбрали оплату картой безопасной сделкой в случае невыполнения заказа.
            </p>
          </div>
        </div>


      </div>

      <div class="text-center mt55">
        <a href="#" class="button">Добавить задание</a>
      </div>
    </div>
  </section>

  <section class="info">
    <div class="container">
      <div class="row">
        <div class="col col--7">
          <h2>Персональный помощник
            itcase.com в вашем кормане</h2>

          <div class="subtitle mt31">
            <p>Скачайте наше приложение и пользуйтесь
              ITCASE, где бы вы ни находились.</p>
          </div>

          <ul class="buttons">
            <li>
              <a href="#">
                <img src="/resources/images/appstore.svg" alt="">
              </a>
            </li>

            <li>
              <a href="#">
                <img src="/resources/images/googleplay.svg" alt="">
              </a>
            </li>
          </ul>

          <div class="info__block">
            <div>
              <p>А также можете скачать с нашего сайта</p>
              <a href="/itcase.apk">
                <img src="/resources/images/download-android.png" alt="" style="vertical-align: middle;"> Скачать
              </a>
            </div>
          </div>
        </div>

        <div class="col col--5 d-flex justify-content-end">
          <img src="/resources/images/hand.png" alt="" class="image">
        </div>
      </div>

    </div>
  </section>

  <section class="background tasks-catalogue">
    <div class="container">

      <div class="text-center color-white tasks-catalogue__title">
        <h2>Каталог заданий</h2>
        <p>Что заказывают на ITcase сейчас</p>
      </div>

      <div class="swiper-container slider-vertical">
        <div class="swiper-wrapper">

          <!-- -->
          @foreach ($tenders as $tender)
          <div class="swiper-slide">
            <div class="row">
              <div class="col col--33 slide-left">
                <figure>
                  <img src="{{ optional($tender->files()->first())->path }}" alt="">

                  <figcaption>
                    <a href="#">
                      <img src="{{ $tender->categoryIcon() }}" alt="">
                    </a>
                  </figcaption>
                </figure>

              </div>

              <div class="col col--66 slide-right">
                <div>
                  <h3>{{ $tender->title }}</h3>
                  <ul class="task-data">
                    <li class="task-address">
                      Юнусабадский район, улица Янги <br>
                      Шахар, Ташкент, Узбекистан
                    </li>

                    <li class="task-money">
                      Оплата наличными <br>
                      Бюджет: <strong>{{ $tender->budget }} сум</strong>
                    </li>

                    <li class="task-date">
                      Опубликован: <span>{{ $tender->published_at->format('d.m.Y') }}</span> <br>
                      Крайний срок приема заявок: <span>{{ $tender->deadline->format('d.m.Y') }}</span>
                    </li>
                  </ul>

                  <a href="{{ route('site.tenders.category', $tender->slug) }}" class="button button--task">Отозваться на задание</a>
                </div>
              </div>
            </div>

          </div>
          @endforeach
          <!-- -->
        </div>
        <div class="swiper-pagination slider-vertical-pagination"></div>
      </div>


    </div>
  </section>

  <section class="blog">
    <div class="container">
      <div class="text-center blog__title section-title">
        <h2>Новые публикации в <a href="#">блоге</a> itcase</h2>
        <p>Хотите стать героем наших историй? Это просто! <a href="{{ route('site.tenders.common.create') }}">Разместите задание</a> или <a href="{{ route('site.account.contractor.professional') }}">станьте
            исполнителем</a>.</p>
      </div>

      <div class="swiper-container slider-blog">
        <div class="swiper-wrapper">

          <!-- -->
          @foreach ($posts as $post)
          <div class="swiper-slide post">
            <a href="{{ route('site.blog.main', $post->slug) }}" class="post-link">
              <figure>
                <img src="{{ $post->getImage() }}" alt="">
              </figure>


              <span class="post__title">{{ $post->title }}</span>
            </a>


          </div>
          @endforeach
          <!-- -->
        </div>

        <div class="slider-pagination"></div>
      </div>



    </div>
  </section>


  <section class="vacancies">
    <div class="container">
      <div class="text-center color-white vacancies__title">
        <h2>Популярные вакансии в Узбекистане</h2>
        <p>itcase сервис, где работа найдётся всегда!</p>
      </div>


      <div class="row mt64">
        <div class="col col--33">
          <h4>Вакансии дня в Ташкенте</h4>

          <ul class="vacancies__list">
            @foreach ($vacancies as $vacancy)
            <li>
              <a href="#">{{ $vacancy->title }}</a>
              {{ $vacancy->budget }} <br>
              {{ $vacancy->address }}
            </li>
            @endforeach
          </ul>
        </div>

        <div class="col col--33 pl50">
          <h4>Работа по профессиям</h4>

          <ul class="vacancies__list">
            @foreach ($vacancyCategories as $category)
            <li>
              <a href="#">{{ $category->title }}</a>
            </li>
            @endforeach
          </ul>
        </div>

        <div class="col col--33 pl73">
          <h4>Работы по городам</h4>

          <ul class="vacancies__list vacancies__list--double">
            <li>
              <a href="#">Андижан</a>
              {{ $vacanciesCount['andijan'] }} вакансии
            </li>


            <li>
              <a href="#">Бухара</a>
              {{ $vacanciesCount['bukhara'] }} вакансии
            </li>


            <li>
              <a href="#">Джизак</a>
              {{ $vacanciesCount['jizzakh'] }} вакансии
            </li>


            <li>
              <a href="#">Кашкадарья</a>
              {{ $vacanciesCount['qashqadaryo'] }} вакансии
            </li>


            <li>
              <a href="#">Навои</a>
              {{ $vacanciesCount['navoiy'] }} вакансии
            </li>

            <li>
              <a href="#">Наманган</a>
              {{ $vacanciesCount['namangan'] }} вакансии
            </li>

            <li>
              <a href="#">Самарканд</a>
              {{ $vacanciesCount['samarqand'] }} вакансии
            </li>


            <li>
              <a href="#">Сурхандарья</a>
              {{ $vacanciesCount['surxondaryo'] }} вакансии
            </li>

            <li>
              <a href="#">Сырдарья</a>
              {{ $vacanciesCount['sirdaryo'] }} вакансии
            </li>

            <li>
              <a href="#">Ташкент</a>
              {{ $vacanciesCount['tashkent'] }} вакансии
            </li>

            <li>
              <a href="#">Фергана</a>
              {{ $vacanciesCount['fergana'] }} вакансии
            </li>

            <li>
              <a href="#">Хорезм</a>
              {{ $vacanciesCount['xorazm'] }} вакансии
            </li>

            <li>
              <a href="#">Каракалпакстан</a>
              {{ $vacanciesCount['karakalpakstan'] }} вакансии
            </li>
            
          </ul>
        </div>
      </div>

      <div class="text-center mt90">
        <a href="#" class="button button--simple">Еще вакансии</a>
      </div>

    </div>
  </section>


  <section class="soon">
    <div class="container">
      <div class="text-center section-title">
        <h2>Скоро в itcase.com</h2>
        <p>Наши сервисы в разработке</p>
      </div>


      <div class="swiper-container slider-soon">
        <div class="swiper-wrapper">

          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <figure>
                <img src="/resources/images/ittaxi.svg" alt="">
              </figure>
            </a>
          </div>
          <!-- -->


          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <figure>
                <img src="/resources/images/itmoney.svg" alt="">
              </figure>
            </a>
          </div>
          <!-- -->


          <!-- -->
          <div class="swiper-slide">
            <a href="#">
              <figure>
                <img src="/resources/images/itcar.svg" alt="">
              </figure>
            </a>
          </div>
          <!-- -->
        </div>

        <div class="slider-pagination"></div>
      </div>
    </div>
  </section>


  <footer class="footer">
    <div class="container">
      <div class="row footer__row">
        <div class="col">
          <h4>Аккаунт</h4>

          <ul>
            <li>
              <a href="{{ route('site.tenders.index') }}">Каталог заданий</a>
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
                <a href="/itcase.apk">
                  <img src="/resources/images/googleplay-black.svg" alt="">
                </a>
              </li>
            </ul>

            <ul class="app-info__list" style="margin-left: 10px; text-align: center;">
              <p style="text-align: center; font-size: 15px; margin-top: 20px; margin-bottom: 20px;">А также можете скачать с нашего сайта</p>
              <li style="margin-bottom: 5px;">
                <a href="/itcase.apk">
                  <img src="/resources/images/download-android.png" alt="" style="vertical-align: middle;"> Скачать
                </a>
              </li>
            </ul>

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
            <a href="{{ route('site.privacy.policy') }}">Правила сервиса</a>
            <a href="{{ route('site.privacy.policy') }}"> Оферта</a>
            <a href="{{ route('site.privacy.policy') }}">Политика конфиденциальности</a>
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