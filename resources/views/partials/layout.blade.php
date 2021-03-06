<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>@yield('title','Jane Verde')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="@yield('description','')">
    <meta name="author" content="Jane Verde">
    <meta name="google-site-verification" content="">
    <META NAME="ROBOTS" CONTENT="@yield('robots','INDEX, FOLLOW')">

    <meta property="og:url" content="https://www.janeverde.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title','Jane Verde')">
    <meta property="og:description" content="@yield('description','')">
    <meta property="og:image" content="{{asset('images/cannabis-background.jpg')}}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-89265552-2"></script>

    {{-- <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-89265552-2');
    </script> --}}

    {{-- <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"> --}}
    @yield('css_links')

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" type="image/png" href="{{asset('images/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" type="text/css" href={{asset('css/app.css')}}>
</head>

<body>
    <div id="accept-cookies">
        <p>This website uses cookies to ensure you get the best experience.</p>
        <a href="{{asset('/terms-of-use')}}">Learn More</a><br/>
        <button onclick="acceptCookies(this)">Accept Cookies</button>
    </div>
    {{-- @include("partials.navigation") --}}
    @yield('content')


    <script type="text/javascript">
        // laravel blade non-escaped bracets
    var config = {
        baseUrl: {!! json_encode(url('/')) !!}
    }
    </script>


    @yield('js_links')
</body>

</html>