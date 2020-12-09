@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('title')Справочник {{ $category->ru_title }} @endsection

@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.categories.index'),
                'title' => 'Категории справочника'
            ]
        ],
        'lastTitle' => $category->ru_title
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{ $category->ru_title }}</h3>
        </div>
        <!-- Form -->
        <form action="{{ route('admin.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
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
                    <div class="block-content block-content-full tab-content">
                        <!-- Step 1 -->
                        <div class="tab-pane active" id="wizard-simple-step1" role="tabpanel">
                            <div class="form-group @error('ru_title') is-invalid @enderror">
                                <label for="ru_title" @error('ru_title') class="col-form-label" @enderror>
                                Заголовок
                                @error('ru_title') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_title" name="ru_title" value="{{ $category->ru_title }}">
                                @error('ru_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_slug') is-invalid @enderror">
                                <label for="ru_title" @error('ru_slug') class="col-form-label" @enderror>
                                Slug
                                @error('ru_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="ru_slug" name="ru_slug" value="{{ $category->ru_slug }}">
                                @error('ru_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_description') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="ru_description" id="ruDescription"
                                              class="form-control">{{ $category->ru_description }}</textarea>
                                    <label for="ruDescription">Описание</label>
                                </div>
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
                                <input class="form-control" type="text" id="en_title" name="en_title" value="{{ $category->en_title }}">
                                @error('en_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_slug') is-invalid @enderror">
                                <label for="ru_title" @error('en_slug') class="col-form-label" @enderror>
                                Slug
                                @error('en_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="en_slug" name="en_slug" value="{{ $category->en_slug }}">
                                @error('en_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_description') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="en_description" id="enDescription"
                                              class="form-control">{{ $category->en_description }}</textarea>
                                    <label for="enDescription">Описание</label>
                                </div>
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
                                <input class="form-control" type="text" id="uz_title" name="uz_title" value="{{ $category->uz_title }}">
                                @error('uz_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_slug') is-invalid @enderror">
                                <label for="ru_title" @error('uz_slug') class="col-form-label" @enderror>
                                Slug
                                @error('uz_slug') <span class="text-danger">*</span> @enderror
                                </label>
                                <input class="form-control" type="text" id="uz_slug" name="uz_slug" value="{{ $category->uz_slug }}">
                                @error('uz_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_description') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="uz_description" id="uzDescription"
                                              class="form-control">{{ $category->uz_description }}</textarea>
                                    <label for="ruDescription">Описание</label>
                                </div>
                                @error('uz_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <!-- END Simple Wizard -->
                <div class="form-group">
                    <label for="parent_id">Родительская категория</label>
                    <select name="parent_id" id="select2" class="form-control">
                        <option value="0">-- нет --</option>
                        @foreach($categories as $category_list)
                            @include('admin.pages.categories.components.category', ['delimiter' => ''])
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Изображение</label>
                    @if($category->image != null)
                        <br>
                        <img src="{{ $category->getImage() }}" style="width: 200px;" alt="{{ $category->ru_title }}">
                        <br>
                        <a href="{{ route('admin.categories.remove.image', $category->id) }}" class="btn btn-danger">Удалить</a>
                        <br>
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label class="css-control css-control-primary css-checkbox">
                        <input type="checkbox" name="favorite" id="favorite" class="css-control-input" @if($category->favorite) checked @endif>
                        <span class="css-control-indicator"></span>Избранное (отобразиться на главной)
                    </label>
                </div>
                <h3 class="font-size-h3 font-w600 my-20">Design</h3>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="template" id="template" class="form-control js-select2">
                            @foreach($templates as $template)
                                <option value="{{ $template }}" @if($category->template == $template) selected @endif>{{ $template }}</option>
                            @endforeach
                        </select>
                        <label for="template">Шаблон</label>
                    </div>
                </div>
                <h3 class="font-size-h3 font-w600 my-20">SEO</h3>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_title" id="meta_title" value="{{ $category->meta_title }}" class="form-control">
                        <label for="meta_title">Мета тег title</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_description" id="meta_description" value="{{ $category->meta_description }}" class="form-control">
                        <label for="meta_description">Мета тег description</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ $category->meta_keywords }}" class="form-control">
                        <label for="meta_keywords">Мета тег keywords</label>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="block-content text-right pb-10">
                    @method('put')
                    <button class="btn btn-success" type="submit">Сохранить</button>
                </div>
            </div>
        </form>
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
    <script>
        jQuery(function() {
            Codebase.helper('select2');
        });
    </script>
@endsection
