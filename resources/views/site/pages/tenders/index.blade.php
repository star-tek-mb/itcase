@extends('site.layouts.app')

@section('title')
    @if ($currentCategory)
        {{ $currentCategory->tender_meta_title_prefix }} @if(empty($currentCategory->meta_title)) {{ $currentCategory->getTitle() }} @else {{ $currentCategory->meta_title }} @endif в Ташкенте|Узбекистане
    @else
        Конкурсы
    @endif
@endsection

@section('meta')
    @if ($currentCategory)
        <meta name="title"
              content="{{ $currentCategory->tender_meta_title_prefix }} @if(empty($currentCategory->meta_title)) {{ $currentCategory->getTitle() }} @else {{ $currentCategory->meta_title }} @endif в Ташкенте|Узбекистане">
        <meta name="description"
              content="@if (empty($currentCategory->meta_description)) {{ strip_tags($currentCategory->ru_description) }} @else {{ $currentCategory->meta_description }} @endif">
    @endif
@endsection
@section('header')
    @include('site.layouts.partials.headers.default')
@endsection
@section('css')
    <style>
        #map {
            width: 730px;
            height: 730px;
            padding: 0;
            margin: 0;
        }

        #location {
            width: 300px;
            height: 300px;
            padding: 0;
            margin: 0;
        }
        .caret::before {
            content: "\25B6";
        }
        .collapsed.caret {
            transform: rotate(0deg);
        }
        .caret {
            color: black;
            display: inline-block;
            transform: rotate(90deg);
            position: absolute;
            top: 0;
        }
    </style>
@endsection

