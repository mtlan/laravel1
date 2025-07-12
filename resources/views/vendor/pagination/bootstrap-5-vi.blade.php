@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous', [], 'vi')</span>
                    </li>
                @else
                    {{-- <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">@lang('pagination.previous', [], 'vi')</a>
                    </li> --}}
                    <button type="button" class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        wire:loading.attr="disabled" rel="prev">@lang('pagination.previous')</button>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        {{-- <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next', [], 'vi')</a> --}}

                        <button type="button" class="page-link"
                            wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                            rel="next">@lang('pagination.next')</button>

                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next', [], 'vi')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted">
                    {!! __('Hiển thị') !!}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('đến') !!}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {!! __('tổng') !!}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('kết quả ') !!}
                </p>
            </div>

            <div>
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous', [], 'vi')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            {{-- <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                                aria-label="@lang('pagination.previous', [], 'vi')">&lsaquo;</a> --}}
                            <button type="button" class="page-link"
                                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled" rel="prev"
                                aria-label="@lang('pagination.previous')">&lsaquo;</button>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span
                                    class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span
                                            class="page-link">{{ $page }}</span></li>
                                @else
                                    {{-- <li class="page-item"><a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a></li> --}}

                                    <li class="page-item"><button type="button" class="page-link"
                                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                            wire:loading.attr="disabled">{{ $page }}</button></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            {{-- <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                                aria-label="@lang('pagination.next', [], 'vi')">&rsaquo;</a> --}}

                            <button type="button" class="page-link"
                                wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                                rel="next" aria-label="@lang('pagination.next')">&rsaquo;</button>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next', [], 'vi')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
