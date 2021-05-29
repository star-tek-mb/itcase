@extends('site.layouts.front')

@section('title') {{ __('Исполнители') }} @endsection

@section('breadcrumbs')
- {{ __('Исполнители') }}
@endsection

@section('sidebar')
<div class="title-top">
	<h2>{{ __('Каталог исполнителей') }}</h2>
</div>

<form class="body-box" action="{{ route('site.contractors.categories') }}" method="POST">
	@csrf
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
	<div class="worker">
		<button type="submit" class="button">Фильтр</button>
	</div>
</form>

@include('site.layouts.sidebar')
@endsection

@section('content')
<div class="title-top title-top--small">
	<h2>
		Исполнителей найдено:
		<span>{{ $contractors->total() }}</span>
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
				<a href="{{ route('site.contractors.show', $contractor->slug) }}">{{ $contractor->name }}</a>

				<div class="badge badge--green"></div>
				<div class="badge badge--red"></div>
			</div>
			<div>{!! $contractor->about_myself !!}</div>
			<p class="status" @if (!$contractor->is_online) style="color: red !important;" @endif>
			@if ($contractor->is_online)
				{{ __('Сейчас на сайте') }}
			@else
				{{ __('Оффлайн') }}
			@endif
			</p>
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