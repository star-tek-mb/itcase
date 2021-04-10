@extends('site.layouts.account')

@section('title', 'Профессиональные данные')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('account.title.h1', 'Профессиональные данные')

@section('account.content')
    <form action="" method="post">
        @csrf
        <section class="box-admin edit-profile">
            <div class="header-box-admin">
                <h3>{{ __('Специализация') }}</h3>
            </div>
            <div class="description-box-admin">
                <p>{{ __('Выберите в этом списке услуги, предоставляемые вами и укажите минимальные и максимальные цены на них. Ставьте реальные цены - не забывайте про конкуренцию на площадке.') }}</p>
            </div>
            <div class="accordion" id="needsAccordion" role="tablist" aria-multiselectable="false">
                @foreach($needs as $need)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between" role="tab" id="heading{{ $need->id }}">
                            <a href="#collapse{{ $need->id }}" data-toggle="collapse" data-parent="#needsAccordion" aria-expanded="true" aria-controls="collapse{{ $need->id }}">{{ $need->ru_title }} <i class="fas fa-caret-down"></i></a>
                        </div>
                        <div class="collapse" id="collapse{{ $need->id }}" data-toggle="false" role="tabpanel" aria-labelledby="heading{{ $need->id }}">
                            <div class="card-body">
                                <div class="accordion" id="categoriesAccordion{{ $need->id }}" role="tablist" aria-multiselectable="false">
                                    @foreach($need->menuItems as $item)
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between" id="headingCategory{{ $item->id }}">
                                                <a href="#collapseCategory{{ $item->id }}" data-toggle="collapse" data-parent="#categoriesAccordion{{ $need->id }}" aria-expanded="true" aria-controls="collapseCategory{{ $item->id }}">{{ $item->ru_title }} <i class="fas fa-caret-down"></i></a>
                                            </div>
                                            <div class="collapse" id="collapseCategory{{ $item->id }}" role="tabpanel" aria-labelledby="headingCategory{{ $item->id }}">
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        @foreach($item->categories as $child)
                                                            <li class="list-group-item">
                                                                <div class="custom-control custom-checkbox" id="category-{{ $child->id }}">
                                                                    <input type="checkbox" name="categories[{{ $child->id }}][id]" value="{{ $child->id }}" id="input-{{ $child->id }}"
                                                                           class="custom-control-input" @if (in_array($child->id, $chosenSpecs)) checked @endif>
                                                                    <label id="input-{{ $child->id }}" class="custom-control-label">{{ $child->getTitle() }}</label>
                                                                </div>
                                                                <div class="row @if (!in_array($child->id, $chosenSpecs)) d-none @endif" id="category-{{ $child->id }}-prices">
                                                                    <div class="col-md-4">
                                                                        <p class="mb-1 text-muted">{{ __('Примерная стоимость услуги') }}</p>
                                                                        <input type="text" @if (in_array($child->id, $chosenSpecs)) required @endif name="categories[{{ $child->id }}][price_from]" @if (in_array($child->id, $chosenSpecs)) value="{{ $user->categories()->find($child->id)->pivot->price_from }}" @endif class="price-control must-required" style="width: 35%"> &mdash; <input
                                                                            type="text" @if (in_array($child->id, $chosenSpecs)) required @endif name="categories[{{ $child->id }}][price_to]" @if (in_array($child->id, $chosenSpecs)) value="{{ $user->categories()->find($child->id)->pivot->price_to }}" @endif class="price-control must-required" style="width: 35%"> <span class="text-muted">{{ __('сум') }}</span>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <p class="mb-1 text-muted">{{ __('Стоимость в час') }}</p>
                                                                        <input type="text" name="categories[{{ $child->id }}][price_per_hour]" @if (in_array($child->id, $chosenSpecs)) value="{{ $user->categories()->find($child->id)->pivot->price_per_hour }}" @endif class="price-control" style="width: 60%"> <span class="text-muted">{{ __('сум/час') }}</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-light-green mt-3 ml-3 mb-3"><i class="fas fa-save"></i>{{ __('Сохранить') }}</button>
        </section>
    </form>
@endsection

@section('js')
    <script src="{{ asset('js/account.professional.js') }}"></script>
    <script>
        $('.collapse').collapse({
            toggle: false
        });
    </script>
@endsection
