@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('title') Редактировать вакансию @endsection

@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.vacancyCategory.index'),
                'title' => 'Вакансии'
            ]
        ],
        'lastTitle' => 'Редактировать вакансию'
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Редактировать вакансию</h3>
        </div>
        <!-- Form -->
        <form action="{{ route('admin.vacancy.store') }}" method="post" enctype="multipart/form-data">
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
                            <div class="form-group @error('title.ru') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="ru_title" name="title[ru]" value="{{ old('title.ru', $vacancy->getTranslation('title', 'ru')) }}">
                                    <label for="ru_title" @error('title.ru') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('title.ru') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('title.ru') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('description.ru') is-invalid @enderror">
                                <label for="ruDescription">Описание</label>
                                <textarea name="description[ru]" id="ruDescription"
                                          class="form-control">{{ old('description.ru', $vacancy->getTranslation('description', 'ru')) }}</textarea>
                                @error('description.ru') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 1 -->

                        <!-- Step 2 -->
                        <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                            <div class="form-group @error('title.en') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="en_title" name="title[en]" value="{{ old('title.en', $vacancy->getTranslation('title', 'en')) }}">
                                    <label for="en_title" @error('title.en') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('title.en') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('title.en') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('description.en') is-invalid @enderror">
                                <label for="enDescription">Описание</label>
                                <textarea name="description[en]" id="enDescription"
                                          class="form-control">{{ old('description.en', $vacancy->getTranslation('description', 'en')) }}</textarea>
                                @error('description.en') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 2 -->

                        <!-- Step 3 -->
                        <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                            <div class="form-group @error('title.uz') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="uz_title" name="title[uz]" value="{{ old('title.uz', $vacancy->getTranslation('title', 'uz')) }}">
                                    <label for="uz_title" @error('title.uz') class="col-form-label" @enderror>
                                    Заголовок
                                    @error('title.uz') <span class="text-danger">*</span> @enderror
                                    </label>
                                </div>
                                @error('title.uz') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('description.uz') is-invalid @enderror">
                                <label for="uzDescription">Описание</label>
                                <textarea name="description[uz]" id="uzDescription"
                                          class="form-control">{{ old('description.uz', $vacancy->getTranslation('description', 'uz')) }}</textarea>
                                @error('description.uz') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <div class="form-group">
                    <label for="category">Категория</label>
                    <select id="category" name="vacancy_category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($vacancy->category->id == $category->id) selected @endif>{{ $category->title }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">Город</label>
                    <select id="city" name="city" class="form-control">
                        <option value="andijan" @if ($vacancy->city == 'andijan') selected @endif>Андижан</option>
                        <option value="bukhara" @if ($vacancy->city == 'bukhara') selected @endif>Бухара</option>
                        <option value="jizzakh" @if ($vacancy->city == 'jizzakh') selected @endif>Джизак</option>
                        <option value="qashqadaryo" @if ($vacancy->city == 'qashqadaryo') selected @endif>Кашкадарья</option>
                        <option value="navoiy" @if ($vacancy->city == 'navoiy') selected @endif>Навои</option>
                        <option value="namangan" @if ($vacancy->city == 'namangan') selected @endif>Наманган</option>
                        <option value="samarqand" @if ($vacancy->city == 'samarqand') selected @endif>Самарканд</option>
                        <option value="surxondaryo" @if ($vacancy->city == 'surxondaryo') selected @endif>Сурхандарья</option>
                        <option value="sirdaryo" @if ($vacancy->city == 'sirdaryo') selected @endif>Сырдарья</option>
                        <option value="tashkent" @if ($vacancy->city == 'tashkent') selected @endif>Ташкент</option>
                        <option value="fergana" @if ($vacancy->city == 'fergana') selected @endif>Фергана</option>
                        <option value="xorazm" @if ($vacancy->city == 'xorazm') selected @endif>Хорезм</option>
                        <option value="karakalpakstan" @if ($vacancy->city == 'karakalpakstan') selected @endif>Каракалпакстан</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="budget">Бюджет</label>
                    <input type="text" id="budget" name="budget" class="form-control" placeholder="от ... до ..." value="{{ old('budget', $vacancy->budget) }}">
                </div>
                <div class="form-group">
                    <label for="address">Адрес</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Имя организации, адрес организации" value="{{ old('address', $vacancy->address) }}">
                </div>
            </div>
            <div class="block-content">
                <div class="block-content text-right pb-10">
                    <button class="btn btn-success" name="save">Сохранить</button>
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
