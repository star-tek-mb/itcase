@extends('admin.layouts.app')

@section('title', 'Создать запись в блоге')

@section('css')

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">

@endsection

@section('content')

    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.blogposts.index'),
                'title' => 'Записи блога'
            ]
        ],
        'lastTitle' => 'Создание'
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Создать <small>запись в блоге</small></h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="fullscreen_toggle"></button>
                {{--<button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">--}}
                {{--<i class="si si-pin"></i>--}}
                {{--</button>--}}
                {{--<button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">--}}
                {{--<i class="si si-refresh"></i>--}}
                {{--</button>--}}
                {{--<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>--}}
                {{--<button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">--}}
                {{--<i class="si si-close"></i>--}}
                {{--</button>--}}
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('admin.blogposts.store') }}" method="post" enctype="multipart/form-data">
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
                            <div class="form-group @error('ru_title') is-invalid @enderror">
                                <label for="ru_title" @error('ru_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('ru_title') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_title" name="ru_title"
                                       value="{{ old('ru_title') }}">
                                @error('ru_title')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_short_content') is-invalid @enderror">
                                <label for="ru_short_content"
                                       @error('ru_short_content') class="col-form-label" @enderror>
                                    Краткое описание
                                    @error('ru_short_content') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="ru_short_content"
                                          name="ru_short_content">{{ old('ru_short_content') }}</textarea>
                                @error('ru_short_content')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_content') is-invalid @enderror">
                                <label for="ru_content" @error('ru_content') class="col-form-label" @enderror>
                                    Полное описание
                                    @error('ru_content') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="ru_content"
                                          name="ru_content">{{ old('ru_content') }}</textarea>
                                @error('ru_content')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_slug') is-invalid @enderror">
                                <label for="ru_title" @error('ru_slug') class="col-form-label" @enderror>
                                    Slug
                                    @error('ru_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_slug" name="ru_slug" value="{{ old('ru_slug') }}">
                                @error('ru_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 1 -->
                        <!-- Step 2 -->
                        <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                            <div class="form-group @error('en_title') is-invalid @enderror">
                                <label for="uz_title" @error('en_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('en_title') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="en_title" name="en_title"
                                       value="{{ old('en_title') }}">
                                @error('en_title')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_short_content') is-invalid @enderror">
                                <label for="ru_title" @error('en_short_content') class="col-form-label" @enderror>
                                    Краткое описание
                                    @error('en_short_content') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="en_short_content"
                                          name="en_short_content">{{ old('en_short_content') }}</textarea>
                                @error('en_short_content')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_content') is-invalid @enderror">
                                <label for="ru_title" @error('en_content') class="col-form-label" @enderror>
                                    Полное описание
                                    @error('en_content') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="en_content"
                                          name="en_content">{{ old('en_content') }}</textarea>
                                @error('en_content')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_slug') is-invalid @enderror">
                                <label for="ru_title" @error('en_slug') class="col-form-label" @enderror>
                                    Slug
                                    @error('en_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="en_slug" name="en_slug" value="{{ old('en_title') }}">
                                @error('en_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 2 -->

                        <!-- Step 3 --> {{--странное название класса class="tab-pane" в диве сразу под этой строкой--}}
                        <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                            <div class="form-group @error('uz_title') is-invalid @enderror">
                                <label for="uz_title" @error('uz_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('uz_title') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="uz_title" name="uz_title"
                                       value="{{ old('uz_title') }}">
                                @error('uz_title')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_short_content') is-invalid @enderror">
                                <label for="ru_title" @error('uz_short_content') class="col-form-label" @enderror>
                                    Краткое описание
                                    @error('uz_short_content') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="uz_description"
                                          name="uz_short_content">{{ old('uz_short_content') }}</textarea>
                                @error('uz_short_content')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_content') is-invalid @enderror">
                                <label for="ru_title" @error('uz_content') class="col-form-label" @enderror>
                                    Полное описание
                                    @error('uz_content') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="uz_content"
                                          name="uz_content">{{ old('uz_content') }}</textarea>
                                @error('uz_content')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_slug') is-invalid @enderror">
                                <label for="ru_title" @error('uz_slug') class="col-form-label" @enderror>
                                    Slug
                                    @error('uz_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="uz_slug" name="uz_slug" value="{{ old('uz_slug') }}">
                                @error('uz_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <!-- END Simple Wizard -->
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="category_id" id="categoryId" class="form-control js-select2">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->getTitle() }}</option>
                            @endforeach
                        </select>
                        <label for="categoryId">Категория</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="block-content">
                <div class="block-content text-right pb-10">
                    <button class="btn btn-success" name="save">Сохранить</button>
                    <button class="btn btn-success" name="saveQuit">Сохранить и выйти</button>
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
