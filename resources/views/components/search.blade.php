@if($contractors == null && $tenders == null)
@else
    <br>
    <div class="block-search">
        <p><strong>Поиск</strong></p>
        <p>Запрос : {{$search}}</p>
        <div class="search-container">
            @if($contractors->count() >0 || $tenders->count() > 0 || $pages->count()>0)

                @include('site.pages.contractors.individual_contractor')
                @include('site.pages.tenders.individual_task')
                @include('site.pages.page_search')

            @elseif($contractors->count()== 0 && $tenders->count() == 0 && $pages->count() == 0)
                <p class="text-center">{{__("Повашему запросу ничего не найдено")}}</p>

            @endif
        </div>
    </div>
    <br>
@endif