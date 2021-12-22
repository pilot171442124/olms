<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    protected $table='t_post';
    protected $fillable=['PostId','PostDate','PostTitle','Post','userrole','UserId'];
}
