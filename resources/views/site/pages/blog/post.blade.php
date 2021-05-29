@extends('site.layouts.front')

@section('title') {{ $post->title }} - {{ __('Блог') }} @endsection

@section('breadcrumbs')
- <a href="{{ route('site.blog.index') }}">{{ __('Блог') }}</a>
- {{ $post->title }}
@endsection

@section('sidebar')
@include('site.layouts.sidebar')
@endsection

@section('content')

<div class="title-top title-top--small">
	<h2>
		Политика конфеденциальности
	</h2>
</div>
<div style="margin: 25px;">
{!! $post->content !!}
</div>

@endsection