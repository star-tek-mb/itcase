@extends('site.layouts.account')

@section('title', 'Мой профиль')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@if ($user->customer_type == 'individual')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endsection
@endif

@section('account.title', 'Мой профиль')
@section('content.account')
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <section class="uk-section-xsmall">
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>Фото</h4>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-4">
                    <img src="{{ $user->getImage() }}" alt="{{ $user->name }}" class="uk-border-circle account-avatar">
                </div>
                <div class="uk-width-3-4">
                    <div class="uk-flex uk-flex-column uk-flex-center">
                        <div class="js-upload" uk-form-custom>
                            <input type="file" name="image" id="image">
                            <button class="uk-button uk-button-primary-outline" type="button" tabindex="-1"><span
                                    uk-icon="image" class="uk-margin-small-right"></span>{{ __('Загрузить фото') }}
                            </button>
                        </div>
                        <span class="uk-text-muted uk-text-small uk-margin-small-top"><span uk-icon="info"></span> {{ __('Минимальные пропорции: 120х120 пикселей') }}</span>
                    </div>
                </div>
            </div>
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>{{ __('Ваше имя:') }} <span class="uk-text-danger">*</span></h4>
                </div>
            </div>
            <div class="uk-grid uk-margin-remove-top">
                <div class="uk-width-1-2">
                    <input type="text" placeholder="Имя" name="first_name"
                           class="uk-input @error('first_name') uk-form-danger @enderror"
                           value="{{ $user->first_name }}">
                </div>
                <div class="uk-width-1-2">
                    <input type="text" placeholder="Фамилия" name="last_name"
                           class="uk-input @error('last_name') uk-form-danger @enderror"
                           value="{{ $user->last_name }}">
                </div>
            </div>
            @if ($user->customer_type == 'individual')
                <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                    <div class="wrapper_title">
                        <h4>{{ __('О себе:') }} <span class="uk-text-danger">*</span></h4>
                    </div>
                </div>
                <div class="uk-grid uk-margin-remove-top">
                    <div class="uk-width-1-1">
                        <textarea name="about_myself" id="aboutMySelf">{!! $user->about_myself !!}</textarea>
                    </div>
                </div>
                <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                    <div class="wrapper_title">
                        <h4>{{ __('Ваш сайт') }}</h4>
                    </div>
                </div>
                <div class="uk-grid uk-margin-remove-top">
                    <div class="uk-width-1-1">
                        <input type="text" placeholder="Ваш сайт" name="site"
                               class="uk-input @error('site') uk-form-danger @enderror"
                               value="{{ $user->site }}">
                    </div>
                </div>
                <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                    <div class="wrapper_title">
                        <h4>{{ __('Телефон и Email:') }} <span class="uk-text-danger">*</span></h4>
                    </div>
                </div>
                <div class="uk-grid uk-margin-remove-top">
                    <div class="uk-width-1-2">
                        <input type="text" placeholder="Телефон" name="phone_number"
                               class="uk-input @error('phone_number') uk-form-danger @enderror"
                               value="{{ $user->phone_number }}">
                    </div>
                    <div class="uk-width-1-2">
                        <input type="text" placeholder="Email" name="email"
                               class="uk-input @error('email') uk-form-danger @enderror"
                               value="{{ $user->email }}">
                    </div>
                </div>
            @elseif($user->customer_type == 'legal_entity')
                <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                    <div class="wrapper_title">
                        <h4>{{ __('Email:') }} <span class="uk-text-danger">*</span></h4>
                    </div>
                </div>
                <div class="uk-grid uk-margin-remove-top">
                    <div class="uk-width-1-1">
                        <input type="text" placeholder="Email" name="email"
                               class="uk-input @error('email') uk-form-danger @enderror"
                               value="{{ $user->email }}">
                    </div>
                </div>
            @endif
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>{{ __('Ссылки на соц. сети:') }}</h4>
                </div>
            </div>
            <div class="uk-grid uk-margin-remove-top">
                <div class="uk-width-1-2 uk-margin-small-bottom">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: facebook"></span>
                        <input type="text" class="uk-input" id="facebook" name="facebook" placeholder="Facebook"
                               value="{{ $user->facebook }}">
                    </div>
                </div>
                <div class="uk-width-1-2 uk-margin-small-bottom">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: question"></span>
                        <input type="text" class="uk-input" id="telegram" name="telegram" placeholder="Telegram"
                               value="{{ $user->telegram }}">
                    </div>
                </div>
                <div class="uk-width-1-2 uk-margin-small-bottom">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: question"></span>
                        <input type="text" class="uk-input" id="vk" name="vk" placeholder="ВКонтакте"
                               value="{{ $user->vk }}">
                    </div>
                </div>
                <div class="uk-width-1-2 uk-margin-small-bottom">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: whatsapp"></span>
                        <input type="text" class="uk-input" id="whatsapp" name="whatsapp" placeholder="WhatsApp"
                               value="{{ $user->vk }}">
                    </div>
                </div>
                <div class="uk-width-1-2">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: instagram"></span>
                        <input type="text" class="uk-input" id="instagram" name="instagram" placeholder="Instagram"
                               value="{{ $user->instagram }}">
                    </div>
                </div>
            </div>
            <div class="uk-grid">
                <button type="submit" class="uk-button uk-button-success uk-width-1-1 uk-margin-medium-left">{{ __('Сохранить') }}
                </button>
            </div>
        </section>
    </form>
@endsection

@if ($user->customer_type == 'individual')
@section('js')
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script>ClassicEditor
            .create(document.querySelector('#aboutMySelf'), {

                toolbar: {
                    items: [
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                language: 'ru',
                licenseKey: '',
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
@endif
