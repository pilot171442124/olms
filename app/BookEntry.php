<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookEntry extends Model
{
    protected $table='t_books';
    protected $fillable=['BookId','DepartmentId','BookTypeId','BookName','AuthorName','TotalCopy','BookAccessTypeId','BookURL','Remarks'];
}
