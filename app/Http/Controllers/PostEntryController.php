<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\PostEntry;
use DB;
use Auth;
class PostEntryController extends Controller
{
   function getPostData(Request $request){

		//datatable column index => database column name. here considaer datatable visible and novisible column
		
		$columns = array(2=>'PostDate',3=>'PostTitle',4=>'Post');
		$loginuserid = Auth::user()->id;

		$limit = $_POST['length'];
		$start = $_POST['start'];
		//$order = $columns[$_POST['order'][0]['column']];
		//$dir = $_POST['order'][0]['dir'];
		$search = $_POST['search']['value'];

		$rowTotalObj = DB::table('t_post')
                     ->select(DB::raw('count(*) as rcount'))
                     ->where('UserId', '=', $loginuserid)
                     ->where(function($query) use ($search)
		              {
		                if(!empty($search)):
		                   $query->Where('PostTitle','like', '%' . $search . '%');
		                   $query->orWhere('Post','like', '%' . $search . '%');
		                endif;
		              })
                     ->get();
		$totalData = $rowTotalObj[0]->rcount;


		

        $posts = DB::table('t_post')
			->where('UserId', '=',  $loginuserid)
			->where(function($query) use ($search)
              {
                if(!empty($search)):
                   $query->Where('PostTitle','like', '%' . $search . '%');
                   $query->orWhere('Post','like', '%' . $search . '%');
                endif;
              })
			->offset($start)
			->limit($limit)
			->orderByRaw("PostDate desc")
            ->get();


		$data = array();

		if($posts){

			$y = "<a class='task-del itmEdit' style='margin-left:4px' href='javascript:void(0);'><span class='label label-info'>Edit</span></a>";
			$z = "<a class='task-del itmDrop' style='margin-left:4px' href='javascript:void(0);'><span class='label label-danger'>Delete</span></a>";
			
			$serial = $_POST['start'] + 1;
			foreach($posts as $r){


				$arr['PostId'] = $r->PostId;
				$arr['Serial'] = $serial++;
				$arr['PostDate'] = $r->PostDate;
				$arr['PostTitle'] = $r->PostTitle;
				$arr['Post'] = $r->Post;
				$arr['PostTo'] = $r->userrole;
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

     public function addEditPost(Request $request){

		$loginuserid = Auth::user()->id;
		$curDateTime = date ( 'Y-m-d H:i:s' );
		/*when post already exist then  update otherwise insert*/
		DB::table('t_post')
		    ->updateOrInsert(
		        ['PostId' => $request->input("recordId")],

		        ['PostDate' => $curDateTime, 
		        'PostTitle' => $request->input("PostTitle"),
		        'Post' => $request->input("Post"),
		        'userrole' => $request->input("userrole"),
		        'UserId' => $loginuserid ]		       
		    );
    }


	 public function deletePost(Request $request){
		$id = $request->input("id");

		$post = PostEntry::where('PostId',$id)->delete();
		return Response::json($post);
    }


}
