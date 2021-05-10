@extends('site.layouts.app')

@section('title', 'Биржа работы | Сайт для фрилансера и компаний')

@section('meta')
    <meta name="title" content="фриланс биржа узбекистана | фрилансер сайт">
@endsection
@section('meta')
    <meta name="description" content="Каталог фриланс услуг и услуг компаний по продвижению бизнеса. Интернет реклама в Ташкенте. Создание сайта в Ташкенте. Реклама в метро в Ташкенте. Наружная реклама в Ташкенте и многое другое">
@endsection
@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('css')

  <!-- Vendor CSS Files -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.1/assets/owl.carousel.min.css'>
  <link rel='stylesheet' href='https://themes.audemedia.com/html/goodgrowth/css/owl.theme.default.min.css'>

  <!-- Template Main CSS File -->
  <link href="/ext/style.css" rel="stylesheet">
@endsection

@section('content')

    <section class="section-banner" style="background-image: url({{ asset('front/images/banner-1.jpg') }})">
        <div class="banner-content">
            <div class="container">

                <div class="banner-item">
                    <h2 class="banner-title">2 Лучших способа найти специалиста для продвижения вашего
                        бизнеса</h2>
                    <div class="banner-sub-title">Добавьте в конкурс на выполнение вашего заказа исполнителя
                        сами или используйте автоматическую систему подбора
                    </div>
                    <div class="search_block_box">
                        <input type="email" placeholder="Чем вам помочь ? .......">
                        <span class="search_box_icon"><i class="fa fa-search"></i></span>
</div>
                    <div class="search-form-adv">
                        <div class="row no-gutters">


                                    <div class="col-md-3">
                                        <div class="form-group search-key">

                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center p-1">

                                        <a class="btn btn-light-green" href="{{ route('site.contractors.index') }}">Хочу добавить сам <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M7.21427 3.35716H4.64283V0.785722C4.64283 0.430669 4.35501 0.142853 3.99996 0.142853C3.64491 0.142853 3.35709 0.430669 3.35709 0.785722V3.35716H0.785691C0.430639 3.35716 0.142822 3.64498 0.142822 4.00003C0.142822 4.35508 0.430639 4.64286 0.785691 4.64286H3.35713V7.2143C3.35713 7.56935 3.64494 7.85717 4 7.85717C4.35505 7.85717 4.64283 7.56931 4.64283 7.2143V4.64286H7.21427C7.56932 4.64286 7.85713 4.35504 7.85713 3.99999C7.85713 3.64494 7.56928 3.35716 7.21427 3.35716Z" fill="white"/>
</svg>

                                            <div class="form-group search-location">

                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 text-center p-1">
                                        <a class="btn btn-light-green" href="{{ route('site.tenders.common.create') }}">
                                          Подберет система <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M7.21427 3.35716H4.64283V0.785722C4.64283 0.430669 4.35501 0.142853 3.99996 0.142853C3.64491 0.142853 3.35709 0.430669 3.35709 0.785722V3.35716H0.785691C0.430639 3.35716 0.142822 3.64498 0.142822 4.00003C0.142822 4.35508 0.430639 4.64286 0.785691 4.64286H3.35713V7.2143C3.35713 7.56935 3.64494 7.85717 4 7.85717C4.35505 7.85717 4.64283 7.56931 4.64283 7.2143V4.64286H7.21427C7.56932 4.64286 7.85713 4.35504 7.85713 3.99999C7.85713 3.64494 7.56928 3.35716 7.21427 3.35716Z" fill="white"/>
