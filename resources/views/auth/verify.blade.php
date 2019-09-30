@extends('partials.layout')

@section('css_links')

@endsection

@section('content')
<div align="right">
    {{"Welcome " . auth()->user()->name . " to your dashboard | "}}
    @if(Gate::check('isVerified') && Gate::check('isBuyer'))
        <a href="{{route('home')}}">Home</a>
        <a href="/changePassword">Change password</a>
        <a href="/myproducts">My purchased items</a>
        <a class="dropdown-item" href="/settings">Profile settings</a>
    @endif
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault();
   document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('partials.footer')

@section('js_links')
    <script type="text/javascript" src={{asset('js/libraries/jquery.js')}}></script>
    <script type="text/javascript" src={{asset('js/libraries/selectric.js')}}></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
    <script type="text/javascript" src={{asset('js/auth.js')}}></script>
    <script type="text/javascript" src={{asset('js/main.js')}}></script>
@endsection
