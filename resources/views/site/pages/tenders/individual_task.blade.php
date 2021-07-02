<div class="tasks-holder">

    @foreach ($tenders as $tender)
        <div class="task-block">
            <div class="task-block__icon">
                <img style="width: 100%; height: auto;padding: 15px;" src="{{ $tender->categoryIcon() }}" alt="">
            </div>
            <div class="task__data">
                <h3><a href="{{ route('site.tenders.category', $tender->slug) }}">{{ $tender->title }}</a></h3>
                <ul class="task-data">
                    @inject('geocoder', 'App\Services\GeocoderService')
                    <li class="task-address">
                        {{ $geocoder->getAddress($tender->geo_location) }}
                    </li>

                    <li class="task-money">
                        Оплата наличными <br>
                        Бюджет: <strong>{{ $tender->budget }} {{$tender->currency}}</strong>
                    </li>

                    <li class="task-date">
                        Опубликован: <span>{{ $tender->published_at->format('d.m.Y') }}</span> <br>
                        Крайний срок приема заявок: <span>{{ $tender->deadline->format('d.m.Y') }}</span>
                    </li>

                    @guest
                        <li class="alert">
                            <a href="{{ route('login') }}">Войдите на сайт чтобы подать заявку</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('site.tenders.category', $tender->slug) }}" class="button button--small">Подробнее</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    @endforeach
{{--    @if($tenders != [])--}}
{{--        {{  }}--}}
{{--    @endif--}}
</div>
