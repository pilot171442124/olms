<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect,Response;
use App\AvailableBookList;
use DB;
use Auth;

class AvailableBookListController extends Controller
{
    function getAvailableBookListData(Request $request){

		//datatable column index => database column name. here considaer datatable visible and novisible column
		
		$columns = array(1=>'BookName',2=>'AuthorName');

		$limit = $_POST['length'];
		$start = $_POST['start'];
		$order = $columns[$_POST['order'][0]['column']];
		$dir = $_POST['order'][0]['dir'];

		$search = $_POST['search']['value'];

		//$totalData = AvailableBookList::count();
		$rowTotalObj = DB::table('t_books')
                     ->select(DB::raw('count(*) as rcount'))
                    ->where('BookTypeId', '=',  1)
					->where(function($query) use ($search)
		              {
		                if(!empty($search)):
		                   $query->Where('BookName','like', '%' . $search . '%');
		                   $query->orWhere('AuthorName','like', '%' . $search . '%');
		                endif;
		              })
                     ->get();
		$totalData = $rowTotalObj[0]->rcount;



		//BookTypeId=1=hard copy
        $posts = DB::table('t_books')
         	->join('t_bookaccesstype', 't_books.BookAccessTypeId', '=', 't_bookaccesstype.BookAccessTypeId')
         	->select('t_books.*', 't_bookaccesstype.BookAccessType')
			->where('BookTypeId', '=',  1)
			->where(function($query) use ($search)
              {
                if(!empty($search)):
                   $query->Where('BookName','like', '%' . $search . '%');
                   $query->orWhere('AuthorName','like', '%' . $search . '%');
                endif;
              })
			->offset($start)
			->limit($limit)
			->orderByRaw("$order $dir")
            ->get();


		$data = array();

		if($posts){

			$serial = $_POST['start'] + 1;
			foreach($posts as $r){

				$rowCountObj = DB::table('t_bookrequest')
                     ->select(DB::raw('count(*) as rcount'))
                    ->where('BookId', '=',  $r->BookId)
                    ->where('Status', '=',  'Issued')
                     ->get();
				$IssuedCopy = $rowCountObj[0]->rcount;



				$arr['Serial'] = $serial++;
				$arr['BookName'] = $r->BookName;
				$arr['AuthorName'] = $r->AuthorName;
				$arr['TotalCopy'] = $r->TotalCopy;
				$arr['AvailableCopy'] = $r->TotalCopy-$IssuedCopy;
				
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
