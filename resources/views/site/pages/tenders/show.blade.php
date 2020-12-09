@extends('site.layouts.app')

@section('title', "Конкурс $tender->title")

@section('meta')
    <meta name="title" content="{{ $tender->title }}">
    <meta name="description" content="{{ strip_tags($tender->description) }}">
@endsection
@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')
    <div class="primary-page">
        <div class="container">
            @if ($tender->checkDeadline() && !$tender->contractor)
                @guest
                    <div class="alert shadow alert-warning fade show">
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <p><i class="fas fa-warning"></i> Войдите и зарегистрируйтесь как "Исполнитель". Это
                                    позволит вам откликаться на задачи. </p>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="d-flex justify-content-between align-items-center"><a href="{{ route('login') }}"
                                                                                                  class="btn btn-light-green mr-1">Войти</a>
                                    или <a href="{{ route('register') }}" class="btn ml-1 btn-light-green">Зарегистрироваться</a></div>
                            </div>
                        </div>
                    </div>
                @endguest
                @auth
                    @if (auth()->user()->requests()->where('invited', false)->count() > 0 && !in_array(auth()->user()->id, $tender->requests()->pluck('user_id')->toArray()))
                        <div class="alert alert-info shadow fade show">
                            <p class="fas fa-info"> Вы не можете подать заявку на участие более чем в одном конкурсе.</p>
                        </div>
                    @elseif (auth()->user()->hasRole('contractor') && !in_array(auth()->user()->id, $tender->requests()->pluck('user_id')->toArray()))
                        <div class="alert shadow alert-info fade show">
                            <div class="d-flex justify-content-between align-items-center">
                                <p><i class="fas fa-info"></i> Вы можете связаться с данным заказчиком</p>
                                <button class="btn btn-light-green" type="button" data-toggle="modal"
                                        data-target="#requestFormModal">Оставить заявку
                                </button>
                            </div>
                        </div>
                        <div class="modal fade" id="requestFormModal" tabindex="-1" role="dialog"
                             aria-labelledby="requestFormModelLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="requestFormModelLabel">Ваша заявка</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('site.tenders.requests.make') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
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
                                                        <input type="text" required name="budget_from" id="budgetFrom"
                                                               class="form-control" placeholder="500 000">
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <input type="text" required name="budget_to" id="budgetTo"
                                                               class="form-control" placeholder="1 000 000">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="period">Срок</label>
                                                <div class="row">
                                                    <div class="col-ms-12 col-lg-6">
                                                        <input type="text" required name="period_from" id="period_from"
                                                               class="form-control" placeholder="2 дня">
                                                    </div>
                                                    <div class="col-ms-12 col-lg-6">
                                                        <input type="text" required name="period_to" id="period_to"
                                                               class="form-control" placeholder="3 дня">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment">Комментарий (по желанию)</label>
                                                <textarea name="comment" id="comment" rows="3"
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
                    @if (in_array(auth()->user()->id, $tender->requests()->pluck('user_id')->toArray()))
                        <div class="alert alert-info shadow fade show">
                            <div class="d-flex justify-content-between align-items-center">
                                <p><i class="fas fa-info"></i> Вы уже оставили заявку на этот конкурс</p>
                                <div class="d-flex">
                                    <form action="{{ route('site.tenders.requests.cancel') }}" method="post" class="mr-3">
                                        @csrf
                                        <input type="hidden" name="requestId"
                                               value="{{ $tender->requests()->where('user_id', auth()->user()->id)->first()->id }}">
                                        <button class="btn btn-light-green" type="submit">Отменить</button>
                                    </form>
                                    <form action="{{ route('site.account.chats') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="with_user_id" value="{{ $tender->owner->id }}">
                                        <button class="btn btn-light-green" type="submit" data-toggle="tooltip" title="Связаться">Связаться через чат</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            @else
                <div class="alert alert-info shadow fade show">
                    <p class="fas fa-info"> Срок приёма заявок окончен.</p>
                </div>
            @endif
            <div class="item-detail-special">
                <div class="text pl-5">
                    <div class="row align-items-lg-center">
                        <div class="col-12">
                            <h2 class="title-detail">{{ $tender->title }}</h2>
                            <div class="meta-job"><span class="phone"><i class="far fa-money-bill-alt"></i>Бюджет: {{ $tender->budget }} сум </span><span
                                    class="mail"><i class="far fa-calendar"></i>Опубликовано: {{ \Carbon\Carbon::create($tender->published_at)->format('d.m.Y') }}</span><span><i
                                        class="fas fa-calendar-times"></i>Крайний срок приёма заявок: {{ $tender->deadline }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-main-right single-detail">
                        <div class="box-description">
                            <h3>Что требуется сделать</h3>
                            {!! $tender->description !!}

                        </div>
                        <hr>
                        <div class="intro-profile">
                            <h3 class="title-box">Условия и требования</h3>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <p>Требуемые услуги</p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <ul class="list-group list-group-flush">
                                        @foreach($tender->categories as $category)
                                            <li class="list-group-item"><i
                                                    class="fas fa-check-circle text-primary"></i> {{ $category->getTitle() }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-right">
                        <div class="sidebar-right-group">
                            <div class="job-detail-summary">
                                <h3 class="title-block mb-1">Организатор</h3>
                                <span class="tender-author-type text-muted text-bold">
                                    @if ($tender->client_type == 'private')
                                        Частное лицо
                                    @elseif ($tender->client_type == 'company')
                                        Компания
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
