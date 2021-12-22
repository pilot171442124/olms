<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\BookRequest;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class BookRequestController extends Controller
{
     function getBookRequestData(Request $request){

		$search = $_POST['search']['value'];
		//datatable column index => database column name. here considaer datatable visible and novisible column
		//$columns = array(2=>'RequestCode',3=>'RequestDate',4=>'BookName',5=>'Issued');
		$loginuserid = Auth::user()->id;


		$rowTotalObj = DB::table('t_bookrequest')
            ->join('t_books', 't_bookrequest.BookId', '=', 't_books.BookId')
            ->join('t_department', 't_department.DepartmentId', '=', 't_books.DepartmentId')
            ->select(DB::raw('count(*) as rcount'))
            ->where('UserId','=',$loginuserid)
            ->when($search, function($query, $search) {
	            	if(!empty($search)):
		                $query->Where('RequestCode', 'LIKE', '%'. $search .'%')
		                      ->orWhere('BookName', 'LIKE', '%'. $search .'%')
		                      ->orWhere('Department', 'LIKE', '%'. $search .'%');
	                endif;
	            })
            ->get();

		$totalData = $rowTotalObj[0]->rcount;
		
		$limit = $_POST['length'];
		$start = $_POST['start'];
		//$order = $columns[$_POST['order'][0]['column']];
		//$dir = $_POST['order'][0]['dir'];
		


		$posts = DB::table('t_bookrequest')
            ->join('t_books', 't_bookrequest.BookId', '=', 't_books.BookId')
            ->join('t_department', 't_department.DepartmentId', '=', 't_books.DepartmentId')
            ->select('t_bookrequest.*', 't_books.BookName', 't_department.Department')
            ->where('UserId','=',$loginuserid)
            ->when($search, function($query, $search) {
	            	if(!empty($search)):
		                $query->Where('RequestCode', 'LIKE', '%'. $search .'%')
		                      ->orWhere('BookName', 'LIKE', '%'. $search .'%')
		                      ->orWhere('Department', 'LIKE', '%'. $search .'%');

	                endif;
	            })
            ->offset($start)
			->limit($limit)
			->orderByRaw("RequestCode desc")
            ->get();

		$data = array();

		if($posts){
			

			$NoAction = "<span class='font-red'>No Action</span>";
			$z = "<a class='task-del itmDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";
			
			$serial = $_POST['start'] + 1;
			foreach($posts as $r){
				$arr['RequestId'] = $r->RequestId;
				$arr['Serial'] = $serial++;
				$arr['RequestCode'] = $r->RequestCode;
				$arr['RequestDate'] = $r->RequestDate;
				$arr['Department'] = $r->Department;
				$arr['BookName'] = $r->BookName;

				if($r->Status == 'Requested'){
					$arr['Status'] = "<span class='font-blue'>". $r->Status ."</span>";
					$arr['action'] = $z;
				}
				else if($r->Status == 'Canceled'){
					$arr['Status'] = "<span class='font-red'>". $r->Status ."</span>";
					$arr['action'] = $NoAction;
				}
				else if($r->Status == 'Accepted'){
					$arr['Status'] = "<span class='font-blue'>". $r->Status ."</span>";
					$arr['action'] = $NoAction;
				}
				else if($r->Status == 'Issued'){
					$arr['Status'] = "<span class='font-green'>Received</span>";
					$arr['action'] = $NoAction;
				}
				else if($r->Status == 'Dateover'){
					$arr['Status'] = "<span class='font-red'>Date Over</span>";
					$arr['action'] = $NoAction;
				}
				else if($r->Status == 'Returned'){
					$arr['Status'] = "<span class='font-green'>". $r->Status ."</span>";;
					$arr['action'] =$NoAction;
				}
				else{
					$arr['Status'] = "";;
					$arr['action'] = "";
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
		$curDateTime = date ( 'Y-m-d' );

		$loginuserid = Auth::user()->id;
		
		DB::table('t_bookrequest')
		    ->updateOrInsert(
		        ['RequestId' => $request->input("recordId")],

		        ['UserId' => $loginuserid, 
		        'RequestDate' => $curDateTime,
		        'RequestCode' => 'Req-'.time(),
		        'BookId' => $request->input("BookId"),
		        'RequestCopy' => 1,
		        'Status' => 'Requested']		       
		    );
    }
 */
	 public function deleteBookRequest(Request $request){
		$id = $request->input("id");

		$book = BookRequest::where('RequestId',$id)->delete();
		return Response::json($book);
    }


  public function getRequestedBookCountByUser()
  {
 	$bookCount = 0;
    
    $loginuserid = Auth::user()->id;

	$rowTotalObj = DB::table('t_bookrequest')
        ->select(DB::raw('count(*) as rcount'))
 		->where('UserId','=',$loginuserid)
        ->where('Status','=','Requested')
		//->toSql();
        ->get();

	$bookCount = $rowTotalObj[0]->rcount;
    
    return $bookCount;
  }



   function getBookListPopupData(Request $request){

		$totalData = 0;
	

		//already requested books
		$loginuserid = Auth::user()->id;
		$rbooks = DB::table('t_bookrequest')
           // ->select('t_bookrequest.*')
            ->where('UserId','=',$loginuserid)
            ->where('Status','=','Requested')
            ->get();
		
		$requestedBooks = array();
		if($rbooks){
			foreach($rbooks as $r){
				$requestedBooks[] = $r->BookId;

			}
		}




		$posts = DB::table('t_books')
            ->join('t_department', 't_books.DepartmentId', '=', 't_department.DepartmentId')
            ->select('t_books.*', 't_department.Department')
            ->where('BookTypeId','=',1)
            ->whereNotIn('BookId', $requestedBooks)
			->orderByRaw("Department asc, BookName asc")
			//->toSql();
            ->get();


		$data = array();

		if($posts){
	
			foreach($posts as $r){
				$arr['BookId'] = $r->BookId;
				$arr['Department'] = $r->Department;
				$arr['BookName'] = $r->BookName;
				$arr['AuthorName'] = $r->AuthorName;
				
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

	public function requestFromRequestEntry(Request $request){

		$bookList = $_POST['sBooks'];

		$curDateTime = date ( 'Y-m-d' );
		$loginuserid = Auth::user()->id;

		foreach($bookList as $BookId){
/*
			$book = DB::table('t_bookrequest')
              ->where('RequestId', $BookId)
              ->update(['Status' => 'Issued', 'IssueDate' => $curDateTime, 'IssueUserId' => $loginuserid]);

*/
          	
			/*when Bookreq already exist then  update otherwise insert*/
			$book = DB::table('t_bookrequest')
			    ->updateOrInsert(
			        ['RequestId' => 0],

			        ['UserId' => $loginuserid, 
			        'RequestDate' => $curDateTime,
			        'RequestCode' => 'Req-'.time(),
			        'BookId' => $BookId,
			        'RequestCopy' => 1,
			        'Status' => 'Requested']		       
			    );


		}

		return Response::json($book);
    }
    
}
