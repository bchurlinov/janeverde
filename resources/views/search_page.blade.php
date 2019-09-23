@extends('partials.layout')

@section("css_links")
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
@endsection

@section('content')
<div class="wrapper">
    <div class="container">
        <div class="outer-wrap outer-wrap-mobile">
            <!-- Mobile Version  -->
            <div class="home-wrap-mobile">
                <div class="home-wrap-mobile__navbar">
                    <div>
                        <h1><a href="/">jane <span>Verde</span></a></h1>
                    </div>
                    <div>
                        <a href="account.html" class="button-link" target="_blank">Create Listing</a>
                        <a href="account.html" class="button-link" target="_blank">My Account</a>
                    </div>
                </div>

                <div class="home-wrap-mobile__togles">
                    <div class="toggle-countries">
                        <fieldset>
                            <input class="input-switch" id="mobile-switch" type="checkbox" />
                            <label for="mobile-switch"></label>
                            <span class="switch-bg"></span>
                            <span class="switch-labels" data-on="Hemp" data-off="Cannabis"></span>
                        </fieldset>
                    </div>
w
                    <div class="selectric-mobile">
                        <select id="select-states-mobile"></select>
                    </div>

                    <div class="search-mobile">
                        <div class="current-state-heading__item">
                            <form method="GET" action="/search">
                                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                                <button type="submit">
                                    <img src={{asset('images/search_white.svg')}} alt="Jane Verde SVG Icon" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Mobile Version -->

    <div class="container">
        <div class="outer-wrap">
            <div align="right">
                @if(auth()->user())
                    {!! "<a href='/dashboard'>" .substr(auth()->user()->name, 0, 1) . " " . substr(auth()->user()->lastname, 0, 1) . "</a>" !!}

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                @endif
            </div>
            <div class="home-wrap home-search-wrap">
                <div class="home-wrap__item search-toggle-information">
                    <div class="inner-wrap">
                        <h1><a href="index.html">jane <span>Verde</span></a></h1>
                        <div class="toggle-countries toggle-desktop">
                            <fieldset>
                                <input class="input-switch" id="switch" type="checkbox" />
                                <label for="switch"></label>
                                <span class="switch-bg"></span>
                                <span class="switch-labels" data-on="Hemp" data-off="Cannabis"></span>
                            </fieldset>
                            <select id="select-states"></select>
                        </div>
                        <div class="listing-account">
                            <a href="account.html" class="button-link" target="_blank">Create Listing</a>
                            <a href="account.html" class="button-link" target="_blank">My Account</a>
                        </div>
                        <div class="useful-links">
                            <a href="account.html" class="button-link" data-account="verify" target="_blank">
                                <img src={{asset('images/shield_green.svg')}} alt="Jane Verde - SVG Icon" />
                                Verify Account
                            </a>
                            <a href="static_page.html" class="button-link">Help / Faq</a>
                            <a href="static_page.html" class="button-link">Privacy Policy</a>
                            <a href="static_page.html" class="button-link">Avoid Scams & Fraud</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="home-wrap__item">
                    <div class="current-state-heading">
                        <div class="current-state-heading__item">
                            <h3>California, USA / CANNABIS / GENERAL</h3>
                        </div>
                        <div class="current-state-heading__item current-state-heading__desktop">
                            <form method="GET" action="/search">
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
                                <fieldset>
                                    <input class="input-switch" id="view-all-verified" type="checkbox" />
                                    <label for="view-all-verified"></label>
                                    <span class="switch-bg"></span>
                                    <span class="switch-labels" data-on="View All" data-off="Verified"></span>
                                </fieldset>
                            </div>
                            <div class="search-filters__pagination">
                                <button><img src={{asset('images/left-arrow_green.svg')}}
                                        alt="Jane Verde - SVG Icon" />PREV</button>
                                <button>1 - 120 / 198</button>
                                <button>NEXT <img src={{asset('images/right-arrow_green.svg')}}
                                        alt="Jane Verde - SVG Icon" /></button>
                            </div>
                            <div class="search-filters__views">
                                <button onclick="renderGridView(this)" class="grid-list-button" data-toggle="grid"><i
                                        class="fas fa-th-large toggle-icon" title="Gallery View"></i>
                                </button>
                                <button onclick="renderListView(this)" class="grid-list-button" title="List View" data-toggle="list"><i
                                        class="fas fa-bars toggle-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="search-products-listing">
                        <div class="products-listing-wrap">
                            @if(count($products) == 0)
                                {{"No products"}}
                            @else
                                @foreach($products as $product)
                                    <div class="product-template-wrap">
                                <div class="product-template">
                                    <div class="product-template__image">
                                        <div class="slider">
                                            <figure>
                                                <a href="/view" target="_blank">
                                                    <img src="https://www.dailymaverick.co.za/wp-content/uploads/openletter-cannabis-1600x875.jpg"
                                                        alt="Jane Verde Image" />
                                                </a>
                                            </figure>
                                            <figure>
                                                <a href="/view" target="_blank">
                                                    <img src="https://www.dailymaverick.co.za/wp-content/uploads/openletter-cannabis-1600x875.jpg"
                                                        alt="Jane Verde Image" />
                                                </a>
                                            </figure>
                                            <figure>
                                                <a href="/view" target="_blank">
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
                                                @if(Gate::check('isAdmin') || Gate::check('isVerified'))
                                                    <img src="https://ei.marketwatch.com/Multimedia/2018/12/12/Photos/ZH/MW-HA201_Hemp_2_20181212143235_ZH.jpg?uuid=ad3498b2-fe44-11e8-bf68-ac162d7bc1f7"
                                                         alt="Jane Verde Image" class="list-view-image" />
                                                    <div class="clearfix"></div>
                                                    <span class="qs">
                                                    <img src={{asset('images/shield_green.svg')}}
                                                            alt="Jane Verde - SVG Icon" />
                                                    <div class="popover above popover-content">
                                                        <h4>
                                                            <img src={{asset('images/shield_green.svg')}}
                                                                    alt="Jane Verde - SVG Icon" />
                                                            Verified Business
                                                        </h4>
                                                        <ul>
                                                            <li><i class="fas fa-check"></i>Bussiness Name: Jane
                                                                Verde LTD</li>
                                                            <li><i class="fas fa-check"></i>Location: California
                                                            </li>
                                                            <li><i class="fas fa-check"></i>Bus License/TAX ID:
                                                                93-1356489</li>
                                                            <li><i class="fas fa-check"></i>Agricultural License: AG
                                                                - R12315321</li>
                                                        </ul>
                                                    </div>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <h4>
                                                <span>Aug 21</span>
                                                <a href="/view" target="_blank">{{$product->title}}
                                                </a>
                                                <span class="product-location">({{$product->location}})</span>
                                                <span class="qs qs-list-view">
                                                    <img src={{asset('images/shield_green.svg')}}
                                                        alt="Jane Verde - SVG Icon" />
                                                    <div class="popover above popover-content">
                                                        <h4>
                                                            <img src={{asset('images/shield_green.svg')}}
                                                                alt="Jane Verde - SVG Icon" />
                                                            Verified Business
                                                        </h4>
                                                        <ul>
                                                            <li><i class="fas fa-check"></i>Bussiness Name: Jane
                                                                Verde LTD</li>
                                                            <li><i class="fas fa-check"></i>Location: California
                                                            </li>
                                                            <li><i class="fas fa-check"></i>Bus License/TAX ID:
                                                                93-1356489</li>
                                                            <li><i class="fas fa-check"></i>Agricultural License: AG
                                                                - R12315321</li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </h4>
                                        </div>
                                        <div class="details-page-link">
                                            <a href="/view" target="_blank">
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
@endsection

@endsection