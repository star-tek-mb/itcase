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
        <meta name="title" content="{{ $currentCategory->tender_meta_title_prefix }} @if(empty($currentCategory->meta_title)) {{ $currentCategory->getTitle() }} @else {{ $currentCategory->meta_title }} @endif в Ташкенте|Узбекистане">
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
            width: 730px; height: 730px; padding: 0; margin: 0;
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
                                    <li class="breadcrumb-item"><a href="{{ route('site.catalog.index') }}">Главная</a></li>
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
                                    <input class="form-control mr-md-4" name="search" type="text" placeholder="Поиск здесь...">
                                    <div id="livesearch"></div>
                                    <button class="btn-clear position-relative" type="submit"><i class=" fa fa-search"></i></button>
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
                    <form id="leftcolumn" action="{{ route('site.maps.filter') }}" method="post">
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
                                    <div class="accordion" id="needsAccordion" role="tablist" aria-multiselectable="false">
                                        @foreach($needs as $need)
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between" role="tab" id="heading{{ $need->id }}">
                                                    <span>{{ $need->ru_title }}</span>
                                                    <a href="#collapse{{ $need->id }}" data-toggle="collapse" data-parent="#needsAccordion" aria-expanded="true" aria-controls="collapse{{ $need->id }}" style="font-size:8px"><button class="btn btn-outline-success"><i class="fas fa-caret-down"></i></button></a>
                                                </div>
                                                <div class="collapse" id="collapse{{ $need->id }}" role="tabpanel" aria-labelledby="heading{{ $need->id }}" data-parent="#needsAccordion">
                                                    <div class="card-body">
                                                        <div class="accordion" id="categoriesAccordion{{ $need->id }}" role="tablist" aria-multiselectable="false">
                                                            @foreach($need->menuItems as $item)
                                                                <div class="card">
                                                                    <div class="card-header d-flex justify-content-between" id="headingCategory{{ $item->id }}">
                                                                        <a href="{{ route('site.tenders.category', $item->ru_slug) }}">{{ $item->ru_title }}</a>
                                                                        <a href="#collapseCategory{{ $item->id }}" data-toggle="collapse" data-parent="#categoriesAccordion{{ $need->id }}" aria-expanded="true" aria-controls="collapseCategory{{ $item->id }}" style="font-size:8px"><button class="btn btn-outline-success"><i class="fas fa-caret-down"></i></button></a>
                                                                    </div>
                                                                    <div class="collapse" id="collapseCategory{{ $item->id }}" role="tabpanel" aria-labelledby="headingCategory{{ $item->id }}" data-parent="#categoriesAccordion{{ $need->id }}">
                                                                        <div class="card-body">
                                                                            <ul class="list-group list-group-flush">
                                                                                @foreach($item->categories as $category)
                                                                                    <!--<a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}" class="list-group-item list-group-item-action">{{ $category->getTitle() }}</a>__DIR__-->
                                                                                    <li class="list-group-item list-group-item-action">
                                                                                        <input type="checkbox" class="ajax-filter" value=" {{ $category->id }}">
                                                                                        {{ $category->getTitle() }}
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- other checkbox -->
                                <div class="body-box">
                                        <label >

                                            Поиск заданий на расстоянии <input type="text" class="ajax-filter" name="distance">км
                                        </label>
                                        <label >

                                            Стоимости заданий от<input type="text" class="ajax-filter" name="min_price"> сум
                                        </label>
                                        <label >
                                            <input type="checkbox" class="ajax-filter"  name="remote">
                                            Удаленная работа
                                        </label>
                                </div>
<button>Фильтр</button>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-8">
                    <div class="content-main-right list-jobs">
                        <div class="header-list-job d-flex flex-wrap justify-content-between align-items-center">
                            <h4>{{ $tendersCount }} Конкурсов найдено</h4>
                            @if (!\Request::is('tenders'))
                              <a class="btn btn-outline-success" href="{{ route('site.maps.index') }}">Все результаты</a>
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
            <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=9b7e0e79-b7ed-43b7-87c6-671049c7c8f3" type="text/javascript"></script>

            <script>
                ymaps.ready(init);
                function init() {

                    destinations = {
                        'Адрес 1': [41.347504, 69.286773],
                        'Адрес 2': [41.303755, 69.283424],
                    },

                        myMap = new ymaps.Map("map", {
                            center: destinations['Адрес 1'],
                            zoom: 16,
                            controls: [],
                            draggable: false
                        }),

                        // Создаем геообъект с типом геометрии "Точка".
                        myGeoObject = new ymaps.GeoObject({
                            // Описание геометрии.
                            geometry: {
                                type: "Point",
                                coordinates: [41.347504, 69.286773]
                            },
                            // Свойства.
                            properties: {
                                // Контент метки.
                                iconContent: '',
                                balloonContent: '+998 99 910 03 00  / +998 99 510 03 00',
                                hintContent: '+998 99 910 03 00  / +998 99 510 03 00'
                            }
                        }, {
                            // Опции.
                            // Иконка метки будет растягиваться под размер ее содержимого.
                            //preset: 'islands#orangeIcon',
                            iconLayout: 'default#image',
                            // Путь до нашей картинки
                            iconImageHref: 'https://cityrentcar.uz/wp-content/themes/cityrentcar/images/address.png',
                            // Размер по ширине и высоте
                            iconImageSize: [92, 88],
                            // Смещение левого верхнего угла иконки относительно
                            // её «ножки» (точки привязки).
                            iconImageOffset: [-38, -88],
                            // Метку можно перемещать.

                        });



                    myGeoObject_1 = new ymaps.GeoObject({
                        // Описание геометрии.
                        geometry: {

                            type: "Point",
                            coordinates: [41.303755, 69.283424]
                        },
                        // Свойства.
                        properties: {
                            // Контент метки.
                            iconContent: '',
                            balloonContent: '+998 90 120 03 00   / +998 95 420 03 00',
                            hintContent: '+998 90 120 03 00  /  +998 95 420 03 00'
                        }
                    }, {
                        // Опции.
                        // Иконка метки будет растягиваться под размер ее содержимого.
                        //preset: 'islands#orangeIcon',
                        iconLayout: 'default#image',
                        // Путь до нашей картинки
                        iconImageHref: 'https://cityrentcar.uz/wp-content/themes/cityrentcar/images/address.png',
                        // Размер по ширине и высоте
                        iconImageSize: [92, 88],
                        // Смещение левого верхнего угла иконки относительно
                        // её «ножки» (точки привязки).
                        iconImageOffset: [-38, -88],
                        // Метку можно перемещать.

                    });





                    //myMap.controls.add('smallZoomControl');
                    // Добавляем все метки на карту.
                    myMap.geoObjects.add(myGeoObject);
                    myMap.geoObjects.add(myGeoObject_1);
                    myMap.behaviors.disable('scrollZoom');
                    myMap.behaviors.disable('drag');

                    function clickGoto() {

                        // город
                        var pos = this.textContent;
                        //result.textContent = pos;

                        // переходим по координатам
                        myMap.panTo(destinations[pos], {
                            flying: 1
                        });


                        return false;
                    }


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
            </script>
@endsection