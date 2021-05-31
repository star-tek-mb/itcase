@extends('site.layouts.app')

@section('title', 'Фриланс биржа узбекистана | Сайт для фрилансера и компаний')

@section('meta')
    <meta name="title" content="фриланс биржа узбекистана | фрилансер сайт">
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
                    <h2 class="banner-title">2 Лучших способа найти специалиста для продвижения вашего
                        бизнеса</h2>
                    <div class="banner-sub-title">Добавьте в конкурс на выполнение вашего заказа исполнителя
                        сами или используйте автоматическую систему подбора
                    </div>
                    <div class="search-form-adv">
                        <div class="row no-gutters">
                            <div class="col-lg-10">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <div class="form-group search-key">

                                        </div>
                                    </div>
                                    <div class="col-md-3">

                                        <button class="btn btn-light-green">Хочу добавить сам <i
                                                class="fas fa-search"></i>
                                            <div class="form-group search-location">

                                            </div>
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-light-green">Подберет система <i
                                                class="fas fa-search"></i>

                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-form-submit">

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
                <h2 class="title">Каталог исполнителей</h2>
            </div>
            <div class="row no-gutters category-list">
                @foreach($parentCategories as $category)
                    <div class="col-sm-6 col-lg-4">
                        <div class="category-single"><span class="category-single-icon"></span>
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
                                <div class="img-job text-center"><a href="04_job_details.html"></a></div>
                            </div>
                            <div class="col-md-10 job-info">
                                <div class="text">
                                    <h3 class="title-job"><a href="04_job_details.html">{{ $tender->title }}</a></h3>
                                    <div class="date-job"><i class="fa fa-check-circle"></i><span
                                            class="company-name">Опубликован: {{ $tender->created_at }}</span>
                                        <div class="date-job"><i class="fa fa-check-circle"></i><span
                                                class="company-name">Крайний срок приема заявок: {{ $tender->deadline }}</span>
                                        </div>
                                    </div>
                                    <div class="meta-job"><span class="salary">Бюджет {{ $tender->budget }} сум</span></div>
                                    <button class="add-favourites"><i class="far fa-star"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="category-button text-center"><a class="btn btn-light-green" href="{{ route('site.tenders.index') }}">Посмотреть Все
                    Задания</a></div>
        </div>
    </section>
    <section class="section-video" style="background-image: url(/front/images/video-bg.jpg)">
        <div class="container">
            <div class="video-container">
                <div class="section-heading">
                    <h2 class="title">Получи самое выгодное предложение на свой заказ
                    </h2>
                </div>
                <div class="video-content">
                    <div class="intro">Мы сотрудничаем с более чем 1000 агентствами и фрилансерами по всему
                        Узбекистану. Оставляй заказ и выбери самое выгодное и предложение от исполнителей. Для
                        Заказчика использование платформы АБСОЛЮТНО БЕСПЛАТНО.
                    </div>
                    <a class="btn btn-light-green" href="#">Давайте начнем</a>
                </div>
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
@endsection
