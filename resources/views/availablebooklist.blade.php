
@extends('olmslayout')

@section('titlename') Available Book List @endsection

@section('maincontent')
	

		<!-- Section -->
		<section class="bg-section ysuccess pt-10 pb-10" data-black-overlay="8" style="background-image: url({{ asset('public/images/background/bg-2.jpg') }})">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-7">
						<i class="fa fa-home white"></i> <span> / Reports / Available Book List</span>	
					</div>
					<div class="col-lg-5 align-right">

						<a class="notification-ico" href="{{ url('postview') }}"><i class="fa fa-bell"></i> <sup><span id="notificationcount"></span></sup></a>

						<span>Hi,</span> <a href="{{ url('profile') }}" <span class="font-white"><u>{{ Auth::user()->name }}</u></span> </a>
						<a class="btn btn-primary mb-0" href="{{ url('logout') }}"><i class="fa fa-lock"></i> {{ __('Logout') }}</a>
					</div>
				</div>
			</div>
		</section>
		<!-- /Section -->	

		<!-- Testimonial Section -->
		<section class="testimonial-area pt-10 pb-10">
			<div class="container">

				<div id="listpanel">
				
					<div class="row">
						<div class="col-lg-12 form-group">
							<div class="pull-right">
								<button class="btn btn-success" id="btnExport" onclick="exportExcel();">Excel</button>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">	
							<table id="tableMain" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Serial</th>
										<th>Book Name</th>
										<th>Author Name</th>
										<th>Total Copy</th>
										<th>Available Copy</th>
									</tr>
								</thead>
								<tbody>
								</tbody>				
							</table>
						</div>
					</div>
				</div>
				
		
				
			</div>
		</section>

 
		

 @endsection


@section('customjs')
<script>
	var tableMain;
 	var SITEURL = '{{URL::to('')}}';


	$(document).ready(function() {
		
		$('.chosen-select').chosen({width: "100%"});


		tableMain = $("#tableMain").dataTable({
		    "bFilter" : true,
		    "bDestroy": true,
			"bAutoWidth": false,
		    "bJQueryUI": true,      
		    "bSort" : true,
		    "bInfo" : true,
		    "bPaginate" : true,
		    "bSortClasses" : true,
		    "bProcessing" : true,
		    "bServerSide" : true,
		    "aaSorting" : [[1, 'asc']],
		    "aLengthMenu" : [[10, 25, 50, 100], [10, 25, 50, 100]],
		    "iDisplayLength" : 10,
		    "ajax":{
		        "url": "<?php route('availablebooktabledatafetch') ?>",
		        "datatype": "json",
		        "type": "post",
		        "data": {"_token":$('meta[name="csrf-token"]').attr('content')}
		    },
		    "fnDrawCallback" : function(oSettings) {
		        },
		    "columns":[
		        {"data":"Serial","sWidth": "6%", "sClass": "align-center", "bSortable": false},
		        {"data":"BookName","sWidth": "40%"},
		        {"data":"AuthorName","sWidth": "24%"},
		        {"data":"TotalCopy","sWidth": "15%", "sClass": "align-right", "bSortable": false},
		        {"data":"AvailableCopy","sWidth": "15%", "sClass": "align-right", "bSortable": false}
		    ]
		});
		



		getMyNewPostCount();
	} );


function getMyNewPostCount() {

	    $.ajax({
	        type: "post",
	        url: SITEURL+"/getMyNewPostCountRoute",
	        data: {
	        	"id":1,
        		"_token":$('meta[name="csrf-token"]').attr('content')
        	},
	        success:function(response){
	        	if(response == 0){
					$("#notificationcount").html('');
	        	}
	        	else{
		        	$("#notificationcount").html(response);
		        }
	        },
	        error:function(error){
	            //alert("fail");
	            setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
				toastr.error("New post count can not fillup");

				}, 1300);

	        }

	    });
	}



function exportExcel(){
	window.open("./custom_script/report/availablebooklist_excel.php");
}

</script>

<style>

	.align-left {
		text-align: left;
	}
	.align-center {
		text-align: center !important;
	}
	.align-right {
		text-align: right;
	}
.font-white {
    color: white !important;
}

</style>


 @endsection