@extends('site.layouts.account')

@section('title', 'Мои конкурсы')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('account.title.h1', 'Мои конкурсы')

@section('account.content')
    <section class="box-admin">
        <div class="header-box-admin">
            <h3>Мои заявки на конкурсы</h3>
        </div>
        <div class="body-box-admin p-0">
            <div class="table-responsive">
                <table class="table tbl-job">
                    <thead>
                        <tr>
                            <th>Название проекта</th>
                            <th class="d-none d-xl-table-cell text-center">Локация</th>
                            <th class="d-none d-xl-table-cell text-center">Категории</th>
                            <th class="d-none d-xl-table-cell text-center">Статус</th>
                            <th class="d-none d-md-table-cell text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->requests()->orderBy('created_at', 'desc')->get() as $request)
                            @if (!$request->tender)
                                @continue
                            @endif
                            <tr class="my-job-item">
                                <td>
                                    <h3 class="title-job"><a href="{{ route('site.tenders.category', $request->tender->slug) }}">{{ $request->tender->title }}</a></h3>
                                    <div class="meta-job"><span> <i class="fas fa-calendar-alt"></i>Опубликован: {{ \Carbon\Carbon::create($request->tender->published_at)->format('d.m.Y') }}</span><span> <i
                                                class="fas fa-calendar-alt"></i>Истекает {{ \Carbon\Carbon::create($request->tender->deadline)->format('d.m.Y') }}</span></div>
                                    <div class="salary-job"><i class="fas fa-money-bill-alt"></i>{{ $request->tender->budget }} сум
                                    </div>
                                    <div class="job-info d-xl-none"><span
                                            class="number-application">Ташкент</span>@foreach($request->tender->categories as $category) <span>{{ $category->getTitle() }} </span>@endforeach<span
                                            class="active">@if($request->tender->contractor_id == $request->user_id) Активный @else В ожидании @endif </span></div>
                                    <div class="job-func d-flex d-md-none">
                                        <form action="{{ route('site.account.chats') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="with_user_id" value="{{ $request->tender->owner->id }}">
                                            <button class="btn btn-light btn-view" type="submit" data-toggle="tooltip" title="Связаться"><i class="fas fa-comments"></i></button>
                                        </form>
                                        <form action="{{ route('site.tenders.requests.cancel') }}" method="post" class="ml-1">
                                            @csrf
                                            <input type="hidden" name="requestId" value="{{ $request->id }}">
                                            <button type="submit" onclick="return confirm('Вы уверены, что хотите отменить заявку на конкурс {{ $request->tender->title }}?')" data-toggle="tooltip" data-placement="top" title="Отменить заявку" class="btn btn-light btn-delete"><i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="d-none d-xl-table-cell text-center number-application">Ташкент</td>
                                <td class="d-none d-xl-table-cell text-center">@foreach($request->tender->categories as $category) <div>{{ $category->getTitle() }} </div>@endforeach</td>
                                <td class="d-none d-xl-table-cell text-center active">@if($request->tender->contractor_id == $request->user_id) Активный @else В ожидании @endif</td>
                                <td class="d-none d-md-table-cell text-right">
                                    <div class="d-flex">
                                        <form action="{{ route('site.account.chats') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="with_user_id" value="{{ $request->tender->owner->id }}">
                                            <button class="btn btn-light btn-view" type="submit" data-toggle="tooltip" title="Связаться"><i class="fas fa-comments"></i></button>
                                        </form>
                                        <form action="{{ route('site.tenders.requests.cancel') }}" method="post" class="ml-1">
                                            @csrf
                                            <input type="hidden" name="requestId" value="{{ $request->id }}">
                                            <button type="submit" onclick="return confirm('Вы уверены, что хотите отменить заявку на конкурс {{ $request->tender->title }}?')" data-toggle="tooltip" data-placement="top" title="Отменить заявку" class="btn btn-light btn-delete"><i class="fas fa-times"></i>
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
