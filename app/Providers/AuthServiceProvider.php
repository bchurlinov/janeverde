<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //admin policy
        Gate::define('isAdmin', function($user){
            return $user->role == 'admin';
        });

        //buyer policy
        Gate::define('isBuyer', function($user){
            return $user->role == 'buyer';
        });

        //seller policy
        Gate::define('isSeller', function($user){
            return $user->role == 'seller';
        });

        //if verified policy
        Gate::define('isVerified', function($user){
            return $user->verified == 1;
        });
    }
}
