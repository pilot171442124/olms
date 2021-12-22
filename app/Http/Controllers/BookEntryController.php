<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\BookEntry;
use DB;
use Auth;

class BookEntryController extends Controller
{
    function getBookData(Request $request){
		$DepartmentId = $_POST['DepartmentId'];
		$search = $_POST['search']['value'];

		//datatable column index => database column name. here considaer datatable visible and novisible column
		
		$columns = array(2=>'BookName',3=>'AuthorName',4=>'TotalCopy',5=>'BookType',6=>'BookAccessType');

		//$totalData = BookEntry::count();

		$rowTotalObj = DB::table('t_books')
            ->join('t_booktypes', 't_books.BookTypeId', '=', 't_booktypes.BookTypeId')
            ->join('t_bookaccesstype', 't_books.BookAccessTypeId', '=', 't_bookaccesstype.BookAccessTypeId')
            ->join('t_department', 't_books.DepartmentId', '=', 't_department.DepartmentId')            
            ->select(DB::raw('count(*) as rcount'))
            ->where(function($query) use ($DepartmentId)
	          {
	            if($DepartmentId != 0):
	               $query->Where('t_books.DepartmentId','=', $DepartmentId);
	            endif;
	          })
	        ->where(function($query) use ($search)
	          {
	            if(!empty($search)):
	               $query->Where('BookName','like', '%' . $search . '%');
	               $query->orWhere('AuthorName','like', '%' . $search . '%');
	               $query->orWhere('BookType','like', '%' . $search . '%');
	               $query->orWhere('BookAccessType','like', '%' . $search . '%');
	               $query->orWhere('Department','like', '%' . $search . '%');
	            endif;
	          })
            ->get();


		$totalData = $rowTotalObj[0]->rcount;




		$limit = $_POST['length'];
		$start = $_POST['start'];
		//$order = $columns[$_POST['order'][0]['column']];
		//$dir = $_POST['order'][0]['dir'];

		

		$posts = DB::table('t_books')
            ->join('t_booktypes', 't_books.BookTypeId', '=', 't_booktypes.BookTypeId')
            ->join('t_bookaccesstype', 't_books.BookAccessTypeId', '=', 't_bookaccesstype.BookAccessTypeId')
            ->join('t_department', 't_books.DepartmentId', '=', 't_department.DepartmentId')
            ->select('t_books.*', 't_booktypes.BookType', 't_bookaccesstype.BookAccessType', 't_department.Department')
            ->where(function($query) use ($DepartmentId)
	          {
	            if($DepartmentId != 0):
	               $query->Where('t_books.DepartmentId','=', $DepartmentId);
	            endif;
	          })
	        ->where(function($query) use ($search)
	          {
	            if(!empty($search)):
	               $query->Where('BookName','like', '%' . $search . '%');
	               $query->orWhere('AuthorName','like', '%' . $search . '%');
	               $query->orWhere('BookType','like', '%' . $search . '%');
	               $query->orWhere('BookAccessType','like', '%' . $search . '%');
	               $query->orWhere('Department','like', '%' . $search . '%');
	            endif;
	          })
	        ->offset($start)
			->limit($limit)
			->orderByRaw("Department asc,BookName asc")
            ->get();

/*
		$posts = DB::table('t_books')
            ->join('t_booktypes', 't_books.BookTypeId', '=', 't_booktypes.BookTypeId')
            ->join('t_bookaccesstype', 't_books.BookAccessTypeId', '=', 't_bookaccesstype.BookAccessTypeId')
            ->select('t_books.*', 't_booktypes.BookType', 't_bookaccesstype.BookAccessType')
            
            ->where('BookName', 'LIKE', '%'.$search.'%')
            ->orWhere('AuthorName', 'LIKE', '%'.$search.'%')
			->orWhere('BookType', 'LIKE', '%'.$search.'%')
			->orWhere('BookAccessType', 'LIKE', '%'.$search.'%')

			->limit($limit)
			->orderByRaw("$order $dir")
            ->get();*/

		$data = array();

		if($posts){
			


		//	$x = "<a class='task-del fileUpload'  href='javascript:void(0);'><span class='label label-info'>File</span></a>";

			$fileNot = "<a class='task-del fileUpload'  href='javascript:void(0);'><span class='label label-lemon'><i class='fa fa-upload'></i></span></a>";
			$fileExist = "<a class='task-del fileUpload'  href='javascript:void(0);'><span class='label label-lemon'><i class='fa fa-file-pdf-o'></i></span></a>";


			$y = "<a class='task-del itmEdit' style='margin-left:4px' href='javascript:void(0);'><span class='label label-info'>Edit</span></a>";
			$z = "<a class='task-del itmDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";
			
			$serial = $_POST['start'] + 1;
			foreach($posts as $r){
				$arr['BookId'] = $r->BookId;
				$arr['Serial'] = $serial++;
				$arr['Department'] = $r->Department;
				$arr['BookName'] = $r->BookName;
				$arr['AuthorName'] = $r->AuthorName;
				$arr['TotalCopy'] = $r->TotalCopy;
				$arr['BookType'] = $r->BookType;
				$arr['BookAccessType'] = $r->BookAccessType;
				
				//Hard Copy = 1, Soft copy = 2
				if($r->BookTypeId == 1){
					$arr['action'] =$y.$z;
				}
				else{
					if($r->BookURL == ""){
						$arr['action'] =$fileNot.$y.$z;
					}
					else{
						$arr['action'] =$fileExist.$y.$z;
					}
				}

				


				$arr['BookTypeId'] = $r->BookTypeId;
				$arr['BookAccessTypeId'] = $r->BookAccessTypeId;
				$arr['BookURL'] = $r->BookURL;
				$arr['Remarks'] = $r->Remarks;
				$arr['DepartmentId'] = $r->DepartmentId;
				
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

     public function addEditBook(Request $request){

		/*when BookTypeId already exist then  update otherwise insert*/
		DB::table('t_books')
		    ->updateOrInsert(
		        ['BookId' => $request->input("recordId")],

		        ['DepartmentId' => $request->input("DepartmentId"), 
		        'BookTypeId' => $request->input("BookTypeId"), 
		        'BookName' => $request->input("BookName"),
		        'AuthorName' => $request->input("AuthorName"),
		        'TotalCopy' => $request->input("TotalCopy"),
		        'BookAccessTypeId' => $request->input("BookAccessTypeId"),
		        'Remarks' => $request->input("Remarks")]		       
		    );
    }

 	public function fileUpload(Request $request){

		$BookId = $request->input('idFileUp');
		$filePath = $request->file('file')->store('bookfile');

		DB::table('t_books')
		->where('BookId', $BookId)
		->update(['BookURL' => $filePath]);
    }

	 public function deleteBook(Request $request){
		$id = $request->input("id");

		$book = BookEntry::where('BookId',$id)->delete();
		return Response::json($book);
    }



	/*This is use in home page*/
	 function getPublicBookData(Request $request){

	 	
//$curruerrole = Auth::user()->userrole;
//echo $curruerrole;
			//datatable column index => database column name. here considaer datatable visible and novisible column
			
			$columns = array(0=>'BookId',1=>'BookName',2=>'AuthorName');

			$totalData = BookEntry::count();
			$limit = $_POST['length'];
			$start = $_POST['start'];
			$order = $columns[$_POST['order'][0]['column']];
			$dir = $_POST['order'][0]['dir'];

			$search = $_POST['search']['value'];



			if(Auth::check()){

				if(Auth::user()->userrole == "Other"){
					$posts = DB::table('t_books')
		            ->select('BookId','BookName','AuthorName','BookURL')
		            ->where('BookAccessTypeId','=','1')
		            ->where('BookTypeId','=','2')
		            ->when($search, function($query, $search) {
			                $query->Where('BookName', 'LIKE', '%'. $search .'%')
			                      ->orWhere('AuthorName', 'LIKE', '%'. $search .'%');
			            })
					->limit($limit)
					->orderByRaw("$order $dir")
		            ->get();
				}
				else{
			 		$posts = DB::table('t_books')
		            ->select('BookId','BookName','AuthorName','BookURL')
		            ->where('BookTypeId','=','2')
		            ->when($search, function($query, $search) {
			                $query->Where('BookName', 'LIKE', '%'. $search .'%')
			                      ->orWhere('AuthorName', 'LIKE', '%'. $search .'%');
			            })
					->limit($limit)
					->orderByRaw("$order $dir")
		            ->get();
				}

		 	}
		 	else{
		 		$posts = DB::table('t_books')
	            ->select('BookId','BookName','AuthorName','BookURL')
	            ->where('BookAccessTypeId','=','1')
	            ->where('BookTypeId','=','2')
	            ->when($search, function($query, $search) {
		                $query->Where('BookName', 'LIKE', '%'. $search .'%')
		                      ->orWhere('AuthorName', 'LIKE', '%'. $search .'%');
		            })
				->limit($limit)
				->orderByRaw("$order $dir")
	            ->get();
		 	}

			$data = array();

			if($posts){

				$fileDown = "<a class='task-del fileDownload'  href='javascript:void(0);'><span class='label label-lemon'><i class='fa fa-download'></i> Download</span></a>";
				

				if(Auth::check()){
					$isValid = 1;//Auth::user()->userrole;
				}
				else{
					$isValid = 0;
				}

				$serial = $_POST['start'] + 1;
				foreach($posts as $r){
					$arr['BookId'] = $r->BookId;
					$arr['BookName'] = $r->BookName;
					$arr['AuthorName'] = $r->AuthorName;					
					$arr['action'] = $fileDown;
					$arr['IsValid'] = $isValid;
					$arr['Url'] = $r->BookURL;
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

}
