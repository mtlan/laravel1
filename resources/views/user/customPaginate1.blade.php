@if ($paginator->hasPages())
<div class="clearfix my-4">
    <nav class="float-start" aria-label="Posts navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link" aria-disabled="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            @php
                $current = $paginator->currentPage();
            @endphp

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($current == 1 && $page > 3)
                            @continue
                        @endif
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link current" aria-current="page">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link" aria-disabled="true">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
    
    {{-- Pagination Info --}}
    <span class="py-2 float-end">
        Hiển thị {{ $paginator->firstItem() ?? 0 }} đến {{ $paginator->lastItem() ?? 0 }} 
        trong tổng số {{ $paginator->total() }} kết quả
    </span>
</div>
@endif