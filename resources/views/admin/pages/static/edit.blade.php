@extends('admin.layouts.app')

@section('title', 'Редактирование статической страницы')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('content')

    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.pages.index'),
                'title' => 'Статические страницы'
            ]
        ],
        'lastTitle' => 'Редактирование'
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Редактирование <small>статической страницы</small></h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="fullscreen_toggle"></button>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('admin.pages.update', $page->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
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
                                       value="{{ $page->getTranslation('title', 'ru') }}">
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
                                          name="content[ru]">{{ $page->getTranslation('content', 'ru') }}</textarea>
                                @error('content.ru')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('slug.ru') is-invalid @enderror">
                                <label for="ru_slug" @error('slug.ru') class="col-form-label" @enderror>
                                    Slug
                                    @error('slug.ru') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_slug" name="slug[ru]" value="{{ $page->getTranslation('slug', 'ru') }}">
                                @error('slug.ru') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
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
                                       value="{{ $page->getTranslation('title', 'en') }}">
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
                                          name="content[en]">{{ $page->getTranslation('content', 'en') }}</textarea>
                                @error('content.en')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('slug.en') is-invalid @enderror">
                                <label for="en_slug" @error('slug.en') class="col-form-label" @enderror>
                                    Slug
                                    @error('slug.en') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="en_slug" name="slug[en]" value="{{ $page->getTranslation('slug', 'en') }}">
                                @error('slug.en') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
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
                                       value="{{ $page->getTranslation('title', 'uz') }}">
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
                                          name="uz_content">{{ $page->getTranslation('content', 'uz') }}</textarea>
                                @error('content.uz')
                                <div id="val-username-error"
                                     class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('slug.uz') is-invalid @enderror">
                                <label for="uz_slug" @error('slug.uz') class="col-form-label" @enderror>
                                    Slug
                                    @error('uz_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="uz_slug" name="slug[uz]" value="{{ $page->getTranslation('slug', 'uz') }}">
                                @error('slug.uz') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <h3 class="font-size-h3 font-w600 my-20">SEO</h3>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_title" id="meta_title" value="{{ $page->meta_title }}" class="form-control">
                        <label for="meta_title">Мета тег title</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_description" id="meta_description" value="{{ $page->meta_description }}" class="form-control">
                        <label for="meta_description">Мета тег description</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ $page->meta_keywords }}" class="form-control">
                        <label for="meta_keywords">Мета тег keywords</label>
                    </div>
                </div>
                <div class="block-content">
                    <div class="block-content text-right pb-10">
                        <button class="btn btn-success" name="save">Сохранить</button>
                        <button class="btn btn-success" name="saveQuit">Сохранить и выйти</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END Form -->
    </div>

@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>


@endsection
