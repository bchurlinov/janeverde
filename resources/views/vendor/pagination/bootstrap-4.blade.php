@if ($paginator->hasPages())
    <div class="search-filters__pagination pagination" role="navigation">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="page-item disabled" aria-disabled="true">
                <button class="page-link link-prev"><img src={{asset('images/left-arrow_green.svg')}} alt="Jane Verde - SVG Icon" />PREV</button>
            </a>
        @else
            <a class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <button class="page-link"><img src={{asset('images/left-arrow_green.svg')}} alt="Jane Verde - SVG Icon" />PREV</button>
                </a>
            </a>
        @endif

        <button class="link-middle">
            <span>
            @php
            //we need to calculate how many are per page, taking into account whether we are on the first page, last page or in between
            $currentPage = $paginator->currentPage();
            $string = "";
            if($currentPage == 1){
                $string .= "0 - ".$paginator->perPage();
            }
            else{
                if($paginator->hasMorePages()){
                    $string .= (($currentPage - 1) * 6 + 1). " - " . $currentPage * 6;
                }
                else{
                    $string .= (($currentPage - 1) * 6 + 1). " - " . $paginator->total();
                }
            }
            @endphp
            {{$string . ' / ' . $paginator->total()}}</span></button>
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="page-item">
                <a class="page-link link-next" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <button>NEXT <img src={{asset('images/right-arrow_green.svg')}} alt="Jane Verde - SVG Icon" /></button>
                </a>
            </a>
        @else
            <a class="page-item disabled link-next" aria-disabled="true">
                <button>NEXT <img src={{asset('images/right-arrow_green.svg')}} alt="Jane Verde - SVG Icon" /></button>
            </a>
        @endif
    </div>
@endif
