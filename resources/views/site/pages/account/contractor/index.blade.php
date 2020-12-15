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
    <form action="{{ route('site.account.contractor.profile.save') }}" enctype="multipart/form-data" method="post">
        @csrf
        <section class="box-admin edit-profile">
            <div class="header-box-admin">
                <h3>Личные данные</h3>
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
                            <input type="text" name="phone_number" id="phoneNumber"
                                   class="form-control @error('phone_number') is-invalid @enderror"
                                   value="{{ $user->phone_number }}">
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="phoneNumber">E-mail</label>
                            <input type="text" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ $user->email }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{--@if ($user->contractor_type == 'freelancer')--}}
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
                    {{--@else--}}@if($user->contractor_type == 'agency')
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="company_name">Название компании</label>
                                <input type="text" name="company_name" id="company_name"
                                       class="form-control form-control" value="{{ $user->company_name }}">
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="aboutMySelf">@if($user->contractor_type == 'agency') О
                                компании @elseif($user->contractor_type == 'freelancer') О себе @endif</label>
                            <textarea name="about_myself" id="aboutMySelf">{{ $user->about_myself }}</textarea>
                        </div>
                    </div>
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
                            <input type="text" name="facebook" id="facebook" class="form-control"
                                   value="{{ $user->facebook }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="twitter"><i class="fab fa-twitter"></i> Twitter</label>
                            <input type="text" name="twitter" id="twitter" class="form-control"
                                   value="{{ $user->twitter }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="telegram"><i class="fab fa-telegram"></i> Telegram</label>
                            <input type="text" name="telegram" id="telegram" class="form-control"
                                   value="{{ $user->telegram }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="instagram"><i class="fab fa-instagram"></i> Instagram</label>
                            <input type="text" name="instagram" id="instagram" class="form-control"
                                   value="{{ $user->instagram }}">
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
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control"
                                   value="{{ $user->whatsapp }}">
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
            .then(editor = > {
            window.editor = editor;
        })
        .catch(error = > {
            console.error(error);
        })
        ;
    </script>
@endsection
