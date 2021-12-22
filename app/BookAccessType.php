<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookAccessType extends Model
{
    protected $table='t_bookaccesstype';
    protected $fillable=['BookAccessTypeId','BookAccessType'];
}
