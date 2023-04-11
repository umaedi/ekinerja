@if ($paginator->hasPages())
<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination">
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        @else
        <li class="page-item">
            <a onclick="loadPaginate({{ explode('page=', $paginator->previousPageUrl())[1]}})" class="page-link" href="javascript:void(0);" tabindex="-1">
                Previous
            </a>
        </li>
        @endif
    
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item"><a class="page-link" href="#">$element</a></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ $page }}<span class="sr-only">(current)</span></a>
                        </li>
                    @else
                    <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="loadPaginate({{ explode('page=', $url)[1]}})">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" onclick="loadPaginate({{ explode('page=',$paginator->nextPageUrl())[1]}})" href="javascript:void(0);">
                    Next
                </a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        @endif
    </ul>
</nav>
@endif