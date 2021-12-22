<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\DepartmentEntry;
use DB;

class DepartmentEntryController extends Controller
{
   
    function getDepartmentData(Request $request){

		//datatable column index => database column name. here considaer datatable visible and novisible column
		$columns = array(2=>'Department');

		$totalData = DepartmentEntry::count();
		$limit = $_POST['length'];
		$start = $_POST['start'];
		$order = $columns[$_POST['order'][0]['column']];
		$dir = $_POST['order'][0]['dir'];

		$search = $_POST['search']['value'];
		

		$posts= DepartmentEntry::offset($start)
		->where('Department', 'LIKE', '%'.$search.'%')
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
				$arr['DepartmentId'] = $r->DepartmentId;
				$arr['Serial'] = $serial++;				
				$arr['Department'] = $r->Department;
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

     public function addEditDepartment(Request $request){

		/*when DepartmentId already exist then  update otherwise insert*/
		DB::table('t_department')
		    ->updateOrInsert(
		        ['DepartmentId' => $request->input("recordId")],
		        ['Department' => $request->input("Department")]
		    );
    }

    public function deleteDepartment(Request $request){
		$id = $request->input("id");

		$result = DepartmentEntry::where('DepartmentId',$id)->delete();
		return Response::json($result);
    }
}
