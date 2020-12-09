
<style>
    .sequence{
        display: flex;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 83px 0;
        flex-wrap: wrap;

    }
    .sequence li{
        margin-right: 17px;
        color: #102840;
        font-size: 18px;
        /* font-family: 'opensans'; */
        font-weight: 400;
        margin-top: 10px;
    }
    .sequence li a{
        color: #102840;
        text-decoration: none;
    }</style>
@extends('site.layouts.app')
@section('title', 'Поиск')
@section('css')
@section('header')
    @include('site.layouts.partials.headers.default')
@endsection
@section('content')
    <!-- Search settings -->
    <!-- <div class="my-container">
        <div class="capsule_item">
            <div class="capsule_img">
                <img src="images/search (1).svg" alt="">
            </div>
            <a href="#">
                <p>Все результаты</p>
            </a>
        </div>
        <div class="capsule_item">
            <div class="capsule_img">
                <img src="images/office-briefcase.svg" alt="">
            </div>
            <a href="#">
                <p>Места и заведения</p>
            </a>
        </div>
        <div class="capsule_item">
            <div class="capsule_img">
                <img src="images/office-briefcase.svg" alt="">
            </div>
            <a href="#">
                <p>Мероприятия</p>
            </a>
        </div>
        <div class="capsule_item">
            <div class="capsule_img">
                <img src="images/office-briefcase.svg" alt="">
            </div>
            <a href="#">
                <p>Акции</p>
            </a>
        </div>
    </div> -->
    <!-- Search settings end -->
    <section class="uk-section-xsmall uk-padding-remove-vertical">
        <div class="uk-container uk-container-xlarge uk-container-center">
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h1>Поиск: {{ $queryString }}</h1>
                </div>
                <div class="uk-width-expand@m"></div>
            </div>
        </div>
    </section>
    <section class="uk-section-xsmall">
        <div class="uk-container uk-container-center uk-container-xlarge uk-margin-top">
            <div uk-grid class="uk-child-width-1-2@s uk-child-width-1-3@m uk-margin-large-top uk-grid-match uk-grid">
                @foreach($companies as $company)
                    <div>
                        <div class="uk-card uk-card-small uk-card-border" itemscope itemtype="http://schema.org/Product">
                            <div class="uk-card-media-top uk-position-relative uk-light">
                                <img itemprop="image" uk-img height="200" src="{{ $company->getImage() }}" class="code-mage" alt="Course Title">
                                <div class="uk-position-cover uk-overlay-xlight"></div>
                                <div class="uk-position-top-left" itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
                                    <span class="uk-text-bold uk-text-price uk-text-small" itemprop="lowPrice" content="{{ $company->price }}">{{ number_format($company->price, 0, ',', '.') }}</span><span class="uk-text-bold uk-text-price uk-text-small" itemprop="priceCurrency" content="SUM">сум</span>
                                </div>
                                <!-- ### Favorites
                                                    <div class="uk-position-top-right">
                                                        <a href="#" class="uk-icon-button uk-like uk-position-z-index uk-position-relative" data-uk-icon="heart"></a>
                                                    </div>
                                -->
                            </div>
                            <div class="uk-card-body">
                                <h2 itemprop="name" class="uk-card-title uk-margin-small-bottom">{{ $company->ru_title }}</h2>
                                <div itemprop="category" class="uk-text-muted uk-text-small">{!! $company->category->ru_title !!}</div>

                                <ul>
                                    @foreach($company->services as $service)
                                        <li><img src="{{ $service->getImage() }}" alt=""></li>
                                    @endforeach
                                </ul>
                                @if ($company->hasUrl() and $company->show_page)
                                    <span class="link">
                            <a href="{{ $company->url }}" target="_blank">
                                 {{ parse_url($company->url, PHP_URL_HOST) }}
                            </a>
                        </span>
                                @endif
                                @if ($company->hasAdvantages())
                                    <div class="tags">
                                        <ol>
                                            @foreach ($company->advantagesAsArray() as $advantage)
                                                <li>{{ $advantage }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                            @endif
                            <!-- ### Rating
                        <div class="uk-text-muted uk-text-small uk-rating uk-margin-small-top">
                            <span class="uk-rating-filled" data-uk-icon="icon: star; ratio: 0.75"></span>
                            <span class="uk-rating-filled" data-uk-icon="icon: star; ratio: 0.75"></span>
                            <span class="uk-rating-filled" data-uk-icon="icon: star; ratio: 0.75"></span>
                            <span class="uk-rating-filled" data-uk-icon="icon: star; ratio: 0.75"></span>
                            <span class="uk-rating-filled" data-uk-icon="icon: star; ratio: 0.75"></span>
                            <span class="uk-margin-small-left uk-text-bold">5.0</span>
                            <span>(324)</span>
                        </div>
-->
                            </div>
                            <a href="@if ($company->show_page) {{ route('site.catalog.main', $company->getAncestorsSlugs()) }} @else {{ $company->url }} @endif" class="uk-position-cover"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
