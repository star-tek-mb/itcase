@extends('site.layouts.app')

@section('title')
    @if(empty($category->meta_title))
        {{ $category->getTitle() }}
    @else
        {{ $category->meta_title }}
    @endif
@endsection

@section('meta')

    <meta name="title" content="@if(empty($category->meta_title)) {{ $category->getTitle() }} в Ташкенте @else {{ $category->meta_title }} @endif">
    <meta name="description" content="@if (empty($category->meta_description)) {{ strip_tags($category->ru_description) }} @else {{ $category->meta_description }} @endif">
    <meta name="keywords" content="{{ $category->meta_keywords }}">

@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('css')
    @if ($category->hasCguFiles())
        <style>
            .main_item_img{
                width: 100%;
                overflow: hidden;
                padding-top: 21px;
                padding-bottom: 5px;
            }
            .main_item_img img{
                object-fit: cover;
                max-height: 200px;
                width: 130px !important;
                height: 130px !important;
            }
            .main_item{

                display: flex;
                flex-flow: column;
            }
            .main_item_p{
                color: #00C3CE;
                font-family: "OpenSans-Semibold";
                font-size: 12px;
                text-transform: uppercase;
            }
        </style>
    @endif
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
        <div uk-grid class="uk-child-width-1-2@s uk-child-width-1-3@m uk-margin-large-top uk-grid-match uk-grid">
            @foreach($companies as $company)
            <div>
                <div class="uk-card uk-card-small uk-card-border">
                    <div class="uk-card-media-top uk-position-relative uk-light">
                        <img uk-img height="200" src="{{ $company->getImage() }}" class="code-mage" alt="Course Title">
                        <div class="uk-position-cover uk-overlay-xlight"></div>
                        <div class="uk-position-top-left">
                            <span class="uk-text-bold uk-text-price uk-text-small">$27.00</span>
                        </div>
<!-- ### Favorites
                    <div class="uk-position-top-right">
                        <a href="#" class="uk-icon-button uk-like uk-position-z-index uk-position-relative" data-uk-icon="heart"></a>
                    </div>
-->
                    </div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-margin-small-bottom">{{ $company->ru_title }}</h3>
                        <div class="uk-text-muted uk-text-small">{!! $company->category->ru_title !!}</div>

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
            @if($category->hasCguFiles())
                @foreach($category->cguFiles as $file)
                    <div class="main_item" style="background-color: transparent;box-shadow: none;display: flex;padding: 0;">
                        @if($file->video == '')
                            @if(strpos($file->getFileType(), 'image') !== false)
                                <a href="{{ $file->getFileUrl() }}" data-fancybox="images" data-caption="" class="main_item_img">
                                    <img class="lazy" src="{{ $file->getFileUrl() }}" style="width: 100%;" alt="">
                                </a>
                                <p class="main_item_p">{{ $file->ru_title }}</p>
                            @elseif(strpos($file->getFileType(), 'video') !== false)
                                <video preload="metadata" controls style="width: 100%;" alt="" style="width: 100%;">
                                    <source src="{{ $file->getFileUrl() }}" type="video/mp4">
                                </video>
                            @elseif(strpos($file->getFileType(), 'application') !== false)
                                <a href="{{ $file->getFileUrl() }}" target="_blank">
                                    <div class="main_item_icon">
                                        <img class="lazy" src="{{ asset('assets/img/pdf-icon.png') }}" alt="">
                                    </div>
                                    <div class="main_item_info">
                                        <h1 class="main_item_title" style="color: #00C3CE;font-size:12px;">
                                            {!! $file->ru_title !!}
                                        </h1>
                                    </div>
                                </a>
                            @endif
                        @else
                            <iframe style="width: 100%;" id="ytplayer" type="text/html"
                                    src="http://www.youtube.com/embed/{{ $file->video }}?autoplay=0"
                                    frameborder="0" allowfullscreen="1"></iframe>
                        @endif
                    </div>
                @endforeach
            @endif
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
