<?php
use App\User;
$reactOrLaravelUser = 0;

if(auth()->user() || !empty($_COOKIE['_main'])){
    if(!empty($_COOKIE['_main'])){
        $user = $_COOKIE['_main'];
        $user = User::find($user);
        $name = $user->name;
        $lastname = $user->lastname;
        $dashboard = config('variables.reacturl');
        $reactOrLaravelUser = 1;
    }
    else{ 
        $name = auth()->user()->name;
        $lastname = auth()->user->lastname;
        $dashboard = "/dashboard";
        $reactOrLaravelUser = 2;
    }
    ?>
    {!! "Welcome <a href='$dashboard'>" .substr($name, 0, 1) . " " . substr($lastname, 0, 1) . "</a>" !!}
    
    @if($reactOrLaravelUser == 2)
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endif
<?php } ?>