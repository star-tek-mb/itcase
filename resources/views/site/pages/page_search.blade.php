
@foreach($pages as $page)
    <p>{{$page->title}} <a href="{{ route('site.page', $page->slug) }}"> <span>подробнее</span> </a></p>
@endforeach