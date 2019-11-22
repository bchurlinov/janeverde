@extends('partials.layout')

@section('css_links')
@php
use App\Http\Controllers\ProductsController;
$fhf = ProductsController::checkfhf();
@endphp
@endsection
@php $country = json_decode(session()->get('country'), true); $type = session()->get('type'); @endphp
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
                                <a href="<?=config('phpurl').'/'.$type.'/0/0/search'?>"><button>BACK
                                        TO SEARCH</button></a>
                                <a href="{{$next == null ? 'javascript:;' : '/view/'.$next}}"><button>NEXT<img
                                            src="{{asset('images/right-arrow_green.svg')}}"
                                            alt="Jane Verde SVG Icon" /></button></a>
                            </div>
                            <div class="search-filters__sorting details-filters__sorting">
                                <span><i id="{{$product->id}}" class="far fa-star favorite"
                                        {{in_array($product->id, $fhf['favorites']) ? ' style=color:#FFD700;' : ""}}></i><br />Favorite</span>
                                <span><i id="{{$product->id}}" class="far fa-window-close hide"
                                        {{in_array($product->id, $fhf['hidden']) ? ' style=color:#FF8C00' : ""}}></i><br />Hide</span>
                                <span><i id="{{$product->id}}" class="far fa-flag flag"
                                        {{in_array($product->id, $fhf['flagged']) ? ' style=color:indianred;' : ""}}></i><br />Flag</span>
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
                                            <a
                                                href="mailto:someemail@janeverde.com?subject={{$product->title}}&amp;body=The transaction is between you and the seller.%0{{config('variables.phpurl')}}/view/{{$product->id}}">
                                                <img src="{{asset('images/email-icon.png')}}"
                                                    alt="aol-logo" />someemail@janeverde.com
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
                                                    <a href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to=someemail@janeverde.com&amp;su={{$mailLinkSubject}}&amp;body=The transaction is between you and the seller.%0A{{config('variables.phpurl')}}/view/{{$product->id}}"
                                                        target="_blank" class="reply-email gmail">gmail</a>
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <img src="{{asset('images/yahoo-logo.jpg')}}" alt="yahoo-logo" />
                                                    <a href="http://compose.mail.yahoo.com/?to=someemail@janeverde.com&amp;subj={{$mailLinkSubject}}&amp;body=The transaction is between you and the seller.%0A{{config('variables.phpurl')}}/view/{{$product->id}}"
                                                        target="_blank" class="reply-email yahoo">yahoo mail</a>
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <img src="{{asset('images/hotmail-logo.png')}}"
                                                        alt="hotmail-logo" />
                                                    <a href="https://outlook.live.com/default.aspx?rru=compose&amp;to=someemail@janeverde.com&amp;subject={{$mailLinkSubject}}&amp;body=The transaction is between you and the seller.%0A{{config('variables.phpurl')}}/view/{{$product->id}}"
                                                        target="_blank" class="reply-email msmail">hotmail, outlook,
                                                        live mail</a>
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <img src="{{asset('images/aol-logo.png')}}" alt="aol-logo" />
                                                    <a href="http://mail.aol.com/mail/compose-message.aspx?to=someemail@janeverde.com&amp;subject={{$mailLinkSubject}}&amp;body=The transaction is between you and the seller.%0A{{config('variables.phpurl')}}/view/{{$product->id}}"
                                                        target="_blank" class="reply-email aol">aol mail</a>
                                                </p>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="copy-paste-email">
                                        <p>Copy & Paste into your email:</p>
                                        <a href="javascript:;">someemail@janeverde.com</a>
                                    </li>

                                    @php
                                    if($product->phone != null && $product->contact_preferences != null &&
                                    $product->contact_preferences != "0,0"){
                                    echo '
                                    <hr style="margin-top: 10px; margin-bottom: 10px" />';
                                    echo '<li><b>Phone: </b> '.$product->phone.'</li>';
                                    $prefs = explode(",", $product->contact_preferences);
                                    if($prefs[0] == 1){
                                    echo "<li><img src='/images/smartphone.svg'
                                            alt='Jane Verde - Smartphone Logo' />Phone calls - <b>OK</b></li>";
                                    }
                                    if($prefs[1] == 1){
                                    echo "<li>
                                    <li><img src='/images/sms-text.svg' alt='Jane Verde - Smartphone Logo' />Text/SMS -
                                        <b>OK</b></li>";
                                    }
                                    }
                                    @endphp
                                </ul>
                            </aside>
                        </div>
                    </div>

                    <div class="details-product">
                        <div class="details-product__information">
                            <div class="product-information-wrap">
                                <h2>
                                    <img src="{{$product->verified == "1" ? asset('images/shield_green.svg') : asset('images/shield_gray.jpg')}}"
                                        alt="Jane Verde SVG Icon" />
                                    {{$product->title}} ( {{$product->location}} )
                                </h2>

                                <div class="product-information-wrap__slider">
                                    <div class="fotorama" data-nav="thumbs" data-transition="crossfade"
                                        data-width="100%" data-maxheight="100%" data-arrows="true">
                                        @php
                                        $allImgs = 0;
                                        for($i = 1; $i < 11; $i++){ $img="img$i" ; if($product->$img !== null){
                                            $allImgs += 1;
                                            echo '<img src="'.asset("/products/".$product->$img).'"alt="Jane Verde
                                                Image" data-width="100%" data-minheight="100%">';
                                            }
                                            }
                                            if($allImgs == 0){
                                            echo '<img src="'.asset("/images/image_placeholder.jpg").'"alt="Jane Verde
                                                Image" style="width:100%; height:400px;" data-width="100%"
                                                data-minheight="100%">';
                                            }
                                            @endphp
                                    </div>
                                </div>

                                <div class="product-information-wrap__information">
                                    <p>{{$product->description}}
                                    </p>
                                    <ul class="product-description-wrap-info">
                                        <li><b>Price</b>: ${{$product->price}}</li>
                                        <li><b>State</b>: {{$product->location}}</li>
                                        <li><b>Type</b>: {{ucfirst($product->type)}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="details-product__facts">
                            <div class="user-verification-info">
                                @if(Gate::check('isAdmin') || !empty($_COOKIE['_main']))
                                <h5> <img
                                        src="{{$product->verified == "1" ? asset('images/shield_green.svg') : asset('images/shield_gray.jpg')}}"
                                        alt="Jane Verde SVG Icon" />
                                    {{$product->verified == "1" ? "Verified business" : "Non verified business"}}</h5>
                                @if($product->verified == "1")
                                <p>The bussiness has been verified for:</p>
                                <ul>
                                    <li><i class="fas fa-check"></i>Bussiness Name</li>
                                    <li><i class="fas fa-check"></i>Location</li>
                                    <li><i class="fas fa-check"></i>Bus Liscense / Tax ID</li>
                                </ul>
                                @endif
                                @else
                                <img src="{{asset('/images/blurred.png')}}" style="width: 100%">
                                <span>Verify your account to view other verified business details and post verified
                                    bussiness postings.
                                </span>
                                <p style="text-align: center">
                                    <a href="{{config('variables.reacturl')}}">My Account</a>
                                </p>
                                @endif
                            </div>

                            <div class="user-other-adds">
                                <ul>
                                    <!--<li>MOQ: 100 units</li>
                                    <li>Direct Business Sales Only</li>
                                    <li>Delivery Available: ALL States</li>-->

                                    <li>
                                        <a
                                            href="{{config('variables.phpurl')."/".session()->get('type')."/0/0/search?user=".$product->user->id}}">
                                            More Ads by this User
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    @php
                    $today = new Datetime(date("Y-m-d h:m:s"));
                    $created = new DateTime($product->created_at);
                    $updated = new Datetime($product->updated_at);
                    $createdString = "";
                    $updatedString = "";
                    //created handle
                    $createdDiff = $today->diff($created)->format('%m,%d');
                    $createdArray = explode(",", $createdDiff);
                    if($createdArray[0] == 1){
                    $createdString .= "1 month";
                    }
                    elseif($createdArray[0] == 2){
                    $createdString .= "2 months";
                    }
                    if($createdArray[1] == 0){
                    $createdString .= " ago";
                    }
                    else{
                    $createdString .= $createdString == "" ? $createdArray[1]." days ago" : ", ".$createdArray[1]." days
                    ago";
                    }

                    if($createdDiff == "0,0"){
                    $createdString = "Today";
                    }

                    $updatedDiff = $today->diff($updated)->format('%m,%d');
                    $updatedArray = explode(",", $updatedDiff);
                    if($updatedArray[0] == 1){
                    $updatedString .= "1 month";
                    }
                    elseif($updatedArray[0] == 2){
                    $updatedString .= "2 months";
                    }
                    if($updatedArray[1] == 0){
                    $updatedString .= " ago";
                    }
                    else{
                    $updatedString .= $updatedString == "" ? $updatedArray[1]." days ago" : ", ".$updatedArray[1]." days
                    ago";
                    }
                    if($updatedDiff == "0,0"){
                    $updatedString = "Today";
                    }

                    @endphp
                    <div class="product-footer">
                        <ul>
                            <li>post id: #{{$product->id}}</li>
                            <li>posted: {{$createdString}}</li>
                            <li>updated: {{$updatedString}}</li>
                            <li><a class="openmodale">email to friend</a></li>
                        </ul>
                    </div>

                    <!-- Email to Friend Modal -->

                    <div class="modale" aria-hidden="true">
                        <div class="modal-dialog-email">
                            <div class="modal-header-email">
                                <h2>Send to Friend</h2>
                                <a href="#" class="btn-close closemodale" aria-hidden="true">&times;</a>
                            </div>
                            <div class="modal-body-email">
                                <form onsubmit="submitEmailFriend(event, this)" id="form">
                                    <label>Your name</label>
                                    <input type="text" name="name" required />
                                    <label>Friend's e-mail address</label>
                                    <input type="email" name="friends_name" required />
                                    <input type="hidden" name="product_url" value="{{$product->id}}" />
                                    <div class="modal-footer-email">
                                        <button class="btn-link" type="submit" id="btn_ingresar">Send<div
                                                class="loader email-friend-loader" title="2">
                                                <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    width="40px" height="40px" viewBox="0 0 50 50"
                                                    style="enable-background:new 0 0 50 50;" xml:space="preserve">
                                                    <path fill="#000"
                                                        d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                                        <animateTransform attributeType="xml" attributeName="transform"
                                                            type="rotate" from="0 25 25" to="360 25 25" dur="0.6s"
                                                            repeatCount="indefinite" />
                                                    </path>
                                                </svg>
                                            </div></button>
                                        <div id="status" style="color: #00cc00"></div>
                                        <div id="error-status" style="color: indianred"></div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <!-- End Modal -->
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>
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