@extends('admin.layouts.app')

@section('title', 'Добавить потребность')

@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.needs.index'),
                'title' => 'Потребности'
            ]
        ],
        'lastTitle' => 'Добавить потребность'
    ])
    <form action="{{ route('admin.needs.store') }}" method="post">
        @csrf
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Добавить потребность</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-success" type="submit"><i class="fa fa-check"></i> Сохранить</button>
                    <button class="btn btn-sm btn-alt-success" type="submit" name="saveQuit"><i class="fa fa-check"></i> Сохранить и выйти</button>
                </div>
            </div>
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
                                    <input class="form-control" type="text" id="ru_title" name="ru_title" value="{{ old('ru_title') }}">
                                    <label for="ru_title" @error('ru_title') class="col-form-label" @enderror>
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
                        </div>
                        <!-- END Step 1 -->

                        <!-- Step 2 -->
                        <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                            <div class="form-group @error('en_title') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="en_title" name="en_title" value="{{ old('en_title') }}">
                                    <label for="en_title" @error('en_title') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('en_title') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('en_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_slug') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="en_slug" name="en_slug" value="{{ old('en_title') }}">
                                    <label for="en_slug" @error('en_slug') class="col-form-label" @enderror>
                                    Slug
                                    @error('en_slug') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('en_slug') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 2 -->

                        <!-- Step 3 -->
                        <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                            <div class="form-group @error('uz_title') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="uz_title" name="uz_title" value="{{ old('uz_title') }}">
                                    <label for="uz_title" @error('uz_title') class="col-form-label" @enderror>
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
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <div class="form-group">
                    <div class="form-material floating">
                        <input type="text" name="url" id="url" class="form-control" value="{{ old('url') }}">
                        <label for="url">Ссылка (если установлена, выпадающее меню показано не будет)</label>
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
        </div>
    </form>
@endsection
