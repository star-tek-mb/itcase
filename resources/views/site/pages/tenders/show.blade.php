@extends('site.layouts.front')

@section('title') {{ $tender->title }} @endsection

@section('breadcrumbs')
    - {{ __('Каталог заданий') }}
    - {{ $tender->title }}
@endsection

@section('sidebar')
    <div class="title-top">
        <h2>{{ $tender->title }}</h2>
    </div>

    <form class="body-box" action="{{ route('site.tenders.search') }}" method="POST">
        @csrf
        <ul class="categories">
            @foreach ($parentCategories as $parent)
                <li>
                    <div class="ml-4 form-check">
                        <input checked="" type="checkbox" id="cat{{ $parent->id }}" class="form-check-input"
                               name="categories[]" value="{{ $parent->id }}">
                        <label class="form-check-label" for="cat{{ $parent->id }}">{{ $parent->title }}</label>
                        <span></span>

                        <div class="arrow"></div>
                        <ul>
                            @foreach ($parent->categories as $category)
                                <li>
                                    <input checked="" type="checkbox" id="cat{{ $category->id }}"
                                           class="form-check-input" name="categories[]" value="{{ $category->id }}">
                                    <label class="form-check-label"
                                           for="cat{{ $category->id }}">{{ $category->title }}</label>
                                    <span></span>
                                </li>
                            @endforeach
                        </ul>
                </li>
            @endforeach
        </ul>
        <div class="py-4 px-4 text-center">
            <div class="form-group">
                <label for="currency">Выберите валюту</label>
                <select name="currency" id="currency" class="form-control">
                    <option selected value="0">{{ __('Все') }}</option>
                    <option selected value="Тенге">{{ __('Тенге') }}</option>
                    <option value="Сум">{{ __('Сум') }}</option>
                    <option selected value="Рубль">{{ __('Рубль') }}</option>
                    <option value="Доллар">{{ __('Доллар') }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="distance">Содержит ключевые слова</label>
                <input type="text" id="terms" class="form-control" name="terms" value="{{ request()->terms }}">
            </div>
            <div class="form-group">
                <label for="price">Минимальная цена задания</label>
                <input type="text" id="price" class="form-control" name="minPrice" value="{{ request()->minPrice }}">
            </div>
            <br>
            <button type="submit" class="button">Фильтр</button>
        </div>
    </form>
    @include('site.layouts.sidebar')
@endsection

@section('content')
    <div class="title-top title-top--small">
        <h2>
            {{ $tender->title }}
        </h2>
    </div>

    <div class="tasks-holder pt30">
        <!-- -->
        <div class="task-block task-block--full">
            <div class="task-block__icon-holder">
                <div class="task-block__icon">
                    <img style="width: 100%; height: auto;" src="{{ $tender->categoryIcon() }}" alt="">
                </div>

                @if ($tender->checkDeadline())
                    <div class="status status--ok">
                        <p>Статус: <strong>АКТИВНО</strong></p>
                    </div>
                @else
                    <div class="status status--no">
                        <p>Статус: <strong>НЕАКТИВНО</strong></p>
                    </div>
                @endif
            </div>


            <div class="task__data">
                <h3><a href="#">{{ $tender->title }}</a></h3>

                <div class="task__data-details">
                    <ul>
                        <li>{{ $tender->views }} просмотров</li>
                        <li>Создано:
                            <span>{{$tender->published_at? $tender->published_at->format('d.m.Y') : "Неизвестно" }}</span>
                        </li>
                        <li>Организатор: <a href="{{ route('site.contractors.show', $tender->owner->slug) }}"
                                            class="organisation">{{ $tender->owner->name }}</a></li>
                    </ul>
                </div>


                @inject('geocoder', 'App\Services\GeocoderService')
                <ul class="task-data">
                    <li class="task-place">
                        {{ $geocoder->getAddress($tender->geo_location) }}
                    </li>

                    <li class="task-address">
                        Место: {{ __($tender->place ?? 'my_place') }}
                    </li>

                    <li class="task-date">
                        <div>

                            Крайний срок приема заявок:
                            <span>{{ $tender->deadline ? $tender->deadline->format('d.m.Y') : 'Неизвестно' }}</span>
                            <br>
                            Дата окончания работ:
                            <span>{{ $tender->work_end_at ? $tender->work_end_at->format('d.m.Y') : 'Неизвестно' }}</span>
                            <br>
                        </div>
                    </li>

                    <li class="task-money">
                        <div>
                            Оплата наличными <br>
                            Бюджет: <strong>{{ $tender->budget }} {{$tender->currency}}</strong>
                        </div>
                    </li>
                </ul>
                @if( auth()->user() && auth()->user()->checkOwnTender($tender))
                @elseif (auth()->user() && in_array(auth()->user()->id, $tender->requests()->pluck('user_id')->toArray()))
                    <div style="text-align: center; font-size: 24px; font-weight: bold; margin: 20px;">Вы уже оставили заявку
                    </div>
                    <form action="{{ route('site.tenders.requests.cancel') }}" method="post" class="mr-3">
                        @csrf
                        <input type="hidden" name="requestId"
                               value="{{ $tender->requests()->where('user_id', auth()->user()->id)->first()->id }}">
                        <button style="margin-top: 0; width: 100%; justify-content: center; font-weight: 24px; font-weight: bold;"
                                class="button" type="submit">Отменить
                        </button>
                    </form>
                    <br>
                    <form action="{{ route('site.account.chats') }}" method="post">
                        @csrf
                        <input type="hidden" name="with_user_id" value="{{ $tender->owner->id }}">
                        <button style="margin: 0; width: 100%; justify-content: center; font-weight: 24px; font-weight: bold;"
                                class="button" type="submit" data-toggle="tooltip" title="Связаться">Связаться через чат
                        </button>
                    </form>
                @elseif (auth()->user() && !auth()->user()->hasRole('contractor'))
                    <a href="#" class="button button--full">
                        Войдите как исполнитель чтоб оставить заявку
                    </a>
                @elseif ($tender->checkDeadline())
                    <a href="#" class="button button--full" data-modal="#modal">Откликнуться на задание</a></li>
                @else
                    <a class="button button--full">
                        Срок приема заявок закончен
                    </a>
                @endif

                <div class="task__data-description">
                    <h4>Что требуется сделать?</h4>

                    <div class="mt18">
                        <h5>Описание задания: </h5>
                        {!! $tender->description !!}
                        @if (auth()->user() && (auth()->user()->id == $tender->contractor_id || auth()->user()->id == $tender->owner_id))
                            <h5 class="mt-4 mb-0">Дополнительная информация (видна только вам)</h5>
                            {!! $tender->additional_info !!}
                        @endif
                    </div>

                </div>

            </div>
        </div>
        <!-- -->
    </div>
@endsection

@section('modal')
    @if (auth()->user() && auth()->user()->hasRole('customer'))
        <div class="modal send_request" id="modal">
            <form action="{{ route('site.tenders.requests.make') }}" method="post" class="main__form">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="tender_id" value="{{ $tender->id }}">
                <h4>Отправьте заявку.</h4>
                <div for="budget" style="margin: 5px;"> Предложите бюджет</div>
                <div class="input-holder">
                    <input type="text" required name="budget_from" id="budgetFrom" placeholder="500 000">
                </div>
                <div class="input-holder">
                    <input type="text" required name="budget_to" id="budgetTo" placeholder="1 000 000">
                </div>
                <div for="period" style="margin: 5px;">Выберите срок выполнения задачи</div>
                <div class="input-holder">
                    <input type="text" required name="period_from" id="period_from" placeholder="2 дня">
                </div>
                <div class="input-holder">
                    <input type="text" required name="period_to" id="period_to" placeholder="3 дня">
                </div>
                <div for="comment" style="margin: 5px;">Комментарий (по желанию)</div>
                <div class="input-holder">
                    <textarea  class="text-area-container" name="comment" style="min-height: 150px; max-height: 200px;" placeholder="Комментарий"  id="comment" type="text"> </textarea>
                </div>

                <button class="button" type="submit">Отправить заявку</button>
            </form>
            <a href="#" class="close"></a>
        </div>
    @else
        <div class="modal" id="modal">
            <h4>Хотите стать исполнителем?</h4>

            <p>Это не сложно. Всего предстоит два шага:
                анкета и подписка на задания. Всё займёт
                примерно 5 минут.</p>

            <a href="{{ route('register') }}" class="button button--simple button--small">Зарегестрироваться</a>
            <p class="light"><a href="{{ route('login') }}">У меня уже есть аккаунт. Войти</a></p>

            <a href="#" class="close"></a>
        </div>
    @endif
@endsection
