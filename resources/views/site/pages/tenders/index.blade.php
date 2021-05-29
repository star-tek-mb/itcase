@extends('site.layouts.front')

@section('title') {{ __('Задания') }} @endsection

@section('breadcrumbs')
- {{ __('Задания') }}
@endsection

@section('sidebar')
<div class="title-top">
	<h2>{{ __('Каталог заданий') }}</h2>
</div>

<form class="body-box" action="{{ route('site.tenders.search') }}" method="POST">
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
    <div class="py-4 px-4 text-center">
        <div class="form-group">
            <label for="distance">Содержит ключевые слова</label>
            <input type="text" id="terms" class="form-control" name="terms" value="{{ request()->terms }}">
        </div>
        <div class="form-group">
            <label for="price">Минимальная цена задания, сум</label>
            <input type="text" id="price" class="form-control" name="minPrice" value="{{ request()->minPrice }}">
        </div>
        <br>
        <button type="submit" class="button">Фильтр</button>
    </div>
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
<div class="tasks-holder">
  @foreach ($tenders as $tender)
  <div class="task-block">
    <div class="task-block__icon">
      <img style="width: 100%; height: auto;" src="{{ $tender->categoryIcon() }}" alt="">
    </div>
    <div class="task__data">
      <h3><a href="{{ route('site.tenders.category', $tender->slug) }}">{{ $tender->title }}</a></h3>
      <ul class="task-data">
        @inject('geocoder', 'App\Services\GeocoderService')
        <li class="task-address">
          {{ $geocoder->getAddress($tender->geo_location) }}
        </li>

        <li class="task-money">
          Оплата наличными <br>
          Бюджет: <strong>{{ $tender->budget }} сум</strong>
        </li>

        <li class="task-date">
          Опубликован: <span>{{ $tender->published_at->format('d.m.Y') }}</span> <br>
          Крайний срок приема заявок: <span>{{ $tender->deadline->format('d.m.Y') }}</span>
        </li>

        <li>
          <a href="#" class="button button--small">Предложить задание</a>
        </li>
      </ul>
    </div>
  </div>
  @endforeach

  {{ $tenders->links() }}
</div>
@endsection