@extends('partials.layout')

@section('css_links')
@php
use App\Http\Controllers\ProductsController;
$fhf = ProductsController::checkfhf();
@endphp
@endsection
@php $country = json_decode(session()->get('country'), true); @endphp
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
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                            <h3>

                                {{$product->country->full_country}} /
                                {{strtoupper(session()->get('type'))}} /
                                {{$product->category->name}}</h3>
                        </div>
                        <div class="current-state-heading__item">
                            <form method="GET"
                                action="/{{session()->get('type') == 'null' ? 'hemp' : session()->get('type')}}/0/0/search">
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
                                <a href="javascript:;" class="button-link reply">Reply</a>
                            </div>
                            <div class="search-filters__pagination details-filters__pagination">
                                <a href="{{$previous == null ? 'javascript:;' : '/view/'.$previous}}"><button><img
                                            src="{{asset('images/left-arrow_green.svg')}}"
                                            alt="Jane Verde SVG Icon" />PREV</button></a>
                                <a href="{{ session()->get('goToPrevious') != 'null' ? session()->get('goToPrevious') : session()->get('type').'/0/search' }}"><button>BACK TO SEARCH</button></a>
                                <a href="{{$next == null ? 'javascript:;' : '/view/'.$next}}"><button>NEXT<img src="{{asset('images/right-arrow_green.svg')}}" alt="Jane Verde SVG Icon" /></button></a>
                            </div>
                            <div class="search-filters__sorting details-filters__sorting">
                                <span><i id="{{$product->id}}" class="far fa-star favorite" {{in_array($product->id, $fhf['favorites']) ? ' style=color:#FFD700;' : ""}}></i><br />Favorite</span>
                                <span><i id="{{$product->id}}" class="far fa-window-close hide" {{in_array($product->id, $fhf['hidden']) ? ' style=color:#FF8C00' : ""}}></i><br />Hide</span>
                                <span><i id="{{$product->id}}" class="far fa-flag flag"{{in_array($product->id, $fhf['flagged']) ? ' style=color:indianred;' : ""}}></i><br />Flag</span>
                            </div>
                        </div>
                    </div>

                    <div class="reply-show" style="display:none;">
                        <div class="reply-info js-only" style="display: block;">
                            <aside class="reply-flap js-captcha">
                                <ul>
                                    <li class="reply-email">
                                        <p>Reply by email:</p>
                                        <p class="reply-email-address">
                                            <a href="mailto:someemail@janeverde.com?subject={{$product->title}}&amp;body=The transaction is between you and the seller.%0Ahttp://janeverde.tricond.com/view/{{$product->id}}">
                                                    <img src="{{asset('images/email-icon.png')}}" alt="aol-logo" />someemail@janeverde.com
                                            </a>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="webmail-links">Webmail links:</p> @php $mailLinkSubject =
                                        str_replace(' ', '+', $product->title); @endphp
                                        <ul class="reply-emails">
                                            <li>
                                                <p>
                                                    <img src="{{asset('images/gmail-logo.jpg')}}" alt="gmail-logo" />
                                                    <a href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to=someemail@janeverde.com&amp;su={{$mailLinkSubject}}&amp;body=The transaction is between you and the seller.%0Ahttp://janeverde.tricond.com/view/{{$product->id}}"
                                                        target="_blank" class="reply-email gmail">gmail</a>
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <img src="{{asset('images/yahoo-logo.jpg')}}" alt="yahoo-logo" />
                                                    <a href="http://compose.mail.yahoo.com/?to=someemail@janeverde.com&amp;subj={{$mailLinkSubject}}&amp;body=The transaction is between you and the seller.%0Ahttp://janeverde.tricond.com/view/{{$product->id}}"
                                                        target="_blank" class="reply-email yahoo">yahoo mail</a>
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <img src="{{asset('images/hotmail-logo.png')}}"
                                                        alt="hotmail-logo" />
                                                    <a href="https://outlook.live.com/default.aspx?rru=compose&amp;to=someemail@janeverde.com&amp;subject={{$mailLinkSubject}}&amp;body=The transaction is between you and the seller.%0Ahttp://janeverde.tricond.com/view/{{$product->id}}"
                                                        target="_blank" class="reply-email msmail">hotmail, outlook,
                                                        live mail</a>
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <img src="{{asset('images/aol-logo.png')}}" alt="aol-logo" />
                                                    <a href="http://mail.aol.com/mail/compose-message.aspx?to=someemail@janeverde.com&amp;subject={{$mailLinkSubject}}&amp;body=The transaction is between you and the seller.%0Ahttp://janeverde.com/view/{{$product->id}}"
                                                        target="_blank" class="reply-email aol">aol mail</a>
                                                </p>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="copy-paste-email">
                                        <p>Copy & Paste into your email:</p>
                                        <a href="javascript:;">someemail@janeverde.com</a>
                                    </li>
                                </ul>
                            </aside>
                        </div>
                    </div>

                    <div class="details-product">
                        <div class="details-product__information">
                            <div class="product-information-wrap">
                                <h2>
                                    <img src="{{asset('images/shield_green.svg')}}" alt="Jane Verde SVG Icon" />
                                    {{$product->title}} ( {{$product->location}} )
                                </h2>

                                <div class="product-information-wrap__slider">
                                    <div class="fotorama" data-nav="thumbs" data-transition="crossfade">
                                        @php
                                            for($i = 1; $i < 11; $i++){
                                                $img = "img$i";
                                                if($product->$img !== null){
                                                echo '<img src="'.asset("/products/".$product->$img).'"alt="Jane Verde Image" data-width="100%" data-minheight="100%">';
                                                }
                                            }

                                        @endphp


                                    </div>
                                </div>

                                <div class="product-information-wrap__information">
                                    <p>{{$product->description}}
                                    </p>
                                    <ul>
                                        <li>• Do not contact me with unsolicited services or offers</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="details-product__facts">
                            <div class="user-verification-info">
                                @if(Gate::check('isVerified') || Gate::check('isAdmin'))
                                <h5> <img src="{{asset('images/shield_green.svg')}}" alt="Jane Verde SVG Icon" />
                                    Verified Business</h5>
                                <p>The bussiness has been verified for:</p>
                                <ul>
                                    <li><i class="fas fa-check"></i>Bussiness Name</li>
                                    <li><i class="fas fa-check"></i>Location</li>
                                    <li><i class="fas fa-check"></i>Bus Liscense / Tax ID</li>
                                    <li><i class="fas fa-check"></i>Agriculture License</li>
                                </ul>
                                @else
                                <img src="{{asset('/images/blurred.png')}}" style="width: 100%">
                                <span>Verify your account to view other verified business details and post verified
                                    bussiness postings.
                                </span>
                                <p style="text-align: center">
                                    <a href="http://localhost:3000/">My Account</a>
                                </p>
                                @endif
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
<script type="text/javascript" src={{asset('js/details.js')}}></script>
<script type="text/javascript" src={{asset('js/main.js')}}></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-148323450-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148323450-1');

    $('.reply').click(function(){
        $('.reply-show').toggle();
    });

</script>

@endsection

@endsection