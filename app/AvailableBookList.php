<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableBookList extends Model
{
    protected $table='t_books';
    protected $fillable=['BookId','BookTypeId','BookName','AuthorName','TotalCopy','BookAccessTypeId','BookURL','Remarks'];
}
