<ul class="worker-list">
    @foreach ($contractors as $contractor)
        <li class="worker">
            <div class="worker__avatar">
                <img style="width: 100%;" src="{{ $contractor->getImage() }}" alt="{{ $contractor->name }}">
            </div>

            <div class="worker__data">
                <div class="worker__title">
                    <a href="{{ route('site.contractors.show', $contractor->slug) }}">{{ $contractor->name }}</a>

                    <div class="badge badge--green"></div>
                    <div class="badge badge--red"></div>
                </div>
                <div class="worker__about_my_self">{!! $contractor->about_myself !!}</div>
                <p class="status" @if (!$contractor->is_online) style="color: red !important;" @endif>
                    @if ($contractor->is_online)
                        {{ __('Сейчас на сайте') }}
                    @else
                        {{ __('Оффлайн') }}
                    @endif
                </p>
            </div>

            <div class="worker__rating">
                <p>Отзывы</p>
                <div class="evaluation">
                    <div class="like">
                        <img src="/resources/images/like.svg" alt="">
                        @if($contractor->comments)
                        {{ $contractor->comments->count() }}
                        @endif
                    </div>
                </div>

                <div class="stars">
                    @for ($i=0; $i < $contractor->mean; $i++)
                        <img src="/resources/images/star.svg" alt="">
                    @endfor
                    <span>{{ $contractor->mean }}</span>
                </div>

                <a href="{{ route('site.contractors.show', $contractor->slug) }}" class="button button--small">Подробнее</a>
            </div>
        </li>
@endforeach

</ul>