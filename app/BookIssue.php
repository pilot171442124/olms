<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookIssue extends Model
{
    protected $table='t_bookrequest';
   protected $fillable=['RequestId','UserId','RequestDate','RequestCode','BookId','RequestCopy','Status','CancelDate','CancelUserId','IssueDate','IssueUserId','ReceiveDate','ReceiveUserId'];
}