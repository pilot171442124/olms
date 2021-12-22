<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\UserEntry;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserEntryController extends Controller
{
     function getUserData(Request $request){

		//datatable column index => database column name. here considaer datatable visible and novisible column
		
		$columns = array(2=>'name',3=>'usercode',4=>'phone',5=>'email',6=>'userrole',7=>'activestatus');

		$totalData = UserEntry::count();
		$limit = $_POST['length'];
		$start = $_POST['start'];
		$order = $columns[$_POST['order'][0]['column']];
		$dir = $_POST['order'][0]['dir'];

		$search = $_POST['search']['value'];

		$posts = DB::table('users')
            ->select('id','name','usercode','email','userrole','activestatus','password','phone')
            ->where('name', 'LIKE', '%'.$search.'%')
			->orWhere('usercode', 'LIKE', '%'.$search.'%')
			->orWhere('phone', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
			->orWhere('userrole', 'LIKE', '%'.$search.'%')
			->orWhere('activestatus', 'LIKE', '%'.$search.'%')
			->offset($start)
			->limit($limit)
			->orderByRaw("$order $dir")
            ->get();

		$data = array();

		if($posts){

			//$fileNot = "<a class='task-del fileUpload'  href='javascript:void(0);'><span class='label label-lemon'><i class='fa fa-upload'></i></span></a>";
			//$fileExist = "<a class='task-del fileUpload'  href='javascript:void(0);'><span class='label label-lemon'><i class='fa fa-file-pdf-o'></i></span></a>";


			$y = "<a class='task-del itmEdit' style='margin-left:4px' href='javascript:void(0);'><span class='label label-info'>Edit</span></a>";
			$z = "<a class='task-del itmDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";
			
			$serial = $_POST['start'] + 1;
			foreach($posts as $r){
				$arr['id'] = $r->id;
				$arr['Serial'] = $serial++;
				$arr['name'] = $r->name;
				$arr['usercode'] = $r->usercode;
				$arr['phone'] = $r->phone;
				$arr['email'] = $r->email;
				$arr['userrole'] = $r->userrole;
				$arr['activestatus'] = $r->activestatus;
				$arr['action'] =$y.$z;
				$arr['password'] = $r->password;
				
				$data[] = $arr;
			}

			$json_data = array(
				"iTotalRecords"=> intval($totalData),
				"iTotalDisplayRecords"=> intval($totalData),
				"draw"=>intval($request->input('draw')),
				"recordsTotal"=> intval($totalData),
				"data"=>$data
			);

			echo json_encode($json_data);
		}
	}

     public function addEditUser(Request $request){
		$curDateTime = date ( 'Y-m-d H:i:s' );

		$validatedData = $request->validateWithBag('post', [
		    'email' => ['required', 'unique:users', 'max:255']
		]);

		/*when id already exist then  update otherwise insert*/
		$obj = DB::table('users')
		    ->updateOrInsert(
		        ['id' => $request->input("recordId")],

		        ['name' => $request->input("name"), 
		        'usercode' => $request->input("usercode"), 
		        'phone' => $request->input("phone"), 
		        'email' => $request->input("email"),
		        'userrole' => $request->input("userrole"),
		        'activestatus' => $request->input("activestatus"),
		        'password' => Hash::make($request->input("password")),
		        'LastPostViewDate' => $curDateTime]		       
		    );
		   // echo $obj;


			//send_sms($request->input("name"), $request->input("phone"), $request->input("email"), $request->input("password"));

			
				


    }


 	public function newUserSendSMS(Request $request){

		//SMS send

		$userName=$request->input("name");
		$phone=$request->input("phone");
		$email=$request->input("email");
		$password=$request->input("password");
		//POST Method example
		$url = "http://66.45.237.70/api.php";
		// $number="88017,88018,88019";
		// $number="01689763654";// we can multiple number using coma seperator
		// $message="Hello Bangladesh";
		$message="Hello $userName, You are registered in olms site. Your Email: $email and password: $password";

		$data= array(
			'username'=>"pilot",
			'password'=>"Z2PE7AY3",
			'number'=>$phone,
			'message'=>"$message"
		);
		
		$ch = curl_init(); // Initialize cURL
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$smsresult = curl_exec($ch);
		$p = explode("|",$smsresult);
		$sendstatus = $p[0];

    }


     public function editUser(Request $request){

		/*when id already exist then  update otherwise insert*/
		DB::table('users')
		    ->updateOrInsert(
		        ['id' => $request->input("recordIdedit")],

		        ['name' => $request->input("nameedit"), 
		        'usercode' => $request->input("usercodeedit"), 
		        'phone' => $request->input("phoneedit"), 
		        'email' => $request->input("emailedit"),
		        'userrole' => $request->input("userroleedit"),
		        'activestatus' => $request->input("activestatusedit")]		       
		    );
    }

	 public function deleteUser(Request $request){
		$id = $request->input("id");

		$user = UserEntry::where('id',$id)->delete();
		return Response::json($user);
    }

}
