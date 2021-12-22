<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous"> -->
	
	<!--<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">-->
 
	<link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet"> 
    <link href="{{ asset('public/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    
    <!--<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">-->

<?php //echo asset('resources/css/bootstrap.min.css');?>

    <title>Hello, world!</title>
  </head>
  <body>
    

    <div class="container">
<!--
       <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">WebSiteName</a>
          </div>
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Page 1</a></li>
            <li><a href="#">Page 2</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
          </ul>
        </div>
      </nav> -->
      <div class="row">
          <div class="col-sm">




            <table id="tableMain" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>







            <table id="example11" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach ($employees as $employee)
                        <tr>
                            <td> {{ $employee->id }} </td>
                            <td> {{ $employee->name }} </td>
                            <td> {{ $employee->email }} </td>
                            <td><button type="button" class="btn btn-primary btn-sm">Edit</button>
                            <button type="button" class="btn btn-primary btn-sm">Delete</button></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>




            


<form id="addEmployeeForm">
    <div>

     {{ csrf_field() }}

      <div class="form-group">
        <label for="id">Id</label>
        <input type="text" class="form-control" id="id" name="id">
      </div>


      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>


      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email">
      </div>
    </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>











<!--
              <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                    </tr>
                    <tr>
                        <td>Shad Decker</td>
                        <td>Regional Director</td>
                        <td>Edinburgh</td>
                        <td>51</td>
                        <td>2008/11/13</td>
                        <td>$183,000</td>
                    </tr>
                    <tr>
                        <td>Michael Bruce</td>
                        <td>Javascript Developer</td>
                        <td>Singapore</td>
                        <td>29</td>
                        <td>2011/06/27</td>
                        <td>$183,000</td>
                    </tr>
                    <tr>
                        <td>Donna Snider</td>
                        <td>Customer Support</td>
                        <td>New York</td>
                        <td>27</td>
                        <td>2011/01/25</td>
                        <td>$112,000</td>
                    </tr>
                </tbody>
            </table>-->
          </div>
        </div>


<br/><br/><br/><br/>
	  <div class="row">
	    <div class="col-sm">
	      One of three columns
	    </div>
	    <div class="col-sm">
	      One of three columns
	    </div>
	    <div class="col-sm">
	      One of three columns
	    </div>
	  </div>
	</div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
 --> 
     <script src="{{ asset('public/js/jquery.dataTables.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('public/js/dataTables.bootstrap4.min.js') }}" crossorigin="anonymous"></script>

<script>
    var tableMain;
  $(document).ready(function() {
    //alert(1);
    $('#example11').DataTable();


    $("#addEmployeeForm").on("submit",function(e){
        e.preventDefault();

        $.ajax({
            type: "post",
            url: "http://localhost/laravel/blog/addEmployeeRoute",
            data: $("#addEmployeeForm").serialize(),
            success:function(response){
                alert("success");


            //$("#example11").DataTable().reload();
            },
            error:function(error){
                alert("fail");
            }

        });

    });


tableMain = $("#tableMain").dataTable({
    "bFilter" : true,
    "bJQueryUI": true,      
    "bSort" : true,
    "bInfo" : true,
    "bPaginate" : true,
    "bSortClasses" : false,
    "bProcessing" : true,
    "bServerSide" : true,
    //"aaSorting" : [[2, 'asc']],
    //"aLengthMenu" : [[25, 50, 100], [25, 50, 100]],
    "iDisplayLength" : 25,
    "ajax":{
        "url": "<?php route('dataProcessing') ?>",
        "datatype": "json",
        "type": "post",
        //"data": {"_token":"<?php csrf_token() ?>"}
        "data": {"_token":"1YodMtnlZIYa9MDCTS2CsxLQYpGjjDgfYoB0rKbj"}
    },
    "fnDrawCallback" : function(oSettings) {

            if (oSettings.aiDisplay.length == 0) {
                return;
            }
            
            $('a.itmEdit', tableMain.fnGetNodes()).each(function() {
               
                $(this).click(function() {
                     alert(111);
                return;
                    var nTr = this.parentNode.parentNode;
                    var aData = tableMain.fnGetData(nTr);
                    recordId = aData[0];
                    
                    $.confirm({
                        title: 'Are you sure?!',
                        content: 'Do you really want to edit this data?',
                        icon: 'fa fa-question',
                        theme: 'bootstrap',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'orange',
                        buttons: {
                            confirm: function () {
                                
                                resetForm("edit-form");
                                $('#recordId').val(aData[0]);
                                $('#UnitName').val(aData[2]);
                                
                                onFormPanel();
                                //$.alert('Confirmed!');
                            },
                            cancel: function () {
                                //$.alert('Canceled!');
                            }
                        }
                    });
                    
                });
            });
            $('a.itmDrop', tableMain.fnGetNodes()).each(function() {
                
                $(this).click(function() {

                    var nTr = this.parentNode.parentNode;
                    console.log(tableMain.fnGetData(nTr));
                    var aData = tableMain.fnGetData(nTr);
                    recordId = aData['id'];
                     alert(recordId);
                    return;

                    $.confirm({
                    title: 'Are you sure?!',
                    content: 'Do you really want to delete this unit?',
                    icon: 'fa fa-question',
                    theme: 'bootstrap',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'red',
                    buttons: {
                        confirm: function () {
                            onConfirmWhenDelete();
                        },
                        cancel: function () {
                            //$.alert('Canceled!');
                        }
                    }
                });

                });
            });
        },
    "columns":[
        {"data":"id","sWidth": "10%"},
        {"data":"name","sWidth": "40%"},
        {"data":"email","sWidth": "40%"},
        {"data":"action","sWidth": "10%"}
    ]
});
 



    $('#example').DataTable();
} );
</script>


<style>
.label-info {
    background-color: #23c6c8;
    color: #FFFFFF;
}
.label-danger {
    background-color: #ed5565;
    color: #FFFFFF;
}
.label {
    color: #FFFFFF;
    font-weight: 600;
    padding: 3px 8px;
    text-shadow: none;
    border-radius: 0.25em;
    line-height: 1;
    white-space: nowrap;
    font-size: 11px;
}
a {
    color: #007bff;
    text-decoration: none !important;
    background-color: transparent; 
}
.font-white {
    color: white !important;
}
    </style>
  </body>
</html>