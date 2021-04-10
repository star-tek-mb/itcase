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

@section('content')

    <section class="section-banner" style="background-image: url({{ asset('front/images/banner-1.jpg') }})">
        <div class="banner-content">
            <div class="container">

                <div class="banner-item">
                  <!-- <h4 class="banner-sub-title">VID присоединяется к борьбе с Covid-19. Все услуги на площадке на время карантина становятся бесплатными </h4> -->
                    <h2 class="banner-title">2 Лучших способа найти специалиста для продвижения вашего
                        бизнеса</h2>
                    <div class="banner-sub-title">Добавьте в конкурс на выполнение вашего заказа исполнителя
                        сами или используйте автоматическую систему подбора
                    </div>
                    <div class="search-form-adv">
                        <div class="row no-gutters">


                                    <div class="col-md-3">
                                        <div class="form-group search-key">

                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center p-1">

                                        <a class="btn btn-light-green" href="{{ route('site.contractors.index') }}">Хочу добавить сам <i class="fas fa-chevron-right"></i>
                                            <div class="form-group search-location">

                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 text-center p-1">
                                        <a class="btn btn-light-green" href="{{ route('site.tenders.common.create') }}">
                                          Подберет система <i class="fas fa-chevron-right"></i>

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
                                <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}" class="category-single__title"><h3>{{ $category->getTitle() }}<span class="count">({{ $category->getAllCompaniesCount() }})</span></h3></a>
                                <div class="text">
                                    @foreach ($category->categories()->limit(5)->get() as $child)
                                        <a href="{{ route('site.catalog.main', $child->getAncestorsSlugs()) }}" class="category-single__child">{!! $child->ru_title !!},</a>
                                    @endforeach
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
                                            class="company-name">Опубликован: {{ \Carbon\Carbon::create($tender->published_at)->format('d.m.Y') }}</span>
                                        <div class="date-job"><i class="fa fa-check-circle"></i><span
                                                class="company-name">Крайний срок приема заявок: {{ \Carbon\Carbon::create($tender->deadline)->format('d.m.Y') }}</span>
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
    <section class="section-video" style="background-image: url(/front/images/video-bg.jpg)">
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
                                <h3 class="card-info-title">{{ $comment->who_set }}</h3>
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

        <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Store",
      "image": [
        "https://lh3.googleusercontent.com/proxy/RomJGetxyExSuPoNnZJKatWVJtl5XU3OFfcnpg57HN12QIQ9yG6uoK4gDm74Cu6OK088oxzsi_ls_IExxfZ5spEj5TZwR9oILWSPkR00SA9UF8GnntVLiLf-VWb5FSI2PdlfJg"
       ],
      "@id": "vid.uz",
      "name": "Каталог фриланс исполнителей и компаний для продвижения бизнеса",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Yunusobod 13",
        "addressLocality": "Tashkent",
        "addressRegion": "UZ",
        "postalCode": "100114",
        "addressCountry": "UZ"
      },
      "review": {
        "@type": "Review",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "4",
          "bestRating": "5"
        },
        "author": {
          "@type": "Person",
          "name": "Murad Ikramhodjaev"
        }
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 41.2825125,
        "longitude": 69.1392828
      },
      "url": "https://www.vid.uz",
      "telephone": "+998909408196",
      "priceRange": "$$$",
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Monday",
            "Tuesday"
          ],
          "opens": "9:00",
          "closes": "22:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Wednesday",
            "Thursday",
            "Friday"
          ],
          "opens": "9:00",
          "closes": "23:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Saturday",
          "opens": "9:00",
          "closes": "23:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Sunday",
          "opens": "9:00",
          "closes": "22:00"
        }
      ]

    }
    </script>

    </section>
@endsection
