<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Pheye\Payments\Traits\Paymentable;
use TCG\Voyager\Traits\VoyagerUser;

class User extends Authenticatable
{
    use Notifiable, Paymentable, VoyagerUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fixInfoByPayments()
    {
    }
}
