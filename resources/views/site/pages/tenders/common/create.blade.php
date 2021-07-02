@extends('site.layouts.app')

@section('title', 'Создать конкурс')

@section('meta')
    <meta name="title" content="">
    <meta name="description" content="">
@endsection
@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">

    <style>
        #location {
            width: 800px;
            height: 300px;
            padding: 0;
            margin: 0;
        }
    </style>
@endsection




@section('content')

    <div class="primary-page">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="title">Сервис поможет найти специалиста в сфере digital</h2>
                <p class="mt-3">Получите предложения по решению задач от дизайна и верстки до программирования и
                    тестирования. Вы можете разместить заказ и ждать откликов или самостоятельно найти специалистов в
                    каталоге.</p>
            </div>
            <div class="box-admin tender-box">
                <div class="header-box-admin">
                    <h3>Создание конкурса</h3>
                </div>
                <hr>
                <div class="body-box-admin">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Что требуется сделать?</label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Название проекта..." value="{{ old('title') }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="place">Место оказания услуги</label>
                            <select name="place" id="place" class="form-control">
                                <option selected value="dont_mind">{{ __('dont_mind') }}</option>
                                <option value="my_place">{{ __('my_place') }}</option>
                                <option value="contractor_place">{{ __('contractor_place') }}</option>
                            </select>
                            @error('place')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="currency">Выберите валюту</label>
                            <select name="currency" id="currency" class="form-control">
                                <option selected value="Тенге">{{ __('Тенге') }}</option>
                                <option value="Сум">{{ __('Сум') }}</option>
                                <option selected value="Рубль">{{ __('Рубль') }}</option>
                                <option value="Доллар">{{ __('Доллар') }}</option>
                            </select>
                            @error('currency')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="mt-3">Выберите услуги: </label>
                        @error('categories')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <ul class="nav nav-tabs mt-3" id="needsTabs" role="tablist">
                            @foreach($parentCategories as $key => $parent)
                                <li class="nav-item">
                                    <a href="#tab-content-{{ $parent->id }}"
                                       class="nav-link @if ($key == 0) active @endif"
                                       @if ($key == 0) aria-selected="true" @else aria-selected="false"
                                       @endif data-toggle="tab" role="tab" aria-controls="tab-content-{{ $parent->id }}"
                                       id="tab-{{ $parent->id }}">{{ $parent->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content mt-3" id="needsTabsContent">
                            @foreach($parentCategories as $key => $parent)
                                <div class="tab-pane fade @if($key == 0) show active @endif"
                                     id="tab-content-{{ $parent->id }}" role="tabpanel"
                                     aria-labelledby="tab-{{ $parent->id }}">
                                    <div class="row">
                                        <ul class="list-group list-group-flush">
                                            @foreach($parent->categories as $category)
                                                <li class="list-group-item">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="categories[]"
                                                               id="category-{{ $category->id }}"
                                                               class="custom-control-input" value="{{ $category->id }}">
                                                        <label for="category-{{ $category->id }}"
                                                               class="custom-control-label">{{ $category->title }}</label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mt-3">
                            <label for="description">Опишите проект подробнее</label>
                            <textarea name="description" @error('description') class="is-invalid"
                                      @enderror id="description">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="additional_info">Дополнительная информация (показывается исполнителю)</label>
                            <textarea name="additional_info" @error('additional_info') class="is-invalid"
                                      @enderror id="additional_info">{{ old('additional_info') }}</textarea>
                            @error('additional_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="other_info">Способы связи с вами (показывается исполнителю)</label>
                            <textarea name="other_info" @error('other_info') class="is-invalid"
                                      @enderror id="other_info">{{ old('other_info') }}</textarea>
                            @error('other_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="upload-avatar">
                            <div class="upload">
                                <div class="desc"><p>Если есть готовое задание или пожелания, обязательно прикрепите их
                                        сюда. Исполнители лучше поймут задачу и зададут минимум уточняющих вопросов, а
                                        вы
                                        сэкономите много времени.</p>
                                    <p>Максималльный размер: 50 MB Максимальное количество файлов: 10</p></div>
                                <div class="btn-upload">
                                    <input type="file" name="files[]" id="file" multiple>
                                    <span class="btn btn-light-green">Прикрепить файлы</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 form-group">
                                <label for="work_start_at">Дата начала работ</label>
                                <input type="text"
                                       class="date form-control @error('work_start_at') is-invalid @enderror"
                                       id="work_start_at" name="work_start_at" value="{{ old('work_start_at') }}">
                                @error('work_start_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="work_end_at">Дата окончания работ</label>
                                <input type="text" class="date form-control @error('work_end_at') is-invalid @enderror"
                                       id="work_end_at" name="work_end_at" value="{{ old('work_end_at') }}">
                                @error('work_end_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="budget">Ориентировочный бюджет</label>
                                    <input type="number" name="budget" id="budget" onkeypress='validate(event)'
                                           class="form-control @error('budget') is-invalid @enderror"
                                           placeholder="Укажите ориентировочный бюджет..." value="{{ old('budget') }}">
                                    @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deadline">Срок окончания приёма заявок</label>
                                    <input type="text" class="form-control @error('deadline') is-invalid @enderror"
                                           id="deadline" name="deadline" value="{{ old('deadline') }}">
                                    @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="geo_location">Укажите местоположение</label>
                                    <input hidden class="form-control" id="geo_location" name="geo_location"
                                           value="41.31064707835609, 69.2795380845336">
                                    <div id="location"></div>
                                </div>

                                <div class="form-group">
                                    <label for="remote" class="form-check-label">
                                        Удаленная работа
                                    </label>
                                    <input type="checkbox" name="remote" id="remote" class="css-control-input">
                                </div>
                            </div>
                        </div>
                        <div class="mb-30 mt-5">
                            <button class="btn btn-light-green"><i class="fas fa-share"></i> Создать конкурс</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/{{ config('app.locale') }}.js"></script>
    <script>flatpickr.localize(flatpickr.l10ns.{{ config('app.locale') }});</script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script>ClassicEditor
            .create(document.querySelector('#description'), {

                toolbar: {
                    items: [
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                language: 'ru',
                licenseKey: '',
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>ClassicEditor
            .create(document.querySelector('#additional_info'), {

                toolbar: {
                    items: [
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                language: 'ru',
                licenseKey: '',
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>ClassicEditor
            .create(document.querySelector('#other_info'), {

                toolbar: {
                    items: [
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                language: 'ru',
                licenseKey: '',
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('#deadline', {
                dateFormat: 'd.m.Y',
                minDate: new Date()
            });
            flatpickr('.date', {
                dateFormat: 'd.m.Y H:i',
                minDate: new Date(),
                enableTime: true
            });

            // document.getElementById('budget').onkeydown = function(event) {
            //     console.log(event);
            //
            //     let charCode = (event.which) ? event.which : event.keyCode;
            //     if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105) && charCode != 189 && charCode != 32 && charCode != 116) {
            //         return false;
            //     }
            //     return true;
            // };
        });
    </script>

    {{-- Map--}}
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey={{ config('services.yandex.maps_api') }}"
            type="text/javascript"></script>
    <script>
        //Map input
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
                    center: [43.2220,76.8512],
                    zoom: 10
                });
            });

            function createMap(state) {
                map = new ymaps.Map('location', state);
                map.events.add('click', function (e) {
                    if (!map.balloon.isOpen()) {
                        var coords = e.get('coords');
                        $('input[name=geo_location]').val(coords);
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

                    } else {
                        map.balloon.close();
                    }
                });
            }
        });
    </script>


@endsection
