<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table='users';
    protected $fillable=['id','name','email','userrole','activestatus','password','phone','LastPostViewDate'];
}
