@extends('site.layouts.account')

@section('title', 'Тендеры')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('account.title.h1', 'Управление тендерами')

@section('account.content')
    <section class="box-admin">
        <div class="header-box-admin">
            <h3>Мои конкурсы</h3>
        </div>
        <div class="body-box-admin p-0">
            <div class="table-responsive">
                <table class="table tbl-job">
                    <thead>
                        <tr>
                            <th>Название проекта</th>
                            <th class="d-none d-xl-table-cell text-center">Предложений</th>
                            <th class="d-none d-xl-table-cell text-center">Категории</th>
                            <th class="d-none d-xl-table-cell text-center">Статус</th>
                            <th class="d-none d-md-table-cell text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($user->ownedTenders()->orderBy('created_at', 'desc')->get() as $tender)
                        <tr class="my-job-item">
                            <td>
                                <h3 class="title-job"><a href="{{ route('site.tenders.category', $tender->slug) }}">{{ $tender->title }}</a></h3>
                                <div class="meta-job"><span> <i class="fas fa-calendar-alt"></i> Опубликован: @if ($tender->published) {{ \Carbon\Carbon::create($tender->published_at)->format('d.m.Y') }} @else На модерации @endif</span><span> <i
                                            class="fas fa-calendar-alt"></i>Истекает {{ $tender->deadline }}</span></div>
                                <div class="salary-job"><i class="fas fa-money-bill-alt"></i>{{ $tender->budget }} сум
                                </div>
                                <div class="job-info d-xl-none"><a href="{{ route('site.account.tenders.candidates', $tender->slug) }}"
                                        class="number-application">{{ $tender->requests()->count() }} заявок</a>  <span
                                        class="active">@if ($tender->opened) Активный @else Закрыт @endif</span></div>
                                <div class="job-func d-flex d-md-none">
                                    <a class="btn btn-light btn-edit"><i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('site.tenders.delete', $tender->id) }}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders') }}">
                                        <button type="submit" onclick="return confirm('Вы уверены, что хотите безвозвратно удалить конкурс {{ $tender->title }}?')" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="d-none d-xl-table-cell text-center number-application"><a href="{{ route('site.account.tenders.candidates', $tender->slug) }}">{{ $tender->requests()->count() }} заявок</a>
                            </td>
                            <td class="d-none d-xl-table-cell text-center">
                                @foreach($tender->categories as $category)
                                    <div>{{ $category->getTitle() }} </div>
                                @endforeach
                            </td>
                            <td class="d-none d-xl-table-cell text-center active">@if ($tender->status !== 'done') @if ($tender->checkDeadline()) Открыт @else @if($tender->owner_id && $tender->opened) В разработке @else Приём заявок закрыт @endif @endif @else Выполнен! @endif</td>
                            <td class="d-none d-md-table-cell text-right">
                                <div class="d-flex">
                                    <a href="{{ route('site.account.tenders.candidates', $tender->slug) }}" class="btn btn-light btn-new" data-toggle="tooltip" title="Посмотреть кандидатов"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('site.account.tenders.edit', $tender->slug) }}" class="btn btn-light btn-edit"><i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('site.tenders.delete', $tender->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders') }}">
                                        <button type="submit" onclick="return confirm('Вы уверены, что хотите безвозвратно удалить конкурс {{ $tender->title }}?')" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
