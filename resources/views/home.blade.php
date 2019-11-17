@extends("partials.layout")


@section("css_links")

@endsection


@section("content")
<div class="wrapper">
    <div class="container">
        @include('partials.mobileMenu')
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
            <div class="welcome-user">
                <p><a href="http://account.janeverde.com">Welcome, User</a></p>
                
            </div>
            <div class="clearfix"></div>
            <div class="home-wrap">
                @include('partials.leftMenu')
                @include('partials.mainCategories')
            </div>
        </div>
        @include("partials.footer")
    </div>
</div>
</div>

@section("js_links")
<script type="text/javascript" src={{asset('js/libraries/jquery.js')}}></script>
<script type="text/javascript" src={{asset('js/libraries/selectric.js')}}></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
<script type="text/javascript" src={{asset('js/main.js')}}></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="http://www.googletagmanager.com/gtag/js?id=UA-148323450-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148323450-1');
</script>

@endsection

@endsection