@section('content')
    <div class="primary-page">
        <div class="container">
            <div class="header-page">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section-heading">
                            <h1 class="title-page">Каталог конкурсов @if ($currentCategory)
                                    {{ $currentCategory->getTitle() }}
                                @endif </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('site.catalog.index') }}">Главная</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Задания</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="search-form d-flex justify-content-end pr-0 align-items-center">

                            <ul class="d-flex ul-nav align-items-center ">
                                <li>
                                    <i class=" fa fa-list"></i> Поиск по тексту
                                </li>
                                <li>  
                                    <a href="{{ route('site.tenders.map') }}">
                                        <i class=" fa fa-map-marker"></i> Поиск по карте
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <form id="filter" action="{{ route('site.tenders.search') }}" method="post">
                            @csrf
                            <div class="toggle-sidebar-left d-lg-none">Фильтр</div>
                            <div class="sidebar-left">
                                <button class="btn-close-sidebar-left btn-clear">
                                    <i class="fa fa-times-circle"></i>
                                </button>
                                <div class="box-sidebar">
                                    <div class="header-box d-flex justify-content-between flex-wrap">
                                        <span class="title-box">Фильтр</span>
                                    </div>
                                    <!-- category checkbox -->
                                    <div class="body-box mb-4">
                                        <ul class="nav nav-stacked" id="categoriesAccordion" style="display: block;">
                                        @foreach ($parentCategories as $parent)
                                            <li class="panel" style="position: relative;">
                                                <a data-toggle="collapse" data-parent="#categoriesAccordion" class="caret collapsed" href="#accordion{{ $parent->id }}"></a>
                                                <div class="ml-4 form-check" style="display: inline-block;">
                                                    <input @if (in_array($parent->id, request()->categories ?? []) || !request()->categories) checked @endif type="checkbox" id="cat{{ $parent->id }}" class="form-check-input" name="categories[]" value="{{ $parent->id }}">
                                                    <label class="form-check-label" for="cat{{ $parent->id }}">{{ $parent->title }}</label>
                                                    <ul id="accordion{{ $parent->id }}" class="collapse panel-collapse in">
                                                        @foreach ($parent->categories as $category)
                                                        <li class="form-check">
                                                            <input @if (in_array($category->id, request()->categories ?? []) || !request()->categories) checked @endif type="checkbox" id="cat{{ $category->id }}" class="form-check-input" name="categories[]" id="tall" value="{{ $category->id }}">
                                                            <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->title }}</label>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </div>

                                    <!-- other checkbox -->
                                    <div class="body-box">
                                        <div class="form-group">
                                            <label for="distance">Содержит ключевые слова</label>
                                            <input type="text" id="terms" class="form-control" name="terms" value="{{ request()->terms }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Минимальная цена задания, сум</label>
                                            <input type="text" id="price" class="form-control" name="minPrice" value="{{ request()->minPrice }}">
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="remote" id="remote" @if (request()->remote) checked @endif>
                                            <label class="form-check-label">Удаленная работа</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-2 btn bg-primary text-white">Фильтр</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div id="result" class="content-main-right list-jobs">
                            <div class="header-list-job d-flex flex-wrap justify-content-between align-items-center">
                                <h4>{{ $tendersCount }} Конкурсов найдено</h4>
                                @if (!\Request::is('tenders'))
                                    <a class="btn btn-outline-success" href="{{ route('site.tenders.index') }}">Все
                                        результаты</a>
                                @endif
                            </div>
                            <div class="list tabs-stage">
                                <div class="tab">
                                    @foreach($tenders as $tender)
                                        <div class="job-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <div class="img-job text-center"><a href="#"></a></div>
                                                </div>
                                                <div class="col-md-10 job-info">
                                                    <div class="text">
                                                        <h3 class="title-job"><a
                                                                    href="{{ route('site.tenders.category', $tender->slug) }}">{{ $tender->title }}</a><span
                                                                    class="ml-2 tags"><a>@if ($tender->opened==0 || $tender->contractor || !$tender->checkDeadline())
                                                                        Приём заявок окончен @else
                                                                        Открыт @endif</a></span></h3>
                                                        <div class="date-job">
                                                            <i class="fa fa-check-circle"></i><span
                                                                    class="company-name">Опубликован: {{ $tender->published_at->format('d.m.Y') }}</span>
                                                            <div class="date-job"><i
                                                                        class="fa fa-check-circle"></i><span
                                                                        class="company-name">Крайний срок приема заявок: {{ $tender->deadline->format('d.m.Y') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="meta-job">
                                                            <div class="categories">@foreach($tender->categories as $category){{ $category->getTitle() }} @endforeach</div>
                                                            <span class="salary">Бюджет {{ $tender->budget }} сум</span>
                                                        </div>
                                                        @guest
                                                        <a href="{{ route('login') }}" class="add-favourites"
                                                           data-toggle="tooltip" title="Оставить заявку"><i
                                                                    class="fas fa-plus"></i></a>
                                                        @else
                                                            @php
                                                                $user = auth()->user();
                                                            @endphp
                                                            @if ($user->hasRole('contractor'))
                                                                @if (in_array($user->id, $tender->requests()->pluck('user_id')->toArray()))
                                                                    <span class="text-primary"><i
                                                                                class="fas fa-check"></i> Вы уже участвуете в этом конкурсе</span>
                                                                @else
                                                                    <button class="add-favourites" type="button"
                                                                            data-toggle="modal"
                                                                            data-target="#requestFormModal{{ $tender->id }}"
                                                                            title="Оставить заявку">
                                                                        <div class="h-100 w-100" data-toggle="tooltip"
                                                                             title="Оставить заявку"><i
                                                                                    class="fas fa-plus"></i></div>
                                                                    </button>
                                                                    <div class="modal fade"
                                                                         id="requestFormModal{{ $tender->id }}"
                                                                         tabindex="-1" role="dialog"
                                                                         aria-labelledby="requestFormModelLabel{{ $tender->id }}"
                                                                         aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-lg"
                                                                             role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="requestFormModelLabel{{ $tender->id }}">
                                                                                        Ваша заявка</h5>
                                                                                    <button type="button" class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <form action="{{ route('site.tenders.requests.make') }}"
                                                                                      method="post">
                                                                                    @csrf
                                                                                    <input type="hidden" name="user_id"
                                                                                           value="{{ $user->id }}">
                                                                                    <input type="hidden"
                                                                                           name="tender_id"
                                                                                           value="{{ $tender->id }}">
                                                                                    <div class="modal-body">
                                                                                        <p>Заинтересованы в данной
                                                                                            задаче? Сразу отправляйте
                                                                                            заявку. Так вы сможете
                                                                                            быстрее
                                                                                            связаться с заказчиком и
                                                                                            обсудить все детали.
                                                                                            <b>Бюджет</b> и <b>Cроки</b>
                                                                                            в
                                                                                            заявке —
                                                                                            <b>ориентировочные</b>. Их
                                                                                            требуется указать
                                                                                            лишь для того, чтобы
                                                                                            заказчик понимал ваш уровень
                                                                                            цен и скорость работы.
                                                                                            При
                                                                                            общении с заказчиком вы
                                                                                            всегда сможете их
                                                                                            пересмотреть.
                                                                                            Ваше предложение и
                                                                                            дальнейшую переписку увидит
                                                                                            только организатор
                                                                                            задачи.
                                                                                        </p>
                                                                                        <div class="form-group">
                                                                                            <label for="budget">Бюджет</label>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12 col-lg-6">
                                                                                                    <input type="text"
                                                                                                           required
                                                                                                           name="budget_from"
                                                                                                           id="budgetFrom{{ $tender->id }}"
                                                                                                           class="form-control"
                                                                                                           placeholder="500 000">
                                                                                                </div>
                                                                                                <div class="col-sm-12 col-lg-6">
                                                                                                    <input type="text"
                                                                                                           required
                                                                                                           name="budget_to"
                                                                                                           id="budgetTo{{ $tender->id }}"
                                                                                                           class="form-control"
                                                                                                           placeholder="1 000 000">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="period">Срок</label>
                                                                                            <div class="row">
                                                                                                <div class="col-ms-12 col-lg-6">
                                                                                                    <input type="text"
                                                                                                           required
                                                                                                           name="period_from"
                                                                                                           id="period_from{{ $tender->id }}"
                                                                                                           class="form-control"
                                                                                                           placeholder="2 дня">
                                                                                                </div>
                                                                                                <div class="col-ms-12 col-lg-6">
                                                                                                    <input type="text"
                                                                                                           required
                                                                                                           name="period_to"
                                                                                                           id="period_to{{ $tender->id }}"
                                                                                                           class="form-control"
                                                                                                           placeholder="3 дня">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="comment">Комментарий
                                                                                                (по желанию)</label>
                                                                                            <textarea name="comment"
                                                                                                      id="comment{{ $tender->id }}"
                                                                                                      rows="3"
                                                                                                      class="form-control"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-dismiss="modal">
                                                                                            Закрыть
                                                                                        </button>
                                                                                        <button class="btn btn-light-green"
                                                                                                type="submit">Отправить
                                                                                            заявку <i
                                                                                                    class="fas fa-send"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @endguest
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="tab">

                                </div>
                                <div class="pagination-page d-flex justify-content-end">
                                    {{ $tenders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($currentCategory !== null && $currentCategory->ru_description)
                    <div class="row">
                        <div class="col-lg">
                            <div id="leftcolumn">
                                <div class="sidebar-left">
                                    <div class="box-sidebar" style="margin-top: 40px;">
                                        <div class="header-box d-flex justify-content-between flex-wrap">
                                            <h3 class="title-box">Описание</h3>
                                        </div>
                                        <div class="body-box">
                                            <p>{!! $currentCategory->ru_description !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$('input[type="checkbox"]').change(function(e) {
  var checked = $(this).prop("checked"),
      container = $(this).parent(),
      siblings = container.siblings();
  container.find('input[type="checkbox"]').prop({
    indeterminate: false,
    checked: checked
  });
  function checkSiblings(el) {
    var parent = el.parent().parent(),
        all = true;
    el.siblings().each(function() {
      let returnValue = all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
      return returnValue;
    });
    if (all && checked) {
      parent.children('input[type="checkbox"]').prop({
        indeterminate: false,
        checked: checked
      });
      checkSiblings(parent);
    } else if (all && !checked) {
      parent.children('input[type="checkbox"]').prop("checked", checked);
      parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
      checkSiblings(parent);
    } else {
      el.parents("li div").children('input[type="checkbox"]').prop({
        indeterminate: true,
        checked: false
      });

    }
  }
  checkSiblings(container);
});
</script>
<script>

    $('#ajaxFilter').click(function (e) {
        var frm = $('#filter');
        var formData = frm.serialize();

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: formData,
            success: function (data) {
                $('#result').html(data);
                $('body').on('click', '.pagination a',function(e){
                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    $.ajax({
                        type: $('#filter').attr('method'),
                        url: $('#filter').attr('action')+"?page="+page,
                        data: $('#filter').serialize(),
                        success:function(data)
                        {
                            $('#result').html(data);
                            console.log(data);
                        }
                    });
                });
                }
        });

    });
</script>
@endsection


