@if($contractors == null && $tenders == null)
@elseif($contractors->count() >0 || $tenders->count() > 0)
    <div class="search-container">
        @include('site.pages.contractors.individual_contractor')
        @include('site.pages.tenders.individual_task')
    </div>
@elseif($contractors->count()== 0 && $tenders->count() == 0)
    <div class="search-container">
        {{__("Повашему запросу ничего не найдено")}}
    </div>
@endif