@if ($paginator->hasPages())
    <div class="search-filters__pagination pagination" role="navigation">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="page-item disabled" aria-disabled="true">
                <button class="page-link"><img src={{asset('images/left-arrow_green.svg')}} alt="Jane Verde - SVG Icon" />PREV</button>
            </a>
        @else
            <a class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <button class="page-link"><img src={{asset('images/left-arrow_green.svg')}} alt="Jane Verde - SVG Icon" />PREV</button>
                </a>
            </a>
        @endif
        {{dd($paginator)}}
        <button>1 - 120 / kiko</button>
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <button>NEXT <img src={{asset('images/right-arrow_green.svg')}} alt="Jane Verde - SVG Icon" /></button>
                </a>
            </a>
        @else
            <a class="page-item disabled" aria-disabled="true">
                <button>NEXT <img src={{asset('images/right-arrow_green.svg')}} alt="Jane Verde - SVG Icon" /></button>
            </a>
        @endif
    </div>
@endif
