<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    protected $table='t_booktypes';
    protected $fillable=['BookTypeId','BookType'];
}
