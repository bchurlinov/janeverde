<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements /*MustVerifyEmail,*/JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    //industrial license relation
    public function industrialLicense(){
        return $this->hasOne('App\IndustrialLicense');
    }

    public function businessLicense(){
        return $this->hasOne('App\BusinessLicense');
    }

    public function pictureID(){
        return $this->hasOne('App\PictureID');
    }

    //user country relation
    public function country(){
        return $this->hasOne('App\Countries', 'name', 'country');
    }

    //user products
    public function products(){
        return $this->hasMany('App\Product');
    }

    public function postsCount(){
        return "1";
    }

    public function supportingDocuments(){
        return $this->hasOne('App\SupportingDocuments');
    }
}
