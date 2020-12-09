@extends('site.layouts.app')

@section('title', 'Инфо')

@section('meta')
    <!-- МЕТА ТЕГИ -->
@endsection

@section('css')
    <style>
     .footer-site{
       margin-top:-40px;

     }
    </style>
@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')
<section class="bg-white" style="margin-top:-42px;">
    <div class="container pt-3">
        <div class="section-heading text-center">
            <h2 class="title pb-3">Как мы можем помочь?</h2>
                <nav>
                <div class="nav nav-tabs btn-group d-inline" id="nav-tab" role="tablist">
                  <a class="btn btn-success" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Я хочу нанять</a>
                  <a class="btn btn-success" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Я ищу работу</a>

                </div>
              </nav>
        </div>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row no-gutters category-list text-center pt-2">
                <div class="col-md-6">
                  <h2 class="pt-2 pb-2">Какого специалиста я могу нанять? </h2>
                  <p class="info pt-2 pb-2">
                    У нас есть специалисты, представляющие все технические, профессиональные и творческие области.
                  </p>
                  <a href="{{ route('site.tenders.common.create')}}" class="btn btn-success">Опубликовать проект</a>
                </div>
                <div class="col-md-6">
                  <img src="{{ asset('images/info_m/map-72359494.png') }}">
                </div>
            </div>
          </div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="row no-gutters category-list pt-2">
                <div class="col-md-6">
                  <h2 class="pt-2 pb-2">Какую работу я могу получить? </h2>
                  <p class="info pt-2 pb-2">
                    Вы можете найти практически любую работу, какую только сможете вообразить.
                    У нас есть рабочие места от доставки до разработки веб-сайтов.
                    На vid.uz вы можете найти множество подходящих вам заказов.
                    <br><br>
                    Просто заполните свой профиль и сообщите нам свои навыки,
                    чтобы мы могли подобрать вам подходящую работу
                  </p>
                  <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
                </div>
                <div class="col-md-6">
                  <img src="{{ asset('images/info_m/jobs-3a2ec70b.png') }}">
                </div>
            </div>
          </div>
        </div>
    </div>
</section>

<section class="section-news bg-white border-top mb-0" style="margin-top:-50px">
    <div class="container">
        <div class="section-heading pt-5 text-center">
            <h5>
                Просто дайте нам подробную информацию о работе, которую вам нужно выполнить,
                и наши фрилансеры выполнят ее быстрее, лучше и дешевле, чем вы можете себе представить.<br>
                Это включает в себя:
            </h5>
        </div>
        <div class="row text-center">
          <div class="col-md-4">
            <svg width="61" height="70" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path d="M15.2 25.717c-4.238-2.07-7.2-6.798-7.2-12.3C8 6.007 10.459 0 20 0s12 6.007 12 13.417c0 5.275-2.723 9.84-6.684 12.031.049 2.426.441 3.987 1.177 4.683 1.182 1.12 5.96 1.707 9.228 2.67 2.179.643 3.605 2.36 4.279 5.148V46H0v-7.743c.6-2.788 1.988-4.52 4.164-5.196 3.265-1.013 9.968-1.638 10.505-2.93.32-.77.498-2.241.531-4.414z" id="a"/><rect id="b" x="3" y="74" width="54" height="5" rx="2"/></defs><g fill="none" fill-rule="evenodd"><g transform="translate(11)"><use fill-opacity=".2" fill="#139FF0" xlink:href="#a"/><path stroke="#139FF0" stroke-width="1.5" d="M.75 38.338v6.912h38.5v-7.21c-.622-2.493-1.861-3.964-3.742-4.519-.813-.24-1.703-.455-3.111-.767l-1.318-.29c-3.022-.67-4.36-1.085-5.102-1.788-.925-.876-1.358-2.601-1.41-5.213l-.01-.452.396-.219c3.817-2.112 6.297-6.488 6.297-11.375C31.25 5.029 28.064.75 20 .75S8.75 5.03 8.75 13.417c0 5.103 2.705 9.636 6.78 11.626l.428.21-.008.476c-.035 2.263-.22 3.806-.588 4.69-.448 1.075-1.73 1.435-6.537 2.366l-.13.025c-2.356.456-3.37.676-4.309.968-1.878.583-3.082 2.067-3.636 4.56z"/></g><path d="M4.691 41h52.407a3 3 0 0 1 2.973 3.402L55.936 75H5.643L1.715 44.382A3 3 0 0 1 4.691 41z" stroke="#139FF0" stroke-width="1.5" fill="#FFF"/><path fill="#139FF0" d="M31.856 55.978L34.118 53h6.322l-4.689 2.978-1.11 6.114L27.69 68l1.324-7.5L24 55.978h3.21l-.673-2.589z"/><g transform="translate(1)"><use fill="#FFF" xlink:href="#b"/><rect stroke="#139FF0" stroke-width="1.5" x="3.75" y="74.75" width="52.5" height="3.5" rx="1.75"/></g></g></svg>
            <p>
              Поиск фрилансера из любых отраслей и с разными опытом работы.
            </p>
          </div>
          <div class="col-md-4">
            <svg width="60" height="70" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M20 1h19" stroke="#139FF0" stroke-width="1.5" stroke-linecap="square"/><g transform="translate(1 2)"><circle stroke="#139FF0" stroke-width="1.5" cx="29" cy="37.667" r="29"/><circle fill="#139FF0" opacity=".2" transform="rotate(-55 29 37.667)" cx="29" cy="37.667" r="16.111"/><path d="M30.611 36.056L43.5 23.166M24.972.611v7m6.445-7v7" stroke="#139FF0" stroke-width="1.5" stroke-linecap="square"/></g></g></svg>
            <p>
              Работа по фиксированной цене
            </p>
          </div>
          <div class="col-md-4">
            <svg width="56" height="70" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><rect x=".75" y=".75" width="45.5" height="52.5" rx="4" stroke="#139FF0" stroke-width="1.5"/><g stroke="#0093F1" stroke-width="1.5"><path d="M6 15c.844 2.136 1.844 3.136 3 3 .31-.077 1.644-2.41 4-7M6 27c.844 2.136 1.844 3.136 3 3 .31-.077 1.644-2.41 4-7M6 39c.844 2.136 1.844 3.136 3 3 .31-.077 1.644-2.41 4-7"/><path d="M19.5 12.75h20.02m-20.02 4h13.02m-13.02 8h16.02m-16.02 4h22.023m-22.023 8h17.02m-17.02 4h19.02" stroke-linecap="square"/></g><g transform="translate(32 34)"><circle stroke="#139FF0" stroke-width="1.5" fill="#FFF" cx="11.5" cy="11.5" r="11.5"/><path d="M16.824 15.228A6.5 6.5 0 1 0 6.176 7.772a6.5 6.5 0 0 0 10.648 7.456z" fill="#D0ECFC"/><path d="M11.698.198v1.317m0 19.97v1.317m.199-15.319v4.7m-4.363.317h4.36M0 11.5h1.5m20 0h1.103" stroke="#139FF0" stroke-linecap="square" stroke-width="1.5"/></g></g></svg>
            <p>
              Работа, требующая определенных навыков, затрат или требований по дедлайну.
            </p>
          </div>
        </div>
    </div>
