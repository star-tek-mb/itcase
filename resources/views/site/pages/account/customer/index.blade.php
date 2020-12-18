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
                            <label for="first_name">Ваше имя</label>
                            <input type="hidden" name="name">
                            <input type="text" name="first_name" id="first_name"
                                   class="form-control @error('first_name') is-invalid @enderror" value="{{ $user->first_name }}">
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="last_name">Ваше Фамилия</label>
                            <input type="text" name="last_name" id="last_name"
                                   class="form-control @error('name') is-invalid @enderror" value="{{ $user->last_name }}">
                            @error('last_name')
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
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Ваш пол:</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="gender" value="male" id="maleRadio"
                               class="custom-control-input" @if ($user->gender == 'male') checked @endif>
                        <label for="maleRadio" class="custom-control-label">Мужской</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="gender" value="female" id="femaleRadio"
                               class="custom-control-input" @if ($user->gender == 'female') checked @endif>
                        <label for="femaleRadio" class="custom-control-label">Женский</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="birthdayDate">Дата рождения</label>
                    <input type="text" class="form-control @error('birthday_date') is-invalid @enderror"
                           id="birthdayDate" name="birthday_date"
                           value="{{ \Carbon\Carbon::create($user->birthday_date)->format('d.m.Y') }}">
                    @error('birthday_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-12"> <label>Сменить пароль:</label> </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="newPassword"> Новый пароль</label>
                    <input type="password" name="newPassword" id="newPassword"
                           class="form-control @error('newPassword') is-invalid @enderror">
                    @error('newPassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="email">Повторите новый пароль</label>
                    <input type="password" name="newPasswordRepeat" id="newPasswordRepeat"
                           class="form-control @error('newPasswordRepeat') is-invalid @enderror">
                    @error('newPasswordRepeat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="currentPassword">Текущий пароль</label>
                    <input type="password" name="currentPassword" id="currentPassword"
                           class="form-control @error('currentPassword') is-invalid @enderror">
                    @error('currentPassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
