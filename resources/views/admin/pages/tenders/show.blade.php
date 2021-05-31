@extends('admin.layouts.app')

@section('title', $tender->title)

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2-bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Конкурс {{ $tender->title }}</h3>
            <div class="block-options">
                @if (!$tender->contractor) <button type="button" class="btn btn-alt-primary" data-toggle="modal" data-target="#requestModal"><i class="fa fa-plus mr-5"></i>Добавить заявку</button> @endif
                @if (!$tender->publish) <a href="{{ route('admin.tenders.publish', $tender->id) }}" class="btn btn-alt-success"><i class="si si-check"></i> Опубликовать</a> @endif
            </div>
        </div>
        <div class="block-content">
            <p class="font-weight-bold h4">{{ $tender->title }}</p>
            <div class="d-flex align-items-center justify-content-between mb-50">
                <span><i class="si si-wallet text-primary"></i> Бюджет: {{ $tender->budget }}</span>
                <span><i class="si si-calendar text-info"></i> Опубликован: @if ($tender->publish) {{ $tender->published_at->format('d.m.Y') }} @else На модерации @endif</span>
                <span><i class="fa fa-calendar-times-o text-danger"></i> Крайний срок: {{ $tender->deadline->format('d.m.Y') }}</span>
                <span><i class="si si-user text-info"></i> Организатор: @if ($tender->owner) <a
                        href="{{ route('admin.users.edit', $tender->owner_id) }}"
                        class="link-effect">{{ $tender->owner->getCommonTitle() }}</a> @else Не зарегистрирован @endif</span>
            </div>
            <h4>Что требуется сделать</h4>
            <p class="mb-10">
                {!! $tender->description !!}
            </p>
            <hr>
            <h4>Условия и требования</h4>
            <div class="row mb-20">
                <div class="col-sm-6">
                    <span class="text-muted">Требуемые услуги</span>
                </div>
                <div class="col-sm-6">
                    <ul class="list-group list-group-flush">
                        @foreach($tender->categories as $category)
                            <li class="list-group-item"><i class="si si-check text-success"></i> {{ $category->getTitle() }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Заявки на участие, {{ $tender->requests()->count() }}</h3>
        </div>
        <div class="block-content">
            <ul class="list-group list-group-flush mb-20">
                @foreach($tender->requests as $request)
                    <a href="{{ route('admin.users.edit', $request->user_id) }}" class="list-group-item list-group-item-action">
                        <p class="font-weight-bold font-size-lg">{{ $request->user->getCommonTitle() }}</p>
                        <p class="text-muted m-0">Срок: {{ $request->period_from }} - {{ $request->period_to }} дней</p>
                        <p class="text-muted m-0">Бюджет: {{ $request->budget_from }} - {{ $request->budget_to }} <сум></сум></p>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="modal fade" id="requestModal" aria-labelledby="requestModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromright modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.tenders.requests.create', $tender->id) }}" method="post">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Добавить заявку</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close"><i class="si si-close"></i></button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group"><span class="font-weight-bold">Бюджет</span>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-material"><input type="text" name="budget_from" id=""
                                                                          class="form-control" placeholder="От"></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-material"><input type="text" name="budget_to" id=""
                                                                          class="form-control" placeholder="До"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><span class="font-weight-bold">Срок</span>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-material"><input type="text" name="period_from" id=""
                                                                          class="form-control" placeholder="От"></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-material"><input type="text" name="period_to" id=""
                                                                          class="form-control" placeholder="До"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><span class="font-weight-bold">Комментарий</span>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-material"><textarea name="comment" id=""
                                                                             class="form-control"></textarea></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-material floating">
                                    <select name="user_id" id="user_id" class="form-control js-select2">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->getCommonTitle() }}</option>
                                        @endforeach
                                    </select>
                                    <label for="user_id">Пользователь</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-alt-success"><i class="fa fa-save mr-5"></i>Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        jQuery(function() {
            Codebase.helper('select2');
            $('.select2.select2-container').css('width', '100%');
        });
    </script>
@endsection
