
<ul class="categories">
    @foreach ($parentCategories as $parent)
        <li>
            <div class="ml-4 form-check @if ($currentCategory && $currentCategory->parent->id == $parent->id) active @endif">
                <input @if (($currentCategory && $currentCategory->id == $parent->id) || in_array($parent->id, request()->categories ?? [])) checked=""
                       @elseif ($currentCategory == null) checked="" @endif type="checkbox"
                       id="cat{{ $parent->id }}" class="form-check-input" name="categories[]"
                       value="{{ $parent->id }}">
                <label class="form-check-label" for="cat{{ $parent->id }}">{{ $parent->title }}</label>
                <span></span>

                <div class="arrow @if ($currentCategory && $currentCategory->parent->id == $parent->id) active @endif"></div>
                <ul>
                    @foreach ($parent->categories as $category)
                        <li>
                            <input @if (($currentCategory && $currentCategory->id == $category->id) || in_array($category->id, request()->categories ?? [])  || in_array($category->parent->id, request()->categories ?? [])) checked=""
                                   @elseif ($currentCategory == null && request()->categories == null) checked=""
                                   @endif type="checkbox" id="cat{{ $category->id }}" class="form-check-input"
                                   name="categories[]" value="{{ $category->id }}">
                            <label class="form-check-label"
                                   for="cat{{ $category->id }}">{{ $category->title }}</label>
                            <span></span>
                        </li>
                    @endforeach
                </ul>
            </div>
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
    <div class="form-group my-3">
        <label for="distance">Содержит ключевые слова</label>
        <input type="text" id="terms" class="form-control" name="terms" value="{{ request()->terms }}">
    </div>
    <div class="form-group">
        <label for="price">Минимальная цена задания</label>
        <input type="text" id="price" class="form-control" name="minPrice" value="{{ request()->minPrice }}">
    </div>
    <br>
    <button type="submit" class="button">Найти</button>
</div>