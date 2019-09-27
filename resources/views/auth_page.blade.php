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
                            <h3>My Account / Sign In</h3>
                        </div>
                        <div class="current-state-heading__item">
                            <form method="GET" action="search">
                                <input type="text" name="keyword" placeholder="Search listings" autocomplete="off" />
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
                                <li class="tab"><a href="#login" id="formlogin">Log In</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="signup">
                                    <h6>Sign Up</h6>
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group field-wrap">
                                            <label>{{ __('First name') }}<span> (*)</span></label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="off" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group field-wrap">
                                            <label>{{ __('Last name') }}<span> (*)</span></label>
                                            <input id="lastname" type="text"
                                                class="form-control @error('lastname') is-invalid @enderror"
                                                name="lastname" value="{{ old('lastname') }}" required
                                                autocomplete="off" autofocus>

                                            @error('lastname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group field-wrap">
                                            <label for="email">{{ __('E-mail address') }}<span> (*)</span></label>

                                            <div>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required autocomplete="off">

                                                @error('email')
                                                <span class="invalid-feedback" id="loginemail" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group field-wrap">
                                            <label for="password"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Set up a password') }}<span>
                                                    (*)</span></label>

                                            <div class="col-md-6">
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="off">

                                                @error('password')
                                                <span class="invalid-feedback" id="loginpass" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group field-wrap">
                                            <label for="password-confirm"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}<span>(*)</span></label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group field-wrap">
                                            <label style="top: -25px">{{ __('I want to') }}<span> (*)</span></label>
                                            <select id="sell-buy-option" name="type">
                                                <option name="buyer" value="buyer">Buy products</option>
                                                <option name="seller" value="seller">Sell products</option>
                                                <option name="buyer_seller" value="buyer_seller">Buy & Sell products
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group field-wrap text-center">
                                            <input type="checkbox" name="verify_account" value="verify_account">
                                            <span>I would like to verify my account and have access to…</span>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="button-auth button-block">
                                                Create Account
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div id="login">
                                    <h6>Sign In</h6>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <input type="hidden" name="field" id="field">
                                        <div class="form-group field-wrap">
                                            <label for="email"
                                                class="col-form-label text-md-right">{{ __('Enter your e-mail address') }}<span>
                                                    (*)</span></label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="off" autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group field-wrap">
                                            <label for="password"
                                                class="col-form-label text-md-right">{{ __('Password') }}<span>
                                                    (*)</span></label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="off">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group field-wrap text-center">
                                            <input type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <span>Remember Me</span>
                                        </div>


                                        @if (Route::has('password.request'))
                                        <div class="forgot">
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        </div>
                                        @endif

                                        <div class="form-group field-wrap">
                                            <div class="text-center">
                                                <button type="submit" class="button-auth button-block">
                                                    {{ __('Log in') }}
                                                </button>
                                            </div>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
<script type="text/javascript" src={{asset('js/auth.js')}}></script>
<script type="text/javascript" src={{asset('js/main.js')}}></script>
@endsection


@endsection