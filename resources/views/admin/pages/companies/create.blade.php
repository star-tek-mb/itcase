@extends('admin.layouts.app')

@section('title')
    Добавить компанию
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">
@endsection
@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.companies.index'),
                'title' => 'Компании справочника'
            ]
        ],
        'lastTitle' => 'Создание'
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Добавить компанию</h3>
        </div>
        <form action="{{ route('admin.companies.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="block-content">
                <div class="wizard-block">
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
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="ruTitle" name="ru_title" value="{{ old('ru_title') }}">
                                    <label for="ruTitle" @error('ru_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('ru_title') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('ru_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_slug') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="ru_slug" name="ru_slug" value="{{ old('ru_slug') }}">
                                    <label for="ru_slug" @error('ru_slug') class="col-form-label" @enderror>
                                        Slug
                                        @error('ru_slug') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('ru_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_description') is-invalid @enderror">
                                <label for="ruDescription">Описание</label>
                                    <textarea name="ru_description" id="ruDescription"
                                              class="form-control">{{ old('ru_description') }}</textarea>
                                @error('ru_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 1 -->

                        <!-- Step 2 -->
                        <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                            <div class="form-group @error('en_title') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="en_title" name="enTitle" value="{{ old('en_title') }}">
                                    <label for="enTitle" @error('en_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('en_title') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('en_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_slug') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="en_slug" name="en_slug" value="{{ old('en_slug') }}">
                                    <label for="en_slug" @error('en_slug') class="col-form-label" @enderror>
                                        Slug
                                        @error('en_slug') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('en_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_description') is-invalid @enderror">
                                <label for="enDescription">Описание</label>
                                    <textarea name="en_description" id="enDescription"
                                              class="form-control">{{ old('en_description') }}</textarea>
                                @error('en_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 2 -->

                        <!-- Step 3 -->
                        <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                            <div class="form-group @error('uz_title') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="uzTitle" name="uz_title" value="{{ old('uz_title') }}">
                                    <label for="uzTitle" @error('uz_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('uz_title') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('uz_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_slug') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="uz_slug" name="uz_slug" value="{{ old('uz_slug') }}">
                                    <label for="uz_slug" @error('uz_slug') class="col-form-label" @enderror>
                                        Slug
                                        @error('uz_slug') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('uz_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_description') is-invalid @enderror">
                                <label for="uzDescription">Описание</label>
                                    <textarea name="uz_description" id="uzDescription"
                                              class="form-control">{{ old('uz_description') }}</textarea>
                                @error('uz_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
                        <label for="price">Цена</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <input type="text" name="url" id="url" value="{{ old('url') }}" class="form-control">
                        <label for="url">Ссылка на сайт</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="css-control css-control-primary css-checkbox">
                        <input type="checkbox" name="favourite" id="favourite" class="css-control-input">
                        <span class="css-control-indicator"></span>Избранное (отобразиться на главной)
                    </label>
                </div>
                <div class="form-group">
                    <label class="css-control css-control-primary css-checkbox">
                        <input type="checkbox" name="showPage" id="showPage" class="css-control-input" checked>
                        <span class="css-control-indicator"></span>Отображать собственную страницу компании в справочнике (в ином случае будет просто ссылка на сайт компании)
                    </label>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="need_id" id="needId" class="form-control js-select2">
                            <option value="0" selected>Нет</option>
                            @foreach($needs  as $need)
                                <option value="{{ $need->id }}">{{ $need->ru_title }}</option>
                            @endforeach
                        </select>
                        <label for="needId">Тип потребности</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="category_id" id="categoryId" class="form-control js-select2">
                            <option value="0">-- нет --</option>
                            @foreach($categories as $category_list)
                                @include('admin.pages.companies.components.category', ['delimiter' => ''])
                            @endforeach
                        </select>
                        <label for="categoryId">Категория</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="faq_id" id="faq_id" class="form-control">
                            <option value="0">Нет</option>
                            @foreach($faqs as $faq)
                                <option value="{{ $faq->id }}">{{ $faq->getTitle() }}</option>
                            @endforeach
                        </select>
                        <label for="faq_id">FAQ группа</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="services[]" id="services" class="form-control js-select2" multiple="multiple">
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->ru_title }}</option>
                            @endforeach
                        </select>
                        <label for="services">Предоставляемые услуги</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="0">Нет</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} - ${{ $user->email }}</option>
                            @endforeach
                        </select>
                        <label for="user_id">Собственник</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="active" id="active" class="form-control">
                            <option value="1" selected>Да</option>
                            <option value="0">Нет</option>
                        </select>
                        <label for="active">Активный</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <input type="text" name="phone_number" id="phoneNumber" class="form-control" value="{{ old('phone_number') }}">
                        <label for="phoneNumber">Номер телефона</label>
                    </div>
                </div>
                <h3 class="font-size-h3 font-w600 my-20">SEO</h3>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="form-control">
                        <label for="meta_title">Мета тег title</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_description" id="meta_description" value="{{ old('meta_description') }}" class="form-control">
                        <label for="meta_description">Мета тег description</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" class="form-control">
                        <label for="meta_keywords">Мета тег keywords</label>
                    </div>
                </div>
            </div>
            <div class="block-content mb-10">
                <div class="block-content text-right pb-10">
                    <button class="btn btn-alt-success" name="save">Сохранить</button>
                    <button class="btn btn-alt-success" name="saveQuit">Сохранить и выйти</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        jQuery(function() {
            Codebase.helper('select2');
        });
    </script>
@endsection

