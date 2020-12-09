<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a></li>
        @if(isset($list))
            @foreach($list as $item)
                @if($item['url'] != '' && $item['title'] != '')
                    <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
                @endif
            @endforeach
        @endif
        @if(isset($lastTitle))
            <li class="breadcrumb-item active" aria-current="page">{{ $lastTitle }}</li>
        @endif
    </ol>
</nav>