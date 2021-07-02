@extends('site.layouts.app')

@section('title')
    Конкурсы
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
        .caret::before {
            content: "\25B6";
        }
        .collapsed.caret {
            transform: rotate(0deg);
        }
        .caret {
            color: black;
            display: inline-block;
            transform: rotate(90deg);
            position: absolute;
            top: 0;
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
                            <h1 class="title-page">Поиск заданий по карте</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('site.catalog.index') }}">Главная</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Задания</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="search-form d-flex justify-content-end pr-0 align-items-center">
                            <ul class="d-flex ul-nav align-items-center ">
                                <li>
                                    <a href="{{ route('site.tenders.index') }}">
                                        <i class=" fa fa-list"></i> Поиск по тексту
                                    </a>
                                </li>
                                <li>  
                                    <i class=" fa fa-map-marker"></i> Поиск по карте
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="toggle-sidebar-left d-lg-none">Фильтр</div>
                        <div class="sidebar-left">
                            <button class="btn-close-sidebar-left btn-clear">
                                <i class="fa fa-times-circle"></i>
                            </button>
                            <div class="box-sidebar">
                                <div class="header-box d-flex justify-content-between flex-wrap">
                                    <span class="title-box">Фильтр</span>
                                </div>
                                <!-- category checkbox -->
                                <div class="body-box mb-4">
                                    <ul class="nav nav-stacked" id="categoriesAccordion" style="display: block;">
                                    @foreach ($parentCategories as $parent)
                                    
                                        <li class="panel" style="position: relative;">
                                            <a data-toggle="collapse" data-parent="#categoriesAccordion" class="caret collapsed" href="#accordion{{ $parent->id }}"></a>
                                            <div class="ml-4 form-check" style="display: inline-block;">
                                                <input onchange="mapFiltersChanged()" checked type="checkbox" id="cat{{ $parent->id }}" class="form-check-input" name="categories[]" value="{{ $parent->id }}">
                                                <label class="form-check-label" for="cat{{ $parent->id }}">{{ $parent->title }}</label>
                                                <ul id="accordion{{ $parent->id }}" class="collapse panel-collapse in">
                                                    @foreach ($parent->categories as $category)
                                                    <li class="form-check">
                                                        <input onchange="mapFiltersChanged()" checked type="checkbox" id="cat{{ $category->id }}" class="form-check-input" name="categories[]" id="tall" value="{{ $category->id }}">
                                                        <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->title }}</label>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>

                                <!-- other checkbox -->
                                <div class="body-box">
                                    <div class="form-group">
                                        <label for="distance">Поиск заданий на расстоянии, км</label>
                                        <input type="text" id="distance" class="form-control" name="distance" value="30">
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Минимальная цена задания</label>
                                        <input type="text" id="minPrice" class="form-control" name="minPrice" value="0">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remote" id="remote">
                                        <label class="form-check-label">Удаленная работа</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div id="result" class="content-main-right list-jobs">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
<script>
$('input[type="checkbox"]').change(function(e) {
  var checked = $(this).prop("checked"),
      container = $(this).parent(),
      siblings = container.siblings();
  container.find('input[type="checkbox"]').prop({
    indeterminate: false,
    checked: checked
  });
  function checkSiblings(el) {
    var parent = el.parent().parent(),
        all = true;
    el.siblings().each(function() {
      let returnValue = all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
      return returnValue;
    });
    if (all && checked) {
      parent.children('input[type="checkbox"]').prop({
        indeterminate: false,
        checked: checked
      });
      checkSiblings(parent);
    } else if (all && !checked) {
      parent.children('input[type="checkbox"]').prop("checked", checked);
      parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
      checkSiblings(parent);
    } else {
      el.parents("li div").children('input[type="checkbox"]').prop({
        indeterminate: true,
        checked: false
      });

    }
  }
  checkSiblings(container);
});
</script>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey={{ config('services.yandex.maps_api') }}" type="text/javascript"></script>
<script>
ymaps.ready(init);
var myMap;
var objectManager;
var myCircle;
var customSingleBalloonContentLayout;

$('#distance').on('input', function(el) {
    myCircle.geometry.setRadius($(el.target).val() * 1000);
    mapFiltersChanged();
});
$('#minPrice').change(function(el) { mapFiltersChanged(); });
$('#remote').change(function(el) { mapFiltersChanged(); });
function mapFiltersChanged(e) {
    var checkedCategories = $('input[name="categories[]"]:checkbox:checked').map(function() {
        return this.value;
    }).get();
    $.ajax({
        type: "POST",
        url: "/api/tenders/maps-filter",
        data: {
            center_lat: myCircle.geometry.getCoordinates()[0],
            center_lng: myCircle.geometry.getCoordinates()[1],
            radius: myCircle.geometry.getRadius() / 1000,
            categories: checkedCategories,
            minPrice: $('#minPrice').val(),
            remote: $('#remote').prop("checked") ? true : null
        }
    }).done(function(data) {
        objectManager.removeAll();
        for (var tender of data) {
            var lat = parseFloat(tender.geo_location.split(',')[0]);
            var lng = parseFloat(tender.geo_location.split(',')[1]);
            objectManager.add({
                type: 'Feature',
                id: tender.id,
                geometry: {
                    type: 'Point',
                    coordinates: [lat, lng]
                },
                properties: {
                    balloonContentHeader: '<div class="image-maps"><div class="task-block__icon"><img style="width: 64px; height: auto;" src="' + tender.icon + '"></div></div>',
                    balloonContentBody: '<a href="/tenders/' + tender.slug + '">' + tender.title + '</a><br><br>' + tender.description
                }
            });
        }
    });
}

function init () {
    myMap = new ymaps.Map('map', {
        center: [43.2220,76.8512],
        zoom: 10
    }, {
        searchControlProvider: 'yandex#search'
    });
    var customBalloonContentLayout = ymaps.templateLayoutFactory.createClass([
        '<div style="min-width: 400px; max-height: 600px; overflow-y: auto;">',
        '{% for geoObject in properties.geoObjects %}',
            '<div class="row mb-2">',
                '<div class="col-3">@{{ geoObject.properties.balloonContentHeader|raw }}</div>',
                '<div class="col-9" style="max-height: 200px;">@{{ geoObject.properties.balloonContentBody|raw }}</a></div>',
            '</div>',
        '{% endfor %}',
        '</div>',
    ].join(''));
    var customSingleBalloonContentLayout = ymaps.templateLayoutFactory.createClass([
        '<div class="row" style="min-width: 400px;">',
            '<div class="col-3">@{{ properties.balloonContentHeader|raw }}</div>',
            '<div class="col-9" style="max-height: 200px;">@{{ properties.balloonContentBody|raw }}</a></div>',
        '</div>',
    ].join(''));

    objectManager = new ymaps.ObjectManager({
        clusterize: true,
        gridSize: 32,
        geoObjectBalloonContentLayout: customSingleBalloonContentLayout,
        clusterBalloonContentLayout: customBalloonContentLayout
    });

    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
    myMap.geoObjects.add(objectManager);

    myCircle = new ymaps.Circle([
        myMap.getCenter(),
        30000
    ], {
        hintContent: "Можно передвинуть центр круга"
    }, {
        draggable: true,
        fillColor: "#007dff7d",
        strokeColor: "#2676cb",
        strokeOpacity: 0.8,
        strokeWidth: 5
    });
    myCircle.events.add('dragend', mapFiltersChanged);
    myMap.geoObjects.add(myCircle);

    mapFiltersChanged();
}
</script>
@endsection