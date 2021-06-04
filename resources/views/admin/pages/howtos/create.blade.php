@extends('admin.layouts.app')

@section('title', 'Создать слайдер')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('content')

    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.howtos.index'),
                'title' => 'Слайдер'
            ]
        ],
        'lastTitle' => 'Создание'
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Создать <small>слайдер</small></h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="fullscreen_toggle"></button>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('admin.howtos.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="block-content">
                <!-- Simple Wizard -->
                <div class="wizard block">
                    <!-- Step Tabs -->
                    <ul class="nav nav-tabs nav-tabs-block nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#wizard-simple-step1" data-toggle="tab">1. Русский</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#wizard-simple-step2" data-toggle="tab">2. Английский</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#wizard-simple-step3" data-toggle="tab">3. Узбекский</a>
                        </li>
                    </ul>
                    <!-- END Step Tabs -->

                    <!-- Steps Content -->
                    <div class="block-content block-content-full tab-content" style="min-height: 265px;">
                        <!-- Step 1 -->
                        <div class="tab-pane active" id="wizard-simple-step1" role="tabpanel">
                            <div class="form-group @error('title.ru') is-invalid @enderror">
                                <label for="ru_title" @error('title.ru') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('title.ru') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_title" name="title[ru]"
                                       value="{{ old('title.ru') }}">
                                @error('title.ru')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_content') is-invalid @enderror">
                                <label for="ru_content" @error('ru_content') class="col-form-label" @enderror>
                                    Полное описание
                                    @error('content.ru') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="ru_content"
                                          name="content[ru]">{{ old('content.ru') }}</textarea>
                                @error('content.ru')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('url_label.ru') is-invalid @enderror">
                                <label for="ru_url_label" @error('url_label.ru') class="col-form-label" @enderror>
                                    Кнопка
                                    @error('url_label.ru') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_url_label" name="url_label[ru]" value="{{ old('url_label.ru') }}">
                                @error('url_label.ru') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 1 -->
                        <!-- Step 2 -->
                        <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                            <div class="form-group @error('title.en') is-invalid @enderror">
                                <label for="en_title" @error('title.en') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('title.en') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="en_title" name="title[en]"
                                       value="{{ old('title.en') }}">
                                @error('title.en')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('content.en') is-invalid @enderror">
                                <label for="en_content" @error('content.en') class="col-form-label" @enderror>
                                    Полное описание
                                    @error('content.en') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="en_content"
                                          name="content[en]">{{ old('content.en') }}</textarea>
                                @error('content.en')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('url_label.en') is-invalid @enderror">
                                <label for="en_url_label" @error('url_label.en') class="col-form-label" @enderror>
                                    Кнопка
                                    @error('url_label.en') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="en_url_label" name="url_label[en]" value="{{ old('url_label.en') }}">
                                @error('url_label.en') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 2 -->

                        <!-- Step 3 --> {{--странное название класса class="tab-pane" в диве сразу под этой строкой--}}
                        <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                            <div class="form-group @error('title.uz') is-invalid @enderror">
                                <label for="uz_title" @error('title.uz') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('title.uz') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="uz_title" name="title[uz]"
                                       value="{{ old('title.uz') }}">
                                @error('uz_title')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('content.uz') is-invalid @enderror">
                                <label for="uz_content" @error('content.uz') class="col-form-label" @enderror>
                                    Полное описание
                                    @error('content.uz') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="content[uz]"
                                          name="uz_content">{{ old('content.uz') }}</textarea>
                                @error('content.uz')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('url_label.uz') is-invalid @enderror">
                                <label for="uz_url_label" @error('url_label.uz') class="col-form-label" @enderror>
                                    Кнопка
                                    @error('uz_url_label') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="uz_url_label" name="url_label[uz]" value="{{ old('url_label.uz') }}">
                                @error('url_label.uz') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="url" id="url" value="{{ old('url') }}" class="form-control">
                        <label for="url">Ссылка</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="block-content">
                    <div class="block-content text-right pb-10">
                        <button class="btn btn-success" name="save">Сохранить</button>
                        <button class="btn btn-success" name="saveQuit">Сохранить и выйти</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END Form -->
@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
@endsection
