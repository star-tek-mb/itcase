@if($contractors->count() >0 || $tenders->count() > 0)
    <div class="search-container">
        @include('site.pages.contractors.individual_contractor')
        @include('site.pages.tenders.individual_task')
    </div>
@endif