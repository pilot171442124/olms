<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentEntry extends Model
{
	protected $table='t_department';
    protected $fillable=['DepartmentId','Department'];
}
