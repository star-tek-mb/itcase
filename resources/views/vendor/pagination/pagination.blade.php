@if ($paginator->hasPages())
    <nav aria-label="Page navigation" style="width: 100%;">
        <ul class="pagination pagination-lg justify-content-center py-10">
            @if ($paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link disabled" href="javascript:void(0)" aria-label="Previous">
                    <span aria-hidden="true">
                        <i class="fa fa-angle-left"></i>
                    </span>
                        <span class="sr-only">Предыдущее</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">
                        <i class="fa fa-angle-left"></i>
                    </span>
                        <span class="sr-only">Предыдущее</span>
                    </a>
                </li>
            @endif


            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item">
                        <a class="page-link disabled" aria-disabled="true" href="javascript:void(0)">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        @if ($page == $paginator->currentPage())
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">
                        <i class="fa fa-angle-right"></i>
                    </span>
                        <span class="sr-only">Следующее</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link disabled" href="javascript:void(0)" aria-label="Next">
                    <span aria-hidden="true">
                        <i class="fa fa-angle-right"></i>
                    </span>
                        <span class="sr-only">Следующее</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif

