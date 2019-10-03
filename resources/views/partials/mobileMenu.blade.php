@php
    $cookieSet = empty($_COOKIE['type']) ? $cookie : $_COOKIE['type'];
@endphp
<div class="container">
    <div class="outer-wrap outer-wrap-mobile">
        <!-- Mobile Version  -->
        <div class="home-wrap-mobile">
            <div class="home-wrap-mobile__navbar">
                <div>
                    <h1><a href="/">jane <span>Verde</span></a></h1>
                </div>
                <div>
                    <a href="/auth" class="button-link">Create Listing</a>
                    <a href="/auth" class="button-link">My Account</a>
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
                        <form method="GET" action="/{{empty($_COOKIE['type']) ? $cookie : $_COOKIE['type']}}/0/search">
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