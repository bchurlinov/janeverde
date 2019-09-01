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
                            <form method="GET" action="product_search.html">
                                <input type="text" name="keyword" placeholder="Search listings"
                                    autocomplete="off" />
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
            <div class="home-wrap auth-home-wrap">
                <div class="home-wrap__item auth-home-wrap__item">
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
                            <a href="javascript:;" class="button-link">Help / Faq</a>
                            <a href="javascript:;" class="button-link">Privacy Policy</a>
                            <a href="javascript:;" class="button-link">Avoid Scams & Fraud</a>
                        </div>
                    </div>
                </div>

                <div class="home-wrap__item">
                    <div class="current-state-heading">
                        <div class="current-state-heading__item">
                            <h3>Sign In</h3>
                        </div>
                        <div class="current-state-heading__item">
                            <form method="GET" action="product_search.html">
                                <input type="text" name="keyword" placeholder="Search listings"
                                    autocomplete="off" />
                                <button type="submit">
                                    <img src="{{asset('images/search_white.svg')}}" alt="Jane Verde SVG Icon" />
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="home-wrap__item">
                        <div class="form">
                            <ul class="tab-group">
                                <li class="tab active"><a href="#signup">Sign Up</a></li>
                                <li class="tab"><a href="#login">Log In</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="signup">
                                    <h6>Sign Up</h6>

                                    <form id="sign-up-form" action="/" method="post">
                                        <div class="form-group field-wrap">
                                            <label>Enter your first name <span>(*)</span></label>
                                            <input type="text" required autocomplete="off" />
                                        </div>

                                        <div class="form-group field-wrap">
                                            <label>Enter your last name<span>(*)</span></label>
                                            <input type="text" required autocomplete="off" />
                                        </div>
                                        <div class="form-group field-wrap">
                                            <label>Enter your e-mail address<span>(*)</span></label>
                                            <input type="email" required autocomplete="off" />
                                        </div>
                                        <div class="form-group field-wrap">
                                            <label>Set up a password<span>(*)</span></label>
                                            <input type="password" required autocomplete="off" />
                                        </div>
                                        <div class="form-group field-wrap" style="margin-top: 15px;">
                                            <label style="top: -25px">I want to<span>(*)</span></label>
                                            <select id="sell-buy-option">
                                                <option name="seller">Sell products</option>
                                                <option name="buyer">Buy products</option>
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="button-auth button-block">Submit</button>
                                        </div>
                                    </form>
                                </div>

                                <div id="login">
                                    <h6>Sign In</h6>
                                    <form id="log-in-form" action="/" method="post">
                                        <div class="form-group field-wrap">
                                            <label>Enter your e-mail address<span>(*)</span></label>
                                            <input type="email" required autocomplete="off" />
                                        </div>
                                        <div class="form-group field-wrap">
                                            <label>Enter your password<span>(*)</span></label>
                                            <input type="password" required autocomplete="off" />
                                        </div>

                                        <div class="forgot">
                                            <p><a href="javascript:;">Forgot Password?</a></p>
                                        </div>

                                        <div class="text-center">
                                            <button class="button-auth button-block">Log In</button>
                                        </div>

                                        <div class="text-center">
                                            <a href="javascript:;" class="seller-login">If you are a seller, use
                                                this link</a>
                                        </div>
                                    </form>

                                </div>

                            </div><!-- tab-content -->

                        </div> <!-- /form -->
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
<script type="text/javascript" src={{asset('js/auth.js')}}></script>
<script type="text/javascript" src={{asset('js/main.js')}}></script>
@endsection


@endsection