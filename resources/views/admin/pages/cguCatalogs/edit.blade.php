@extends('admin.layouts.app')

@section('title', 'Создание ЦГУ Категории')

@section('css')

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">

@endsection

@section('title') Добавить ЦГУ категорию @endsection

@section('content')

    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.cgucatalogs.index'),
                'title' => 'Цгу Каталоги'
            ]
        ],
        'lastTitle' => 'Редактирование'
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Редактирование <small>Цгу Каталоги</small></h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>
        <!-- Form -->
        <form action="{{ route('admin.cgucatalogs.update', $catalog->id) }}" method="post" enctype="multipart/form-data">
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
                            <div class="form-group @error('ru_title') is-invalid @enderror">
                                <label for="ru_title" @error('ru_title') class="col-form-label" @enderror>
                                Заголовок
                                @error('ru_title') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_title" name="ru_title" value="{{ $catalog->ru_title }}">
                                @error('ru_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_slug') is-invalid @enderror">
                                <label for="ru_title" @error('ru_slug') class="col-form-label" @enderror>
                                Slug
                                @error('ru_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_slug" name="ru_slug" value="{{ $catalog->ru_slug }}">
                                @error('ru_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_slug') is-invalid @enderror">
                                <label for="ru_title" @error('ru_description') class="col-form-label" @enderror>
                                Описание
                                @error('ru_description') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="ru_description" name="ru_description">{{ $catalog->ru_description }}</textarea>
                                @error('ru_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
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
                                <input class="form-control" type="text" id="en_title" name="en_title" value="{{ $catalog->en_title }}">
                                @error('en_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_slug') is-invalid @enderror">
                                <label for="ru_title" @error('en_slug') class="col-form-label" @enderror>
                                Slug
                                @error('en_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="en_slug" name="en_slug" value="{{ $catalog->en_title }}">
                                @error('en_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_slug') is-invalid @enderror">
                                <label for="ru_title" @error('en_description') class="col-form-label" @enderror>
                                Описание
                                @error('en_description') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="en_description" name="en_description">{{ $catalog->en_description }}</textarea>
                                @error('en_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 2 -->

                        <!-- Step 3 -->
                        <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                            <div class="form-group @error('uz_title') is-invalid @enderror">
                                <label for="uz_title" @error('uz_title') class="col-form-label" @enderror>
                                Заголовок
                                @error('uz_title') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="uz_title" name="uz_title" value="{{ $catalog->uz_title }}">
                                @error('uz_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_slug') is-invalid @enderror">
                                <label for="ru_title" @error('uz_slug') class="col-form-label" @enderror>
                                Slug
                                @error('uz_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="uz_slug" name="uz_slug" value="{{ $catalog->uz_slug }}">
                                @error('uz_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_slug') is-invalid @enderror">
                                <label for="ru_title" @error('uz_description') class="col-form-label" @enderror>
                                Описание
                                @error('uz_description') <span class="text-danger">*</span> @enderror
                                </label>
                                <textarea class="form-control" type="text" id="uz_description" name="uz_description">{{ $catalog->uz_description }}</textarea>
                                @error('uz_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="parent_id">Ссылка на сайт</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="link" value="{{ $catalog->link }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="parent_id">Категории</label>
                                </div>
                                <div class="col-md-12">
                                    <select name="category_id" id="select2" class="form-control">
                                        <option value="0">-- нет --</option>
                                        @foreach($categories as $category_list)
                                            @include('admin.pages.cguCatalogs.components.category', ['delimiter' => ''])
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="parent_id">Активность</label>
                                </div>
                                <div class="col-md-12">
                                    <select name="parent_id" id="select2" class="form-control">
                                        <option value="1" @if($catalog->active == 1) selected @endif>Активен</option>
                                        <option value="0" @if($catalog->active == 0) selected @endif>Не активен</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="parent_id">Ссылка на видео с ютуб</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="video" value="{{ old('video') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">Файл</label>
                            @if($catalog->file != null)
                                <br>
                                    {!! $catalog->getRenderedFile() !!}
                                <br>
                                <a onclick="return confirm('Вы уверены?')" href="{{ route('admin.cgucatalogs.remove.file', $catalog->id) }}" class="btn btn-danger">Удалить</a>
                                <br>
                            @endif
                            <input type="file" name="file" class="form-control">
                        </div>

                    </div>
                    <!-- END Steps Content -->

                    <!-- Steps Navigation -->
                    <div class="block-content block-content-sm block-content-full bg-body-light">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-alt-secondary" data-wizard="prev">
                                    <i class="fa fa-angle-left mr-5"></i> Предедущее
                                </button>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                                    Next <i class="fa fa-angle-right ml-5"></i>
                                </button>
                                <button type="submit" class="btn btn-alt-primary d-none" data-wizard="finish">
                                    <i class="fa fa-check mr-5"></i> Следующее
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- END Steps Navigation -->
                </div>
                <!-- END Simple Wizard -->
            </div>
            <div class="block-content">
                <div class="block-content text-right pb-10">
                    <button class="btn btn-success" name="save">Сохранить</button>
                    <button class="btn btn-success" name="saveQuit">Сохранить и выйти</button>
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


    <script>
        $(function(){
            $.fn.bootstrapWizard.defaults.nextSelector     = '[data-wizard="next"]';
            $.fn.bootstrapWizard.defaults.previousSelector = '[data-wizard="prev"]';

            $('.wizard').bootstrapWizard({
                onTabShow: function(tab, navigation, index) {
                    var percent = ((index + 1) / navigation.find('li').length) * 100;

                    // Get progress bar
                    var progress = navigation.parents('.block').find('[data-wizard="progress"] > .progress-bar');

                    // Update progress bar if there is one
                    if (progress.length) {
                        progress.css({ width: percent + 1 + '%' });
                    }
                }
            });

            $('#select2').select2();
        })
    </script>
@endsection
