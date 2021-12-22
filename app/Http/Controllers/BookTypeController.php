<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\BookType;
use DB;

class BookTypeController extends Controller
{
 

    function getBookTypeData(Request $request){
		//echo '<pre>';
		//print_r( $_POST);

		//datatable column index => database column name. here considaer datatable visible and novisible column
		$columns = array(2=>'BookType');

		$totalData = BookType::count();
		
		$limit = $_POST['length'];
		$start = $_POST['start'];
		$order = $columns[$_POST['order'][0]['column']];
		$dir = $_POST['order'][0]['dir'];

		$search = $_POST['search']['value'];
		

		$posts= BookType::offset($start)
		//->where('BookType', 'like', '%Ha%')
		->where('BookTypeId', 'LIKE', '%'.$search.'%')
		->orWhere('BookType', 'LIKE', '%'.$search.'%')
		->offset($start)
		->limit($limit)
		->orderByRaw("$order $dir")
		->get();

		$data = array();

		if($posts){

			$y = "<a class='task-del itmEdit' href='javascript:void(0);'><span class='label label-info'>Edit</span></a>";
			$z = "<a class='task-del itmDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";
			
			$serial = $_POST['start'] + 1;
			foreach($posts as $r){
				$arr['BookTypeId'] = $r->BookTypeId;
				$arr['Serial'] = $serial++;				
				$arr['BookType'] = $r->BookType;
				$arr['action'] =$y.$z;
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

     public function addEditBookType(Request $request){

		/*when BookTypeId already exist then  update otherwise insert*/
		DB::table('t_booktypes')
		    ->updateOrInsert(
		        ['BookTypeId' => $request->input("recordId")],
		        ['BookType' => $request->input("BookType")]
		    );

		/*
		//this is for only insert
		$bookType = new BookType;
			$bookType->BookType = $request->input("BookType");
			$bookType->save();
		*/

		//if we want to response
		//return Response::json($bookType);
    }

    public function deleteBookType(Request $request){
		$id = $request->input("id");

		$bookType = BookType::where('BookTypeId',$id)->delete();
		return Response::json($bookType);
    }
}