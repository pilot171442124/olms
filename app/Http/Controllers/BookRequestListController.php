<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\BookRequestList;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class BookRequestListController extends Controller
{
    function getBookRequestData(Request $request){
		
		$search = $_POST['search']['value'];

		$rowTotalObj = DB::table('t_bookrequest')
            ->join('t_books', 't_bookrequest.BookId', '=', 't_books.BookId')
            ->join('users', 't_bookrequest.UserId', '=', 'users.id')
   
             ->select(DB::raw('count(*) as rcount'))
             
            ->where(function($query) use ($search)
              {
                   $query->Where('Status','=', 'Requested');
                   $query->orWhere('Status','=', 'Accepted');
              })

            ->where(function($query) use ($search)
              {
                if(!empty($search)):
                   $query->where('RequestCode', 'LIKE', '%'. $search .'%')
	                      ->orWhere('BookName', 'LIKE', '%'. $search .'%')
	                      ->orWhere('usercode', 'LIKE', '%'. $search .'%')
	                      ->orWhere('name', 'LIKE', '%'. $search .'%')
	                      ->orWhere('userrole', 'LIKE', '%'. $search .'%');
                endif;
              })
             ->get();

		$totalData = $rowTotalObj[0]->rcount;


		$start = $_POST['start'];
		$limit = $_POST['length'];

		//$order = $columns[$_POST['order'][0]['column']];
		//$dir = $_POST['order'][0]['dir'];
		//$loginuserid = Auth::user()->id;

		
		//echo $search;
	 	$posts = DB::table('t_bookrequest')
            ->join('t_books', 't_bookrequest.BookId', '=', 't_books.BookId')
            ->join('users', 't_bookrequest.UserId', '=', 'users.id')
            ->select('t_bookrequest.*', 't_books.BookName', 'users.usercode', 'users.name', 'users.userrole')

            ->where(function($query) use ($search)
              {
                   $query->Where('Status','=', 'Requested');
                   $query->orWhere('Status','=', 'Accepted');
              })

            ->where(function($query) use ($search)
              {
                if(!empty($search)):
                   $query->where('RequestCode', 'LIKE', '%'. $search .'%')
	                      ->orWhere('BookName', 'LIKE', '%'. $search .'%')
	                      ->orWhere('usercode', 'LIKE', '%'. $search .'%')
	                      ->orWhere('name', 'LIKE', '%'. $search .'%')
	                      ->orWhere('userrole', 'LIKE', '%'. $search .'%');
                endif;
              })

            ->offset($start)
			->limit($limit)
			->orderByRaw("RequestCode desc")
			// ->toSql();
            ->get();

//var_dump($posts); // Show results of log
/*
string(414) "select `t_bookrequest`.*, `t_books`.`BookName`, `users`.`usercode`, `users`.`name`, `users`.`userrole`
 from `t_bookrequest` inner join `t_books` on `t_bookrequest`.`BookId` = `t_books`.`BookId`
  inner join `users` on `t_bookrequest`.`UserId` = `users`.`id` 
  where `Issued` = ? 
  and `RequestCode` LIKE ? or `BookName` LIKE ? or `usercode` LIKE ? or `name` LIKE ? or `userrole` 
  LIKE ? order by RequestCode desc limit 10"
*/

		$data = array();

		if($posts){
			
			$y = "<a class='task-del itmAccept' style='margin-left:4px' href='javascript:void(0);'><span class='label label-info'>Accept</span></a>";
			$z = "<a class='task-del itmDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Cancel</span></a>";

			$serial = $_POST['start'] + 1;
			foreach($posts as $r){
				$arr['RequestId'] = $r->RequestId;
				$arr['Serial'] = $serial++;
				$arr['RequestCode'] = $r->RequestCode;
				$arr['RequestDate'] = $r->RequestDate;
				$arr['BookName'] = $r->BookName;
				$arr['userrole'] = $r->userrole;
				$arr['usercode'] = $r->usercode;
				$arr['name'] = $r->name;

				if($r->Status == "Accepted"){
					$arr['action'] = "<span class='font-green'>".$r->Status."</span>";
				}
				else{
					$arr['action'] =$y.$z;
				}
				
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

/*
	 public function addEditBookRequest(Request $request){
		date_default_timezone_set ( "Asia/Dhaka" );
		$curDateTime = date ( 'Y-m-d' );

		$loginuserid = Auth::user()->id;
		//when Bookreq already exist then  update otherwise insert
		DB::table('t_bookrequest')
		    ->updateOrInsert(
		        ['RequestId' => $request->input("recordId")],

		        ['UserId' => $loginuserid, 
		        'RequestDate' => $curDateTime,
		        'RequestCode' => 'Req-'.time(),
		        'BookId' => $request->input("BookId"),
		        'RequestCopy' => 1,
		        'Status' => 'Request']		       
		    );
    }
 */
	 public function cancelBookRequest(Request $request){
		$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Canceled']);
		
		self::SendSMS($id, 'Canceled');

		return Response::json($book);
    }

    public function acceptedBookRequest(Request $request){
		$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Accepted']);

		self::SendSMS($id, 'Accepted');

		return Response::json($book);
    }



    public function SendSMS($RequestId, $Status){

		$posts = DB::table('t_bookrequest')
            ->join('t_books', 't_bookrequest.BookId', '=', 't_books.BookId')
            ->join('users', 't_bookrequest.UserId', '=', 'users.id')
            ->select('t_bookrequest.*', 't_books.BookName', 'users.phone', 'users.name')
            ->where('RequestId','=',$RequestId)
            ->get();



		if($posts){

			foreach($posts as $r){

					//SMS send
					$userName=$r->name;
					$bookName=$r->BookName;
					$phone=$r->phone;

					//POST Method example
					$url = "http://66.45.237.70/api.php";
					// $number="88017,88018,88019";
					// $number="01689763654";// we can multiple number using coma seperator
					// $message="Hello Bangladesh";

					if($Status == 'Accepted'){
						$message="Hello $userName, Your request has been apccepted of $bookName book";
					}
					else{
						$message="Hello $userName, Your request has been canceled of $bookName book";
					}

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
		}





    }


}
