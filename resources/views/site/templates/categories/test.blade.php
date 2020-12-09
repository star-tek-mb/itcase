@extends('site.layouts.app')

@section('title')
    @if(empty($category->meta_title))
        {{ $category->getTitle() }}
    @else
        {{ $category->meta_title }}
    @endif
    Zzzzzz
@endsection

@section('meta')

    <meta name="title" content="{{ $category->meta_title }}">
    <meta name="description" content="{{ $category->meta_description }}">
    <meta name="keywords" content="{{ $category->meta_keywords }}">

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
    <section class="uk-section-xsmall uk-padding-remove-vertical">
        <div class="uk-container uk-container-xlarge uk-container-center">
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h3>{{ $category->getTitle() }}</h3>
                </div>
                <div class="uk-width-expand@m"></div>
                @if ($category->services()->count() > 0)
                    <div class="sorting uk-grid-small uk-flex-middle" uk-grid>
                        <p>Сортировать: </p>
                        <div id="dropdown-menu" class="dropdown-menu">
                            @isset($currentService)
                                <span class="dropdown_title"><img src="{{ $currentService->getImage() }}" alt="">{{ $currentService->ru_title }}</span>
                            @endisset
                            <ul>
                                @foreach($category->services as $service)
                                    @if ($service->companies()->count() > 0)
                                        <li>
                                            <a href="{{ route('site.catalog.main', [$category->id, 'service' => $service->id]) }}">{{ $service->ru_title }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <div class="uk-container uk-container-xlarge uk-margin-small uk-margin-medium-bottom">
    <!--
        <div class="uk-child-width-auto uk-child-width-auto@m uk-grid-small" uk-grid>
             <div>
                        <div class="uk-card uk-card-default uk-card-body">Item</div>
                    </div>
                    <div>
                        <div class="uk-card uk-card-default uk-card-body">Item</div>
                    </div>
                    <div>
                        <div class="uk-card uk-card-default uk-card-body">Item</div>
                </div>
            <div>
                <div class="plus_item">
                    <div class="plus_img">
                        <img src="{{ asset('assets/img/left-arrow.svg') }}" alt="Go back">
                    </div>
                    <a href="{{ $category->hasParentCategory() ? route('site.catalog.main', $category->parent_id) : route('site.catalog.index') }}">
                        <p>Назад</p>
                    </a>
                </div>
            </div>
            @foreach($category->categories as $child)
        <div>
            <div class="plus_item">
                <div class="plus_img">
                    <img src="{{ $child->getImage() }}" alt="">
                        </div>
                        <a href="{{ route('site.catalog.main', $child->id) }}">
                            <p>{{ $child->ru_title }} <span>({{ $child->getAllCompaniesCount() }})</span></p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

-->
        <ul class="cat-tab uk-tab" >
            <li class="uk-active">
                <a href="{{ $category->hasParentCategory() ? route('site.catalog.main', $category->parent->getAncestorsSlugs()) : route('site.catalog.index') }}">
                    <span uk-icon="arrow-left"></span>
                    <span>Назад</span>
                </a>
            </li>

            @foreach($category->categories as $child)
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
    </div>
    <section class="uk-section-xsmall">
        <div class="uk-container uk-container-center uk-container-xlarge uk-margin-top">
            <div uk-grid class="uk-grid uk-grid-match uk-grid-small uk-child-width-1-1 uk-child-width-1-1@s uk-child-width-1-4@m uk-child-width-1-5@l">
                @foreach($companies as $company)
                    <div  class="uk-container-center">
                        <div class="inner">
                            <div class="header_logo">
                                <div class="inner_logo">
                                    <a href="@if ($company->show_page) {{ route('site.catalog.main', $company->getAncestorsSlugs()) }} @else {{ $company->url }} @endif">
                                        <img src="{{ $company->getImage() }}" alt="">
                                    </a>
                                </div>
                                <!-- <ul class="dots">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul> -->
                            </div>
                            <div class="inner_tages">
                                <div class="title">
                                    <h2 class="uk-margin-remove-bottom	"><a href="@if ($company->show_page) {{ route('site.catalog.main', $company->getAncestorsSlugs()) }} @else {{ $company->url }} @endif">{{ $company->ru_title }}</a></h2>

                                    @if ($company->hasUrl() and $company->show_page)
                                        <span class="link">
                                    <a href="{{ $company->url }}" target="_blank">
                                         {{ parse_url($company->url, PHP_URL_HOST) }}
                                    </a>
                                </span>
                                    @endif
                                </div>



                                <!--
                                                                <div class="tags">
                                                                    <ol>

                                                                            <li>Коньтетн</li><li>Коньтетн</li><li>Коньтетн</li><li>Коньтетн</li>

                                                                    </ol>
                                                                </div>
                                -->
                                @if ($company->hasAdvantages())
                                    <div class="tags">
                                        <ol>
                                            @foreach ($company->advantagesAsArray() as $advantage)
                                                <li>{{ $advantage }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                @endif
                            </div>
                            <div class="description">
                                <p>{!! $company->category->ru_title !!}</p>
                                <ul>
                                    @foreach($company->services as $service)
                                        <li><img src="{{ $service->getImage() }}" alt=""></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="uk-section-xsmall uk-padding-remove-vertical">
        <div class="uk-container uk-container-xlarge uk-container-center container uk-margin-top">
            <ul class="sequence">
                <li><a href="{{ route('site.catalog.index') }}">Главная</a></li>
                <li><img src="{{ asset('assets/img/next.svg') }}" alt=""></li>
                @foreach ($category->ancestors as $parentCategory)
                    <li><a href="{{ route('site.catalog.main', $parentCategory->getAncestorsSlugs()) }}">{{ $parentCategory->getTitle() }}</a></li>
                    <li><img src="{{ asset('assets/img/next.svg') }}" alt=""></li>
                @endforeach
                <li>{{ $category->getTitle() }}</li>
            </ul>
        </div>
    </section>

@endsection
