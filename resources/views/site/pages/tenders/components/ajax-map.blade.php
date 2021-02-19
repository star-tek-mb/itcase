<div class="header-list-job d-flex flex-wrap justify-content-between align-items-center">
    <h4>{{ $tendersCount }} Конкурсов найдено</h4>
    @if (!\Request::is('tenders'))
        <a class="btn btn-outline-success" href="{{ route('site.maps.index') }}">Все результаты</a>
    @endif
</div>
<div id="map"></div>
<script>
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("map", {
                center: [ {{$location}} ],
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
                                "hintContent": "Центр выдачи в Великом Новгороде"
                            }
                        },

                        @endforeach
                    ]
                }).addToMap(myMap)@if(!empty($distance)),

            circle = new ymaps.Circle([[{{$location}}],{{ $distance*1000 }}], null, {draggable: true});

        circle.events.add('drag', function () {
            // Объекты, попадающие в круг, будут становиться красными.
            var objectsInsideCircle = objects.searchInside(circle);
            objectsInsideCircle.setOptions('preset', 'islands#redIcon');
            // Оставшиеся объекты - синими.
            objects.remove(objectsInsideCircle).setOptions('preset', 'islands#blueIcon');
        });
        myMap.geoObjects.add(circle);
        @endif

            myPlacemark = new ymaps.Placemark( [{{ $location }}],  {
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
        myMap.geoObjects
            .add(myPlacemark);
    }
</script>



