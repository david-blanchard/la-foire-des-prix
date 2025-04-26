@if($paginator->hasPages())
<ul class="pagination" >
    @foreach($elements as $element)

        @if(is_string($element))
            <li class="page-item disabled">
                <span class="page-link">
                    {{ $element }}
                </span>
            </li>
        @endif

        @if($paginator->onFirstPage())
            <li class="page-item">
                <span class="page-link">&lt;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">&lt;</a>
            </li>  
        @endif

        @if(is_array($element))
            @foreach($element as $page=>$url)
                @if($page == $paginator->currentPage())
                <li class="page-item active my-active">
                    <span class="page-link" >{{ $page }}</span>
                </li>            
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>            
                @endif
            @endforeach
        @endif

        @if($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">&gt;</a>
            </li> 
        @else
            <li class="page-item">
                <span class="page-link">&gt;</span>
            </li>
 
        @endif
    @endforeach
</ul>
@endif
