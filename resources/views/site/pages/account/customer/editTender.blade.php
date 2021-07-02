@extends('site.layouts.account')

@section('title', "Релактировать конкрус $tender->title")

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('account.title.h1', "Конкурс $tender->title")

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

@section('account.content')
    <form action="{{ route('site.tenders.edit', $tender->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders') }}">
        <section class="box-admin">
            <div class="header-box-admin">
                <h3>{{ __('Редактировать данные') }}</h3>
            </div>
            <div class="body-box-admin">
                <div class="form-group">
                    <label for="title">{{ __('Что требуется сделать?') }}</label>
                    <input type="text" name="title" id="title"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Название проекта..." value="{{ $tender->title }}">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="place">{{ __('Место оказания услуги') }}</label>
                    <select name="place" id="place" class="form-control">
                        <option value="dont_mind" @if ($tender->place == 'dont_mind') selected @endif>{{ __('dont_mind') }}</option>
                        <option value="my_place" @if ($tender->place == 'my_place') selected @endif>{{ __('my_place') }}</option>
                        <option value="contractor_place" @if ($tender->place == 'contractor_place') selected @endif>{{ __('contractor_place') }}</option>
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
                <label class="mt-3">{{ __('Выберите услуги:') }} </label>
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
                                                        class="custom-control-input" value="{{ $category->id }}" @if($tender->categories()->pluck('category_id')->contains($category->id)) checked @endif>
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
                    <label for="description">{{ __('Опишите проект подробнее') }}</label>
                    <textarea name="description" @error('description') class="is-invalid" @enderror id="description">{{ $tender->description }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="additional_info">{{ __('Дополнительная информация (показывается исполнителю)') }}</label>
                    <textarea name="additional_info" @error('additional_info') class="is-invalid" @enderror id="additional_info">{{ $tender->additional_info }}</textarea>
                    @error('additional_info')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="other_info">{{ __('Способы связи с вами (показывается исполнителю)') }}</label>
                    <textarea name="other_info" @error('other_info') class="is-invalid" @enderror id="other_info">{{ $tender->other_info }}</textarea>
                    @error('other_info')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="upload-avatar">
                    <div class="upload">
                        <div class="desc"><p>{{ __('Если есть готовое задание или пожелания, обязательно прикрепите их
                                сюда. Исполнители лучше поймут задачу и зададут минимум уточняющих вопросов, а вы
                                сэкономите много времени.') }}</p>
                            <p>{{ __('Максималльный размер: 50 MB    Максимальное количество файлов: 10') }}</p></div>
                        <div class="btn-upload">
                            <input type="file" name="files[]" id="file" multiple>
                            <span class="btn btn-light-green">{{ __('Прикрепить файлы') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 form-group">
                        <label for="work_start_at">{{ __('Дата начала работ') }}</label>
                        <input type="text" class="date form-control @error('work_start_at') is-invalid @enderror" id="work_start_at" name="work_start_at" value="{{ optional($tender->work_start_at)->format('d.m.Y H:i') }}">
                        @error('work_start_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="work_end_at">{{ __('Дата окончания работ') }}</label>
                        <input type="text" class="date form-control @error('work_end_at') is-invalid @enderror" id="work_end_at" name="work_end_at" value="{{ optional($tender->work_end_at)->format('d.m.Y H:i') }}">
                        @error('work_end_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="budget">{{ __('Ориентировочный бюджет') }}</label>
                            <input type="number" name="budget" id="budget" class="form-control @error('budget') is-invalid @enderror" placeholder="Укажите ориентировочный бюджет в сумах..." value="{{ $tender->budget }}">
                            @error('budget')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="deadline">{{ __('Срок окончания приёма заявок') }}</label>
                            <input type="text" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ $tender->deadline->format('d.m.Y') }}">
                            @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                                <div class="form-group">
                                    <label for="geo_location">{{ __('Укажите местоположение') }}</label>
                                    <input hidden class="form-control" id="geo_location" name="geo_location" value="41.31064707835609, 69.2795380845336">
                                    <div id="location"></div>
                                </div>

                                <div class="form-group">
                                    <label for="remote" class="form-check-label">
                                        {{ __('Удаленная работа') }}
                                    </label>
                                    <input type="checkbox" name="remote" id="remote"  class="css-control-input" >
                                </div>



                    </div>
                </div>
                <div class="mb-30 mt-5">
                    <button class="btn btn-light-green"><i class="fas fa-save"></i>  {{ __('Сохранить конкурс') }}</button>
                </div>
            </div>
        </section>
    </form>
    <section class="box-admin">
        <div class="header-box-admin">
            <h3>{{ __('Заявки от исполнителей') }}</h3>
        </div>
    </section>
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
                    center: [{{empty($tender->geo_location) ? "43.2220, 76.8512" :$tender->geo_location }}],
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

                    }
                    else {
                        map.balloon.close();
                    }
                });
            }
        });
    </script>
@endsection
