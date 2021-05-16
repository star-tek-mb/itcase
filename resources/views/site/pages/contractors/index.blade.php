@extends('site.layouts.front')

@section('title') {{ __('Исполнители') }} @endsection

@section('breadcrumbs')
- {{ __('Исполнители') }}
@endsection

@section('sidebar')
<div class="title-top">
	<h2>{{ __('Каталог исполнителей') }}</h2>
</div>

<div class="body-box">
	<ul class="categories">
		@foreach ($parentCategories as $parent)
			<li>
				<div class="ml-4 form-check">
					<input checked="" type="checkbox" id="cat{{ $parent->id }}" class="form-check-input" name="categories[]" value="{{ $parent->id }}">
					<label class="form-check-label" for="cat{{ $parent->id }}">{{ $parent->title }}</label>
					<span></span>

					<div class="arrow"></div>
					<ul>
						@foreach ($parent->categories as $category)
							<li>
								<input checked="" type="checkbox" id="cat{{ $category->id }}" class="form-check-input" name="categories[]" value="{{ $category->id }}">
								<label class="form-check-label" for="cat{{ $category->id }}">{{ $category->title }}</label>
								<span></span>
							</li>
						@endforeach
					</ul>
			</li>
		@endforeach
	</ul>
</div>


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
		Исполнителей найдено:
		<span>{{ $contractors->count() }}</span>
	</h2>

	<a href="#" class="button">{{ __('Стать исполнителем') }}</a>
</div>

<ul class="worker-list">
	@foreach ($contractors as $contractor)
	<!-- -->
	<li class="worker">
		<div class="worker__avatar">
			<img src="{{ $contractor->getImage() }}" alt="{{ $contractor->name }}">
		</div>

		<div class="worker__data">
			<div class="worker__title">
				{{ $contractor->name }}

				<div class="badge badge--green"></div>
				<div class="badge badge--red"></div>
			</div>
			<p>-Проверенный исполнитель "itcase", более 400 выполненных заданий! -Профессиональный ремонт и
				программирование, разблокировка, восстановление данных сотовых телефонов, план…</p>
			<p class="status">Сейчас на сайте</p>
		</div>

		<div class="worker__rating">
			<p>Отзывы</p>
			<div class="evaluation">
				<div class="like">
					<img src="/resources/images/like.svg" alt="">
					{{ $contractor->comments->count() }}
				</div>
			</div>

			<div class="stars">
				@for ($i=0; $i < $contractor->mean; $i++)
					<img src="/resources/images/star.svg" alt="">
				@endfor
				<span>{{ $contractor->mean }}</span>
			</div>

			<a href="#" class="button button--small">Предложить задание</a>
		</div>
	</li>
	@endforeach
	<!-- -->
</ul>

{{ $contractors->links() }}

</div>
@endsection