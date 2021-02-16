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
        <meta name="title" content="{{ $currentCategory->tender_meta_title_prefix }} @if(empty($currentCategory->meta_title)) {{ $currentCategory->getTitle() }} @else {{ $currentCategory->meta_title }} @endif в Ташкенте|Узбекистане">
        <meta name="description"
              content="@if (empty($currentCategory->meta_description)) {{ strip_tags($currentCategory->ru_description) }} @else {{ $currentCategory->meta_description }} @endif">
    @endif
@endsection
@section('header')
    @include('site.layouts.partials.headers.default')
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
                                    <li class="breadcrumb-item"><a href="{{ route('site.catalog.index') }}">Главная</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Конкурсы</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="search-form d-flex justify-content-end pr-0 align-items-center">
                            <form action="{{ route('site.tenders.index.search') }}" method="post">
                                @csrf
                                <div class="form-group d-flex">
                                    <input class="form-control mr-md-4" name="search" type="text" placeholder="Поиск здесь...">
                                    <div id="livesearch"></div>
                                    <button class="btn-clear position-relative" type="submit"><i class=" fa fa-search"></i></button>
                                </div>
                            </form>

                            <ul class="d-flex ul-nav align-items-center tabs-nav">

                                <li>
                                    <a href="#tab-1" title="Список">
                                        <i class=" fa fa-list"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="#tab-2" title="Показать на карте">
                                        <i class=" fa fa-map-marker"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <form id="leftcolumn" action="#">
                            <div class="toggle-sidebar-left d-lg-none">Фильтр</div>
                            <div class="sidebar-left">
                                <button class="btn-close-sidebar-left btn-clear">
                                    <i class="fa fa-times-circle"></i>
                                </button>
                                <div class="box-sidebar">
                                    <div class="header-box d-flex justify-content-between flex-wrap">
                                        <span class="title-box">Фильтр</span>
                                        <input type="reset" value="Очистить">
                                    </div>
                                    <div class="body-box">
                                        <div class="accordion" id="needsAccordion" role="tablist" aria-multiselectable="false">
                                            @foreach($needs as $need)
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between" role="tab" id="heading{{ $need->id }}">
                                                        <span>{{ $need->ru_title }}</span>
                                                        <a href="#collapse{{ $need->id }}" data-toggle="collapse" data-parent="#needsAccordion" aria-expanded="true" aria-controls="collapse{{ $need->id }}" style="font-size:8px"><button class="btn btn-outline-success"><i class="fas fa-caret-down"></i></button></a>
                                                    </div>
                                                    <div class="collapse" id="collapse{{ $need->id }}" role="tabpanel" aria-labelledby="heading{{ $need->id }}" data-parent="#needsAccordion">
                                                        <div class="card-body">
                                                            <div class="accordion" id="categoriesAccordion{{ $need->id }}" role="tablist" aria-multiselectable="false">
                                                                @foreach($need->menuItems as $item)
                                                                    <div class="card">
                                                                        <div class="card-header d-flex justify-content-between" id="headingCategory{{ $item->id }}">
                                                                            <a href="{{ route('site.tenders.category', $item->ru_slug) }}">{{ $item->ru_title }}</a>
                                                                            <a href="#collapseCategory{{ $item->id }}" data-toggle="collapse" data-parent="#categoriesAccordion{{ $need->id }}" aria-expanded="true" aria-controls="collapseCategory{{ $item->id }}" style="font-size:8px"><button class="btn btn-outline-success"><i class="fas fa-caret-down"></i></button></a>
                                                                        </div>
                                                                        <div class="collapse" id="collapseCategory{{ $item->id }}" role="tabpanel" aria-labelledby="headingCategory{{ $item->id }}" data-parent="#categoriesAccordion{{ $need->id }}">
                                                                            <div class="card-body">
                                                                                <ul class="list-group list-group-flush">
                                                                                @foreach($item->categories as $category)
                                                                                    <!--<a href="{{ route('site.tenders.category', $category->getAncestorsSlugs()) }}" class="list-group-item list-group-item-action">{{ $category->getTitle() }}</a>__DIR__-->
                                                                                        <li class="list-group-item list-group-item-action">
                                                                                            <input type="checkbox" class="ajax-filter">
                                                                                            {{ $category->getTitle() }}
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-8">
                        <div class="content-main-right list-jobs">
                            <div class="header-list-job d-flex flex-wrap justify-content-between align-items-center">
                                <h4>{{ $tendersCount }} Конкурсов найдено</h4>
                                @if (!\Request::is('tenders'))
                                    <a class="btn btn-outline-success" href="{{ route('site.tenders.index') }}">Все результаты</a>
                                @endif
                            </div>
                            <div class="list tabs-stage">
                                <div class="tab" id="tab-1">
                                    @foreach($tenders as $tender)
                                        <div class="job-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <div class="img-job text-center"><a href="#"></a></div>
                                                </div>
                                                <div class="col-md-10 job-info">
                                                    <div class="text">
                                                        <h3 class="title-job"><a href="{{ route('site.tenders.category', $tender->slug) }}">{{ $tender->title }}</a><span class="ml-2 tags"><a>@if ($tender->opened==0 || $tender->contractor) Приём заявок окончен @else Открыт @endif</a></span></h3>
                                                        <div class="date-job">
                                                            <i class="fa fa-check-circle"></i><span
                                                                    class="company-name">Опубликован: {{ \Carbon\Carbon::create($tender->published_at)->format('d.m.Y') }}</span>
                                                            <div class="date-job"><i class="fa fa-check-circle"></i><span
                                                                        class="company-name">Крайний срок приема заявок: {{ \Carbon\Carbon::create($tender->deadline)->format('d.m.Y') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="meta-job">
                                                            <div class="categories">@foreach($tender->categories as $category){{ $category->getTitle() }} @endforeach</div>
                                                            <span class="salary">Бюджет {{ $tender->budget }} сум</span>
                                                        </div>
                                                        @guest
                                                        <a href="{{ route('login') }}" class="add-favourites" data-toggle="tooltip" title="Оставить заявку"><i class="fas fa-plus"></i></a>
                                                        @else
                                                            @php
                                                                $user = auth()->user();
                                                            @endphp
                                                            @if ($user->hasRole('contractor'))
                                                                @if (in_array($user->id, $tender->requests()->pluck('user_id')->toArray()))
                                                                    <span class="text-primary"><i class="fas fa-check"></i> Вы уже участвуете в этом конкурсе</span>
                                                                @else
                                                                    <button class="add-favourites" type="button" data-toggle="modal"
                                                                            data-target="#requestFormModal{{ $tender->id }}" title="Оставить заявку"><div class="h-100 w-100" data-toggle="tooltip" title="Оставить заявку"><i class="fas fa-plus"></i></div>
                                                                    </button>
                                                                    <div class="modal fade" id="requestFormModal{{ $tender->id }}" tabindex="-1" role="dialog"
                                                                         aria-labelledby="requestFormModelLabel{{ $tender->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="requestFormModelLabel{{ $tender->id }}">Ваша заявка</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <form action="{{ route('site.tenders.requests.make') }}" method="post">
                                                                                    @csrf
                                                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                                                    <input type="hidden" name="tender_id" value="{{ $tender->id }}">
                                                                                    <div class="modal-body">
                                                                                        <p>Заинтересованы в данной задаче? Сразу отправляйте заявку. Так вы сможете
                                                                                            быстрее
                                                                                            связаться с заказчиком и обсудить все детали.
                                                                                            <b>Бюджет</b> и <b>Cроки</b> в
                                                                                            заявке — <b>ориентировочные</b>. Их требуется указать
                                                                                            лишь для того, чтобы заказчик понимал ваш уровень цен и скорость работы.
                                                                                            При
                                                                                            общении с заказчиком вы всегда сможете их пересмотреть.
                                                                                            Ваше предложение и дальнейшую переписку увидит только организатор
                                                                                            задачи.
                                                                                        </p>
                                                                                        <div class="form-group">
                                                                                            <label for="budget">Бюджет</label>
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12 col-lg-6">
                                                                                                    <input type="text" required name="budget_from" id="budgetFrom{{ $tender->id }}"
                                                                                                           class="form-control" placeholder="500 000">
                                                                                                </div>
                                                                                                <div class="col-sm-12 col-lg-6">
                                                                                                    <input type="text" required name="budget_to" id="budgetTo{{ $tender->id }}"
                                                                                                           class="form-control" placeholder="1 000 000">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="period">Срок</label>
                                                                                            <div class="row">
                                                                                                <div class="col-ms-12 col-lg-6">
                                                                                                    <input type="text" required name="period_from" id="period_from{{ $tender->id }}"
                                                                                                           class="form-control" placeholder="2 дня">
                                                                                                </div>
                                                                                                <div class="col-ms-12 col-lg-6">
                                                                                                    <input type="text" required name="period_to" id="period_to{{ $tender->id }}"
                                                                                                           class="form-control" placeholder="3 дня">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="comment">Комментарий (по желанию)</label>
                                                                                            <textarea name="comment" id="comment{{ $tender->id }}" rows="3"
                                                                                                      class="form-control"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                                            Закрыть
                                                                                        </button>
                                                                                        <button class="btn btn-light-green" type="submit">Отправить заявку <i
                                                                                                    class="fas fa-send"></i></button>
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

                                <div class="tab" id="tab-2">

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
@endsection
