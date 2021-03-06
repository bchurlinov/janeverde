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
            <div class="welcome-user">
                <p>@include('partials.userAndLogout')</p>
            </div>
            <div class="clearfix"></div>
            <div class="home-wrap home-search-wrap">
                @include('partials.leftMenu')

                <div class="home-wrap__item">
                    <div class="current-state-heading">
                        <div class="current-state-heading__item">
                            <h3>{{$country['fullName']}} /
                                {{session()->get('type') == 'null' ? 'HEMP' : strtoupper(session()->get('type'))}} /
                                {{strtoupper(App\Http\Controllers\ProductsController::getCategoryName(request()->segment(2)))}}
                            </h3>
                        </div>
                        <div class="current-state-heading__item current-state-heading__desktop">
                            <form method="GET"
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
                            @if(!$hideFields)
                            <div class="search-filters__sorting">
                                <div class="hemp-cannabis-toggle">
                                    <button
                                        class="ftype {{session()->get('searchType') != 'null' && session()->get('searchType') == 'viewAll' ? "toggle-active" : ""}}"
                                        id="viewAll">View All</button>
                                    <button
                                        class="ftype {{session()->get('searchType') != 'null' && session()->get('searchType') == 'verifiedOnly' ? "toggle-active" : ""}}"
                                        id="verifiedOnly">Verified</button>
                                </div>
                            </div>

                            @php
                            if($products != null){
                            echo $keyword == "" ? $products->links() : $products->appends(['keyword' =>
                            $keyword])->links();
                            }

                            @endphp

                            <div class="search-filters__views">
                                <button onclick="renderGridView(this)" class="grid-list-button" data-toggle="grid"><i
                                        class="fas fa-th-large toggle-icon" title="Gallery View"></i>
                                </button>
                                <button onclick="renderListView(this)" class="grid-list-button" title="List View"
                                    data-toggle="list"><i class="fas fa-bars toggle-icon"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>


                    <div class="search-products-listing">
                        <div class="products-listing-wrap">
                            @if($products == null || count($products) == 0)
                            @if($hideFields)
                            {!! "<div class='desktop-user-cannabis-error' style='margin-top: -65px'>
                                <h3><span>!</span>Please <a href='http://account.janeverde.com'>log in</a> to view
                                    Cannabis posts</h3>
                                <div class='forbidden-access-cannabis'>

                                    <div class='home-categories'>

                                        <div class='home-categories__item'>
                                            <div class='category-item' data-category='sale'>
                                                <h5><a href='javascript:;'>For Sale</a></h5>
                                                <ul>
                                                    <li><a href='javascript:;'>Biomass</a></li>
                                                    <li><a href='javascript:;'>Concentrates</a></li>
                                                    <li><a href='javascript:;'>Retail Products</a></li>
                                                    <li><a href='javascript:;'>Grow Equipment/Supplies</a></li>
                                                    <li><a href='javascript:;'>Lab Equipment Supplies</a></li>
                                                    <li><a href='javascript:;'>Promotional</a></li>
                                                    <li><a href='javascript:;'>In Search of</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class='home-categories__item'>
                                            <div class='category-item' data-category='misc'>
                                                <h5><a href='javascript:;'>Misc</a></h5>
                                                <ul>
                                                    <li><a href='javascript:;'>Events / Promotional</a></li>
                                                    <li><a href='javascript:;'>Groups / Activities</a></li>
                                                    <li><a href='javascript:;'>Groups / Clubs / Memberships</a></li>
                                                    <li><a href='javascript:;'>General</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class='home-categories__item'>
                                            <div class='category-item' data-category='vendor-listings'>
                                                <h5><a href='javascript:;'>Vendor Listings</a></h5>
                                                <ul>'
                                                    <li><a href='javascript:;'>Other</a></li>
                                                    <li><a href='javascript:;'>Point of Sale</a></li>
                                                    <li><a href='javascript:;'>Equipment Rental</a></li>
                                                    <li><a href='javascript:;'>Logistics / Trucking</a></li>
                                                    <li><a href='javascript:;'>Labor</a></li>
                                                    <li><a href='javascript:;'>Attorney</a></li>
                                                    <li><a href='javascript:;'>Marketing / Advertising</a></li>
                                                    <li><a href='javascript:;'>Telecom</a></li>
                                                    <li><a href='javascript:;'>Equipment Manufacturers</a></li>
                                                    <li><a href='javascript:;'>Consulting</a></li>
                                                </ul>
                                                <ul>
                                                    <li><a href='javascript:;'>Sales Brokers</a></li>
                                                    <li><a href='javascript:;'>Web / Design</a></li>
                                                    <li><a href='javascript:;'>Insurance</a></li>
                                                    <li><a href='javascript:;'>Banking</a></li>
                                                    <li><a href='javascript:;'>Lab Testing</a></li>
                                                    <li><a href='javascript:;'>Ag Processing Facilities</a></li>
                                                    <li><a href='javascript:;'>Concentrate Facilities</a></li>
                                                    <li><a href='javascript:;'>Processing</a></li>
                                                    <li><a href='javascript:;'>Farms</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class='home-categories__item'>
                                            <div class='category-item' data-category='forums'>
                                                <h5>Discussions / Forums</h5>
                                                <ul>
                                                    <li><a href='javascript:;'>Outdoor Grow</a></li>
                                                    <li><a href='javascript:;'>Indoor Grow</a></li>
                                                    <li><a href='javascript:;'>Extraction</a></li>
                                                    <li><a href='javascript:;'>Lab / Testing</a></li>
                                                </ul>
                                                <ul>
                                                    <li><a href='javascript:;'>Production / Distribution</a>
                                                    </li>
                                                    <li><a href='javascript:;'>General</a></li>
                                                </ul>
                                            </div>
                                            <div class='clearfix'></div>
                                        </div>

                                        <div class='home-categories__item'>
                                            <div class='category-item' data-category='jobs'>
                                                <h5><a href='javascript:;'>Jobs</a></h5>
                                                <ul>
                                                    <li><a href='javascript:;'>All</a></li>
                                                    <li><a href='javascript:;'>Agriculture</a></li>
                                                    <li><a href='javascript:;'>Processing</a></li>
                                                    <li><a href='javascript:;'>Sales / Marketing</a></li>
                                                    <li><a href='javascript:;'>Admin / Executive</a></li>
                                                    <li><a href='javascript:;'>Other/General</a></li>
                                                    <li><a href='javascript:;'>Distribution</a></li>
                                                    <li><a href='javascript:;'>Laboratory</a></li>
                                                </ul>
                                            </div>
                                        </div>


                                        <div class='home-categories__item'>
                                            <div class='category-item' data-category='real-estate'>
                                                <h5><a href='javascript:;'>Business / Real Estate</a></h5>
                                                <ul>
                                                    <li><a href='javascript:;'>Commercial for Sale</a></li>
                                                    <li><a href='javascript:;'>Commercial for Rent</a></li>
                                                    <li><a href='javascript:;'>Land for Sale</a></li>javascript:;
                                                    <li><a href='javascript:;'>Business for Sale</a></li>
                                                    <li><a href='javascript:;'>Investment Opportunities</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>"; !!}
                                @else
                                {{"No posts"}}
                                @endif
                                @else
                                @foreach($products as $product)
                                <div class="product-template-wrap">
                                    <div class="product-template">
                                        <div class="product-template__image">
                                            <div class="slider">
                                                @php
                                                $allImgs = 0;
                                                for($i = 1; $i < 11; $i++){ $img="img$i" ; if($product->$img !== null){
                                                    $allImgs += 1;
                                                    echo '<figure>
                                                        <a href="/view/'.$product->id.'">
                                                            ';
                                                            echo '<img
                                                                src="'.asset("/products/".$product->$img).'"alt="Jane
                                                                Verde Image" data-width="100%" data-minheight="100%">';
                                                            echo '</a>
                                                    </figure>';
                                                    }
                                                    }
                                                    if($allImgs == 0){
                                                    echo '<figure>
                                                        <a href="/view/'.$product->id.'">
                                                            ';
                                                            echo '<img
                                                                src="'.asset("/images/image_placeholder.jpg").'"alt="Jane
                                                                Verde Image">';
                                                            echo '</a>
                                                    </figure>';
                                                    }
                                                    @endphp

                                            </div>
                                            <div class="price-box">
                                                <span>${{$product->price}}</span>
                                            </div>
                                        </div>

                                        <div class="product-template__info">
                                            <div>
                                                <div>
                                                    @php
                                                    $allImgs = 0;
                                                    $index = 0;
                                                    for($i = 1; $i < 11; $i++){ $img="img$i" ; if($product->$img !==
                                                        null){
                                                        $allImgs += 1;
                                                        echo '<img src="'.asset("/products/".$product->$img).'"alt="Jane
                                                            Verde Image" class="list-view-image">';
                                                        break;
                                                        }
                                                        }
                                                        if($allImgs == 0){
                                                        echo '<img
                                                            src="'.asset("/images/image_placeholder.jpg").'"alt="Jane
                                                            Verde Image" class="list-view-image">';
                                                        }
                                                        @endphp

                                                        <div class="clearfix"></div>
                                                        <span class="qs">
                                                            @php
                                                            $verif = $product->verified == 1 ? true : false;
                                                            @endphp
                                                            <img src={!! !$verif ? asset('images/shield_gray.jpg') :
                                                                asset('images/shield_green.svg') !!}
                                                                alt="Jane Verde - SVG Icon"
                                                                style="height: 30px!important" />

                                                            <div class="popover above popover-content">
                                                                <h4>
                                                                    <img src={!! !$verif ?
                                                                        asset('images/shield_gray.jpg') :
                                                                        asset('images/shield_green.svg') !!}
                                                                        alt="Jane Verde - SVG Icon" />
                                                                    @if($verif)
                                                                    Verified Business
                                                                    @else
                                                                    Not Verified
                                                                    @endif
                                                                </h4>
                                                                @if($verif)
                                                                <ul>
                                                                    <li><i class="fas fa-check"></i>Location:
                                                                        {{$product->location}}</li>
                                                                    <li><i class="fas fa-check"></i>License number: {!!
                                                                        $product->userAlter->licensenumber !!}</li>
                                                                </ul>
                                                                @else
                                                                <ul>
                                                                    <li></li>
                                                                </ul>
                                                                @endif
                                                            </div>
                                                        </span>
                                                </div>
                                            </div>
                                            <div>
                                                <h4>
                                                    <span>@php
                                                        echo date('M d', strtotime($product->created_at));
                                                        @endphp</span>
                                                    <a href="/view/{{$product->id}}">
                                                        @php
                                                        echo strlen($product->title) > 45 ? substr($product->title, 0,
                                                        50) .
                                                        "..." : $product->title;
                                                        $verif = $product->verified == 1 ? true : false;
                                                        @endphp
                                                    </a>
                                                    <span class="product-location"
                                                        style="display: inline">({{$product->location}})</span>

                                                    <span class="qs qs-list-view">
                                                        <img src={!! !$verif ? asset('images/shield_gray.jpg') :
                                                            asset('images/shield_green.svg') !!}
                                                            alt="Jane Verde - SVG Icon" />
                                                        <div class="popover above popover-content">
                                                            <h4>
                                                                <img src={!! $product->verified === 0 ?
                                                                asset('images/shield_gray.jpg') :
                                                                asset('images/shield_green.svg') !!}
                                                                alt="Jane Verde - SVG Icon" />
                                                                @if($verif)
                                                                Verified Business
                                                                @else
                                                                Not Verified
                                                                @endif
                                                            </h4>
                                                            @if($verif)
                                                            <ul>
                                                                <li><i class="fas fa-check"></i>Location:
                                                                    {{$product->location}}</li>
                                                                <li><i class="fas fa-check"></i>License number: {!!
                                                                    $product->userAlter->licensenumber !!}</li>
                                                            </ul>
                                                            @else
                                                            <ul>
                                                                <li></li>
                                                            </ul>
                                                            @endif
                                                        </div>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>
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