@extends('site.layouts.app')

@section('title')
    @if ($currentCategory)
        {{ $currentCategory->tender_meta_title_prefix }} @if(empty($currentCategory->meta_title)) {{ $currentCategory->getTitle() }} @else {{ $currentCategory->meta_title }} @endif в Ташкенте|Узбекистане
    @else
        Конкурсы
    @endif
@endsection

@section('meta')
    @if ($currentCategory)
        <meta name="title"
              content="{{ $currentCategory->tender_meta_title_prefix }} @if(empty($currentCategory->meta_title)) {{ $currentCategory->getTitle() }} @else {{ $currentCategory->meta_title }} @endif в Ташкенте|Узбекистане">
        <meta name="description"
              content="@if (empty($currentCategory->meta_description)) {{ strip_tags($currentCategory->ru_description) }} @else {{ $currentCategory->meta_description }} @endif">
    @endif
@endsection
@section('header')
    @include('site.layouts.partials.headers.default')
@endsection
@section('css')
    <style>
        #map {
            width: 730px;
            height: 730px;
            padding: 0;
            margin: 0;
        }

        #location {
            width: 300px;
            height: 300px;
            padding: 0;
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div class="primary-page">
        <div class="container">
            <div class="header-page">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section-heading">
                            <h1 class="title-page">Каталог конкурсов @if ($currentCategory)
                                    {{ $currentCategory->getTitle() }}
                                @endif </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('site.catalog.index') }}">Главная</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Конкурсы</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="search-form d-flex justify-content-end pr-0 align-items-center">
                            <form action="{{ route('site.tenders.index.search') }}" method="post">
                                @csrf
                                <div class="form-group d-flex">
                                    <input class="form-control mr-md-4" name="search" type="text"
                                           placeholder="Поиск здесь...">
                                    <div id="livesearch"></div>
                                    <button class="btn-clear position-relative" type="submit"><i
                                                class=" fa fa-search"></i></button>
                                </div>
                            </form>

                            <ul class="d-flex ul-nav align-items-center ">

                                <li>
                                    <a href="{{ route('site.tenders.index') }}" title="Список">
                                        <i class=" fa fa-list"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('site.maps.index') }}" title="Показать на карте">
                                        <i class=" fa fa-map-marker"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <form id="filter" action="{{ route('site.maps.filter') }}" method="post">
                            @csrf
                            <div class="toggle-sidebar-left d-lg-none">Фильтр</div>
                            <div class="sidebar-left">
                                <button class="btn-close-sidebar-left btn-clear">
                                    <i class="fa fa-times-circle"></i>
                                </button>
                                <div class="box-sidebar">
                                    <div class="header-box d-flex justify-content-between flex-wrap">
                                        <span class="title-box">Фильтр</span>
                                        <input type="reset" value="Очистить">
                                    </div>
                                    <!-- category checkbox -->
                                    <div class="body-box">
                                        <div class="accordion"
                                                id="categoriesAccordion" role="tablist"
                                                aria-multiselectable="false">
                                            @foreach($parentCategories as $parent)
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between"
                                                            id="headingCategory{{ $parent->id }}">
                                                        <a href="{{ route('site.tenders.category', $parent->ru_slug) }}">{{ $parent->title }}</a>
                                                        <a href="#collapseCategory{{ $parent->id }}"
                                                            data-toggle="collapse"
                                                            data-parent="#categoriesAccordion"
                                                            aria-expanded="true"
                                                            aria-controls="collapseCategory{{ $parent->id }}"
                                                            style="font-size:8px">
                                                            <button class="btn btn-outline-success">
                                                                <i class="fas fa-caret-down"></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="collapse"
                                                            id="collapseCategory{{ $parent->id }}"
                                                            role="tabpanel"
                                                            aria-labelledby="headingCategory{{ $parent->id }}"
                                                            data-parent="#categoriesAccordion">
                                                        <div class="card-body">
                                                            <ul class="list-group list-group-flush">
                                                            @foreach($parent->categories as $category)
                                                                <!--<a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}" class="list-group-item list-group-item-action">{{ $category->getTitle() }}</a>__DIR__-->
                                                                    <li class="list-group-item list-group-item-action">
                                                                        <input type="checkbox"
                                                                                class="ajax-filter"
                                                                                value=" {{ $category->id }}">
                                                                        {{ $category->title }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- other checkbox -->
                                    <div class="body-box">
                                        <label>
                                            Поиск заданий на расстоянии <input type="text" class="ajax-filter"
                                                                               name="distance">км
                                        </label>
                                        <label>
                                            <input hidden class="ajax-filter" name="location">
                                            <input hidden class="ajax-filter" name="map_filter" value="41.31064707835609, 69.2795380845336">
                                            Укажите местоположение
                                        </label>
                                        <div id="location"></div>

                                        <label>
                                            Стоимости заданий от<input type="text" class="ajax-filter" name="min_price">
                                            сум
                                        </label>
                                        <label>
                                            <input type="checkbox" class="ajax-filter" name="remote">
                                            Удаленная работа
                                        </label>
                                    </div>
                                    <div id="ajaxFilter" class="btn btn-outline-success">Фильтр</div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-8">
                        <div id="result" class="content-main-right list-jobs">
                            <div class="header-list-job d-flex flex-wrap justify-content-between align-items-center">
                                <h4>{{ $tendersCount }} Конкурсов найдено</h4>
                                @if (!\Request::is('tenders'))
                                    <a class="btn btn-outline-success" href="{{ route('site.maps.index') }}">Все
                                        результаты</a>
                                @endif
                            </div>
                            <div id="map"></div>

                        </div>
                    </div>
                </div>
                @if ($currentCategory !== null && $currentCategory->ru_description)
                    <div class="row">
                        <div class="col-lg">
                            <div id="leftcolumn">
                                <div class="sidebar-left">
                                    <div class="box-sidebar" style="margin-top: 40px;">
                                        <div class="header-box d-flex justify-content-between flex-wrap">
                                            <h3 class="title-box">Описание</h3>
                                        </div>
                                        <div class="body-box">
                                            <p>{!! $currentCategory->ru_description !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=9b7e0e79-b7ed-43b7-87c6-671049c7c8f3"
            type="text/javascript"></script>

    <script>
        ymaps.ready(init);

        function init() {
            var myMap = new ymaps.Map("map", {
                    center: [ 41.31064707835609, 69.2795380845336],
                    zoom: 12
                }, {
                    searchControlProvider: 'yandex#search'
                }),
                objects = ymaps.geoQuery({
                    "type": "FeatureCollection",
                    "features": [
                            @foreach($tenders as $tender)
                        {
                            "type": "Feature",
                            "geometry": {
                                "type": "Point",
                                "coordinates": [ {{ $tender->geo_location }} ]
                            },
                            "properties": {
                                "balloonContent": "<a href='{{ route('site.tenders.category', $tender->slug) }}'>{{ $tender->title }}</a> {{ ($tender->opened==0 || $tender->contractor) ? "(Приём заявок окончен)" :"(Открыт)" }}",
                                "hintContent": "{{ $tender->title }} {{ ($tender->opened==0 || $tender->contractor) ? "(Приём заявок окончен)" :"(Открыт)" }}"
                            }
                        },

                        @endforeach
                    ]
                }).addToMap(myMap)
        }
        $('#ajaxFilter').click(function (e) {
            var frm = $('#filter');
            var formData = frm.serialize();

            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: formData,
                success: function (data) {
                    $('#result').html(data);

                }
            });

        });


        ymaps.ready(function () {
            var map;
            ymaps.geolocation.get({
                provider: 'browser',
                mapStateAutoApply: true
            }).then(function (res) {
                var mapContainer = $('#location'),
                    bounds = res.geoObjects.get(0).properties.get('boundedBy'),
                    // Рассчитываем видимую область для текущей положения пользователя.
                    mapState = ymaps.util.bounds.getCenterAndZoom(
                        bounds,
                        [mapContainer.width(), mapContainer.height()]
                    );
                createMap(mapState);
            }, function (e) {
                // Если местоположение невозможно получить, то просто создаем карту.
                createMap({
                    center: [41.2825125, 69.1392828],
                    zoom: 10
                });
            });

            function createMap(state) {
                map = new ymaps.Map('location', state);
                map.events.add('click', function (e) {
                    if (!map.balloon.isOpen()) {
                        var coords = e.get('coords');
                        $('input[name=location]').val(coords);
                        console.log(coords);
                        myPlacemark = new ymaps.Placemark(coords, {
                            //hintContent: 'Собственный значок метки',
                         //   balloonContent: 'Это красивая метка'
                        }, {
                            // Опции.
                            // Необходимо указать данный тип макета.
                            iconLayout: 'default#image',
                            // Своё изображение иконки метки.
                            iconImageHref: '/front/images/location.gif',
                            // Размеры метки.
                            iconImageSize: [30, 42],
                            // Смещение левого верхнего угла иконки относительно
                            // её "ножки" (точки привязки).
                            iconImageOffset: [-5, -38]
                        });
                        map.geoObjects
                            .removeAll()
                            .add(myPlacemark);

                    }
                    else {
                        map.balloon.close();
                    }
                });
            }
        });

    </script>
@endsection