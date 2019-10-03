<div class="home-wrap__item">
    <div class="inner-wrap">
        <h1><a href="/{{empty($_COOKIE['type']) ? $cookie : $_COOKIE['type']}}"><img src="{{asset('/images/Janeverde_logo.svg')}}" /></a></h1>
        <div class="toggle-countries toggle-desktop">
            <fieldset>
                <input class="input-switch" id="switch" type="checkbox" />
                <label for="switch"></label>
                <span class="switch-bg"></span>
                <span class="switch-labels" data-on="Hemp" data-off="Cannabis"></span>
            </fieldset>
            <div id="country" style="display:none;">{{$country['dropdown']}}</div>
            <div id="typehc" style="display:none;">{{empty($_COOKIE['type']) ? $cookie : $_COOKIE['type']}}</div>
            <select id="select-states"></select>
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