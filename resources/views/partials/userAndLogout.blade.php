<?php
use App\User;
$reactOrLaravelUser = 0;

if(auth()->user() || !empty($_COOKIE['_main'])){
    if(!empty($_COOKIE['_main'])){
        $user = $_COOKIE['_main'];
        $user = User::find($user);
        if($user != null){
            $name = ucfirst($user->name);
            $dashboard = config('variables.reacturl');
            echo "Welcome, <a href='$dashboard'><b>" .$name . "</b></a>";
            $reactOrLaravelUser = 1;
        }        
    }
    else{ 
        $name = ucfirst(auth()->user()->name);
        $dashboard = "/dashboard";
        $reactOrLaravelUser = 2;
        echo "Welcome <a href='$dashboard'><b>" .$name . "</b></a>";
    }
    ?>
    
    @if($reactOrLaravelUser == 2)
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endif
<?php } ?>