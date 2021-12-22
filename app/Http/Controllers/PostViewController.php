<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\PostView;
use DB;
use Auth;

class PostViewController extends Controller
{
    function getPostData(Request $request){

		$loginuserid = Auth::user()->id;
        $loginuserrole = Auth::user()->userrole;
/*
        $posts = DB::table('t_post')
			->where('UserId', '=',  $loginuserid)
			->orderByRaw("PostDate desc")
            ->get();
*/

		$posts = DB::table('t_post')
            ->join('users', 't_post.UserId', '=', 'users.id')
            ->select('t_post.*', 'users.name', 'users.userrole')
            /*->where('UserId','=',$loginuserid)*/
            ->where(function($query) use ($loginuserrole)
                  {
                       $query->Where('t_post.userrole','=',  'All');
                       $query->orWhere('t_post.userrole','=', $loginuserrole);
                  })

			->orderByRaw("PostDate desc")
            ->get();

//All


            echo json_encode($posts);

	}

}
