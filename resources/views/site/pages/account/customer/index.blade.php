@extends('site.layouts.account')

@section('title', 'Личный кабинет')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endsection
@section('account.title.h1', 'Профиль')
@section('account.title', 'Личные данные')
@section('account.content')
    <form action="{{ route('site.account.customer.profile.save') }}" enctype="multipart/form-data" method="post">
        @csrf
        @if ($user->customer_type == 'legal_entity')
            <section class="box-admin edit-profile">
                <div class="header-box-admin">
                    <h3>Данные о компании</h3>
                </div>
                <div class="body-box-admin">
                    <div class="upload-avatar">
                        <div class="avatar">
                            <img src="{{ $user->getImage() }}" alt="{{ $user->getCommonTitle() }}">
                        </div>
                        <div class="upload">
                            <div class="desc">Минимальные пропорции: 120х120 пикселей</div>
                            <div class="btn-upload">
                                <input type="file" name="image" id="image">
                                <span class="btn btn-light-green">Выбрать изображение</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="company_name">Название компании</label>
                                <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $user->company_name }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="foundation_year">Год основания</label>
                                <input type="text" name="foundation_year" id="foundation_year" class="form-control" value="{{ $user->foundation_year }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="aboutMySelf">О компании</label>
                                <textarea name="about_myself" id="aboutMySelf">{{ $user->about_myself }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="site">Ссылка на сайт</label>
                                <input type="text" name="site" id="site" class="form-control" value="{{ $user->site }}"></div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="email">Электронная почта</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="box-admin edit-profile">
            <div class="header-box-admin">
                <h3>Личные данные</h3>
            </div>
            <div class="body-box-admin">
                @if ($user->customer_type != 'legal_entity')
                    <div class="upload-avatar">
                        <div class="avatar">
                            <img src="{{ $user->getImage() }}" alt="{{ $user->getCommonTitle() }}">
                        </div>
                        <div class="upload">
                            <div class="desc">Минимальные пропорции: 120х120 пикселей</div>
                            <div class="btn-upload">
                                <input type="file" name="image" id="image">
                                <span class="btn btn-light-green">Выбрать изображение</span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="name">Ваше имя</label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="phoneNumber">Номер телефона</label>
                            <input type="text" name="phone_number" id="phoneNumber" class="form-control @error('phone_number') is-invalid @enderror" value="{{ $user->phone_number }}">
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @if ($user->customer_type !== 'legal_entity')
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="email">Электронная почта</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <section class="box-admin edit-profile">
            <div class="header-box-admin">
                <h3>Социальные сети</h3>
            </div>
            <div class="body-box-admin">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="facebook"><i class="fab fa-facebook"></i> Facebook</label>
                            <input type="text" name="facebook" id="facebook" class="form-control" value="{{ $user->facebook }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="twitter"><i class="fab fa-twitter"></i> Twitter</label>
                            <input type="text" name="twitter" id="twitter" class="form-control" value="{{ $user->twitter }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="telegram"><i class="fab fa-telegram"></i> Telegram</label>
                            <input type="text" name="telegram" id="telegram" class="form-control" value="{{ $user->telegram }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="instagram"><i class="fab fa-instagram"></i> Instagram</label>
                            <input type="text" name="instagram" id="instagram" class="form-control" value="{{ $user->instagram }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="vk"><i class="fab fa-vk"></i> Вконтакте</label>
                            <input type="text" name="vk" id="vk" class="form-control" value="{{ $user->vk }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ $user->whatsapp }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-light-green"><i class="fas fa-save"></i> Сохранить</button>
            </div>
        </section>
    </form>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('js/ckeditor.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr(document.getElementById('birthdayDate'), {
                dateFormat: 'd.m.Y',
                maxDate: new Date()
            });
        });
    </script>
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
