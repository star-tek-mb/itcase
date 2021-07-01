@extends('site.layouts.front')

@section('title') {{ __('Задания') }} @endsection
{{--@push('css')--}}
{{--    <link rel="stylesheet" href="/front/css/bootstrap.css" />--}}
{{--@endpush--}}
@section('breadcrumbs')
    - {{ __('Задания') }}
@endsection

@section('sidebar')
    <div class="title-top">
        <h2>{{ __('Каталог заданий') }}</h2>
    </div>

    <form class="body-box" action="{{ route('site.tenders.search') }}" method="POST">
        @csrf
        @include('site.pages.tenders.filter')

    </form>

    @include('site.layouts.sidebar')
@endsection

@section('content')
    <div class="title-top title-top--small">
        <h2>
            Заданий найдено:
            <span>{{ $tenders->total() }}</span>
        </h2>

        <a href="{{ route('site.tenders.map') }}" class="button button--search-task">Поиск заданий на карте</a>
    </div>
   <div id="full_width_tasks_holder">
    @include('site.pages.tenders.individual_task')
   </div>
    {{ $tenders->links()}}

@endsection