<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookAccessType;

class BookAccessTypeController extends Controller
{
    function getBookAccessTypeData(Request $request){

		//datatable column index => database column name. here considaer datatable visible and novisible column
		$columns = array(2=>'BookAccessType');

		$totalData = BookAccessType::count();
		$limit = $_POST['length'];
		$start = $_POST['start'];
		$order = $columns[$_POST['order'][0]['column']];
		$dir = $_POST['order'][0]['dir'];

		$search = $_POST['search']['value'];
		

		$posts= BookAccessType::offset($start)
		//->where('BookType', 'like', '%Ha%')
		->where('BookAccessType', 'LIKE', '%'.$search.'%')
		//->orWhere('BookAccessType', 'LIKE', '%'.$search.'%')
		->offset($start)
		->limit($limit)
		->orderByRaw("$order $dir")
		->get();

		$data = array();

		if($posts){

			$serial = $_POST['start'] + 1;
			foreach($posts as $r){
				$arr['BookAccessTypeId'] = $r->BookAccessTypeId;
				$arr['Serial'] = $serial++;				
				$arr['BookAccessType'] = $r->BookAccessType;
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
