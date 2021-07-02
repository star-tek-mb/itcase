@extends('site.layouts.account')

@section('title', 'Тендеры')

@section('header')
@include('site.layouts.partials.headers.default')
@endsection

@section('account.title.h1', 'Управление тендерами')

@section('account.content')
<section class="box-admin">
    <div class="header-box-admin">
        <h3>{{ __('Мои задания') }}</h3>
        <h3><a href="{{ route('site.tenders.common.create') }}"><i class="fas fa-plus-circle"></i>
                {{ __('Добавить задание') }}</a></h3>
    </div>
    <div class="body-box-admin p-0">
        <div class="table-responsive">
            <table class="table tbl-job">
                <thead>
                    <tr>
                        <th>{{ __('Название проекта') }}</th>
                        <th class="d-none d-xl-table-cell text-center">{{ __('Предложений') }}</th>
                        <th class="d-none d-xl-table-cell text-center">{{ __('Категории') }}</th>
                        <th class="d-none d-xl-table-cell text-center">{{ __('Статус') }}</th>
                        <th class="d-none d-md-table-cell text-right">{{ __('Действия') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->ownedTenders()->orderBy('created_at', 'desc')->get() as $tender)
                    <tr class="my-job-item">
                        <td>
                            <h3 class="title-job"><a href="{{ route('site.tenders.category', $tender->slug) }}">{{ $tender->title }}</a></h3>
                            <div class="meta-job"><span> <i class="fas fa-calendar-alt"></i> {{ __('Опубликован:') }} @if ($tender->published)
                                    {{ $tender->published_at->format('d.m.Y') }} @else {{ __('На модерации') }} @endif</span><span> <i class="fas fa-calendar-alt"></i>{{ __('Истекает') }}
                                    {{ $tender->deadline }}</span></div>
                            <div class="salary-job"><i class="fas fa-money-bill-alt"></i>{{ $tender->budget }} {{$tender->currency}}
                            </div>
                            <div class="job-info d-xl-none"><a href="{{ route('site.account.tenders.candidates', $tender->slug) }}" class="number-application">{{ $tender->requests()->count() }} {{ __('заявок') }}</a> <span class="active">
                                @if ($tender->status !== 'done' && !$tender->isDeleted())
                                    @if ($tender->contractor_id) {{ __('В разработке') }}
                                    @elseif ($tender->checkDeadline()) {{ __('Открыт') }}
                                    @else {{ __('Приём заявок закрыт') }}
                                    @endif
                                @elseif ($tender->isDeleted()) {{ __('Удален') }}
                                @else {{ __('Выполнен!') }}
                                @endif
                            </span></div>
                            <div class="job-func d-flex d-md-none">
                                <a class="btn btn-light btn-edit"><i class="fas fa-pencil-alt"></i>
                                </a>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete-modal" data-route="{{ route('site.tenders.delete', $tender->id) }}"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-center number-application"><a href="{{ route('site.account.tenders.candidates', $tender->slug) }}">{{ $tender->requests()->count() }} {{ __('заявок') }}</a>
                        </td>
                        <td class="d-none d-xl-table-cell text-center">
                            @foreach ($tender->categories as $category)
                            <div>{{ $category->getTitle() }} </div>
                            @endforeach
                        </td>
                        <td class="d-none d-xl-table-cell text-center active">
                            @if ($tender->status !== 'done' && !$tender->isDeleted())
                                @if ($tender->status == 'check') {{ __('Ожидает проверки') }}
                                @elseif ($tender->status == 'finished') {{ __('Завершено') }}
                                @elseif ($tender->contractor_id) {{ __('В разработке') }}
                                @elseif ($tender->checkDeadline()) {{ __('Открыт') }}
                                @else {{ __('Приём заявок закрыт') }}
                                @endif
                            @elseif ($tender->isDeleted()) {{ __('Удален') }}
                            @else {{ __('Выполнен!') }}
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell text-right">
                            @if (!$tender->isDeleted())
                            <div class="d-flex">
                                <a href="{{ route('site.account.tenders.candidates', $tender->slug) }}" class="btn btn-light btn-new" data-toggle="tooltip" title="Посмотреть кандидатов"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('site.account.tenders.edit', $tender->slug) }}" class="btn btn-light btn-edit"><i class="fas fa-pencil-alt"></i>
                                </a>
                                
                                @if ($tender->contractor_id && $tender->status == 'check')
                                <form method="post" action="{{ route('site.tenders.complete', $tender->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-light mr-2" title="Выполнено"><i class="fas fa-check"></i></button>
                                </form>
                                @endif
                                
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete-modal" data-route="{{ route('site.tenders.delete', $tender->id) }}"><i class="far fa-trash-alt"></i></button>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Вы точно уверены что вы хотите удалить конкурс?') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                @method('delete')
                <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders') }}">
                <input type="text" class="form-control" name="delete_reason" placeholder="Укажите причину" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-light btn-delete">{{ __('Да') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Я передумал') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#delete-modal').on('show.bs.modal', function(e) {
        $('form', e.target)[0].action = $(e.relatedTarget).data('route');
    });

</script>
@endsection
