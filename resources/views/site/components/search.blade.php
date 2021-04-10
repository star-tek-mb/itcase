<!-- Search section -->
<form action="{{ route('site.catalog.search') }}" method="post" class="uk-grid-collapse uk-width-3-4@m uk-margin-medium-top" data-uk-grid data-uk-scrollspy="cls: uk-animation-slide-bottom-medium; delay: 200; repeat: true">
    <div class="uk-width-expand">
        @csrf
        <input class="uk-input uk-form-large uk-border-remove-right" type="text" placeholder="Найти вашего исполнителя" required name="query" @isset($queryString) value="{{ $queryString }}" @endisset>
    </div>
    <div class="uk-width-auto">
        <button class="uk-button uk-button-large uk-button-success-outline">{{ __('Искать') }}</button>
    </div>
</form>

<!-- Search section end -->
   