@extends('partials.layout')

@section('css_links')

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

                    <div class="selectric-mobile">
                        <select id="select-states-mobile"></select>
                    </div>

                    <div class="search-mobile">
                        <div class="current-state-heading__item">
                            <form method="GET" action="/details">
                                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                                <button type="submit">
                                    <img src="{{asset('images/search_white.svg')}}" alt="Jane Verde SVG Icon" />
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
            <div class="home-wrap home-search-wrap">
                <div class="home-wrap__item search-toggle-information">
                    <div class="inner-wrap">
                        <h1><a href="/">jane <span>Verde</span></a></h1>
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
                                <img src="{{asset('images/shield_green.svg')}}" alt="Jane Verde SVG Icon" />
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
                            <h3>California, USA / CANNABIS / FOR SALE / BIOMASS</h3>
                        </div>
                        <div class="current-state-heading__item">
                            <form method="GET" action="/search">
                                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
                                <button type="submit">
                                    <img src="{{asset('images/search_white.svg')}}" alt="Jane Verde SVG Icon" />
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="search-wrap details-wrap">
                        <div class="search-filters details-filters">
                            <div class="search-filters__views details-filters__views" style="text-align: left">
                                <a href="javascript:;" class="button-link">Reply</a>
                            </div>
                            <div class="search-filters__pagination details-filters__pagination">
                                <button><img src="{{asset('images/left-arrow_green.svg')}}"
                                        alt="Jane Verde SVG Icon" />PREV</button>
                                <button>BACK TO SEARCH</button>
                                <button>NEXT <img src="{{asset('images/right-arrow_green.svg')}}"
                                        alt="Jane Verde SVG Icon" /></button>
                            </div>
                            <div class="search-filters__sorting details-filters__sorting">
                                <span><i class="far fa-star"></i><br />Favorite</span>
                                <span><i class="far fa-window-close"></i><br />Hide</span>
                                <span><i class="far fa-flag"></i><br />Flag</span>
                            </div>
                        </div>
                    </div>

                    <div class="details-product">
                        <div class="details-product__information">
                            <div class="product-information-wrap">
                                <h2>
                                    <img src="{{asset('images/shield_green.svg')}}" alt="Jane Verde SVG Icon" />
                                    Sour Space Candy, Special Sauce, Lifter Pre-rolls ( CA )
                                </h2>

                                <div class="product-information-wrap__slider">
                                    <div class="fotorama" data-nav="thumbs">
                                        <img src="https://www.medicalnewstoday.com/content//images/articles/320/320984/a-man-holding-a-marijuana-leaf.jpg"
                                            alt="Jane Verde Image" data-width="100%" data-minheight="100%">
                                        <img src="https://g.foolcdn.com/image/?url=https%3A%2F%2Fg.foolcdn.com%2Feditorial%2Fimages%2F536649%2Fcannabidiol-oil-cbd-marijuana-hemp-cannabis-pot-derivative-legal-us-canada-getty.jpg&w=700&op=resize"
                                            alt="Jane Verde Image" data-width="100%" data-height="100%">
                                        <img src="https://www.medicalnewstoday.com/content//images/articles/320/320984/a-man-holding-a-marijuana-leaf.jpg"
                                            alt="Jane Verde Image" data-width="100%" data-height="100%">
                                        <img src="https://www.medicalnewstoday.com/content//images/articles/323/323673/cannabis-plant.jpg"
                                            alt="Jane Verde Image" data-width="100%" data-height="100%">
                                        <img src="https://thumbor.forbes.com/thumbor/960x0/https%3A%2F%2Fblogs-images.forbes.com%2Fjavierhasse%2Ffiles%2F2019%2F03%2FTHC-Hostel-1-1200x900.jpg"
                                            alt="Jane Verde Image" data-width="100%" data-height="100%">
                                        <img src="https://images.unsplash.com/photo-1556928045-16f7f50be0f3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80"
                                            alt="Jane Verde Image" data-width="100%" data-height="100%">
                                        <img src="https://www.swindonadvertiser.co.uk/resources/images/7860292.jpg?display=1&htype=0&type=responsive-gallery"
                                            alt="Jane Verde Image" data-width="100%" data-height="100%">
                                        <img src="https://www.kidderminstershuttle.co.uk/resources/images/9324128?type=responsive-gallery-fullscreen"
                                            alt="Jane Verde Image" data-width="100%" data-minheight="100%">
                                        <img src="https://i2.wp.com/cbdtesters.co/wp-content/uploads/2019/05/shutterstock_470900741.jpg?fit=810%2C541&ssl=1"
                                            alt="Jane Verde Image" data-width="100%" data-minheight="100%">

                                    </div>
                                </div>

                                <div class="product-information-wrap__information">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                    <ul>
                                        <li>• Do not contact me with unsolicited services or offers</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="details-product__facts">
                            <div class="user-verification-info">
                                <h5> <img src="{{asset('images/shield_green.svg')}}" alt="Jane Verde SVG Icon" /> Verified Business</h5>
                                <p>The bussiness has been verified for:</p>
                                <ul>
                                    <li><i class="fas fa-check"></i>Bussiness Name</li>
                                    <li><i class="fas fa-check"></i>Location</li>
                                    <li><i class="fas fa-check"></i>Bus Liscense / Tax ID</li>
                                    <li><i class="fas fa-check"></i>Agriculture License</li>
                                </ul>
                                <span>Verify your account to view other verified business details and post verified
                                    bussiness postings.
                                </span>
                                <p style="text-align: center">
                                    <a href="javascript:;">Verify my Account</a>
                                </p>
                            </div>

                            <div class="user-other-adds">
                                <ul>
                                    <li>MOQ: 100 units</li>
                                    <li>Direct Business Sales Only</li>
                                    <li>Delivery Available: ALL States</li>
                                    <li>More Adds by this User</li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="product-footer">
                        <ul>
                            <li>post id: 845738239</li>
                            <li>posted: 19 days ago</li>
                            <li>updated: about an hour ago</li>
                            <li>email to friend</li>
                            <li>▽ best of</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.footer')
    </div>
</div>
</div>

@section('js_links')
<script type="text/javascript" src={{asset('js/libraries/jquery.js')}}></script>
<script type="text/javascript" src={{asset('js/libraries/selectric.js')}}></script>
<script type="text/javascript" src={{asset('js/libraries/fotorama.min.js')}}></script>
<script type="text/javascript" src={{asset('js/details.js')}}></script>
<script type="text/javascript" src={{asset('js/main.js')}}></script>
@endsection

@endsection