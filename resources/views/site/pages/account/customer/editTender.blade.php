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
@endsection

@section('account.content')
    <form action="{{ route('site.tenders.edit', $tender->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders') }}">
        <section class="box-admin">
            <div class="header-box-admin">
                <h3>Редактировать данные</h3>
            </div>
            <div class="body-box-admin">
                <div class="form-group">
                    <label for="title">Что требуется сделать?</label>
                    <input type="text" name="title" id="title"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Название проекта..." value="{{ $tender->title }}">
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
                                                               class="custom-control-input" value="{{ $category->id }}" @if($tender->categories()->pluck('category_id')->contains($category->id)) checked @endif>
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
                    <textarea name="description" @error('description') class="is-invalid" @enderror id="description">{{ $tender->description }}</textarea>
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
                            <label for="budget">Ориентировочный бюджет</label>
                            <input type="text" name="budget" id="budget" class="form-control @error('budget') is-invalid @enderror" placeholder="Укажите ориентировочный бюджет в сумах..." value="{{ $tender->budget }}">
                            @error('budget')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="deadline">Срок окончания приёма заявок</label>
                            <input type="text" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ \Carbon\Carbon::create($tender->deadline)->format('d.m.Y') }}">
                            @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-30 mt-5">
                    <button class="btn btn-light-green"><i class="fas fa-save"></i>  Сохранить конкурс</button>
                </div>
            </div>
        </section>
    </form>
    <section class="box-admin">
        <div class="header-box-admin">
            <h3>Заявки от исполнителей</h3>
        </div>
    </section>
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
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr(document.getElementById('deadline'), {
                dateFormat: 'd.m.Y',
                minDate: new Date()
            });
        });
    </script>
@endsection
