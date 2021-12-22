
@extends('olmslayout')

@section('titlename') Fine Book List @endsection

@section('maincontent')
	

		<!-- Section -->
		<section class="bg-section ysuccess pt-10 pb-10" data-black-overlay="8" style="background-image: url({{ asset('public/images/background/bg-2.jpg') }})">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-7">
						<i class="fa fa-home white"></i> <span> / Admin / Fine Book List</span>	
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
						<label class="col-lg-1 col-form-label">User</label>
						<div class="col-lg-4 form-group">
							<div class="form-group">												
								<select data-placeholder="Select User..." class="chosen-select" id="fUserId" name="fUserId">
									<option value="0">All Users</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3 form-group">
							Paid Amount: <span id="paidamount" class="font-green"></span>
						</div>
						<div class="col-lg-3 form-group">
							Unpaid Amount: <span id="unpaidamount" class="font-red"></span>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">	
							<table id="tableMain" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="display:none;">RequestId</th>
										<th>Serial</th>
										<th>Issue Date</th>
										<th>Book Name</th>
										<th>Request Code</th>
										<th>Issued to ID</th>
										<th>User Name</th>
										<th>Fine</th>
										<th>Status</th>
										<th>Action</th>
										<th style="display:none;">FinePaid</th>
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
	var tableMainPopup;
 	var SITEURL = '{{URL::to('')}}';
	var pUserId=0;

	/***Hide entry form and show table***/
	function onListPanel(){
		$("#formpanel").hide();
		$("#listpanel").show();
	}
	/***Hide table and show entry form***/
	function onFormPanel(){
		$("#listpanel").hide();
		$("#formpanel").show();
	}

	/***Reset the control***/
	function resetForm(id) {
		$('#' + id).each(function() {
			this.reset();
		});
	}
	

	/***Data return***/
	function onConfirmWhenReturnBook(recordId) {

		$.ajax({
            type: "post",
            url: SITEURL+"/bookFinePaymentRoute",
            
            datatype:"json",
            data: {
            	"id":recordId,
        		"_token":$('meta[name="csrf-token"]').attr('content')
    		},
            success:function(response){

				var msg = "Payment completed successfully.";
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
					toastr.success(msg);

				}, 1300);
                getTableMainData();
                getFineAmountData();
			},
            error:function(error){
                setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
				toastr.error(error.responseJSON.message);

				}, 1300);

            }

        });
	}

/***Data Delete***/
	function onConfirmWhenReturnDelete(recordId) {

		$.ajax({
            type: "post",
            url: SITEURL+"/deleteBookFinePaymentRoute",
            
            datatype:"json",
            data: {
            	"id":recordId,
        		"_token":$('meta[name="csrf-token"]').attr('content')
    		},
            success:function(response){
                //alert("success");
				//console.log(response);
				//$("#tableMain").dataTable().fnDraw();

				var msg = "Payment removed successfully.";
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
					toastr.success(msg);

				}, 1300);
               getTableMainData();
                getFineAmountData();
			},
            error:function(error){
                //alert("fail");
                //console.log(error.responseJSON.message);

                setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
				toastr.error(error.responseJSON.message);

				}, 1300);

            }

        });
	}


