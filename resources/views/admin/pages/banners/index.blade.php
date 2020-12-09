@extends('admin.layouts.app')

@section('title', 'Рекламные баннеры')

@section('content')
    @include('admin.components.breadcrumb', [
        'lastTitle' => 'Баннеры'
    ])
    <h3 class="content-heading">Рекламные баннеры</h3>
    <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
        @foreach($banners as $banner)
            <div class="col-md-4 col-sm-6">
                <a href="javascript:void(0)" class="block block-link-shadow text-center">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">{{ $banner->name }}</div>
                        <div class="font-size-h3 font-w600">{{ $banner->clicks }} <small>переходов</small></div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