</svg>


                                        </a>
                                    </div>
                                    <div class="col-md-3">

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
                <h2 class="title">Каталог исполнителей</h2>
            </div>
            <div class="row no-gutters category-list">
                @foreach($parentCategories as $category)
                    <div class="col-sm-6 col-lg-4">
                        <div class="category-single"><span class="category-single-icon"><img src="{{ $category->getImage() }}" alt=""></span>
                            <div class="category-signle-content">
                                <div>
                                <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}" class="category-single__title">
                                    <h3>{{ $category->getTitle() }}</h3>
                                    <div class="count_block"><span class="count">{{ $category->getAllCompaniesCount() }}</span>Заданий</div>
                                </a>
                                <div class="text">
                                    @foreach ($category->categories()->limit(5)->get() as $child)
                                        @if (!$loop->first), @endif<a href="{{ route('site.catalog.main', $child->getAncestorsSlugs()) }}" class="category-single__child">{!! $child->ru_title !!}</a>
                                    @endforeach
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="category-button text-center"><a class="btn btn-light-green" href="{{ route('site.contractors.index') }}">Посмотреть все категории</a></div>
        </div>
    </section>
    <section class="popular-category bg-white">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="title">Каталог заданий</h2>
            </div>
            <div class="list">
                @foreach($tenders as $tender)
                    <div class="job-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="img-job text-center"><a href="{{ route('site.tenders.category', $tender->slug) }}"></a></div>
                            </div>
                            <div class="col-md-10 job-info">
                                <div class="text">
                                    <h3 class="title-job"><a href="{{ route('site.tenders.category', $tender->slug) }}">{{ $tender->title }}</a></h3>
                                    <div class="date-job">
                                      <i class="fa fa-check-circle"></i><span
                                            class="company-name">Опубликован: {{ $tender->published_at->format('d.m.Y') }}</span>
                                        <div class="date-job"><i class="fa fa-check-circle"></i><span
                                                class="company-name">Крайний срок приема заявок: {{ $tender->deadline->format('d.m.Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="meta-job">
                                        <div class="categories">@foreach($tender->categories as $category){{ $category->getTitle() }} @endforeach</div>
                                        <span class="salary">Бюджет {{ $tender->budget }} сум</span>
                                    </div>
                                    @guest
                                        <a href="{{ route('login') }}" class="add-favourites" data-toggle="tooltip" title="Оставить заявку"><i class="fas fa-plus"></i></a>
                                    @else
                                        @php
                                            $user = auth()->user();
                                        @endphp
                                        @if ($user->hasRole('contractor'))
                                            @if (in_array($user->id, $tender->requests()->pluck('user_id')->toArray()))
                                                <span class="text-primary"><i class="fas fa-check"></i> Вы уже участвуете в этом задании</span>
                                            @else
                                                <button class="add-favourites" type="button" data-toggle="modal"
                                                        data-target="#requestFormModal{{ $tender->id }}" title="Оставить заявку"><div class="h-100 w-100" data-toggle="tooltip" title="Оставить заявку"><i class="fas fa-plus"></i></div>
                                                </button>
                                                <div class="modal fade" id="requestFormModal{{ $tender->id }}" tabindex="-1" role="dialog"
                                                     aria-labelledby="requestFormModelLabel{{ $tender->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="requestFormModelLabel{{ $tender->id }}">Ваша заявка</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('site.tenders.requests.make') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                                <input type="hidden" name="tender_id" value="{{ $tender->id }}">
                                                                <div class="modal-body">
                                                                    <p>Заинтересованы в данной задаче? Сразу отправляйте заявку. Так вы сможете
                                                                        быстрее
                                                                        связаться с заказчиком и обсудить все детали.
                                                                        <b>Бюджет</b> и <b>Cроки</b> в
                                                                        заявке — <b>ориентировочные</b>. Их требуется указать
                                                                        лишь для того, чтобы заказчик понимал ваш уровень цен и скорость работы.
                                                                        При
                                                                        общении с заказчиком вы всегда сможете их пересмотреть.
                                                                        Ваше предложение и дальнейшую переписку увидит только организатор
                                                                        задачи.
                                                                    </p>
                                                                    <div class="form-group">
                                                                        <label for="budget">Бюджет</label>
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-lg-6">
                                                                                <input type="text" required name="budget_from" id="budgetFrom{{ $tender->id }}"
                                                                                       class="form-control" placeholder="500 000">
                                                                            </div>
                                                                            <div class="col-sm-12 col-lg-6">
                                                                                <input type="text" required name="budget_to" id="budgetTo{{ $tender->id }}"
                                                                                       class="form-control" placeholder="1 000 000">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="period">Срок</label>
                                                                        <div class="row">
                                                                            <div class="col-ms-12 col-lg-6">
                                                                                <input type="text" required name="period_from" id="period_from{{ $tender->id }}"
                                                                                       class="form-control" placeholder="2 дня">
                                                                            </div>
                                                                            <div class="col-ms-12 col-lg-6">
                                                                                <input type="text" required name="period_to" id="period_to{{ $tender->id }}"
                                                                                       class="form-control" placeholder="3 дня">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="comment">Комментарий (по желанию)</label>
                                                                        <textarea name="comment" id="comment{{ $tender->id }}" rows="3"
                                                                                  class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                        Закрыть
                                                                    </button>
                                                                    <button class="btn btn-light-green" type="submit">Отправить заявку <i
                                                                            class="fas fa-send"></i></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="category-button text-center"><a class="btn btn-light-green mt-4" href="{{ route('site.tenders.index') }}">Посмотреть Все
                    задания</a></div>
        </div>
    </section>


    <section class="carousel-section">

        <div class="section-title">
        <h2>Популярные услуги</h2>
        </div>

        <div id="services-carousel" class="owl-carousel">

            <div class="service-popular-item" style="background-color: #fef3ed;">
                <div class="service-item-image">
                <img class="service-img" src="/ext/assets/img/courier.bd096ee86d28a4d13c31eb3844d93d5b.svg" alt="">
                </div>
                <div class="service-item-text">
                <div>
                    <h3>Курьерские услуги</h3>
                    <p>от 5000 сум</p>
                </div>
                </div>
            </div>

            <div class="service-popular-item" style="background-color: #ebeaf4;">
                <div class="service-item-image">
                <img class="service-img" src="/ext/assets/img/finishing-work.a79ed8c2ec62a29a09b74c2edfc11a83.svg" alt="">
                </div>
                <div class="service-item-text">
                <div>
                    <h3>Отделочные<br>работы</h3>
                    <p>от 150 000 сум</p>
                </div>
                </div>
            </div>

            <div class="service-popular-item" style="background-color: #f2e7e7;">
                <div class="service-item-image">
                <img class="service-img" src="/ext/assets/img/relocation.9cba7babc52f8611e6a066cabd50a792.svg" alt="">
                </div>
                <div class="service-item-text">
                <div>
                    <h3>Помощь<br>с переездом</h3>
                    <p>от 100 000 сум</p>
                </div>
                </div>
            </div>

            <div class="service-popular-item" style="background-color: #f1e0d5;">
                <div class="service-item-image">
                <img class="service-img" src="/ext/assets/img/university.92fd872cf6bd1f7f042fde9928a09584.svg" alt="">
                </div>
                <div class="service-item-text">
                <div>
                    <h3>Помощь студентам</h3>
                    <p>от 100 000 сум</p>
                </div>
                </div>
            </div>

            <div class="service-popular-item" style="background-color: #e2e1f4;">
                <div class="service-item-image">
                <img class="service-img" src="/ext/assets/img/manicure.9854b58ee4a21c515fc5cc16cd3283cd.svg" alt="">
                </div>
                <div class="service-item-text">
                <div>
                    <h3>Ногтевой сервис</h3>
                    <p>от 50 000 сум</p>
                </div>
                </div>
            </div>

            <div class="service-popular-item" style="background-color: #f2e7e7;">
                <div class="service-item-image">
                <img class="service-img" src="/ext/assets/img/hairdressing.6396daf347ce8146e5c9b17c7ddc7bbe.svg" alt="">
                </div>
                <div class="service-item-text">
                <div>
                    <h3>Парикмахерские<br>услуги</h3>
                    <p>от 25 000 сум</p>
                </div>
                </div>
            </div>

        </div>

    </section>

    <section class="carousel-section">

        <div class="section-title">
        <h2>Популярные услуги</h2>
        </div>

        <div id="offer-carousel" class="owl-carousel offer-carousel">

        <div class="row content">
            <div class="col-md-6 content-img">
            <div>
            <img src="/ext/assets/img/Слой 2.png" class="img-fluid" alt="">
</div>
            </div>
            <div class="col-md-6 right-part">
            <div>
                <h3>Создайте задание</h3>
                <p>Опишите своими словами задачу, которую требуется выполнить.</p>
                <div class="open_page_btn"><a href="#about" class="btn-content">Создать задание</a></div>
            </div>
            </div>
        </div>

        <div class="row content">
            <div class="col-md-6 content-img">
            <div>
            <img src="/ext/assets/img/Слой 1.png" class="img-fluid" alt="">
</div>
            </div>
            <div class="col-md-6 right-part">
            <div>
                <h3>Исполнители предложат вам свои услуги и цены</h3>
                <p>Уже через пару минут вы начнете получать предложения от исполнителей, готовых
                выполнить ваше задание.</p>
                <div class="open_page_btn"><a href="#about" class="btn-content">Исполнители</a></div>
            </div>
            </div>
        </div>

        <div class="row content">
            <div class="col-md-6 content-img">
                <div>
            <img src="/ext/assets/img/Слой 4.png" alt="">
            </div>
            </div>
            <div class="col-md-6 right-part">
            <div>
                <h3>Выберите лучшее предложение</h3>
                <p>Вы сможете выбрать подходящего исполнителя, по разным критериям:</p>
                <ul>
                <li><span><img src="/ext/assets/img/checked.png" alt=""></span> Стоимость услуг</li>
                <li><span><img src="/ext/assets/img/checked.png" alt=""></span> Рейтинг</li>
                <li><span><img src="/ext/assets/img/checked.png" alt=""></span> Отзывы заказчиков</li>
                <li><span><img src="/ext/assets/img/checked.png" alt=""></span> Примеры работ</li>
                </ul>
                <div class="open_page_btn"><a href="#about" class="btn-content">Разместить задание прямо сейчас</a></div>
            </div>
            </div>
        </div>

        </div>

    </section>


    <section class="why-we-section">
        <div class="container">
        <div class="row">
            @foreach ($populars as $popular) 
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch">
                <div class="whywe-box">
                    <a href="{{$popular->url}}">
                        <div class="whywe-image"><img src="{{$popular->getImg()}}" alt="{{$popular->getTitleAttribute()}}"></div>
                        <div class="whywe-title">
                        <h4>{{$popular->getTitleAttribute()}}</h4>
                        </div>
                        <p class="whywe-description">{!! $popular->getContentAttribute() !!}</p>
                    </a>
                </div>
                </div>
            @endforeach

        </div>
        </div>
    </section>



    <section class="download-section">
        <div class="container">
        <div class="row">

            <div class="col-md-6 col-lg-6 download-text-part">
            <div>
                <h3>Персональный помощник в вашем кармане</h3>
                <p>Скачайте наше приложение и пользуйтесь YouDo, где бы вы ни находились.</p>
                <div class="buttons-download">
                <div><a href="#about" class="btn-started">Android</a></div>
                <div><a href="#about" class="btn-started">iOS</a></div>
                <div><a href="#about" class="btn-started">J2ME</a></div>
                <div><a href="#about" class="btn-started">Tizen</a></div>
                <div><a href="#about" class="btn-started">Wear OS</a></div>
                </div>
            </div>
            </div>

            <div class="col-md-6 col-lg-6 download-image-part">
                <div class="download-image">
                <img src="/ext/assets/img/download_hand-13ced686918d5e0b8a92914b8cc87aaf.png" alt="">
                </div>
            </div>

        </div>
        </div>
    </section>

    <section class="section-video" style="background-image: url(/front/images/fon_bottomm.jpg); margin-top: 0px;">
        <div class="container">
            <div class="video-container">
                <div class="section-heading">
                    <h2 class="title">Получи самое выгодное предложение на свой заказ<br> Удаленно и Бесплатно.
                    </h2>
                </div>
                <div class="video-content">
                    <div class="intro">Мы сотрудничаем с более чем 1000 агентствами и фрилансерами по всему
                        Узбекистану. Оставляй заказ и выбери самое выгодное и предложение от исполнителей. Для
                        Заказчика использование платформы АБСОЛЮТНО БЕСПЛАТНО.
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="section-news">
        <div class="container">
            <div class="section-heading">
                <h2 class="title">Комментарии пользователей</h2><a href="">Посмотреть больше <i
                        class="fas fa-long-arrow-alt-right"></i></a>
            </div>
            <div class="row">
                @foreach($comments as $comment)
                    <div class="col-md-4 single-card-info">
                        <div class="card-info">

                            <div class="card-info-body">
                                <h3 class="card-info-title">{{ $comment->author->name }}</h3>
                                <hr>
                                <div class="card-info-text">{!! $comment->comment !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="section-news">
        <div class="container">
            <div class="section-heading">
                <h2 class="title">Последние новости с нашего блога</h2><a href="{{ route('site.blog.index') }}">Посмотреть больше <i
                        class="fas fa-long-arrow-alt-right"></i></a>
            </div>
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-4 single-card-info">
                        <div class="card-info">
                            <div class="card-info-img"><a href="{{ route('site.blog.main', $post->ru_slug) }}"><img
                                        src="{{ $post->getImage() }}"
                                        alt="16 Ridiculously Easy Ways to Find &amp; Keep a Remote Job"></a></div>
                            <div class="card-info-body"><span class="meta">Опубликован {{ $post->created_at }}</span>
                                <h3 class="card-info-title"><a href="{{ route('site.blog.main', $post->ru_slug) }}">{{ $post->getTitle() }}</a></h3>
                                <div class="card-info-text">{!! $post->ru_short_description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section>
@endsection

@section('js')
  <!-- Vendor JS Files -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.1/owl.carousel.min.js'></script>

  <!-- Template Main JS File -->
  <script src="/ext/main.js"></script>
@endsection