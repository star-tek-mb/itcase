@extends('site.layouts.account')

@section('title', 'Кандидаты')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('account.title.h1', $tender->title)

@section('account.content')
    <section class="box-admin">
        <div class="header-box-admin">
            <h3>{{ $tender->requests()->count() }} {{ __('заявок') }}</h3>
        </div>
        <div class="body-box-admin p-0">
            <div class="table-responsive">
                <table class="table tbl-job">
                    <thead>
                    <tr>
                        <th>Кандидат</th>
                        <th class="d-none d-xl-table-cell text-center">{{ __('Предложенный срок') }}</th>
                        <th class="d-none d-xl-table-cell text-center text-nowrap">{{ __('Предложенный бюджет') }}</th>
                        <th class="d-none d-md-table-cell text-right">{{ __('Действия') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tender->requests as $request)
                        <tr class="my-job-item candidate">
                            <td>
                                <div class="candidate-tile">
                                    <div class="img"><img src="{{ $request->user->getImage() }}" alt="{{ $request->user->getCommonTitle() }}">
                                    </div>
                                    <div class="text">
                                        <h3 class="title-job"><a href="{{ route('site.contractors.show', $request->user->slug) }}">{{ $request->user->getCommonTitle() }}</a> @if ($request->invited) <small class="text-primary"><i class="far fa-check-circle"></i> {{ __('Приглашённый') }}</small>@endif  @if ($tender->contractor_id == $request->user_id) <i class="fas fa-check-double text-success"></i> @endif</h3>
                                        <div class="date-job"><i class="fas fa-check-circle"></i> @if ($request->user->cotractor_type == 'legal_entity') {{ __('Digital-агенство') }} @else {{ __('Фрилансер') }} @endif </div>
                                    </div>
                                </div>
                                <div class="job-info-mobile d-xl-none">
                                    <ul>
                                        @if ($request->period_from && $request->period_to)
                                            <li><strong>{{ __('Сроки:') }} </strong>{{ $request->period_from }} - {{ $request->period_to }}
                                            </li>
                                        @endif
                                        @if ($request->budget_from && $request->budget_to)
                                            <li><strong>{{ __('Бюджет:') }} </strong>{{ $request->budget_from }} - {{ $request->budget_to }}</li>
                                        @endif
                                    </ul>
                                    <div class="job-func d-md-none">
                                        <div class="d-flex">
                                            <form action="{{ route('site.account.chats') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="with_user_id" value="{{ $request->user->id }}">
                                                <button class="btn btn-light btn-view" type="submit" data-toggle="tooltip" title="Связаться"><i class="fas fa-comments"></i></button>
                                            </form>
                                            @if ($tender->contractor_id !== $request->user_id)
                                                <form action="{{ route('site.tenders.accept', ['tenderId' => $tender->id, 'requestId' => $request->id]) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders.candidates', $tender->slug) }}">
                                                    <button class="btn btn-light btn-edit" type="submit" onclick="return confirm('Вы уверены, что хотите принять кандидата {{ $request->user->getCommonTitle() }} на роль исполнителя этого конкурса? В будущем вы не сможете поменять своё решение.')" data-toggle="tooltip" data-placement="top" title="Принять заявку"><i class="fas fa-check"></i></button>
                                                </form>
                                                <form action="{{ route('site.tenders.requests.cancel') }}" method="post" class="ml-1">
                                                    @csrf
                                                    <input type="hidden" name="requestId" value="{{ $request->id }}">
                                                    <input type="hidden" name="rejected" value="true">
                                                    <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders.candidates', $tender->slug) }}">
                                                    <button type="submit" onclick="return confirm('Вы уверены, что хотите отклонить кандидата {{ $request->user->getCommonTitle() }}?')" data-toggle="tooltip" data-placement="top" title="Отклонить заявку" class="btn btn-light btn-delete"><i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-xl-table-cell text-center" style="width: 100%">@if ($request->period_from && $request->period_to){{ $request->period_from }} - {{ $request->period_to }} {{ __('дней') }}@endif</td>
                            <td class="d-none d-xl-table-cell text-center">@if ($request->budget_from && $request->budget_to)от {{ $request->budget_from }} {{ __('сум до') }} {{ $request->budget_to }} {{ __('сум') }}@endif</td>
                            <td class="d-none d-md-table-cell text-right">
                                <div class="d-flex">
                                    <form action="{{ route('site.account.chats') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="with_user_id" value="{{ $request->user->id }}">
                                        <button class="btn btn-light btn-view mr-1" type="submit" data-toggle="tooltip" title="Связаться"><i class="fas fa-comments"></i></button>
                                    </form>
                                    @if ($tender->contractor_id !== $request->user_id)
                                        <form action="{{ route('site.tenders.accept', ['tenderId' => $tender->id, 'requestId' => $request->id]) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders.candidates', $tender->slug) }}">
                                            <button class="btn btn-light btn-edit" type="submit" onclick="return confirm('Вы уверены, что хотите принять кандидата {{ $request->user->getCommonTitle() }} на роль исполнителя этого конкурса? В будущем вы не сможете поменять своё решение.')" data-toggle="tooltip" data-placement="top" title="Принять заявку"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('site.tenders.requests.cancel') }}" method="post" class="ml-1">
                                            @csrf
                                            <input type="hidden" name="requestId" value="{{ $request->id }}">
                                            <input type="hidden" name="rejected" value="true">
                                            <input type="hidden" name="redirect_to" value="{{ route('site.account.tenders.candidates', $tender->slug) }}">
                                            <button type="submit" onclick="return confirm('Вы уверены, что хотите отклонить кандидата {{ $request->user->getCommonTitle() }}?')" data-toggle="tooltip" data-placement="top" title="Отклонить заявку" class="btn btn-light btn-delete"><i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
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
