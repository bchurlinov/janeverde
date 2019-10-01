<div class="home-wrap__item">
    <div class="inner-wrap">
        <h1><a href="/"><img src="{{asset('/images/Janeverde_logo.svg')}}" /></a></h1>
        <div class="toggle-countries toggle-desktop">
            <fieldset>
                <input class="input-switch" id="switch" type="checkbox" />
                <label for="switch"></label>
                <span class="switch-bg"></span>
                <span class="switch-labels" data-on="Hemp" data-off="Cannabis"></span>
            </fieldset>
            <div id="country" style="display:none;">{{$country}}</div>
            <select id="select-states"></select>
        </div>
        <div class="listing-account">
            <a href="/auth" class="button-link">Create Listing</a>
            <a href="/auth" class="button-link">My Account</a>
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