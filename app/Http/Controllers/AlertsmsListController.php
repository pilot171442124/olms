<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\BookRequestList;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class AlertsmsListController extends Controller
{
     function getBookAlertSMSData(Request $request){
		
		$rowTotalObj = DB::table('t_bookrequest')
                     ->select(DB::raw('count(*) as rcount'))
                     ->whereNotNull('RetSMSDate')
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
            ->select('t_bookrequest.*', 't_books.BookName', 'users.usercode', 'users.name', 'users.phone','users.userrole')
            ->whereNotNull('RetSMSDate')

            ->offset($start)
			->limit($limit)
			->orderByRaw("RetSMSDate desc")
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
				$arr['RetSMSDate'] = $r->RetSMSDate;
				$arr['BookName'] = $r->BookName;
				$arr['RequestCode'] = $r->RequestCode;
				$arr['usercode'] = $r->usercode;
				$arr['UserName'] = $r->name;
				$arr['Phone'] = $r->phone;
				
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

	 public function cancelBookRequest(Request $request){
		$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Canceled']);


		return Response::json($book);
    }

    public function acceptedBookRequest(Request $request){
		$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['Status' => 'Accepted']);


		return Response::json($book);
    }

}
