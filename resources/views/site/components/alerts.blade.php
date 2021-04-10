@if ($message = session()->get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">{{ __('Готово!') }}</h4>
        <p>{{ $message }}</p>
        <button class="close" type="button" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if ($message = session()->get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">{{ __('Ошибка!') }}</h4>
        <p>{{ $message }}</p>
        <button class="close" type="button" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if ($message = session()->get('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h4 class="alert-heading"></h4>
        <p>{{ $message }}</p>
        <button class="close" type="button" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session()->get('verified'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">{{ __('Готово!') }}</h4>
        <p>{{ __('Ваш email-адрес подтверждён, теперь вы можете пользоваться системой!') }}</p>
        <button class="close" type="button" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

