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
                                        class="ml-2 tags"><a>@if ($tender->opened==0 || $tender->contractor)
                                            Приём заявок окончен @else
                                            Открыт @endif</a></span></h3>
                            <div class="date-job">
                                <i class="fa fa-check-circle"></i><span
                                        class="company-name">Опубликован: {{ \Carbon\Carbon::create($tender->published_at)->format('d.m.Y') }}</span>
                                <div class="date-job"><i
                                            class="fa fa-check-circle"></i><span
                                            class="company-name">Крайний срок приема заявок: {{ \Carbon\Carbon::create($tender->deadline)->format('d.m.Y') }}</span>
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
