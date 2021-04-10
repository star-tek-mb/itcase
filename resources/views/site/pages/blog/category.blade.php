@extends('site.layouts.app')
@section('title', $category->getTitle())
@section('meta')
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection
@section('header')
    @include('site.layouts.partials.headers.default')
@endsection
@section('content')


    <div class="primary-page">
        <div class="container">
            <div class="header-page">
                <div class="row">
                    <div class="col-md-8">
                        <div class="section-heading">
                            <h1 class="title-page">{{ __('Блог') }}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">{{ __('Главная') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('site.blog.index') }}">{{ __('Блог') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $category->getTitle() }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="search-form">
                            <input class="form-control" type="text" placeholder="Поиск здесь...">
                            <button class="btn-clear"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-lists">
                        <div class="row">
                            @foreach($category->posts as $post)
                                <div class="col-sm-12 col-md-6 single-card-info">
                                    <div class="card-info">
                                        <div class="card-info-img"><a href="{{ route('site.blog.main', $post->getAncestorsSlugs()) }}"><img
                                                    src="{{ $post->getImage() }}"
                                                    alt="{{ $post->ru_title }}"></a></div>
                                        <div class="card-info-body"><span class="meta">{{ __('Опубликован') }} {{ $post->created_at }}</span>
                                            <h3 class="card-info-title"><a href="{{ route('site.blog.main', $post->getAncestorsSlugs()) }}">{{ $post->ru_title }}</a></h3>
                                            <div class="card-info-text">{!! $post->ru_short_content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-right">
                        <div class="sidebar-right-group">
                            <div class="box-sidebar">
                                <div class="header-box d-flex justify-content-between flex-wrap">
                                    <h3 class="title-box">{{ __('Категории') }}</h3>
                                </div>
                                <div class="body-box">
                                    <ul class="list-check-filter-job">
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ route('site.blog.main', $category->ru_slug) }}">{{ $category->getTitle() }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
