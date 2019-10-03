<div class="home-wrap__item">
    <div class="inner-wrap">
        @php
        $cookieSet = empty($_COOKIE['type']) ? $cookie : $_COOKIE['type'];
        @endphp
        <h1><a href="/{{$cookieSet}}"><img src="{{asset('/images/Janeverde_logo.svg')}}" /></a></h1>
        <div class="toggle-countries toggle-desktop">
            <div class="hemp-cannabis-toggle">
                <button class="ctype {{$cookieSet == "hemp" ? "toggle-active" : ""}}" id="hemp">HEMP</button>
                <button class="ctype {{$cookieSet == "cannabis" ? "toggle-active" : "" }}" id="cannabis">CANNABIS</button>
            </div>
            <div id="country" style="display:none;">{{$country['dropdown']}}</div>
            <div id="typehc" style="display:none;">{{$cookieSet}}</div>
            @if (request()->segment(1) !== "view")
            <select id="select-states"></select>
            @endif
        </div>
        <div class="listing-account">
            <a href="/auth" class="button-link">Create Listing</a>
            <a href="/auth" class="button-link">My Account</a>
        </div>
        <div class="useful-links">
            <a href="/auth" class="button-link" data-account="verify" ">
                <img src="{{asset('images/shield_green.svg')}}" alt="Jane Verde SVG Icon" />
                Verify Account
            </a>
            <a href="javascript:;" class="button-link">Help / Faq</a>
            <a href="javascript:;" class="button-link">Privacy Policy</a>
            <a href="javascript:;" class="button-link">Avoid Scams & Fraud</a>
        </div>
    </div>
</div>