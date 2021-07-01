@extends('site.layouts.app')

@section('title', 'Создать аккаунт')

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

@section('content')
    <div class="primary-page">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="title">Создайте себе аккаунт</h2>
                <p class="mt-3">Выберите вашу роль и введите данные. Без этого вы не сможете выполнять какие-либо действия на сайте</p>
            </div>
            <div class="box-admin tender-box">
                <div class="header-box-admin">
                    <h3>Создание аккаунта для {{ $user->getCommonTitle() }}</h3>
                </div>
                <hr>
                <div class="body-box-admin">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                </div>
                <div class="body-box-admin">
                    <ul class="nav nav-tabs btn-group-toggle" data-toggle="buttons" id="myTab" role="tablist">
                        @if (!request()->hasCookie('tenderId'))
                            <li class="nav-item">
                                <a class="nav-link @if (!old('user_role') || old('user_role') == 'contractor' ) active @endif" id="home-tab" data-toggle="tab" href="#contractor"
                                   role="tab" aria-controls="contractor" aria-selected="true">Исполнитель</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link @if (old('user_role') == 'customer' || request()->hasCookie('tenderId')) active @endif" id="profile-tab" data-toggle="tab" href="#customer" role="tab"
                               aria-controls="customer" aria-selected="false">Заказчик</a>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @if (!request()->hasCookie('tenderId'))
                            <div class="tab-pane fade @if (!old('user_role') || old('user_role') == 'contractor' ) show active @endif" id="contractor" role="tabpanel"
                                 aria-labelledby="home-tab">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="user_role" value="contractor">
                                    <div class="upload-avatar">
                                        <div class="avatar">
                                            <img src="{{ $user->getImage() }}" alt="{{ $user->email }}">
                                        </div>
                                        <div class="upload">
                                            <div class="desc">Минимальные пропорции: 120х120 пикселей</div>
                                            <div class="btn-upload">
                                                <input onchange="loadFile(event)" type="file" name="image" id="image" required class="@error('image') is-invalid @enderror">
                                                <span class="btn btn-light-green">Выбрать изображение</span>
                                                @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">Ваше имя</label>
                                                <input type="text" name="contractor_first_name" id="first_name"
                                                       class="form-control @error('contractor_first_name') is-invalid @enderror" value="{{ $user->first_name }}">
                                                @error('contractor_first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Ваше Фамилия</label>
                                                <input type="text" name="contractor_last_name" id="last_name"
                                                       class="form-control @error('contractor_last_name') is-invalid @enderror" value="{{ $user->last_name }}">
                                                @error('contractor_last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="contractor_phoneNumber">Номер телефона</label>
                                                <input type="text" name="contractor_phone_number" id="contractor_phoneNumber" class="form-control @error('contractor_phone_number') is-invalid @enderror" value="{{ old('contractor_phone_number') }}">
                                                @error('contractor_phone_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="contractor_birthdayDate">Дата рождения</label>
                                            <input type="text" class="form-control @error('contractor_birthday_date') is-invalid @enderror"
                                                   id="contractor_birthdayDate" name="contractor_birthday_date" value="{{ old('contractor_birthday_date')  }}">
                                            @error('contractor_birthday_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Вы являетесь:</label>
                                                <div class="custom-control custom-radio" id="freelancerRadio">
                                                    <input type="radio" name="contractor_type" value="individual" id="freelancerRadioInput" class="custom-control-input" @if (!old('contractor_type') || old('contractor_type') == 'individual') checked @endif>
                                                    <label for="freelancerRadioInput" class="custom-control-label">Физ. лицо</label>
                                                </div>
                                                <div class="custom-control custom-radio" id="agencyRadio">
                                                    <input type="radio" name="contractor_type" value="legal_entity" id="agencyRadioInput" class="custom-control-input" @if (old('contractor_type') == 'legal_entity') checked @endif>
                                                    <label for="agencyRadioInput" class="custom-control-label">Юр. лицо</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label>Ваш пол:</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="gender" value="male" id="maleRadio"
                                                       class="custom-control-input" @if (!old('gender') || old('gender') == 'male') checked @endif>
                                                <label for="maleRadio" class="custom-control-label">Мужской</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="gender" value="female" id="femaleRadio"
                                                       class="custom-control-input" @if (old('gender') == 'female') checked @endif>
                                                <label for="femaleRadio" class="custom-control-label">Женский</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group contractor-type-agency @if (!old('contractor_type') || old('contractor_type') == 'legal_entity') d-none @endif">
                                                <label for="contractor_companyName">Название компании</label>
                                                <input type="text" name="contractor_company_name" id="contractor_companyName" class="form-control @error('contractor_company_name') is-invalid @enderror" value="{{ old('contractor_company_name') }}">
                                                @error('contractor_company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="contractor_email">Email</label>
                                                <input type="text" name="contractor_email" id="contractor_email" class="form-control @error('contractor_email') is-invalid @enderror" value="@if ($user->email) {{ $user->email }} @else {{ old('contractor_email') }} @endif">
                                                @error('contractor_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="contractor_city">Город</label>
                                                <input type="text" name="contractor_city" id="contractor_city" class="form-control @error('contractor_city') is-invalid @enderror" value="{{ old('contractor_city') }}" placeholder="Ваш город проживания">
                                                @error('contractor_city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="aboutMySelfContractor" class="contractor-type-freelancer @if (old('contractor_type') == 'legal_entity') d-none @endif">О себе</label><label
                                                    for="aboutMySelfContractor" class="contractor-type-agency @if (!old('contractor_type') || old('contractor_type') == 'individual') d-none @endif">О компании</label>
                                                <textarea name="contractor_about_myself" id="aboutMySelfContractor">{{ old('about_myself') }}</textarea>
                                                @error('contractor_about_myself')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" required type="checkbox" value="1" name="agree_personal_data_processing" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Соглашаюсь на обработку <a href="{{ route('site.page', 'privacy-policy') }}">персональных данных</a>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" required type="checkbox" value="1" name="agree_tos" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Соглашаюсь с <a href="{{ route('site.page', 'terms-of-service') }}">правилами сервиса</a> и <a href="{{ route('site.page', 'offerta') }}">условиями оферты</a>
                                        </label>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-light-green">Профессиональные данные <i class="fas fa-arrow-right"></i></button>
                                </form>
                            </div>
                        @endif
                        <div class="tab-pane fade @if (old('user_role') == 'customer' || request()->hasCookie('tenderId') ) show active @endif" id="customer" role="tabpanel" aria-labelledby="profile-tab">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_role" value="customer">
                                <div class="upload-avatar">
                                    <div class="avatar">
                                        <img src="{{ $user->getImage() }}" alt="{{ $user->getCommonTitle() }}">
                                    </div>
                                    <div class="upload">
                                        <div class="desc">Минимальные пропорции: 120х120 пикселей</div>
                                        <div class="btn-upload">
                                            <input onchange="loadFile(event)" type="file" name="image" id="image" required class="@error('image') is-invalid @enderror">
                                            <span class="btn btn-light-green">Выбрать изображение</span>
                                            @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">Ваше имя</label>
                                            <input type="text" name="customer_first_name" id="first_name"
                                                   class="form-control @error('first_name') is-invalid @enderror" value="{{ $user->first_name }}">
                                            @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Ваше Фамилия</label>
                                            <input type="text" name="customer_last_name" id="last_name"
                                                   class="form-control @error('name') is-invalid @enderror" value="{{ $user->last_name }}">
                                            @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="customer_phoneNumber">Номер телефона</label>
                                            <input type="text" name="customer_phone_number" id="customer_phoneNumber" class="form-control @error('customer_phone_number') is-invalid @enderror" value="{{ old('customer_phone_number') }}">
                                            @error('customer_phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">

                                        <label>Ваш пол:</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="gender" value="male" id="maleRadio"
                                                   class="custom-control-input" @if (!old('gender') || old('gender') == 'male') checked @endif>
                                            <label for="maleRadio" class="custom-control-label">Мужской</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="gender" value="female" id="femaleRadio"
                                                   class="custom-control-input" @if (old('gender') == 'female') checked @endif>
                                            <label for="femaleRadio" class="custom-control-label">Женский</label>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-md-6">

                                        <label for="contractor_birthdayDate">Дата рождения</label>
                                        <input type="text" class="form-control @error('contractor_birthday_date') is-invalid @enderror"
                                               id="contractor_birthdayDate1" name="contractor_birthday_date" value="{{ old('contractor_birthday_date')  }}">
                                        @error('contractor_birthday_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Вы являетесь:</label>
                                            <div class="custom-control custom-radio" id="privateRadio">
                                                <input type="radio" name="customer_type" value="individual" id="privateRadioInput" class="custom-control-input" @if (!old('customer_type') || old('customer_type') == 'individual') checked @endif>
                                                <label for="privateRadioInput" class="custom-control-label">Физ. лицо</label>
                                            </div>
                                            <div class="custom-control custom-radio" id="companyRadio">
                                                <input type="radio" name="customer_type" value="legal_entity" id="companyRadioInput" class="custom-control-input" @if (old('customer_type') == 'legal_entity') checked @endif>
                                                <label for="companyRadioInput" class="custom-control-label">Юр. лицо</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group customer-type-company d-none">
                                            <label for="customer_companyName">Название компании</label>
                                            <input type="text" name="customer_company_name" id="customer_companyName" class="form-control @error('customer_company_name') is-invalid @enderror" value="{{ old('customer_company_name') }}">
                                            @error('customer_company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="customer_email">Email</label>
                                            <input type="text" name="customer_email" id="customer_email" class="form-control @error('customer_email') is-invalid @enderror" value="@if ($user->email) {{ $user->email }} @else {{ old('customer_email') }} @endif">
                                            @error('customer_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="customer_city">Город</label>
                                            <input type="text" name="customer_city" id="customer_city" class="form-control @error('customer_city') is-invalid @enderror" value="{{ old('customer_city') }}" placeholder="Ваш город проживания">
                                            @error('customer_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="aboutMySelfCompany" class="customer-type-private">О себе</label><label
                                                for="aboutMySelfCompany" class="customer-type-company d-none">О компании</label>
                                            <textarea name="customer_about_myself" id="aboutMySelfCompany">{{ old('about_myself') }}</textarea>
                                            @error('customer_about_myself')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" required type="checkbox" value="1" name="agree_personal_data_processing" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Соглашаюсь на обработку <a href="{{ route('site.page', 'privacy-policy') }}">персональных данных</a>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" required type="checkbox" value="1" name="agree_tos" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Соглашаюсь с <a href="{{ route('site.page', 'terms-of-service') }}">правилами сервиса</a> и <a href="{{ route('site.page', 'offerta') }}">условиями оферты</a>
                                    </label>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-light-green"><i class="fas fa-save"></i> Сохранить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

        @section('js')
            <script>
                /*window.addEventListener('message', function(message){
                    if (message.data == "close") {
                        $('#payment-modal').modal('hide');
                        $('#payment-button').prop("disabled", true);
                        $('#payment-iframe').remove();
                        $('button[type="submit"]').prop("disabled", false);
                    }
                });*/
                var loadFile = function(event) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('img', $(event.target).parent().parent().parent()).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(event.target.files[0]);
                };
            </script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/{{ config('app.locale') }}.js"></script>
            <script>flatpickr.localize(flatpickr.l10ns.{{ config('app.locale') }});</script>
            <script src="{{ asset('js/ckeditor.js') }}"></script>
            @if (!request()->hasCookie('tenderId'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        flatpickr(document.getElementById('contractor_birthdayDate'), {
                            dateFormat: 'd.m.Y',
                            maxDate: new Date()
                        });
                    });
                    document.addEventListener('DOMContentLoaded', function () {
                        flatpickr(document.getElementById('contractor_birthdayDate1'), {
                            dateFormat: 'd.m.Y',
                            maxDate: new Date()
                        });
                    });
                </script>
            @endif
            <script>
                @if (!request()->hasCookie('tenderId'))
                ClassicEditor
                    .create(document.querySelector('#aboutMySelfContractor'), {

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
                @endif
                ClassicEditor
                    .create(document.querySelector('#aboutMySelfCompany'), {

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
            <script>
                    document.getElementById('agencyRadio').addEventListener('click', function () {
                        $('.contractor-type-freelancer').addClass('d-none');
                        $('.contractor-type-agency').removeClass('d-none');
                    });
                    document.getElementById('freelancerRadio').addEventListener('click', function () {
                        $('.contractor-type-agency').addClass('d-none');
                        $('.contractor-type-freelancer').removeClass('d-none');
                    });
                    document.getElementById('privateRadio').addEventListener('click', function () {
                        $('.customer-type-company').addClass('d-none');
                        $('.customer-type-private').removeClass('d-none');
                    });
                    document.getElementById('companyRadio').addEventListener('click', function () {
                        $('.customer-type-company').removeClass('d-none');
                        $('.customer-type-private').addClass('d-none');
                    });
            </script>
@endsection
