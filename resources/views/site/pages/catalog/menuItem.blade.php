@extends('site.layouts.app')
@section('title')
    @if(empty($menuItem->meta_title))
        {{ $menuItem->ru_title }} в Ташкенте
    @else
        {{ $menuItem->meta_title }}
    @endif
@endsection
@section('meta')
    <meta name="title" content="@if(empty($menuItem->meta_title)) {{ $menuItem->ru_title }} в Ташкенте @else {{ $menuItem->meta_title }} @endif">
    <meta name="description" content="@if (empty($menuItem->meta_description)) {{ strip_tags($menuItem->ru_description) }} @else {{ $menuItem->meta_description }} @endif">
    <meta name="keywords" content="{{ $menuItem->meta_keywords }}">
@endsection
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

    <div class="uk-container uk-container-xlarge uk-margin-small uk-margin-medium-bottom">
        <ul class="cat-tab uk-tab" >
            <li class="uk-active">
                <a href="{{ route('site.catalog.index') }}">
                    <span uk-icon="arrow-left"></span>
                    <span>Назад</span>
                </a>
            </li>
            @foreach($menuItem->categories as $child)
                <li>
                    <a href="{{ route('site.catalog.main', $child->getAncestorsSlugs()) }}">
                        <div class="uk-flex uk-flex-middle">
                        <!--                                <span><img src="{{ $child->getImage() }}" alt=""></span>-->
                            <span>{{ $child->ru_title }} </span>
                            <span class="countcat">({{ $child->getAllCompaniesCount() }})</span>
                        </div>
                    </a>
                </li>
        @endforeach
        <!--
            <li>
                <a href="#">More <span class="uk-margin-small-left" uk-icon="icon: triangle-down"></span></a>
                <div uk-dropdown="mode: click">
                    <ul class="uk-nav uk-dropdown-nav">
                        <li class="uk-active"><a href="#">Active</a></li>
                        <li><a href="#">Item</a></li>
                        <li class="uk-nav-header">Header</li>
                        <li><a href="#">Item</a></li>
                        <li><a href="#">Item</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </div>
            </li>
-->
        </ul>
        <!-- <div class="uk-margin text-left">
            <div uk-grid class="uk-grid-magrin uk-grid-stack">
                <div class="uk-width-1-1@m">
                </div>
            </div>
        </div> -->
          <div class="sorting uk-grid-small uk-flex-middle" uk-grid>
                    <p>Цена: </p>
                    <form action="" method="get">
                        <div class="uk-flex">
                            <select name="price" class="uk-select" id="price">
                                <option value="asc" @if (request()->get('price') == 'asc') selected @endif>По возрастанию</option>
                                <option value="desc" @if (request()->get('price') == 'desc') selected @endif>По убыванию</option>
                            </select>
                            <input type="submit" value="Применить" class="uk-button uk-button-success-outline uk-margin-left">
                        </div>
                    </form>
                </div>
    </div>


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
                                <h3 itemprop="name" class="uk-card-title uk-margin-small-bottom">{{ $company->ru_title }}</h3>
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
      </section>
        <section class="uk-section-xsmall uk-padding-remove-vertical">
        <div class="uk-container uk-container-xlarge uk-container-center">
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h1>{{ $menuItem->ru_title }}</h1>
                    {!! $menuItem->ru_description !!}
                </div>
                <div class="uk-width-expand@m"></div>

            </div>
        </div>
    </section>
    <section class="uk-section-xsmall uk-padding-remove-vertical">
        <div class="uk-container uk-container-xlarge uk-container-center container uk-margin-top">
            <ul class="sequence" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem"><a itemprop="item" href="{{ route('site.catalog.index') }}"><span itemprop="name"><meta itemprop="position" content="1" />Главная</span></a></li>
                <li ><img src="{{ asset('assets/img/next.svg') }}" alt=""></li>
                <li itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem"><span itemprop="name"><meta itemprop="position" content="2" />{{ $menuItem->ru_title }}</span></li>
            </ul>
        </div>

@endsection
