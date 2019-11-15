@php
use App\User;
@endphp
<div class="home-wrap__item">
    <div class="inner-wrap">
        @php
        $country = json_decode(session()->get('country'), true);
        $cookieSet = session()->get('type') == null ? "hemp" : session()->get('type');
        @endphp
        <h1><a href="/"><img src="{{asset('/images/Janeverde_logo.svg')}}" /></a></h1>
        <div class="toggle-countries toggle-desktop">

            @php
            $disabled = "disabled title='Log in to be able to toggle between Hemp and Cannabis'";
            if(!empty($_COOKIE['_main']) || auth()->user() != null){
                $disabled = "";
            }
            //check for logged in user
            $showVerifyLink = false;
            $user = 0;
            if(!empty($_COOKIE['_main']) || auth()->user() != null){
                if(!empty($_COOKIE['_main'])){
                    $user = $_COOKIE['_main'];
                    $user = User::find($user);
                    if($user != null && $user->verification_step_1 == 0){
                    $showVerifyLink = true;
                    }
                }
            }
            @endphp
            <div class="hemp-cannabis-toggle">
                <button class="ctype {{$cookieSet == "hemp" ? "toggle-active" : ""}}" id="hemp" {!! $disabled !!}>HEMP</button>
                <button class="ctype {{$cookieSet == "cannabis" ? "toggle-active" : "" }}" id="cannabis" {!! $disabled !!}>CANNABIS</button>
            </div>

            <div id="country" style="display:none;">{{$country['dropdown']}}</div>
            <div id="typehc" style="display:none;">{{$cookieSet}}</div>
            @if (request()->segment(1) !== "view")
            <select id="select-states"></select>
            @endif
        </div>
        <div class="listing-account">
            <a href="{{config('variables.reacturl')}}" class="button-link">User Account</a>
            <a href="{{config('variables.phpurl')}}/auth" class="button-link">Owner Account</a>
        </div>
        <div class="useful-links">
        @if($showVerifyLink)
            <a href="http://account.jv.com/verification-step" class="button-link" data-account="verify" >
                <img src="{{asset('images/shield_green.svg')}}" alt="Jane Verde SVG Icon" />
                Verify Account
            </a>
        @endif
            <a href="javascript:;" class="button-link">Help / Faq</a>
            <a href="/privacy-policy" class="button-link">Privacy Policy</a>
            <a href="/terms-of-use" class="button-link">Terms of Use</a>
            <a href="javascript:;" class="button-link">Avoid Scams & Fraud</a>
        </div>
    </div>
</div>