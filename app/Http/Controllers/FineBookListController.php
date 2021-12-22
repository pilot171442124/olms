<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use DB;
use Auth;

class FineBookListController extends Controller
{
    function getFineBookListData(Request $request){
    	$UserId = $_POST['UserId'];
   	
		$rowTotalObj = DB::table('t_bookrequest')
                     ->select(DB::raw('count(*) as rcount'))
                     ->where('FineSMSCount','>',0)
                     ->where('FineAmount','>',0)
                     ->where(function($query) use ($UserId)
				          {
				            if($UserId != 0):
				               $query->Where('t_bookrequest.UserId','=', $UserId);
				            endif;
				          })
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
            ->where('FineSMSCount','>',0)
            ->where('FineAmount','>',0)
            ->where(function($query) use ($UserId)
	          {
	            if($UserId != 0):
	               $query->Where('t_bookrequest.UserId','=', $UserId);
	            endif;
	          })

            ->offset($start)
			->limit($limit)
			->orderByRaw("FinePaid asc, FineFirstSMSDate desc")
            ->get();

		$data = array();

		if($posts){
			
			$returnDel = "<a class='task-del returnDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";
			$return = "<a class='task-del returnItem' style='margin-left:4px' href='javascript:void(0);'><span class='label label-green'>Paid</span></a>";
			
			$serial = $_POST['start'] + 1;

			foreach($posts as $r){
				$arr['RequestId'] = $r->RequestId;
				$arr['Serial'] = $serial++;
				$arr['IssueDate'] = $r->IssueDate;
				$arr['BookName'] = $r->BookName;
				$arr['RequestCode'] = $r->RequestCode;
				$arr['usercode'] = $r->usercode;
				$arr['UserName'] = $r->name;
				$arr['FineAmount'] = $r->FineAmount;

				if($r->FinePaid == 0){
					$arr['Status'] = "<span class='font-red'>Not Paid</span>";
					$arr['action'] = $return;
				}
				else if($r->FinePaid == 1){
					$arr['Status'] = "<span class='font-green'>Paid</span>";
					$arr['action'] =  $returnDel;
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

function getFineAmountData(Request $request){

		$UserId = $_POST['UserId'];

		$posts = DB::table('t_bookrequest')
			->select(DB::raw("SUM(case when FinePaid=0 then FineAmount else 0 end) Unpaid, SUM(case when FinePaid=1 then FineAmount else 0 end) Paid"))
            ->where('FineSMSCount','>',0)
            ->where('FineAmount','>',0)
            ->where(function($query) use ($UserId)
	          {
	            if($UserId != 0):
	               $query->Where('t_bookrequest.UserId','=', $UserId);
	            endif;
	          })
            ->get();

		$data = array("Unpaid"=>0,"Paid"=>0);

		if($posts){

			foreach($posts as $r){
				$data['Unpaid'] = $r->Unpaid;
				$data['Paid'] = $r->Paid;
			}

			return $data;
		}
	}

   

	public function bookFinePayment(Request $request){

	 	$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['FinePaid' => 1]);

		return Response::json($book);
    }

     public function deleteBookFinePayment(Request $request){
	 	$id = $request->input("id");

		$book = DB::table('t_bookrequest')
              ->where('RequestId', $id)
              ->update(['FinePaid' => 0]);

		return Response::json($book);
    }
}