</section>
<section class="section-news bg-dark mb-0">
    <div class="container">

        <div class="row">
            <div class="col-md-6 pt-5">
              <img src="{{ asset('images/info_m/how-to-employer-c433ccda.png') }}">
            </div>
            <div class="col-md-6 pt-5">
              <div class="section-heading  text-center text-light">
                  <h1>
                    Как это работает?
                  </h1>
              </div>
                <ol class="list-group text-light">
                  <li class="pt-2">
                    <h3>Опубликовать проект</h3>
                    <p>
                      Это всегда бесплатно опубликовать свой проект. Вы автоматически начнете получать предложения от наших фрилансеров.
                      Кроме того, вы можете просмотреть таланты, доступные на нашем сайте, и вместо этого сделать прямое предложение фрилансеру.
                    </p>
                  </li>
                  <li class="pt-3">
                    <h3>Выберите идеального фрилансера</h3>
                    <ul>
                      <li>Просмотр профилей фрилансеров</li>
                      <li>Чат в режиме реального времени</li>
                      <li>Сравните предложения и выберите лучший</li>
                    </ul>
                  </li>
                  <li class="pt-3">
                    <h3>Безопасная оплата</h3>
                    <p>Все оплаты проходят через нашу площадку и фрилансер получит свои деньги только тогда когда вы довольны. </p>
                  </li>
                </ol>
                <a href="{{ route('site.tenders.index') }}" class="btn btn-success">Просмотр конкурсов</a>
            </div>
        </div>
    </div>
</section>
<section class="section-news bg-white mb-0">
    <div class="container">
      <div class="row pt-5">
        <div class="col-md-6">
          <h3>Контролировать. Всегда на связи с исполнителем</h3>
          <p class="pt-3">
            Используйте наш чат, чтобы отслеживать прогресс, отслеживать сроки, общаться, делиться вашими правками по заказу и делать многое другое.<br><br>
            Мы даже можем вас связать в видео конференции с исполнителем, чтобы вы были в курсе, что происходит с вашим проектом, что делается и что еще нужно сделать.
          </p>
        </div>
        <div class="col-md-6">
          <img src="{{ asset('images/info_m/mobile-desktop-app-763228e3.png') }}">
        </div>
      </div>
      <div class="row pt-5">
        <div class="col-md-6">
          <img src="{{ asset('images/info_m/safety-fb581158.png') }}">
        </div>
        <div class="col-md-6">
          <h3>Безопасно и надежно.</h3>
          <p class="pt-3">VID.UZ - это сообщество, которое ценит ваше доверие и безопасность как наш приоритет номер один:</p>
          <ul class="pt-2">
            <li>Современная безопасность ваших средств. Все транзакции защищены с помощью DigiCert 4096-битного шифрования SSL. </li>
            <li class="pt-3">Наши представители доступны 24/7, чтобы помочь вам с любыми вопросами. </li>
          </ul>
        </div>
      </div>
    </div>
</section>
<section class="bg-light">
    <div class="container pt-3">
        <div class="section-heading text-center pb-5">
            <h2 class="title pb-3">И так, чего же ты ждешь?</h2>
            <p class="pt-3">Опубликуйте проект сегодня и получите предложения от талантливых фрилансеров. </p>
            <a href="{{ route('register') }}" class="btn btn-success">Регистрация</a>
        </div>
    </div>
</section>
@endsection

@section('js')
    <!-- СКРИПТЫ -->
@endsection
