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


<div class="worker-list">
  <div class="worker worker--page">
    <div class="worker__avatar">
      <img src="{{ $contractor->getImage() }}" alt="">
    </div>

    <div class="worker__data">
      <div class="worker__title">
        Здравствуйте я {{ $contractor->name }}
      </div>

      <ul class="worker__list">
        <li>
          Данные подтверждены:
          <div class="badge badge--green"></div>
          <div class="badge badge--red"></div>
        </li>

        <li class="worker__tasks">
          <div>
            Выполнил: <strong>{{ $contractor->contractedTenders->count() }} заданий </strong>
          </div>

          <div>
            Создал: <strong>{{ $contractor->ownedTenders->count() }} заданий</strong>
          </div>

        </li>

        <li class="strong">
          <p>Отзывы:</p>
          <div class="evaluation">
            <div class="like">
              <img src="/resources/images/like.svg" alt="">
              {{ $comments->count() }}
            </div>
          </div>
        </li>

        <li class="strong">
          Средняя оценка:

          <div class="stars">
            @for ($i=0; $i < $mean; $i++)
              <img src="/resources/images/star.svg" alt="">
            @endfor
            <span>{{ $mean }}</span>
          </div>
        </li>
      </ul>
    </div>


    <div class="worker__rating">
      <div class="text-holder">
        <p>Исполнитель получит
          уведомление и сможет
          оказать вам свои услуги
        </p>
      </div>


      <a href="#" class="button button--small">Предложить задание</a>

      <p>Был на сайте: <strong>{{ $contractor->last_online_at->diffForHumans() }}</strong> </p>
    </div>
  </div>
  <!-- -->
</div>

<div class="worker__data worker__about">
  <h3>Обо мне</h3>
  <div class="worker__about-text">
    {!! $contractor->about_myself !!}
  </div>


  <div class="worker__portfolio">
    <h3>Примеры работ</h3>
  </div>

  <div class="row  portfolio-row">
    <!-- -->
    @foreach ($contractor->contractedTenders->take(5) as $tender)
    <div class="col col--33 project">
      <a href="{{ route('site.tenders.category', $tender->slug) }}">
        <figure>
          <img src="{{ optional($tender->files()->first())->path }}" alt="">
          <figcaption>2</figcaption>
        </figure>
      </a>

      <h4>{{ $tender->title }}</h4>
    </div>
    @endforeach
  </div>

  <div class="mt50">
    <h3>Виды выполняемых работ</h3>
  </div>


  <ul class="worklist">
    @foreach ($contractor->categories as $category)
    <li>
      <a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
    </li>
    @endforeach
  </ul>


  <div class="testimonials-info">

    <h3>Отзывы</h3>

    <div class="evaluation">
      <div class="like">
        <img src="/resources/images/like.svg" alt="">
        {{ $comments->count() }}
      </div>
    </div>
  </div>


  <div class="testimonials">
    @foreach ($comments as $comment)
    <!-- -->
    <div class="testimonial">
      <div class="testimonial__data">
        <div class="testimonial__image">
          <img src="{{ $comment->author->getImage() }}" alt="">
        </div>

        <div class="testimonial__author">
          {{ $comment->author->name }}
        </div>
      </div>

      <div class="testimonial__text">
        <p>{!! $comment->comment !!}</p>

        <hr>


        <div class="testimonial__bottom">
          <p>{!! $comment->comment !!}</p>

          <div class="stars">
            @for ($i=0; $i < $comment->assessment; $i++)
              <img src="/resources/images/star.svg" alt="">
            @endfor
            <span>{{ $comment->assessment }}</span>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    <!-- -->

  </div>

</div>
@endsection