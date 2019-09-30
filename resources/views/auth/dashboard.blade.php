@extends('partials.layout')

@section('css_links')

@endsection

@section('content')
<div align="right">
    {{"Welcome " . $user->name . " to your dashboard | "}}
    <a href="{{route('home')}}">Home</a>
    <a href="/changePassword">Change password</a>
    @if(Gate::check('isVerified') && Gate::check('isBuyer'))
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

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <strong>{{ $message }}</strong>
    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong>  There was a problem while uploading your picture ID.
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div align="center">
    <br />
    @if($user->is_verified != 1)
        @if($user->is_verified == 0 || $user->is_verified == -1)
            @if($user->is_verified == 0)
                {{"You are not verified. please upload your picture ID"}}
            @elseif($user->is_verified == -1)
                {{"Administrator has removed your ID. Please re-upload your picture ID"}}
            @endif
            <form action="{{ route('uploadID') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </form>
        @elseif($user->is_verified == 2)
            {!! "Your picture id is uploaded. Please wait for an administrator to verify your ID.<br /><br />Uploaded ID:<br>" !!}
            <img src="pictureID/{{$user->id_pic_name}}" width="300" height="200" />
        @endif
    @elseif($user->is_verified == 1)
        {{"You are verified!"}}
    @endif
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
