<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

/*Index page*/
Route::get('/', function () {
    return view('home');
});

/*Public book list for datatable*/
Route:: post('/','BookEntryController@getPublicBookData')->name('publicBookTableDataFetch');


/*Index page*/
Route::get('/home', function () {
    return view('home');
});

/*Public book list for datatable*/
Route:: post('/home','BookEntryController@getPublicBookData')->name('publicBookTableDataFetch');



/*Authentication*/
Route::get('logout', 'Auth\LoginController@logout');



/**dashboard route*/
Route::get('/dashboard/', function () {
    return view('dashboard');
})->middleware('auth'); //when not login then redirect to login page
/*get dashboard basic info*/
Route::post('/getDashboardBasicInfoRoute', 'CommonController@getDashboardBasicInfo');
/*get book issued trend*/
Route::post('/getIssuedTrendDataRoute', 'CommonController@getIssuedTrendData');



/**Available book route*/
Route::get('/availablebooklist/', function () {
    return view('availablebooklist');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('availablebooklist','AvailableBookListController@getAvailableBookListData')->name('availablebooktabledatafetch');


/**User entry route*/
Route::get('/userentry/', function () {
    return view('userentry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('userentry','UserEntryController@getUserData')->name('usertabledatafetch');
/*add user*/
Route::post('/addEditUserRoute', 'UserEntryController@addEditUser');
/*edit book*/
Route::post('/userEditUserRoute', 'UserEntryController@editUser');
/*delete book*/
Route::post('/deleteUserRoute', 'UserEntryController@deleteUser');
/*send sms*/
Route::post('/newUserSendSMSRoute', 'UserEntryController@newUserSendSMS');



/**Book entry route*/
Route::get('/bookentry/', function () {
    return view('bookentry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('bookentry','BookEntryController@getBookData')->name('booktabledatafetch');
/*add book*/
Route::post('/addEditBookRoute', 'BookEntryController@addEditBook');
/*file upload*/
Route::post('/fileUploadBookRoute', 'BookEntryController@fileUpload');
/*delete book*/
Route::post('/deleteBookRoute', 'BookEntryController@deleteBook');



/**department route*/
Route::get('/departmententry/', function () {
    return view('departmententry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('departmententry','DepartmentEntryController@getDepartmentData')->name('departmenttabledatafetch');
/*add department*/
Route::post('/addEditDepartmentRoute', 'DepartmentEntryController@addEditDepartment');
/*delete department*/
Route::post('/deleteDepartmentRoute', 'DepartmentEntryController@deleteDepartment');






/**Book Request entry route*/
Route::get('/bookrequestentry/', function () {
    return view('bookrequestentry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('bookrequestentry','BookRequestController@getBookRequestData')->name('bookrequesttabledatafetch');
/*add book*/
//Route::post('/addEditBookRequestRoute', 'BookRequestController@addEditBookRequest');
/*delete book*/
Route::post('/deleteBookRequestRoute', 'BookRequestController@deleteBookRequest');
/*requested bookcount*/
Route::post('/getRequestedBookCountByUserRoute', 'BookRequestController@getRequestedBookCountByUser');
/*data fetch for booklist*/
Route:: post('booklistpopuptabledatafetch','BookRequestController@getBookListPopupData');
/*request from request entry*/
Route::post('/requestFromRequestEntryRoute', 'BookRequestController@requestFromRequestEntry');



/**Book Request list for admin route*/
Route::get('/bookrequestlist/', function () {
    return view('bookrequestlist');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('bookrequestlist','BookRequestListController@getBookRequestData')->name('bookrequestlisttabledatafetch');
/*delete book*/
Route::post('/cancelBookRequestRoute', 'BookRequestListController@cancelBookRequest');
/*delete book*/
Route::post('/acceptBookRequestRoute', 'BookRequestListController@acceptedBookRequest');



/**Book Issue and return entry route*/
Route::get('/bookissueentry/', function () {
    return view('bookissueentry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('bookissueentry','BookIssueController@getBookIssueData')->name('bookissuetabledatafetch');
/*delete issue book*/
Route::post('/deleteBookIssueRoute', 'BookIssueController@deleteBookIssue');
/*delete return book*/
Route::post('/bookReturnRoute', 'BookIssueController@bookReturn');
/*delete return book*/
Route::post('/deleteBookReturnRoute', 'BookIssueController@deleteBookReturn');
/*data fetch for datatable*/
Route:: post('bookrequestlistpopuptabledatafetch','BookIssueController@getBookRequestPopupData');
/*issue from request list book*/
Route::post('/IssueFromRequestListRoute', 'BookIssueController@issueFromRequestList');



/**Alert for book return for admin route*/
Route::get('/alertsmslist/', function () {
    return view('alertsmslist');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('alertsmslist','AlertsmsListController@getBookAlertSMSData')->name('alertsmslisttabledatafetch');


/**Fine book list for admin route*/
Route::get('/finebooklist/', function () {
    return view('finebooklist');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('finebooklist','FineBookListController@getFineBookListData')->name('finebooklisttabledatafetch');
/*delete return book*/
Route::post('/bookFinePaymentRoute', 'FineBookListController@bookFinePayment');
/*delete return book*/
Route::post('/deleteBookFinePaymentRoute', 'FineBookListController@deleteBookFinePayment');
/*get paid unpaid amount*/
Route::post('/getFineAmountDataRoute', 'FineBookListController@getFineAmountData');


/**BookType entry route*/
Route::get('/booktypeentry/', function () {
    return view('booktypeentry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('booktypeentry','BookTypeController@getBookTypeData')->name('booktypetabledatafetch');
/*add booktype*/
Route::post('/addEditBookTypeRoute', 'BookTypeController@addEditBookType');
/*delete booktype*/
Route::post('/deleteBookTypeRoute', 'BookTypeController@deleteBookType');



/**BookAccessType entry route*/
Route::get('/bookaccesstypeentry/', function () {
    return view('bookaccesstypeentry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('bookaccesstypeentry','BookAccessTypeController@getBookAccessTypeData')->name('bookaccesstypetabledatafetch');


/**User role entry route*/
Route::get('/userroleentry/', function () {
    return view('userroleentry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('userroleentry','UserRoleController@getUserRoleData')->name('userroletabledatafetch');





/**Post entry route*/
Route::get('/postentry/', function () {
    return view('postentry');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route:: post('postentry','PostEntryController@getPostData')->name('posttabledatafetch');
/*add Post*/
Route::post('/addEditPostRoute', 'PostEntryController@addEditPost');
/*delete Post*/
Route::post('/deletePostRoute', 'PostEntryController@deletePost');



/**Post view route*/
Route::get('/postview/', function () {
    return view('postview');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route::post('postviewRoute', 'PostViewController@getPostData');



/**Profile route*/
Route::get('/profile/', function () {
    return view('profile');
})->middleware('auth'); //when not login then redirect to login page
/*data fetch for datatable*/
Route::post('profileviewRoute', 'ProfileController@getProfileData');
/*update Profile*/
Route::post('/editProfileRoute', 'ProfileController@editMyProfile');



/*CommonController*/
/*get book type book*/
Route::post('/getBookTypeListRoute', 'CommonController@getBookTypeList');
/*get book access type book*/
Route::post('/getBookAccessTypeListRoute', 'CommonController@getBookAccessTypeList');
/*get book access type book*/
Route::post('/getBookListRoute', 'CommonController@getBookList');
/*get my new post*/
Route::post('/getMyNewPostCountRoute', 'CommonController@getMyNewPostCount');
/*get my new post*/
Route::post('/updateLastPostViewDateByUserRoute', 'CommonController@updateLastPostViewDateByUser');
/*get book type book*/
Route::post('/getDepartmentListRoute', 'CommonController@getDepartmentList');
/*get user list*/
Route::post('/getUserListRoute', 'CommonController@getUserList');














/*Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/hometable/', function () {
    return view('index');
});

Route::get('/test/', function () {
    return view('welcome');
});

Route::get('/users/', function () {
    return view('users');
});

Route::get('/bootstraptest/', function () {
    return view('bootstraptest');
});




/*
Route::get('/', function () {
    return view('employees');
});*/
/*
Route::get('/employees/', function () {
    return view('employees');
});*/




Route::get('list', 'EmployeeController@list');
Route::post('/addEmployeeRoute', 'EmployeeController@addEmployee');

Route:: post('list','EmployeeController@getEmployee')->name('dataProcessing');
//Route::resource('employees','EmployeeController@index');
//Route::get('employees',  'Employee@index');

//Route::resource('users','UserController');
//Route::get('users/{id}/edit/','UserController@edit');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
