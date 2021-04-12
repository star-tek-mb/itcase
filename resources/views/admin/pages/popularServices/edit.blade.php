@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('title')Популярная услуга {{ $current->ru_title }} @endsection

@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.popular.index'),
                'title' => 'Популярные услуги'
            ]
        ],
        'lastTitle' => $current->ru_title
    ])

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{ $current->ru_title }}</h3>
        </div>
        <!-- Form -->
        <form action="{{ route('admin.popular.update', $current->id) }}" method="post" enctype="multipart/form-data">
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
                                <input class="form-control" type="text" id="ru_title" name="ru_title" value="{{ $current->ru_title }}">
                                @error('ru_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('ru_content') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="ru_content" id="ruDescription"
                                              class="form-control">{{ $current->ru_content }}</textarea>
                                    <label for="ruDescription">Описание</label>
                                </div>
                                @error('ru_content') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
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
                                <input class="form-control" type="text" id="en_title" name="en_title" value="{{ $current->en_title }}">
                                @error('en_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('en_content') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="en_content" id="enDescription"
                                              class="form-control">{{ $current->en_content }}</textarea>
                                    <label for="enDescription">Описание</label>
                                </div>
                                @error('en_content') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
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
                                <input class="form-control" type="text" id="uz_title" name="uz_title" value="{{ $current->uz_title }}">
                                @error('uz_title') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group @error('uz_content') is-invalid @enderror">
                                <div class="form-material">
                                    <textarea name="uz_content" id="uzDescription"
                                              class="form-control">{{ $current->uz_content }}</textarea>
                                    <label for="ruDescription">Описание</label>
                                </div>
                                @error('uz_content') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <!-- END Step 3 -->
                    </div>
                    <!-- END Steps Content -->
                </div>
                <!-- END Simple Wizard -->
                <div class="form-group @error('url') is-invalid @enderror">
                    <label for="ru_title" @error('url') class="col-form-label" @enderror>
                        Ссылка
                    @error('url') <span class="text-danger">*</span> @enderror
                    </label>
                    <input class="form-control" type="text" id="url" name="url" value="{{ $current->url }}">
                    @error('url') <div id="val-username-error" class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="image">Изображение</label>
                    @if($current->image != null)
                        <br>
                        <img src="{{ $current->getImg() }}" style="width: 200px;" alt="{{ $current->ru_title }}">
                        <br>
                        <a href="{{ route('admin.popular.remove.image', $current->id) }}" class="btn btn-danger">Удалить</a>
                        <br>
                    @endif
                    <input type="file" name="image" class="form-control">
                    <div class="mt-2">
                        <input type="text" name="image-text" class="form-control" placeholder="Ссылка для изображение">
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
