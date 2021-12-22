<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class CommonController extends Controller
{
   	public function getBookTypeList()
	{
 
		$posts = DB::table('t_booktypes')
            ->select('BookTypeId', 'BookType')
			->orderByRaw("BookType asc")
            ->get();

         return $posts;
	}

	public function getBookAccessTypeList()
	{
 
		$posts = DB::table('t_bookaccesstype')
            ->select('BookAccessTypeId', 'BookAccessType')
			->orderByRaw("BookAccessType asc")
            ->get();

         return $posts;
	}

  public function getBookList()
  {
 
    $posts = DB::table('t_books')
            ->select('BookId', 'BookName')
            ->orderByRaw("BookName asc")
            ->get();

         return $posts;
  }

  public function getMyNewPostCount()
  {
    $myNewPostCount = 0;
    if(Auth::check()){
        $loginuserid = Auth::user()->id;
        $loginuserrole = Auth::user()->userrole;
        $LastPostViewDate = Auth::user()->LastPostViewDate;


        $rowTotalObj = DB::table('t_post')
                         ->select(DB::raw('count(*) as rcount'))                     
                         ->where('PostDate', '>', $LastPostViewDate)
                         //->where('userrole', '=', 'All')
                         //->orWhere('userrole', '=', $loginuserrole)
                         ->where(function($query) use ($loginuserrole)
                          {
                               $query->Where('userrole','=',  'All');
                               $query->orWhere('userrole','=', $loginuserrole);
                          })

                        // ->toSQL();
                         ->get();
                        // echo  $rowTotalObj ;
        $myNewPostCount = $rowTotalObj[0]->rcount;
    }
    return $myNewPostCount;
  }

 public function updateLastPostViewDateByUser(){
    $loginuserid = Auth::user()->id;
    $curDateTime = date ( 'Y-m-d H:i:s' );
    $affected = DB::table('users')
              ->where('id', $loginuserid)
              ->update(['LastPostViewDate' => $curDateTime]);
 }

  public function getDepartmentList()
  {
 
    $posts = DB::table('t_department')
            ->select('DepartmentId', 'Department')
      ->orderByRaw("Department asc")
            ->get();

         return $posts;
  }

  public function getUserList()
  {
 
    $posts = DB::table('users')
            ->select(DB::raw("id, CONCAT(usercode,' - ',name) AS name"))
      ->orderByRaw("usercode asc, name asc")
            ->get();

         return $posts;
  }



  /*For dashbard*/
  public function getDashboardBasicInfo()
  {
 
    $basicInfo = array("gTeachersCount"=>0,"gStudentCount"=>0,"gMemberCount"=>0,"gBooksinFieldCount"=>0,"gBookPendingCount"=>0);


    $rowTotalObj = DB::table('users')
                     ->select(DB::raw('count(*) as rcount'))
                     ->where('userrole', 'Teacher')
                     ->get();
    $basicInfo['gTeachersCount'] = $rowTotalObj[0]->rcount;
    

    $rowTotalObj = DB::table('users')
                     ->select(DB::raw('count(*) as rcount'))
                     ->where('userrole', 'Student')
                     ->get();
    $basicInfo['gStudentCount'] = $rowTotalObj[0]->rcount;


    $rowTotalObj = DB::table('users')
                     ->select(DB::raw('count(*) as rcount'))
                     ->where('userrole', 'Other')
                     ->get();
    $basicInfo['gMemberCount'] = $rowTotalObj[0]->rcount;

    


    $rowTotalObj = DB::table('t_bookrequest')
                     ->select(DB::raw('count(*) as rcount'))
                     ->where('Status', 'Issued')
                     ->get();
    $basicInfo['gBooksinFieldCount'] = $rowTotalObj[0]->rcount;



    $rowTotalObj = DB::table('t_bookrequest')
                     ->select(DB::raw('count(*) as rcount'))
                     ->where('Status', 'Requested')
                     ->get();
    $basicInfo['gBookPendingCount'] = $rowTotalObj[0]->rcount;


    return $basicInfo;
  }



  public function getIssuedTrendData()
  {
    $search='';

    $posts = DB::table('t_bookrequest')
      //->select(DB::raw("CONCAT(YEAR(`IssueDate`),'-',MONTH(`IssueDate`)) AS IssuedYearMonth,COUNT(`RequestId`) AS RequestCount"))
      ->select(DB::raw("DATE_FORMAT(IssueDate, '%Y-%m') AS IssuedYearMonth,COUNT(`RequestId`) AS RequestCount"))
      ->whereNotNull('IssueDate')
      ->where(function($query) use ($search)
        {
           $query->Where('Status','=', 'Issued');
           $query->orWhere('Status','=', 'Returned');
        })
      ->groupByRaw("DATE_FORMAT(IssueDate, '%Y-%m')")
      //->tosql();
      ->get();


    $category = array();
    $series = array("name"=>"Books","data"=>array(),"color"=>"#00587E");

    foreach($posts as $r){
      $category[] = $r->IssuedYearMonth;

      settype($r->RequestCount,"int");
      $series["data"][] = $r->RequestCount;
    }
    
    $output = array();
    $output["category"] = $category;
    $output["series"][] = $series;
    
    return $output;//json_encode($output);

  }

}