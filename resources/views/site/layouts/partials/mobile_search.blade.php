<!-- #### Nav Search -->
<form class="uk-search uk-search-navbar uk-width-1-1" action="{{ route('site.catalog.search') }}" method="post">
    @csrf
    <input id="search-input" required class="uk-search-input uk-text-demi-bold" name="query" type="search" placeholder="Поиск..." autofocus @isset($queryString) value="{{ $queryString }}" @endisset>
</form>
<!-- #### Nav Search - END -->