function getUsersList() {

	    $.ajax({
	        type: "post",
	        url: SITEURL+"/getUserListRoute",
	        data: {
	        	"id":1,
        		"_token":$('meta[name="csrf-token"]').attr('content')
        	},
	        success:function(response){				
				$.each(response, function(i, obj) {
					$("#fUserId").append($('<option></option>').val(obj.id).html(obj.name));
					
				});
				$("#fUserId").trigger("chosen:updated");
				 
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
				toastr.error("Dropdown can not fillup");

				}, 1300);

	        }

	    });
	}


	$(document).ready(function() {

		
		$('.chosen-select').chosen({width: "100%"});
		getUsersList();

		 $("#fUserId").change(function () {
		 	pUserId = $('#fUserId').val();

	        getTableMainData();
            getFineAmountData();
	    });






	
	getTableMainData();
    getFineAmountData();
	getMyNewPostCount();

	});

    function getTableMainData(){

		tableMain = $("#tableMain").dataTable({
		    "bFilter" : false,
		    "bDestroy": true,
			"bAutoWidth": false,
		    "bJQueryUI": true,      
		    "bSort" : false,
		    "bInfo" : true,
		    "bPaginate" : true,
		    "bSortClasses" : true,
		    "bProcessing" : true,
		    "bServerSide" : true,
		    "aaSorting" : [[2, 'asc']],
		    "aLengthMenu" : [[10, 25, 50, 100], [10, 25, 50, 100]],
		    "iDisplayLength" : 10,
		    "ajax":{
		        "url": "<?php route('finebooklisttabledatafetch') ?>",
		        "datatype": "json",
		        "type": "post",
		        "data": {
		        		"UserId" : pUserId,
				        "_token":$('meta[name="csrf-token"]').attr('content')
				    }
		    },
		    "fnDrawCallback" : function(oSettings) {
	
		            if (oSettings.aiDisplay.length == 0) {
		                return;
		            }
		            
					$('a.returnItem', tableMain.fnGetNodes()).each(function() {

		                $(this).click(function() {

		                    var nTr = this.parentNode.parentNode;
		                    var aData = tableMain.fnGetData(nTr);
							
							
							$.confirm({
									title: 'Are you sure?!',
									content: 'Do you really want to paid the fine?',
									icon: 'fa fa-question',
									theme: 'bootstrap',
									closeIcon: true,
									animation: 'scale',
									type: 'red',
									buttons: {
										confirm: function () {
											onConfirmWhenReturnBook(aData['RequestId']);
										},
										cancel: function () {
											//$.alert('Canceled!');
										}
									}
								});


		                });
		            });


 					$('a.returnDrop', tableMain.fnGetNodes()).each(function() {

		                $(this).click(function() {

		                    var nTr = this.parentNode.parentNode;
		                    var aData = tableMain.fnGetData(nTr);

		                    $.confirm({
		                    title: 'Are you sure?!',
		                    content: 'Do you really want to delete this payment?',
		                    icon: 'fa fa-question',
		                    theme: 'bootstrap',
		                    closeIcon: true,
		                    animation: 'scale',
		                    type: 'red',
		                    buttons: {
		                        confirm: function () {
		                            onConfirmWhenReturnDelete(aData['RequestId']);
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
		        {"data":"RequestId","bVisible" : false},
		        {"data":"Serial","sWidth": "5%", "sClass": "align-center", "bSortable": false},
		        {"data":"IssueDate","sWidth": "10%"},
		        {"data":"BookName","sWidth": "20%"},
		        {"data":"RequestCode","sWidth": "12%"},
				{"data":"usercode","sWidth": "12%"},	        
		        {"data":"UserName","sWidth": "13%"},
		        {"data":"FineAmount","sWidth": "8%", "sClass": "align-right"},	
		        {"data":"Status","sWidth": "10%", "sClass": "align-center"},
		        {"data":"action","sWidth": "10%", "sClass": "align-center", "bSortable": false},
		        {"data":"FinePaid", "bVisible": false}		       
		    ]
		});

    }
function getFineAmountData() {

	    $.ajax({
	        type: "post",
	        url: SITEURL+"/getFineAmountDataRoute",
	        data: {
	        	"id":1,
	        	"UserId" : pUserId,
        		"_token":$('meta[name="csrf-token"]').attr('content')
        	},
	        success:function(response){
	        	$("#paidamount").html(response.Paid);
	        	$("#unpaidamount").html(response.Unpaid);
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
				toastr.error("Paid and unpaid amount can not fillup");

				}, 1300);

	        }

	    });
	}


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
.font-red {
    color: red !important;
}
.font-green {
    color: green !important;
}

</style>


 @endsection