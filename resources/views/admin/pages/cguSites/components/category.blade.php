<option @if(isset($site)) @if($site->category_id == $category_list->id) selected @endif @endif value="{{ $category_list->id }}">{{ $delimiter }} {{ $category_list->ru_title }}</option>
@if($category_list->hasChildren())
    @foreach($category_list->children as $category_list)
        @include('admin.pages.cguSites.components.category', ['delimiter' => $delimiter . '-'])
    @endforeach
@endif