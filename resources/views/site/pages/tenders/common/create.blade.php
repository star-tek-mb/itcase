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
                        <label class="mt-3">Выберите услуги: </label>
                        @error('categories')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <ul class="nav nav-tabs mt-3" id="needsTabs" role="tablist">
                            @foreach($needs as $key => $need)
                                <li class="nav-item">
                                    <a href="#tab-content-{{ $need->id }}"
                                       class="nav-link @if ($key == 0) active @endif"
                                       @if ($key == 0) aria-selected="true" @else aria-selected="false"
                                       @endif data-toggle="tab" role="tab" aria-controls="tab-content-{{ $need->id }}"
                                       id="tab-{{ $need->id }}">{{ $need->ru_title }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content mt-3" id="needsTabsContent">
                            @foreach($needs as $key => $need)
                                <div class="tab-pane fade @if($key == 0) show active @endif"
                                     id="tab-content-{{ $need->id }}" role="tabpanel"
                                     aria-labelledby="tab-{{ $need->id }}">
                                    <div class="row">
                                        @foreach($need->menuItems as $item)
                                            <div class="col-sm-12 col-md-3">
                                                <h5>{{ $item->ru_title }}</h5>
                                                <ul class="list-group list-group-flush">
                                                    @foreach($item->categories as $category)
                                                        <li class="list-group-item">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="categories[]"
                                                                       id="category-{{ $category->id }}"
                                                                       class="custom-control-input" value="{{ $category->id }}">
                                                                <label for="category-{{ $category->id }}"
                                                                       class="custom-control-label">{{ $category->getTitle() }}</label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mt-3">
                            <label for="description">Опишите проект подробнее</label>
                            <textarea name="description" @error('description') class="is-invalid" @enderror id="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="upload-avatar">
                            <div class="upload">
                                <div class="desc"><p>Если есть готовое задание или пожелания, обязательно прикрепите их
                                        сюда. Исполнители лучше поймут задачу и зададут минимум уточняющих вопросов, а вы
                                        сэкономите много времени.</p>
                                    <p>Максималльный размер: 50 MB    Максимальное количество файлов: 10</p></div>
                                <div class="btn-upload">
                                    <input type="file" name="file" id="file" multiple>
                                    <span class="btn btn-light-green">Прикрепить файлы</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="budget">Ориентировочный бюджет, сум</label>
                                    <input type="text" name="budget" id="budget" onkeypress='validate(event)' class="form-control @error('budget') is-invalid @enderror" placeholder="Укажите ориентировочный бюджет..." value="{{ old('budget') }}">
                                    @error('budget')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Дата начало работы</label>
                                    <input type="text" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deadline">Срок окончания приёма заявок</label>
                                    <input type="text" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline') }}">
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

    <script>
    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
          theEvent.returnValue = false;
          if(theEvent.preventDefault) theEvent.preventDefault();
        }
      }
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr(document.getElementById('deadline'), {
                dateFormat: 'd.m.Y',
                minDate: new Date()
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
@endsection
