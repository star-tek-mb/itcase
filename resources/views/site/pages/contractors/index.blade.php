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
				<div class="ml-4 form-check @if ($category && $category->parent->id == $parent->id) active @endif">
					<input @if (($category == null && request()->categories == null) || in_array($parent->id, request()->categories ?? [])) checked="" @endif type="checkbox" id="cat{{ $parent->id }}" class="form-check-input" name="categories[]" value="{{ $parent->id }}">
					<label class="form-check-label" for="cat{{ $parent->id }}">{{ $parent->title }}</label>
					<span></span>

					<div class="arrow @if ($category && $category->parent->id == $parent->id) active @endif"></div>
					<ul>
						@foreach ($parent->categories as $cat)
							<li>
								<input @if (($category && $category->id == $cat->id) || in_array($cat->id, request()->categories ?? []) || in_array($cat->parent->id, request()->categories ?? [])) checked="" @elseif ($category == null && request()->categories == null) checked="" @endif type="checkbox" id="cat{{ $cat->id }}" class="form-check-input" name="categories[]" value="{{ $cat->id }}">
								<label class="form-check-label" for="cat{{ $cat->id }}">{{ $cat->title }}</label>
								<span></span>
							</li>
						@endforeach
					</ul>
				</div>
			</li>

		@endforeach
	</ul>
	<div class="worker filter-button">
		<button type="submit" class="button">Найти</button>
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


	<!-- -->
  @include('site.pages.contractors.individual_contractor')


{{ $contractors->links() }}

</div>
@endsection