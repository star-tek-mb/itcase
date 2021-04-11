@extends('site.layouts.app')

@section('title')
    @if(empty($category->meta_title)) {{ $category->getTitle() }} @else {{ $category->meta_title }} @endif в Ташкенте|Узбекистане
@endsection

@section('meta')

    <meta name="title"
          content="@if(empty($category->meta_title)) {{ $category->getTitle() }} @else {{ $category->meta_title }} @endif в Ташкенте|Узбекистане">
    <meta name="description"
          content="@if (empty($category->meta_description)) {{ strip_tags($category->ru_description) }} @else {{ $category->meta_description }} @endif">
    <meta name="keywords" content="{{ $category->meta_keywords }}">

@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')
    <div class="primary-page">
        <div class="container">
          <div class="header-page">
            <div class="row">
                <div class="col-md-8">
                    <div class="section-heading">
                        <h1 class="title-page">Каталог исполнителей</h1>
                        <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('site.catalog.index') }}">Главная</a>
                              </li>
                              <li class="breadcrumb-item"><a href="{{ route('site.contractors.index') }}">Исполнители</a>
                              </li>
                              @foreach($category->ancestors as $ancestor)
                                  <li class="breadcrumb-item"><a
                                          href="{{ route('site.catalog.main', $ancestor->getAncestorsSlugs()) }}">{{ $ancestor->getTitle() }}</a>
                                  </li>
                              @endforeach
                              <li class="breadcrumb-item active"
                                  aria-current="page">{{ $category->getTitle() }}</li>
                          </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="search-form">
                      <form action="{{ route('site.contractors.search') }}" method="post">
                        @csrf
                        <div class="form-group">
                          <input class="form-control" name="contractorSearch" type="text" placeholder="Поиск здесь...">
                          <button class="btn-clear" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
          </div>

        <div class="row">
          <div class="col-lg-4">
              <div id="leftcolumn">
                  <div class="toggle-sidebar-left d-lg-none">Фильтр</div>
                  <div class="sidebar-left">
                      <button class="btn-close-sidebar-left btn-clear"><i class="fa fa-times-circle"></i>
                      </button>
                      <div class="box-sidebar">
                          <div class="header-box d-flex justify-content-between flex-wrap">
                              <h3 class="title-box">Категории</h3>
                          </div>
                          <div class="body-box">
                            <div class="accordion" id="categoriesAccordion" role="tablist" aria-multiselectable="false">
                                @foreach($parentCategories as $parent)
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between" id="headingCategory{{ $parent->id }}">
                                            <a href="{{ route('site.catalog.main', $parent->ru_slug) }}">{{ $parent->title }}</a>
                                            <a href="#collapseCategory{{ $parent->id }}" data-toggle="collapse" data-parent="#categoriesAccordion" aria-expanded="true" aria-controls="collapseCategory{{ $parent->id }}" style="font-size:8px"><button class="btn btn-outline-success"><i class="fas fa-caret-down"></i></button></a>
                                        </div>
                                        <div class="collapse" id="collapseCategory{{ $parent->id }}" role="tabpanel" aria-labelledby="headingCategory{{ $parent->id }}" data-parent="#categoriesAccordion">
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    @foreach($parent->categories as $category)
                                                        <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}" class="list-group-item list-group-item-action">{{ $category->title }}</a>
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
              </div>
          </div>
          <div class="col-lg-8">
            <div class="content-main-right list-jobs">
                <div class="header-list-job d-flex flex-wrap justify-content-between align-items-center">
                    <h4>{{ $contractorsCount }} Исполнителей найдено</h4>
                    @if (!\Request::is('contractors'))
                      <a class="btn btn-outline-success" href="{{ route('site.contractors.index') }}">Все результаты</a>
                    @endif
                </div>
                <div class="list">
                    @foreach($contractors as $contractor)
                        <div class="candidate-item hover">
                            <div class="candidate-img"><a
                                    href="{{ route('site.contractors.show', $contractor->slug) }}"><img
                                        src="{{ $contractor->getImage() }}"
                                        alt="{{ $contractor->getContractorTitle() }}"></a></div>
                            <div class="candidate-content">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="candidate-info">
                                            <h3 class="title-job"><a
                                                    href="{{ route('site.contractors.show', $contractor->slug) }}">{{ $contractor->getContractorTitle() }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                    @guest
                                        <div class="col-md-4">
                                            <div class="candidate-button"><button class="btn btn-light btn-lg tender-item" type="button" data-target="{{ route('site.tenders.contractors.add.guest', $contractor->id) }}">Добавить
                                                    в конкурс</button></div>
                                        </div>
                                    @endguest
                                    @auth
                                        @if (auth()->user()->hasRole('customer'))
                                            <div class="col-md-4">
                                                <div class="candidate-button"><button class="btn btn-light btn-lg" type="button" data-toggle="modal" data-target="#tendersModal{{ $contractor->id }}">Добавить
                                                        в конкурс</button></div>
                                            </div>
                                            <div class="modal fade" id="tendersModal{{ $contractor->id }}" tabindex="-1" role="dialog" aria-labelledby="tendersModalLabel{{ $contractor->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tendersModalLabel{{ $contractor->id }}">Выберите конкурс</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Выберите конкурс, в который вы хотите пригласить исполнителя</p>
                                                            <ul class="list-group list-group-flush">
                                                                @foreach(auth()->user()->ownedTenders as $tender)
                                                                    @continue(!$tender->opened || $tender->status == 'done')
                                                                    @if ($tender->hasRequestFrom($contractor->id))
                                                                        <li class="list-group-item">{{ $tender->title }} <small class="text-primary"><i class="far fa-check-circle"></i> Уже участвует в этом конкурсе</small></li>
                                                                        @continue
                                                                    @endif
                                                                    <a href="#" class="list-group-item list-group-item-action tender-item" data-target="{{ route('site.tenders.contractors.add', ['tenderId' => $tender->id, 'contractorId' => $contractor->id]) }}">{{ $tender->title }}</a>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light-green" data-dismiss="modal">Закрыть</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            <div class="candidate-content mt-3" style="margin-left: 36px;">
                                <div class="row">
                                    @if($contractor->about_myself)
                                        <div class="col-md-6">
                                            <div class="candidate-info">
                                                <h3 class="title-job">Описание</h3>
                                                <div class="date-job"><p>{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($contractor->about_myself)), 150, $end='...') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="candidate-info">
                                            <h3 class="title-job">Цены на услуги</h3>
                                            @foreach($contractor->categories as $contractorCategory)
                                                <div class="price-item">
                                                    <i class="fa fa-check-circle text-primary"></i> <span
                                                        class="service-name">{{ $contractorCategory->getTitle() }}: </span>
                                                    @if($contractorCategory ->pivot->price_from!='' or $contractorCategory->pivot->price_to !='')
                                                      <span class="price-from">{{ $contractorCategory->pivot->price_from }}</span> - <span class="price-to">{{ $contractorCategory->pivot->price_to }}</span> сум
                                                    @else
                                                      <span class="price-from">Договорная</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-page d-flex justify-content-end">
                    {{ $contractors->links() }}
                </div>
            </div>
          </div>
        </div>
        @if($category)
        <div class="row">
            <div class="col-lg">
                <div id="leftcolumn">
                    <div class="toggle-sidebar-left d-lg-none">Фильтр</div>
                    <div class="sidebar-left">
                        <button class="btn-close-sidebar-left btn-clear"><i class="fa fa-times-circle"></i>
                        </button>
                        <div class="box-sidebar" style="margin-top: 40px;">
                            <div class="header-box d-flex justify-content-between flex-wrap">
                                <h3 class="title-box">Описание</h3>
                            </div>
                            <div class="body-box">
                   <p>{!! $category->ru_description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
      </div>
    </div>

        {{-- <div class="container">
            <div class="section-heading text-center">
                <h2 class="title">Исполнители</h2>
                <p class="mt-3">В нашем каталоге собраны digital-агенства и специалисты-фрилансеры. Выберите нужный раздел каталога и
                    отберите подходящих вам Исполнителей.</p>
            </div>
            <div class="content-main-right">
                @foreach($categories as $category)
                    <div class="category-item job-item">
                        <div class="row no-gutters">
                            <h3 class="title-job w-100"><a
                                    href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}" class="text-center w-100 d-block">{{ $category->getTitle() }}</a></h3>
                        </div>
                        <div class="d-flex justify-content-center category-children__list">
                            @foreach($category->categories as $child)
                                <a href="{{ route('site.catalog.main', $child->getAncestorsSlugs()) }}"><span class="badge badge-primary category-badge">{{ $child->getTitle() }}</span></a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}

@endsection
