@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-container">
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">&raquo;</a>
            @else
                <span class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </span>
            @endif
        </div>
        <div class="pagination-info">
            Showing {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
    </nav>
@endif
