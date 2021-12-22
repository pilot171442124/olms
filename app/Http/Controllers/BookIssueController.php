<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\BookIssue;
use DB;
use Auth;


class BookIssueController extends Controller
{

	
   function getBookIssueData(Request $request){
   	
		$rowTotalObj = DB::table('t_bookrequest')
                     ->select(DB::raw('count(*) as rcount'))
                     ->where('Status','=','Issued')
            		->orWhere('Status','=','Returned')
                     ->get();

		$totalData = $rowTotalObj[0]->rcount;

		$limit = $_POST['length'];
		$start = $_POST['start'];
		//$order = $columns[$_POST['order'][0]['column']];
		//$dir = $_POST['order'][0]['dir'];
		$loginuserid = Auth::user()->id;


		$posts = DB::table('t_bookrequest')
            ->join('t_books', 't_bookrequest.BookId', '=', 't_books.BookId')
            ->join('users', 't_bookrequest.UserId', '=', 'users.id')
            ->select('t_bookrequest.*', 't_books.BookName', 'users.usercode', 'users.name')
            ->where('Status','=','Issued')
            ->orWhere('Status','=','Returned')

            ->offset($start)
			->limit($limit)
			->orderByRaw("IssueDate desc")
            ->get();

		$data = array();

		if($posts){
			
			//$NoAction = "<span class='label label-red-light'>No Action</span>";
			$issueDel = "<a class='task-del issueDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";
			$returnDel = "<a class='task-del returnDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";
			$return = "<a class='task-del returnItem' style='margin-left:4px' href='javascript:void(0);'><span class='label label-green'>Return</span></a>";
			
			$serial = $_POST['start'] + 1;

			foreach($posts as $r){
				$arr['RequestId'] = $r->RequestId;
				$arr['Serial'] = $serial++;
				$arr['IssueDate'] = $r->IssueDate;
				$arr['BookName'] = $r->BookName;
				$arr['RequestCode'] = $r->RequestCode;
				$arr['FineAmount'] = $r->FineAmount;
				$arr['usercode'] = $r->usercode;
				$arr['ReceiveDate'] = $r->ReceiveDate;

				if($r->Status == 'Issued'){
					$arr['Status'] = "<span class='font-blue'>". $r->Status ."</span>";
					$arr['action'] = $return . $issueDel;
				}
				else if($r->Status == 'Returned'){
					$arr['Status'] = "<span class='font-green'>". $r->Status ."</span>";
					$arr['action'] = $returnDel;
				}
				else if($r->Status == 'Dateover'){
					$arr['Status'] = "<span class='font-red'>". $r->Status ."</span>";
					$arr['action'] =  $return . $issueDel;
				}
				$arr['FinePaid'] = $r->FinePaid;
				
				
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



   function getBookRequestPopupData(Request $request){

		$totalData = 0;
	
		$posts = DB::table('t_bookrequest')
            ->join('t_books', 't_bookrequest.BookId', '=', 't_books.BookId')
            ->join('users', 't_bookrequest.UserId', '=', 'users.id')
            ->select('t_bookrequest.*', 't_books.BookName', 'users.usercode', 'users.name', 'users.userrole')
            ->where('Status','=','Accepted')
			->orderByRaw("RequestCode desc")
			//->toSql();
            ->get();


		$data = array();

		if($posts){
	
			foreach($posts as $r){
				$arr['RequestId'] = $r->RequestId;
				$arr['RequestCode'] = $r->RequestCode;
				$arr['RequestDate'] = $r->RequestDate;
				$arr['BookName'] = $r->BookName;
				$arr['usercode'] = $r->usercode;
				$arr['name'] = $r->name;
				
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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'RequestCode' => ['required', 'string', 'max:2']
        ]);
    }
*/
    /*
     public function addEditBookIssue(Request $request){
		date_default_timezone_set ( "Asia/Dhaka" );
		$curDateTime = date ( 'Y-m-d' );
		$loginuserid = Auth::user()->id;

	 	$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Issued', 'IssueDate' => $curDateTime, 'IssueUserId' => $loginuserid]);


		return Response::json($book);

    }*/
 
	

    
    public function issueFromRequestList(Request $request){

		$bookList = $_POST['sBooks'];
	 	//print_r($bookList);

		$curDateTime = date ( 'Y-m-d' );
		$loginuserid = Auth::user()->id;

	 	//$id = $request->input("id");
		foreach($bookList as $id){
			$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Issued', 'IssueDate' => $curDateTime, 'IssueUserId' => $loginuserid]);
		}

		return Response::json($book);
    }

	public function deleteBookIssue(Request $request){
	 	$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Accepted', 'IssueDate' => NULL, 'IssueUserId' => NULL]);

		return Response::json($book);
    }


	public function bookReturn(Request $request){

		$curDateTime = date ( 'Y-m-d' );
		$loginuserid = Auth::user()->id;

	 	$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Returned', 'ReceiveDate' => $curDateTime, 'ReceiveUserId' => $loginuserid]);

		return Response::json($book);
    }

     public function deleteBookReturn(Request $request){
	 	$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Issued', 'ReceiveDate' => NULL, 'ReceiveUserId' => NULL]);

		return Response::json($book);
    }
}
