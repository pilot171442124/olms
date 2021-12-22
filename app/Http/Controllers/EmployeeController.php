<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{
     function list(){
    	$employees = Employee::all();
    	return view('employees')->with('employees',$employees);
    }

    function getEmployee(Request $request){

		$columns = array('id','name','email');

		$posts = Employee::all();

		$data = array();

		if($posts){

			$y = "<a class='task-del itmEdit' href='javascript:void(0);'><span class='label label-info'>Edit</span></a>";
			$z = "<a class='task-del itmDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";

			foreach($posts as $r){
				$arr['id'] = $r->id;
				$arr['name'] = $r->name;
				$arr['email'] = $r->email;
				$arr['action'] =$y.$z;
				$data[] = $arr;
			}

			$json_data = array(
				"data"=> intval(0),
				"recordsTotal"=>intval(0),
				"data"=>$data
			);

			echo json_encode($json_data);
		}
    }


    public function addEmployee(Request $request){
    	$employee = new Employee;

		$employee->id = $request->input("id");
		$employee->name = $request->input("name");
		$employee->email = $request->input("email");


		$employee->save();
    }

}
