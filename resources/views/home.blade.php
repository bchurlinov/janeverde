@extends("partials.layout")


@section("css_links")

@endsection


@section("content")
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
                        <a href="/auth" class="button-link" target="_blank">Create Listing</a>
                        <a href="/auth" class="button-link" target="_blank">My Account</a>
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

                    <div class="selectric-mobile">
                        <select id="select-states-mobile"></select>
                    </div>

                    <div class="search-mobile">
                        <div class="current-state-heading__item">
                            <form method="GET" action="/search">
                                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                                <button type="submit">
                                    <img src={{asset('images/search_white.svg')}} alt="Jane Verde SVG Image" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mobile-categories__item" data-click="sale" data-category="sale"
                    onclick="toggleCategory(this)">
                    <h4>For Sale
                        <span>
                            <i class="fas fa-chevron-down" data-clicked="sale"></i>
                        </span>
                    </h4>
                    <div data-target="sale">
                        <ul>
                            <li><a href="product_search.html" target="_blank">Biomass</a></li>
                            <li><a href="product_search.html" target="_blank">Conentrates</a></li>
                            <li><a href="product_search.html" target="_blank">Retail Products</a></li>
                            <li><a href="product_search.html" target="_blank">Grow Equipment</a></li>
                            <li><a href="product_search.html" target="_blank">Lab Equipment</a></li>
                            <li><a href="product_search.html" target="_blank">Promotional</a></li>
                            <li><a href="product_search.html" target="_blank">Misc</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mobile-categories__item" data-click="jobs" data-category="jobs"
                    onclick="toggleCategory(this)">
                    <h4>Jobs
                        <span>
                            <i class="fas fa-chevron-down" data-clicked="jobs"></i>
                        </span>
                    </h4>
                    <div data-target="jobs">
                        <ul>
                            <li><a href="product_search.html" target="_blank">Grow Indoor</a></li>
                            <li><a href="product_search.html" target="_blank">Grow Outdoor</a></li>
                            <li><a href="product_search.html" target="_blank">Trimming</a></li>
                            <li><a href="product_search.html" target="_blank">Hemp Extract</a></li>
                            <li><a href="product_search.html" target="_blank">THC Extract</a></li>
                            <li><a href="product_search.html" target="_blank">Drying</a></li>
                            <li><a href="product_search.html" target="_blank">Sales</a></li>
                            <li><a href="product_search.html" target="_blank">Marketing</a></li>
                            <li><a href="product_search.html" target="_blank">Business</a></li>
                            <li><a href="product_search.html" target="_blank">Admin</a></li>
                            <li><a href="product_search.html" target="_blank">Design / Web</a></li>
                            <li><a href="product_search.html" target="_blank">Retail</a></li>
                            <li><a href="product_search.html" target="_blank">Distribution</a></li>
                            <li><a href="product_search.html" target="_blank">Laboratory</a></li>
                            <li><a href="product_search.html" target="_blank">Regulatory</a></li>
                            <li><a href="product_search.html" target="_blank">Construction</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mobile-categories__item" data-click="real-estate" data-category="real-estate"
                    onclick="toggleCategory(this)">
                    <h4>Real Estate
                        <span>
                            <i class="fas fa-chevron-down" data-clicked="real-estate"></i>
                        </span>
                    </h4>
                    <div data-target="real-estate">
                        <ul>
                            <li><a href="product_search.html" target="_blank">Commercial for Sale</a></li>
                            <li><a href="product_search.html" target="_blank">Commercial for Rent</a></li>
                            <li><a href="product_search.html" target="_blank">Farm / Land</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mobile-categories__item" data-click="vendor-listings" data-category="vendor-listings"
                    onclick="toggleCategory(this)">
                    <h4>Vendor Listings
                        <span>
                            <i class="fas fa-chevron-down" data-clicked="vendor-listings"></i>
                        </span>
                    </h4>
                    <div data-target="vendor-listings">
                        <ul>
                            <li><a href="product_search.html" target="_blank">Legal / Attorney</a></li>
                            <li><a href="product_search.html" target="_blank">Account / Bank</a></li>
                            <li><a href="product_search.html" target="_blank">Web / Design</a></li>
                            <li><a href="product_search.html" target="_blank">Brokers</a></li>
                            <li><a href="product_search.html" target="_blank">Consulting</a></li>
                            <li><a href="product_search.html" target="_blank">Tolling Facilities</a></li>
                            <li><a href="product_search.html" target="_blank">Lab / Testing</a></li>
                            <li><a href="product_search.html" target="_blank">Equipment / Manufacturers</a></li>
                            <li><a href="product_search.html" target="_blank">Telecom</a></li>
                            <li><a href="product_search.html" target="_blank">Labor</a></li>
                            <li><a href="product_search.html" target="_blank">Marketing</a></li>
                            <li><a href="product_search.html" target="_blank">General</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mobile-categories">
                    <div class="mobile-categories__item" data-category="forums" data-click="discussions-forums"
                        onclick="toggleCategory(this)">
                        <h4>Discussions / Forums
                            <span>
                                <i class="fas fa-chevron-down" data-clicked="discussions-forums"></i>
                            </span>
                        </h4>
                        <div data-target="discussions-forums">
                            <ul>
                                <li><a href="product_search.html" target="_blank">Outdoor Grow</a></li>
                                <li><a href="product_search.html" target="_blank">Indoor Grow</a></li>
                                <li><a href="product_search.html" target="_blank">Extraction</a></li>
                                <li><a href="product_search.html" target="_blank">Lab / Testing</a></li>
                                <li><a href="product_search.html" target="_blank">Production / Distribution</a></li>
                                <li><a href="product_search.html" target="_blank">General</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="mobile-categories__item" data-click="misc" data-category="misc"
                        onclick="toggleCategory(this)">
                        <h4>Misc
                            <span>
                                <i class="fas fa-chevron-down" data-clicked="misc"></i>
                            </span>
                        </h4>
                        <div data-target="misc">
                            <ul>
                                <li><a href="product_search.html" target="_blank">Events / Promotional</a></li>
                                <li><a href="product_search.html" target="_blank">Groups / Activites</a></li>
                                <li><a href="product_search.html" target="_blank">General</a></li>
                            </ul>
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
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endif
            </div>
            <div class="home-wrap">
                <div class="home-wrap__item">
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
                            <a href="/auth" class="button-link" target="_blank">Create Listing</a>
                            <a href="/auth" class="button-link" target="_blank">My Account</a>
                        </div>
                        <div class="useful-links">
                            <a href="/auth" class="button-link" data-account="verify" target="_blank">
                                <img src="{{asset('images/shield_green.svg')}}" alt="Jane Verde SVG Icon" />
                                Verify Account
                            </a>
                            <a href="static_page.html" class="button-link">Help / Faq</a>
                            <a href="static_page.html" class="button-link">Privacy Policy</a>
                            <a href="static_page.html" class="button-link">Avoid Scams & Fraud</a>
                        </div>
                    </div>
                </div>

                <div class="home-wrap__item">
                    <div class="current-state-heading">
                        <div class="current-state-heading__item">
                            <h3>California, USA / <span class="toggle-hemp-cannabis">CANNABIS</span></h3>
                        </div>
                        <div class="current-state-heading__item current-state-heading__desktop">
                            <form method="GET" action="/search">
                                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                                <button type="submit">
                                    <img src="{{asset('images/search_white.svg')}}" alt="Jane Verde SVG Icon" />
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="home-categories">
                        <div class="home-categories__item">
                            <div class="category-item" data-category="forums">
                                <h5>Discussions / Forums</h5>
                                <ul>
                                    <li><a href="/search" target="_blank">Outdoor Grow</a></li>
                                    <li><a href="/search" target="_blank">Indoor Grow</a></li>
                                    <li><a href="/search" target="_blank">Extraction</a></li>
                                    <li><a href="/search" target="_blank">Lab / Testing</a></li>
                                </ul>
                                <ul>
                                    <li><a href="/search" target="_blank">Production / Distribution</a>
                                    </li>
                                    <li><a href="/search" target="_blank">General</a></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="home-categories__item">
                            <div class="category-item" data-category="vendor-listings">
                                <h5>Vendor Listings</h5>
                                <ul>
                                    <li><a href="/search" target="_blank">Legal / Attorney</a></li>
                                    <li><a href="/search" target="_blank">Account / Bank</a></li>
                                    <li><a href="/search" target="_blank">Web / Design</a></li>
                                    <li><a href="/search" target="_blank">Brokers</a></li>
                                    <li><a href="/search" target="_blank">Consulting</a></li>
                                    <li><a href="/search" target="_blank">Tolling Facilities</a></li>
                                </ul>
                                <ul>
                                    <li><a href="/search" target="_blank">Lab / Testing</a></li>
                                    <li><a href="/search" target="_blank">Equipment / Manufacturers</a>
                                    </li>
                                    <li><a href="/search" target="_blank">Telecom</a></li>
                                    <li><a href="/search" target="_blank">Labor</a></li>
                                    <li><a href="/search" target="_blank">Marketing</a></li>
                                    <li><a href="/search" target="_blank">General</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="home-categories__item">
                            <div class="category-item" data-category="sale">
                                <h5>For Sale</h5>
                                <ul>
                                    <li><a href="/search" target="_blank">Biomass</a></li>
                                    <li><a href="/search" target="_blank">Conentrates</a></li>
                                    <li><a href="/search" target="_blank">Retail Products</a></li>
                                    <li><a href="/search" target="_blank">Grow Equipment</a></li>
                                    <li><a href="/search" target="_blank">Lab Equipment</a></li>
                                    <li><a href="/search" target="_blank">Promotional</a></li>
                                    <li><a href="/search" target="_blank">Misc</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="home-categories__item">
                            <div class="category-item" data-category="misc">
                                <h5>Misc</h5>
                                <ul>
                                    <li><a href="/search" target="_blank">Events / Promotional</a></li>
                                    <li><a href="/search" target="_blank">Groups / Activites</a></li>
                                    <li><a href="/search" target="_blank">General</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="home-categories__item">
                            <div class="category-item" data-category="real-estate">
                                <h5>Real Estate</h5>
                                <ul>
                                    <li><a href="/search" target="_blank">Commercial for Sale</a></li>
                                    <li><a href="/search" target="_blank">Commercial for Rent</a></li>
                                    <li><a href="/search" target="_blank">Farm / Land</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="home-categories__item">
                            <div class="category-item" data-category="jobs">
                                <h5>Jobs</h5>
                                <ul>
                                    <li><a href="/search" target="_blank">Grow Indoor</a></li>
                                    <li><a href="/search" target="_blank">Grow Outdoor</a></li>
                                    <li><a href="/search" target="_blank">Trimming</a></li>
                                    <li><a href="/search" target="_blank">Hemp Extract</a></li>
                                    <li><a href="/search" target="_blank">THC Extract</a></li>
                                    <li><a href="/search" target="_blank">Drying</a></li>
                                    <li><a href="/search" target="_blank">Sales</a></li>
                                    <li><a href="/search" target="_blank">Marketing</a></li>
                                    <li><a href="/search" target="_blank">Business</a></li>
                                    <li><a href="/search" target="_blank">Admin</a></li>
                                </ul>
                                <ul>
                                    <li><a href="/search" target="_blank">Design / Web</a></li>
                                    <li><a href="/search" target="_blank">Retail</a></li>
                                    <li><a href="/search" target="_blank">Distribution</a></li>
                                    <li><a href="/search" target="_blank">Laboratory</a></li>
                                    <li><a href="/search" target="_blank">Regulatory</a></li>
                                    <li><a href="/search" target="_blank">Construction</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include("partials.footer")
    </div>
</div>
</div>

@section("js_links")
<script type="text/javascript" src={{asset('js/libraries/jquery.js')}}></script>
<script type="text/javascript" src={{asset('js/libraries/selectric.js')}}></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
<script type="text/javascript" src={{asset('js/main.js')}}></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="http://www.googletagmanager.com/gtag/js?id=UA-148323450-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148323450-1');
</script>

@endsection

@endsection