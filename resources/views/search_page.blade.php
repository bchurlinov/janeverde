@extends('partials.layout')
@php
    $category =
    $country = json_decode(session()->get('country'), true);
@endphp
@section("css_links")
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
@endsection

@section('content')
<div class="wrapper">
    <div class="container">
        @include('partials.mobileMenu')
    </div>

    <!-- End Mobile Version -->

    <div class="container">
        <div class="outer-wrap">
            <div align="right">
                @if(auth()->user())
                {!! "<a href='/dashboard'>" .substr(auth()->user()->name, 0, 1) . " " . substr(auth()->user()->lastname,
                    0, 1) . "</a>" !!}

                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                @endif
            </div>
            <div class="home-wrap home-search-wrap">
                @include('partials.leftMenu')

                <div class="home-wrap__item">
                    <div class="current-state-heading">
                        <div class="current-state-heading__item">
                            <h3>{{$country['fullName']}} /
                                {{session()->get('type') == 'null' ? 'HEMP' : strtoupper(session()->get('type'))}} /
                                {{strtoupper(App\Http\Controllers\ProductsController::getCategoryName(request()->segment(2)))}}</h3>
                        </div>
                        <div class="current-state-heading__item current-state-heading__desktop">
                            <form method="GET"
                                  <?php //TODO: GET PARENT CATEGORY AND PUT IT BEFORE SEGMENT 2 BELOW  ?>
                                action="/{{session()->get('type') == 'null' ? 'hemp' : session()->get('type')}}/{{request()->segment(2)}}/{{request()->segment(3)}}/search">
                                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                                <button type="submit">
                                    <img src={{asset('images/search_white.svg')}} alt="Jane Verde - SVG Icon" />
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="search-wrap">
                        <div class="search-filters">
                            <div class="search-filters__sorting">
                                <div class="hemp-cannabis-toggle">
                                    <button class="ftype {{session()->get('searchType') != 'null' && session()->get('searchType') == 'viewAll' ? "toggle-active" : ""}}" id="viewAll">View All</button>
                                    <button class="ftype {{session()->get('searchType') != 'null' && session()->get('searchType') == 'verifiedOnly' ? "toggle-active" : ""}}" id="verifiedOnly">Verified</button>
                                </div>
                            </div>
                                
                                @php
                                echo $keyword == "" ? $products->links() : $products->appends(['keyword' =>
                                $keyword])->links();
                                @endphp
                            
                            <div class="search-filters__views">
                                <button onclick="renderGridView(this)" class="grid-list-button" data-toggle="grid"><i
                                        class="fas fa-th-large toggle-icon" title="Gallery View"></i>
                                </button>
                                <button onclick="renderListView(this)" class="grid-list-button" title="List View"
                                    data-toggle="list"><i class="fas fa-bars toggle-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="search-products-listing">
                        <div class="products-listing-wrap">
                            @if(count($products) == 0)
                            {{"No posts"}}
                            @else
                            @foreach($products as $product)
                            <div class="product-template-wrap">
                                <div class="product-template">
                                    <div class="product-template__image">
                                        <div class="slider">
                                            <figure>
                                                <a href="/view/{{$product->id}}">
                                                    <img src="https://www.dailymaverick.co.za/wp-content/uploads/openletter-cannabis-1600x875.jpg"
                                                        alt="Jane Verde Image" />
                                                </a>
                                            </figure>
                                            <figure>
                                                <a href="/view/{{$product->id}}">
                                                    <img src="https://www.dailymaverick.co.za/wp-content/uploads/openletter-cannabis-1600x875.jpg"
                                                        alt="Jane Verde Image" />
                                                </a>
                                            </figure>
                                            <figure>
                                                <a href="/view/{{$product->id}}">
                                                    <img src="https://www.dailymaverick.co.za/wp-content/uploads/openletter-cannabis-1600x875.jpg"
                                                        alt="Jane Verde Image" />
                                                </a>
                                            </figure>
                                        </div>
                                        <div class="price-box">
                                            <span>$100</span>
                                        </div>
                                    </div>
                                  
                                    <div class="product-template__info">
                                        <div>
                                            <div>
                                                <img src="https://ei.marketwatch.com/Multimedia/2018/12/12/Photos/ZH/MW-HA201_Hemp_2_20181212143235_ZH.jpg?uuid=ad3498b2-fe44-11e8-bf68-ac162d7bc1f7"
                                                    alt="Jane Verde Image" class="list-view-image" />

                                                <div class="clearfix"></div>
                                                <span class="qs">
                                                    @php
                                                    $verif = $product->userAlter != null && $product->userAlter->verified == 1 ? true : false;
                                                    @endphp
                                                <img src={!! !$verif  ? asset('images/shield_gray.jpg') : asset('images/shield_green.svg') !!}
                                                        alt="Jane Verde - SVG Icon"  />
                                                        @if($verif)
                                                    <div class="popover above popover-content">
                                                        <h4>
                                                            <img src={!! !$verif ? asset('images/shield_gray.jpg') : asset('images/shield_green.svg') !!}
                                                                alt="Jane Verde - SVG Icon" />
                                                            @if($verif)
                                                            Verified Business
                                                            @endif
                                                        </h4>
                                                        @if($verif)
                                                        <ul>
                                                            <li><i class="fas fa-check"></i>Location: {{$product->location}}</li>
                                                            <li><i class="fas fa-check"></i>License number: {!! $product->userAlter->licensenumber !!}</li>
                                                        </ul>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>
                                                <span>Aug 21</span>
                                                <a href="/view/{{$product->id}}">
                                                    @php
                                                        echo strlen($product->title) > 45 ? substr($product->title, 0, 50) . "..." : $product->title;    
                                                        $verif = $product->userAlter != null && $product->userAlter->verified == 1 ? true : false;
                                                    @endphp
                                                </a>
                                                <span class="product-location" style="display: inline">({{$product->location}})</span>
                                              
                                                <span class="qs qs-list-view" >
                                                    <img src= {!! !$verif  ? asset('images/shield_gray.jpg') : asset('images/shield_green.svg') !!}
                                                        alt="Jane Verde - SVG Icon" />
                                                         @if($verif)
                                                    <div class="popover above popover-content">
                                                        <h4>
                                                            <img src={!! $product->verified === 0 ? asset('images/shield_gray.jpg') : asset('images/shield_green.svg') !!}
                                                                alt="Jane Verde - SVG Icon" />
                                                            @if($verif)
                                                            Verified Business
                                                            @endif
                                                        </h4>
                                                        @if($verif)
                                                        <ul>
                                                            <li><i class="fas fa-check"></i>Location: {{$product->location}}</li>
                                                            <li><i class="fas fa-check"></i>License number: {!! $product->userAlter->licensenumber !!}</li>
                                                        </ul>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </span>
                                               
                                            </h4>
                                        </div>
                                        <div class="details-page-link">
                                            <a href="/view/{{$product->id}}">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include("partials.footer")
    </div>
</div>
</div>

@section('js_links')
<script type="text/javascript" src={{asset('js/libraries/jquery.js')}}></script>
<script type="text/javascript" src={{asset('js/libraries/selectric.js')}}></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
<script type="text/javascript" src={{asset('js/search.js')}}></script>
<script type="text/javascript" src={{asset('js/main.js')}}></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-148323450-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148323450-1');
</script>

@endsection

@endsection