@extends("partials.layout")


@section("css_links")

@endsection


@section("content")
<div class="wrapper">
    <div>
        @include('partials.mobileMenu')
        <div class="container">
            <div class="outer-wrap">
                <div class="welcome-user">
                    <p>@include('partials.userAndLogout')</p>
                    <div class="clearfix"></div>
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