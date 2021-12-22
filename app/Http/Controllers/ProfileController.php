<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Redirect,Response;
use App\Profile;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
   function getProfileData(Request $request){

		$loginuserid = Auth::user()->id;
        //$loginuserrole = Auth::user()->userrole;

		$posts = DB::table('users')
            //->join('users', 'users.UserId', '=', 'users.id')
            //->select('users.*', 'users.name', 'users.userrole')
            ->select('users.*')
            ->where('id','=',$loginuserid)
            ->get();

            echo json_encode($posts);
	}

	 public function editMyProfile(Request $request){
		$loginuserid = Auth::user()->id;

		$affected = DB::table('users')
          ->where('id', $loginuserid)
          ->update(['name' => $request->input("name"),
          	'email' => $request->input("email"),
          	'phone' => $request->input("phone"),
          	'password' => Hash::make($request->input("password"))]);
    }
}
