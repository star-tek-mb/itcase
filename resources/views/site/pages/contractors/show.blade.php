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
	<div class="worker filter-button">
		<button type="submit" class="button">Найти</button>
	</div>
</form>

@include('site.layouts.sidebar')
@endsection

@section('content')


<div class="worker-list">
  <div class="worker worker--page">
    <div class="worker__avatar">
      <img style="width: 100%;" src="{{ $contractor->getImage() }}" alt="">
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


      <a href="#" class="button button--full" data-modal="#modal">Предложить задание</a>

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


  @if ($contractor->contractedTenders->count() > 0)
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
  @endif

  <div class="mt50">
    <h3>Виды выполняемых работ</h3>
  </div>


  <ul class="worklist">
    @foreach ($contractor->categories as $category)
    <li>
      <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->title }}</a>
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

@section('modal')
@auth
<div class="modal" id="modal">
  <h4>Выберите задание, в который вы хотите пригласить исполнителя</h4>
  <select id="add-form" class="form-control" style="margin-top: 20px;">
      <option value="{{ route('site.tenders.common.create') }}">У вас нету опубликованных заданий</option>
      @foreach(auth()->user()->ownedTenders as $tender)
          @continue(!$tender->opened || $tender->status == 'done')
          @if ($tender->hasRequestFrom($contractor->id))
              <option disabled>{{ $tender->title }} - уже учавствует</option>
          @endif
          <option value="{{ route('site.tenders.contractors.add', ['tenderId' => $tender->id, 'contractorId' => $contractor->id]) }}">{{ $tender->title }}</option>
      @endforeach
  </select>
  <a href="#" onclick="window.location = document.getElementById('add-form').value;" class="button button--simple button--small">Пригласить</a>
  <a href="#" class="close"></a>
</div>
@else
<div class="modal" id="modal">
  <h4>Хотите стать заказчиком?</h4>

  <p>Это не сложно. Всего предстоит два шага:
    анкета и подписка на задания. Всё займёт 
    примерно 5 минут.</p>

    <a href="{{ route('register') }}" class="button button--simple button--small">Зарегестрироваться</a>
    <p class="light"><a href="{{ route('login') }}">У меня уже есть аккаунт. Войти</a></p>

    <a href="#" class="close"></a>
</div>
@endauth
@endsection