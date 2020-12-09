@extends('site.layouts.app')


@section('title')
    VID - тендерная площадка
@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')
<section class="section-banner" style="background-image: url({{ asset('front/images/banner-1.jpg') }})">
    <div class="banner-content">
      <div class="container">
        <div class="banner-item">
        <h1 class="banner-title">Тендерная площадка digital-услуг</h1>
        <div class="banner-sub-title">Сервис помогает организовать тендер на digital-услуги </div>
        <div class="search-form-adv">
          <div class="row no-gutters">
          <div class="col-lg-12">
            <div class="row no-gutters">
              <div class="col-2"></div>
              <div class="col-8" style="text-align:center">


                <form class="form-inline">
                  <div class="form-group mb-2">
                    <h3 class="mx-sm-3 mb-2" style="color:white">Мне требуется</h3>

                  </div>
                  <div class="form-group mx-sm-5 mb-2">

                    <select class="form-control dropdown-primary">
                      <option>Разработка сайта</option>
                      <option>Поисковая оптимизация</option>
                      <option>Разработка приложений</option>
                      <option>Контекстная реклама</option>
                      <option>Маркетинг, SMM, PR</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success mb-2">Организовать тендер</button>
                </form>



              </div>
              <div class="col-2"></div>
            </div>
          </div>

          </div>
        </div>
        </div>
      </div>
    </div>
    </section>

    <section class="popular-category bg-white">
      <div class="container">
        <div class="section-heading text-center">
          <h2 class="title">Выберите услугу</h2>
        </div>
        <div class="row no-gutters category-list">
          <div class="col-sm-6 col-lg">
            <div class="category-single"><span class="category-single-icon"><i class="fas fa-book-reader"></i></span>
              <div class="category-signle-content">
                <h3>Разработка сайтов</h3>

              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg">
            <div class="category-single"><span class="category-single-icon"><i class="fas fa-arrow-alt-circle-up"></i></span>
              <div class="category-signle-content">
                <h3>Поисковая оптимизация</h3>

              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg">
            <div class="category-single"><span class="category-single-icon"><i class="fas fa-code"></i></span>
              <div class="category-signle-content">
                <h3>Разработка приложений</h3>

              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg">
            <div class="category-single"><span class="category-single-icon"><i class="fas fa-desktop"></i></span>
              <div class="category-signle-content">
                <h3>Контекстная рекламаs</h3>

              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg">
            <div class="category-single"><span class="category-single-icon"><i class="fas fa-comment-alt"></i></span>
              <div class="category-signle-content">
                <h3>Маркетинг, SMM, PR</h3>

            </div>
            </div>
          </div>

        </div>

      </div>
    </section>

    <section class="popular-category bg-dark">
      <div class="container">
        <div class="section-heading text-center">
          <h2 class="title text-light">Сайт запущен 6 июля 2016 г. На 3 Апреля 2020 организовано: 4301 тендер. Из них: </h2>
        </div>
        <div class="row no-gutters category-list">
          <div class="col-sm-6 col-lg">
            <div class="category-single" style="border-right:1px solid white"><span class="category-single-icon"></span>
              <div class="category-signle-content">
                <h2 class="text-primary">2761</h2>
              <div class="text">На разработку сайтов</div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg">
            <div class="category-single" style="border-right:1px solid white"><span class="category-single-icon"></span>
              <div class="category-signle-content">
                <h2 class="text-primary">478</h2>
              <div class="text">На поисковую оптимизацию</div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg">
            <div class="category-single" style="border-right:1px solid white"><span class="category-single-icon"></span>
              <div class="category-signle-content">
                <h2 class="text-primary">324</h2>
              <div class="text">На контекстную рекламу</div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg">
            <div class="category-single" style="border-right:1px solid white"><span class="category-single-icon"></span>
              <div class="category-signle-content">
                <h2 class="text-primary">563</h2>
              <div class="text">На мобильную разработку</div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg">
            <div class="category-single"><span class="category-single-icon"></span>
              <div class="category-signle-content">
                <h2 class="text-primary">375</h2>
              <div class="text">На маркетинг, SMM, PR</div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>



    <section class="how-it-work bg-white">
      <div class="container">
        <div class="section-heading text-center">
          <h2 class="title">Как это работает</h2>
        </div>
        <div class="row">
          <div class="col-sm-6 col-md-3">
            <div class="how-it-work-box"><span class="img"><i class="fas fa-bullhorn"></i></span>
              <h3>Опубликуйте задачу</h3>
            <div class="text text-center">Расскажите о себе и своих задачах — и сервис сам подберет оптимальных исполнителей</div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="how-it-work-box"><span class="img"><i class="fas fa-align-justify"></i></span>
              <h3>Получайте предложения</h3>
            <div class="text text-center">Исполнители откликнутся на вашу заявку и вышлют коммерческое предложение</div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="how-it-work-box"><span class="img"><i class="fas fa-chess"></i></span>
              <h3>Общайтесь с исполнителями</h3>
            <div class="text text-center">Общайтесь с исполнителями в удобном интерфейсе VID</div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="how-it-work-box"><span class="img"><i class="fas fa-check"></i></span>
              <h3>Выбирайте победителя</h3>
            <div class="text text-center">Сравните опыт исполнителей, стоимость и сроки работ — и выберите победителя</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section-banner" style="background-image: url({{ asset('front/images/video-bg.jpg') }});">
    <div class="container">
      <div class="section-heading text-center">
        <h2 class="title text-light">Свежие тендеры</h2>
      </div>
      <div class="row pb-5">
        <div class="col-md-6 single-card-info">
          <div class="card-info zoom bg-light rounded">

            <div class="card-info-body">
              <h3 class="card-info-title text-dark"><a href="">Web-аналитика интернет-магазина </a></h3>
            <div class="card-info-text ">До 25000000 сум</div>
            </div>
          </div>
        </div>
        <div class="col-md-6 single-card-info">
          <div class="card-info zoom bg-light rounded">

            <div class="card-info-body">
              <h3 class="card-info-title text-dark"><a href="">Вести страницу в Facebook </a></h3>
            <div class="card-info-text">До 3000000 сум</div>
            </div>
          </div>
        </div>

      </div>
      <div class="row pb-5">
        <div class="col-md-6 single-card-info">
          <div class="card-info zoom bg-light rounded">

            <div class="card-info-body">
              <h3 class="card-info-title text-dark"><a href="">Сайт для магазина zero waste people  </a></h3>
            <div class="card-info-text ">До 10000000 сум</div>
            </div>
          </div>
        </div>
        <div class="col-md-6 single-card-info">
          <div class="card-info zoom bg-light rounded">

            <div class="card-info-body">
              <h3 class="card-info-title text-dark"><a href="">Перенос сайта на новую CMS  </a></h3>
            <div class="card-info-text">До 3000000 сум</div>
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-md-6 single-card-info">
          <div class="card-info zoom bg-light rounded">

            <div class="card-info-body">
              <h3 class="card-info-title text-dark"><a href="">Мобильное приложение перевозчика </a></h3>
            <div class="card-info-text ">До 25000000 сум</div>
            </div>
          </div>
        </div>
        <div class="col-md-6 single-card-info">
          <div class="card-info zoom bg-light rounded">

            <div class="card-info-body">
              <h3 class="card-info-title text-dark"><a href="">Предлагаем Вам рассмотреть возможность создания... </a></h3>
            <div class="card-info-text">До 3000000 сум</div>
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <button class="btn btn-success btn-lg btn-block">Посмотреть все тендеры</button>
      </div>
    </div>

    </section>

    <section class="section-pricing bg-grey pt-2">
      <div class="container">
        <div class="section-heading text-center">
          <h2 class="title">Пользователи о VID</h2>
        </div>
        <div class="best-pricing">

        </div>
        <div class="list">
          <div class="candidate-item hover">
            <div class="candidate-img"><a href="17_candidate_details.html"><img src="assets/images/images-2-100x100-2.png" alt="Robert Hayes"></a></div>
            <div class="candidate-content">
              <div class="row align-items-center">
              <div class="col-md-4">
                <div class="candidate-info">
                  <h3 class="title-job"><a href="17_candidate_details.html">Матвей Родионов</a></h3>
                  <div class="date-job"><i class="fa fa-check-circle"></i>factor-sport.ru</div>
                </div>
              </div>
              <div class="col-md-8">
                Понравилось: достаточно быстро, просто, есть из кого выбрать. Не понравилось: кто-то в тендере на площадке отвечает, кто-то на емайл пишет, а кто-то и туда и туда, в итоге только пару дней понадобилось чтобы всех в эксельку записать кто откуда и куда написал, чтоб дальше начать с ними работать, и смотреть портфолио каждого. А также было всего 9 дней на принятие решения, если я правильно помню, написало народа много, тендер закончился, еще не со всеми поговорил, а время уже к закрытию идет, в итоге пришлось сильно поторопиться.
              </div>
              </div>
            </div>
          </div>
          <div class="candidate-item hover">
            <div class="candidate-img"><a href="17_candidate_details.html"><img src="assets/images/images-2-100x100-2.png" alt="Robert Hayes"></a></div>
            <div class="candidate-content">
              <div class="row align-items-center">
              <div class="col-md-4">
                <div class="candidate-info">
                  <h3 class="title-job"><a href="17_candidate_details.html">Сергей Гасанбеков</a></h3>
                  <div class="date-job"><i class="fa fa-check-circle"></i>Товарнаябиржа.рус</div>
                </div>
              </div>
              <div class="col-md-8">
                Мы в первый раз размещали у Вас на площадке тендер. Очень приятно удивлен, понравилась работа сервиса. Понятность, сроки – очень важно, что участники проявляли заинтересованность получить заказ и предложений было много. Впредь будем пользоваться Вашим сервисом.
              </div>
              </div>
            </div>
          </div>
          <div class="candidate-item hover">
            <div class="candidate-img"><a href="17_candidate_details.html"><img src="assets/images/images-2-100x100-2.png" alt="Robert Hayes"></a></div>
            <div class="candidate-content">
              <div class="row align-items-center">
              <div class="col-md-4">
                <div class="candidate-info">
                  <h3 class="title-job"><a href="17_candidate_details.html">Санжар Самсара</a></h3>
                  <div class="date-job"><i class="fa fa-check-circle"></i>sam8sara.com</div>
                </div>
              </div>
              <div class="col-md-8">
                Все очень профессионально, удобно. Замечаний и предложений нет, ваш сервис очень помог!
              </div>
              </div>
            </div>
          </div>
          <button class="btn btn-success btn-lg btn-block">Показать больше</button>
        </div>
      </div>
    </section>

    <section class="section-pricing bg-grey">
      <div class="section-heading text-center">
        <h2 class="title">Нами уже воспользовались</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-1.jpg') }}" class="img-fluid">
          </div>
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-2.jpg') }}" class="img-fluid">
          </div>
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-3.jpg') }}" class="img-fluid">
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-4.jpg') }}" class="img-fluid">
          </div>
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-5.jpg') }}" class="img-fluid">
          </div>
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-6.jpg') }}" class="img-fluid">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-7.jpg') }}" class="img-fluid">
          </div>
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-8.jpg') }}" class="img-fluid">
          </div>
          <div class="col-sm-4 col-lg-4 text-center p-3">
            <img src="{{ asset('front/images/job-thumb-9.jpg') }}" class="img-fluid">
          </div>
        </div>
      </div>
    </section>




@endsection
