@if (Session::has('contractors'))
    @php
        $contractors = Session::get('contractors');
    @endphp
    <nav class="navbar fixed-bottom navbar-light bg-light contractors-bar">
        <div class="container">
            <div class="row w-100">
                <div class="col-sm-12 col-md-3">
                    <a href="{{ route('site.tenders.common.create') }}" class="btn btn-light-green">{{ __('Организовать конкурс') }}</a>
                </div>
                <div class="col-sm-6 col-md-5">
                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#contractorsModal">{{ __('У вас') }} {{ count($contractors) }} @if (count($contractors) == 1){{ __('исполнитель') }}@elseif(count($contractors) <= 4){{ __('исполнитель') }}@else{{ __('исполнителей') }}@endif</button>
                </div>
                <div class="col-sm-6 col-md-4"><a href="#" data-target="{{ route('site.tenders.contractors.clear') }}" class="btn btn-link btn-delete tender-item"><i class="fas fa-trash"></i> {{ __('Удалить всех исполнителей') }}</a></div>
            </div>
        </div>
    </nav>
    <div class="modal fade" id="contractorsModal" tabindex="-1" role="dialog" aria-labelledby="contractorsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered contractors-modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contractorsModalLabel">{{ __('Выбранные исполнители') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        @foreach($contractors as $contractor)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img class="avatar" src="{{ $contractor['image'] }}" alt="">{{ $contractor['name'] }}
                                </div>
                                <a href="#" data-target="{{ route('site.tenders.contractors.delete', $contractor['id']) }}" class="btn btn-link btn-delete tender-item" data-toggle="tooltip" title="Удалить"><i class="fas fa-trash"></i></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-green" data-dismiss="modal">{{ __('Закрыть') }}</button>
                </div>
            </div>
        </div>
    </div>
@endif
