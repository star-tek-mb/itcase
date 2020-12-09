@extends('site.layouts.app')

@section('title')
    @if(empty($post->meta_title))
        {{ $post->getTitle() }}
    @else
        {{ $post->meta_title }}
    @endif
@endsection

@section('meta')
    <meta name="title"
          content="@if(empty($post->meta_title)) {{ $post->getTitle() }} в Ташкенте @else {{ $post->meta_title }} @endif">
    <meta name="description"
          content="@if (empty($post->meta_description)) {{ strip_tags($post->ru_description) }} @else {{ $post->meta_description }} @endif">
    <meta name="keywords" content="{{ $post->meta_keywords }}">
@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')

    <div class="primary-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-post-single">
                        <article class="blog-post-media">
                            <div class="blog-post-media-heading">
                                <div class="blog-post-meta"><span><i
                                            class="far fa-clock"></i> {{ $post->created_at }}</span>
                                </div>
                                <h1 class="blog-post-title">{{ $post->ru_title }}</h1>
                            </div>
                            <div class="blog-post-media-body">{!! $post->ru_short_content !!}
                                <figure class="blog-post-image"><img src="{{ $post->getImage() }}"
                                                                     alt="Qdesk"></figure>
                                {!! $post->ru_content !!}
                            </div>
                            <div class="post-share">
                                <label>Поделиться статьей</label>
                                <div class="social-icon"><a href="#"><i class="fab fa-facebook-f"></i></a><a
                                        href="#"><i class="fab fa-behance"></i></a><a href="#"><i
                                            class="fab fa-linkedin-in"></i></a><a href="#"><i
                                            class="fab fa-pinterest-p"></i></a><a href="#"><i
                                            class="fab fa-twitter"></i></a></div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-right">
                        <div class="sidebar-right-group">
                            <div class="box-sidebar">
                                <div class="header-box d-flex justify-content-between flex-wrap">
                                    <h3 class="title-box">Категории</h3>
                                </div>
                                <div class="body-box">
                                    <ul class="list-check-filter-job">
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ route('site.blog.main', $category->ru_slug) }}">{{ $category->getTitle() }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <!-- Banner -->--}}
    {{--    <div itemtype="http://schema.org/Product" itemscope>--}}
    {{--        <header id="header"--}}
    {{--                class="uk-background-cover uk-background-norepeat uk-background-center-center uk-background-blend-soft-light uk-background-primary" style="background-image: url({{ $post->getImage() }}); back">--}}
    {{--            <div class="uk-container uk-container-large uk-light" uk-height-viewport="offset-top: true">--}}
    {{--                <div uk-grid uk-height-viewport="offset-top: true">--}}
    {{--                    <div class="uk-header-left uk-section uk-visible@m uk-flex uk-flex-bottom">--}}
    {{--                        <div class="uk-text-xsmall uk-text-bold">--}}
    {{--                            <a class="hvr-back" href="#course" uk-scroll="offset: 80"><span--}}
    {{--                                    class="uk-margin-small-right"--}}
    {{--                                    data-uk-icon="arrow-left"></span>Прокрутить вниз</a>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="uk-width-expand@m uk-section">--}}
    {{--                        <div class="uk-margin-top">--}}
    {{--                            <div class="uk-grid-large" uk-grid--}}
    {{--                                 uk-scrollspy="cls: uk-animation-slide-bottom-medium; delay: 200; repeat: true">--}}
    {{--                                <div class="">--}}
    {{--                                    <h1 class="uk-heading-medium uk-margin-remove-top uk-letter-spacing-xl"--}}
    {{--                                        itemprop="name">{{ $post->ru_title }}</h1>--}}
    {{--                                    <p class="uk-text-lead">{!! $post->ru_short_content !!}</p>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="uk-margin-xlarge-top">--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </header>--}}
    {{--        <div id="course" class="uk-section">--}}
    {{--            <div class="uk-container uk-margin-pricing-offset">--}}
    {{--                <div class="uk-grid-large" data-uk-grid>--}}
    {{--                    <div class="uk-width-expand@m">--}}
    {{--                        <div class="uk-article">--}}
    {{--                            @if (!empty($post->ru_content))--}}
    {{--                                <div>--}}
    {{--                                    <span itemprop="description">{!! $post->ru_content !!}</span>--}}
    {{--                                </div>--}}
    {{--                            @endif--}}
    {{--                            <div>--}}
    {{--                                <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>--}}
    {{--                                    <meta itemprop="reviewCount" content="89"/>--}}
    {{--                                    <meta itemprop="ratingValue" content="4.4"/>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}

    {{--        <!-- Main Info -->--}}
    {{--            <!-- Main Info -->--}}
    {{--            <!-- Delivery Settings -->--}}
    {{--            <!-- <div class="uk-container uk-container-expand uk-container-center  margin-top2">--}}
    {{--                    <div class="unwrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle">--}}
    {{--                        <div class="sorting uk-grid-small uk-flex-middle">--}}
    {{--                            <p>Сортировать по типу перевозок:</p>--}}
    {{--                            <div class="center_item">--}}
    {{--                                <img src="images/flats.svg" alt="">--}}
    {{--                                <a href="#">--}}
    {{--                                    <p>Городские</p>--}}
    {{--                                </a>--}}
    {{--                            </div>--}}
    {{--                            <div class="center_item">--}}
    {{--                                <img src="images/planet-earth-1.svg" alt="">--}}
    {{--                                <a href="#">--}}
    {{--                                    <p>Международные </p>--}}
    {{--                                </a>--}}
    {{--                            </div>--}}
    {{--                            <div class="buttons">--}}
    {{--                                <a href="#" class="setting_button right"> <i class="fa fa-bars"></i></a>--}}
    {{--                                <a href="#" class="setting_button left"> <i class="fa fa-th-large"></i></a>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--            </div> -->--}}
    {{--            <!-- Delivery Settings -->--}}

    {{--            <!-- Content--}}
    {{--            <div class="uk-container uk-container-expand uk-container-center  uk-margin-top">--}}
    {{--                    <ul class="uk-grid uk-grid-medium  uk-child-width-1-2@s uk-child-width-1-4@m uk-child-width-1-4@l" uk-grid data-uk-grid-margin>--}}
    {{--                        <li class="uk-container-center" >--}}
    {{--                            <div class="price_card">--}}
    {{--                                <div class="price_pic">--}}
    {{--                                    <div class="inner_logo">--}}
    {{--                                        <img src="images/photo_2019-08-21 15.44.08.svg" alt="">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="price">--}}
    {{--                                        <p>1 200 000 сум</p>--}}
    {{--                                        <span>скачать коммерческое</span>--}}
    {{--                                        <ul>--}}
    {{--                                            <li><img src="images/planet-earth-1.svg" alt=""></li>--}}
    {{--                                            <li><img src="images/flats.svg" alt=""></li>--}}
    {{--                                        </ul>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}

    {{--                                <div class="price_wrapper">--}}
    {{--                                    <div class="price_tages">--}}
    {{--                                            <div class="title">--}}
    {{--                                                <span>Категория</span>--}}
    {{--                                                <h2><a href="page2.html">Наименование Услуги</a> </h2>--}}
    {{--                                            </div>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="hr"></div>--}}
    {{--                                    <div class="description">--}}
    {{--                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et doloremagnaaliquyam erat, sed diam voluptua. At vero eos et accusam et justo</p>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </li>--}}
    {{--                        <li class="uk-container-center" >--}}
    {{--                            <div class="price_card">--}}
    {{--                                <div class="price_pic">--}}
    {{--                                    <div class="inner_logo">--}}
    {{--                                        <img src="images/photo_2019-08-21 15.44.08.svg" alt="">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="price">--}}
    {{--                                        <p>1 200 000 сум</p>--}}
    {{--                                        <span>скачать коммерческое</span>--}}
    {{--                                        <ul>--}}
    {{--                                            <li><img src="images/planet-earth-1.svg" alt=""></li>--}}
    {{--                                            <li><img src="images/flats.svg" alt=""></li>--}}
    {{--                                        </ul>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}

    {{--                                <div class="price_wrapper">--}}
    {{--                                    <div class="price_tages">--}}
    {{--                                            <div class="title">--}}
    {{--                                                <span>Категория</span>--}}
    {{--                                                <h2><a href="page2.html">Наименование Услуги</a> </h2>--}}
    {{--                                            </div>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="hr"></div>--}}
    {{--                                    <div class="description">--}}
    {{--                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et doloremagnaaliquyam erat, sed diam voluptua. At vero eos et accusam et justo</p>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </li>--}}
    {{--                        <li class="uk-container-center" >--}}
    {{--                            <div class="price_card">--}}
    {{--                                <div class="price_pic">--}}
    {{--                                    <div class="inner_logo">--}}
    {{--                                        <img src="images/photo_2019-08-21 15.44.08.svg" alt="">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="price">--}}
    {{--                                        <p>1 200 000 сум</p>--}}
    {{--                                        <span>скачать коммерческое</span>--}}
    {{--                                        <ul>--}}
    {{--                                            <li><img src="images/planet-earth-1.svg" alt=""></li>--}}
    {{--                                            <li><img src="images/flats.svg" alt=""></li>--}}
    {{--                                        </ul>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}

    {{--                                <div class="price_wrapper">--}}
    {{--                                    <div class="price_tages">--}}
    {{--                                            <div class="title">--}}
    {{--                                                <span>Категория</span>--}}
    {{--                                                <h2><a href="page2.html">Наименование Услуги</a> </h2>--}}
    {{--                                            </div>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="hr"></div>--}}
    {{--                                    <div class="description">--}}
    {{--                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et doloremagnaaliquyam erat, sed diam voluptua. At vero eos et accusam et justo</p>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </li>--}}
    {{--                        <li class="uk-container-center" >--}}
    {{--                            <div class="price_card">--}}
    {{--                                <div class="price_pic">--}}
    {{--                                    <div class="inner_logo">--}}
    {{--                                        <img src="images/photo_2019-08-21 15.44.08.svg" alt="">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="price">--}}
    {{--                                        <p>1 200 000 сум</p>--}}
    {{--                                        <span>скачать коммерческое</span>--}}
    {{--                                        <ul>--}}
    {{--                                            <li><img src="images/planet-earth-1.svg" alt=""></li>--}}
    {{--                                            <li><img src="images/flats.svg" alt=""></li>--}}
    {{--                                        </ul>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}

    {{--                                <div class="price_wrapper">--}}
    {{--                                    <div class="price_tages">--}}
    {{--                                            <div class="title">--}}
    {{--                                                <span>Категория</span>--}}
    {{--                                                <h2><a href="page2.html">Наименование Услуги</a> </h2>--}}
    {{--                                            </div>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="hr"></div>--}}
    {{--                                    <div class="description">--}}
    {{--                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et doloremagnaaliquyam erat, sed diam voluptua. At vero eos et accusam et justo</p>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </li>--}}
    {{--                    </ul>--}}
    {{--            </div>--}}
    {{--            Content end-->--}}
    {{--            <section class="uk-section-xsmall uk-padding-remove-vertical">--}}
    {{--                <div class="uk-container uk-container-xlarge uk-container-center container uk-margin-top">--}}
    {{--                    <ul class="sequence" itemscope itemtype="http://schema.org/BreadcrumbList">--}}
    {{--                        <li itemprop="itemListElement" itemscope--}}
    {{--                            itemtype="http://schema.org/ListItem"><a href="{{ route('site.catalog.index') }}"--}}
    {{--                                                                     itemprop="item"><span itemprop="name"><meta--}}
    {{--                                        itemprop="position" content="1"/>Главная</span></a></li>--}}
    {{--                        <li><img src="{{ asset('assets/img/next.svg') }}" alt=""></li>--}}
    {{--                        <li itemprop="itemListElement" itemscope--}}
    {{--                            itemtype="http://schema.org/ListItem"><a href="{{ route('site.blog.index') }}"--}}
    {{--                                                                     itemprop="item"><span itemprop="name"><meta--}}
    {{--                                        itemprop="position" content="2"/>Блог</span></a></li>--}}
    {{--                        <li><img src="{{ asset('assets/img/next.svg') }}" alt=""></li>--}}
    {{--                        <li itemprop="itemListElement" itemscope--}}
    {{--                            itemtype="http://schema.org/ListItem"><a href="{{ route('site.blog.main', $post->category->ru_slug) }}"--}}
    {{--                                                                     itemprop="item"><span itemprop="name"><meta--}}
    {{--                                        itemprop="position" content="3"/>{{ $post->category->getTitle() }}</span></a></li>--}}
    {{--                        <li><img src="{{ asset('assets/img/next.svg') }}" alt=""></li>--}}
    {{--                        <li itemprop="itemListElement" itemscope--}}
    {{--                            itemtype="http://schema.org/ListItem"><span itemprop="name"><meta itemprop="position"--}}
    {{--                                                                                              content="4"/>{{ $post->getTitle() }}</span>--}}
    {{--                        </li>--}}
    {{--                    </ul>--}}

    {{--                </div>--}}
    {{--        </section>--}}
@endsection
