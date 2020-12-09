@extends('admin.layouts.app')

@section('title')
    {{ $company->getTitle() }}
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
        'lastTitle' => $company->getTitle()
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Добавить компанию</h3>
        </div>
        <form action="{{ route('admin.companies.update', $company->id) }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PUT')
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
                                    <input class="form-control" type="text" id="ruTitle" name="ru_title" value="{{ $company->ru_title }}">
                                    <label for="ruTitle" @error('ru_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('ru_title') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('ru_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_slug') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="ru_slug" name="ru_slug" value="{{ $company->ru_slug }}">
                                    <label for="ru_slug" @error('ru_slug') class="col-form-label" @enderror>
                                        Slug
                                        @error('ru_slug') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('ru_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_description') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="ru_description" id="ruDescription"
                                              class="form-control">{{ $company->ru_description }}</textarea>
                                    <label for="ruDescription">Описание</label>
                                </div>
                                @error('ru_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 1 -->

                        <!-- Step 2 -->
                        <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                            <div class="form-group @error('en_title') is-invalid @enderror">
                                <input class="form-control" type="text" id="enTitle" name="en_title" value="{{ $company->en_title }}">
                                <label for="enTitle" @error('en_title') class="col-form-label" @enderror>
                                Заголовок
                                @error('en_title') <span class="text-danger">*</span> @enderror
                                </label>
                                @error('en_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_slug') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="en_slug" name="en_slug" value="{{ $company->en_slug }}">
                                    <label for="en_slug" @error('en_slug') class="col-form-label" @enderror>
                                        Slug
                                        @error('en_slug') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('en_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_description') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="en_description" id="enDescription"
                                              class="form-control">{{ $company->en_description }}</textarea>
                                    <label for="enDescription">Описание</label>
                                </div>
                                @error('en_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 2 -->

                        <!-- Step 3 -->
                        <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                            <div class="form-group @error('uz_title') is-invalid @enderror">
                                <input class="form-control" type="text" id="uzTitle" name="uz_title" value="{{ $company->uz_title }}">
                                <label for="uzTitle" @error('uz_title') class="col-form-label" @enderror>
                                Заголовок
                                @error('uz_title') <span class="text-danger">*</span> @enderror
                                </label>
                                @error('uz_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_slug') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="uz_slug" name="uz_slug" value="{{ $company->uz_slug }}">
                                    <label for="uz_slug" @error('uz_slug') class="col-form-label" @enderror>
                                        Slug
                                        @error('uz_slug') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('uz_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_description') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="uz_description" id="uzDescription"
                                              class="form-control">{{ $company->uz_description }}</textarea>
                                    <label for="ruDescription">Описание</label>
                                </div>
                                @error('uz_description') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <input type="text" name="price" id="price" class="form-control" value="{{ $company->price }}">
                        <label for="price">Цена</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <input type="text" name="url" id="url" value="{{ $company->url }}" class="form-control">
                        <label for="url">Ссылка на сайт</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="css-control css-control-primary css-checkbox">
                        <input type="checkbox" name="favourite" id="favourite" class="css-control-input" @if ($company->favourite) checked @endif>
                        <span class="css-control-indicator"></span>Избранное (отобразиться на главной)
                    </label>
                </div>
                <div class="form-group">
                    <label class="css-control css-control-primary css-checkbox">
                        <input type="checkbox" name="showPage" id="showPage" class="css-control-input" @if ($company->show_page) checked @endif>
                        <span class="css-control-indicator"></span>Отображать собственную страницу компании в справочнике (в ином случае будет просто ссылка на сайт компании)
                    </label>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="need_id" id="needId" class="form-control js-select2">
                            <option value="0">Нет</option>
                            @foreach($needs  as $need)
                                <option value="{{ $need->id }}" @if($company->needType) @if($company->needType->id == $need->id) selected @endif @endif>{{ $need->ru_title }}</option>
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
                        <select name="faq_id" id="faq_id" class="form-control js-select2">
                            <option value="0">Нет</option>
                            @foreach($faqs as $faq)
                                <option value="{{ $faq->id }}" @if($faq->id == $company->faq_id) selected @endif>{{ $faq->getTitle() }}</option>
                            @endforeach
                        </select>
                        <label for="faq_id">FAQ группа</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="services[]" id="services" class="form-control js-select2" multiple="multiple">
                            @php
                            $serviceIds = $company->services()->pluck('service_id')->toArray()
                            @endphp
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" @if(in_array($service->id, $serviceIds)) selected @endif>{{ $service->ru_title }}</option>
                            @endforeach
                        </select>
                        <label for="services">Предоставляемые услуги</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Изображение</label>
                    @if($company->image != null)
                        <br>
                        <img src="{{ $company->getImage() }}" style="width: 200px;" alt="{{ $company->getTitle() }}">
                        <br>
                        <a href="{{ route('admin.companies.remove.image', $company->id) }}" class="btn btn-danger">Удалить</a>
                        <br>
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="user_id" id="user_id" class="form-control js-select2">
                            <option value="0">Нет</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if($company->user) @if($company->user->id == $user->id) selected @endif @endif>{{ $user->name }} - {{ $user->email }}</option>
                            @endforeach
                        </select>
                        <label for="user_id">Собственник</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <select name="active" id="active" class="form-control">
                            <option value="1" @if($company->active) selected @endif>Да</option>
                            <option value="0" @if(!$company->active) selected @endif>Нет</option>
                        </select>
                        <label for="active">Активный</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <input type="text" name="phone_number" id="phoneNumber" class="form-control" value="{{ $company->phone_number }}">
                        <label for="phoneNumber">Номер телефона</label>
                    </div>
                </div>
                <h3 class="font-size-h3 font-w600 my-20">SEO</h3>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_title" id="meta_title" value="{{ $company->meta_title }}" class="form-control">
                        <label for="meta_title">Мета тег title</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_description" id="meta_description" value="{{ $company->meta_description }}" class="form-control">
                        <label for="meta_description">Мета тег description</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material floating form-material-primary">
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ $company->meta_keywords }}" class="form-control">
                        <label for="meta_keywords">Мета тег keywords</label>
                    </div>
                </div>
            </div>
            <div class="block-content mb-10">
                <div class="block-content text-right pb-10">
                    <button class="btn btn-alt-success" type="submit">Сохранить</button>
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
