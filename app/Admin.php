<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $table = 'administration';

    protected $fillable = [
        'id', 'name', 'email', 'phone', 'image', 'password', 'type', 'remember_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = true;

//    public function getAuthPassword()
//    {
//        return $this->administration_password;
//    }

}
