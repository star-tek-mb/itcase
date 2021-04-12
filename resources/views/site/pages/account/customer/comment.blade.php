@extends('site.layouts.account')

@section('title', 'Комментарии')

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

@section('account.title.h1', 'Оставить комментарий')

@section('account.content')
<form action="" method="post">
    @csrf
<section class="box-admin edit-profile">
  <div class="body-box-admin">
    <div class="row p-3">
      <div class="form-group">
          <label for="name">{{ __('Ваше имя') }}</label>
          <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" disabled>

      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label for="aboutMySelf">{{ __('Напишите свой коментарий') }}</label>
            <p class="alert alert-info">{{ __('Оставленные Вами комментарии будут видны на главной странице') }}</p>
            <textarea name="about_myself" id="aboutMySelf"></textarea>
        </div>
        <button type="submit" class="btn btn-light-green"><i class="fas fa-save"></i> {{ __('Сохранить') }}</button>
      </div>
    </div>

  </div>


</section>
</form>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/{{ config('app.locale') }}.js"></script>
    <script>flatpickr.localize(flatpickr.l10ns.{{ config('app.locale') }});</script>
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
