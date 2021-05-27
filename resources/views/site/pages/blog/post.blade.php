@extends('site.layouts.front')

@section('title') {{ $post->title }} - {{ __('Блог') }} @endsection

@section('breadcrumbs')
- <a href="{{ route('site.blog.index') }}">{{ __('Блог') }}</a>
- {{ $post->title }}
@endsection

@section('sidebar')
<div class="title-top">
	<h2>{{ __('Новые публикации') }}
		<span>{{ __('в блоге') }}</span>
	</h2>
</div>

<div class="body-box body-box--blog">
	<div class="blog-block">
		@foreach ($posts as $post)
			<div class="blog-post">
				<a href="{{ route('site.blog.main', $post->ru_slug) }}">{{ $post->title }}</a>

				<a href="{{ route('site.blog.main', $post->ru_slug) }}" class="post-image">
					<img src="{{ $post->getImage() }}" alt="{{ $post->title }}">
				</a>

				<p>
					<a href="{{ route('site.blog.main', $post->ru_slug) }}">
						{!! $post->summary !!}
					</a>
				</p>
			</div>
		@endforeach
	</div>

	<div class="text-center">
		<a href="{{ route('site.blog.index') }}" class="button button--simple button--small">{{ __('Читать еще') }}</a>
	</div>
</div>


<div class="title-top">
	<h2>{{ __('Популярные вакансии') }}
		<span>ITCASE.com</span>
	</h2>
</div>

<div class="body-box pt0 pb30">
	<div class="works-list">
		@foreach ($vacancies as $vacancy)
			<div class="work">
				<h4>
					<a href="#">{{ $vacancy->title }}</a>
					<p>{{ $vacancy->budget }} {{ __('сум') }}</p>
					<span>{{ $vacancy->address }}</span>
				</h4>
			</div>
		@endforeach
	</div>

	<div class="text-center mt24">
		<a href="#" class="button button--simple button--small">{{ __('Смотреть еще') }}</a>
	</div>
</div>
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