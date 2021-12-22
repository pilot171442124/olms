
@extends('olmslayout')


@section('titlename') Book Request Entry @endsection

@section('maincontent')

		<!-- Section -->
		<section class="bg-section ysuccess pt-10 pb-10" data-black-overlay="8" style="background-image: url({{ asset('public/images/background/bg-2.jpg') }})">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-7">
						<i class="fa fa-home white"></i> <span> / Book Entry / Book Request Entry</span>	
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
								<button class="btn btn-primary" id="btnAdd">New Book Request</button>
								<button class="btn btn-success" id="btnExport" onclick="exportExcel();">Excel</button>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">	
							<table id="tableMain" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="display:none;">RequestId</th>
										<th>Serial</th>
										<th>Request Code</th>										
										<th>Date</th>
										<th>Department</th>
										<th>Book Name</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>				
							</table>
						</div>
					</div>
				</div>
				

				<div id="formpanel" style="display:none;">
					<div class="row">
						<div class="col-lg-12 mb-10">
							<button class="btn btn-info btn-sm pull-right" type="button" id="btnBack"><i class="fa fa-mail-reply"></i>&nbsp;&nbsp;<span class="bold">Back</span></button>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">

									<form role="form" id="addeditform">
									{{ csrf_field() }}
										<div class="row">

											<div class="col-md-4">
												<div class="form-group">
													<label>Book<span class="red">*</span></label>													
													<select data-placeholder="Choose Book..." class="chosen-select" id="BookId" name="BookId" required>
														<option value="">Select Book</option>
													</select>
												</div>											
											</div>

											<div class="col-md-4">
											</div>

											<div class="col-md-4">
											</div>
										</div>

										<div class="form-group row">
											<div class="col align-self-center">
												<input type="text" id="recordId" name="recordId" style="display:none;">
												<input type="text" id="loginuserid" name="loginuserid" value={{ Auth::user()->id }} style="display:none;">
												<a href="javascript:void(0)" class="btn btn-primary btn-sm" id="btnSubmit"><i class="fa fa-save"></i> Save</a>
												<a href="javascript:void(0)" class="btn btn-danger btn-sm" onClick="onListPanel();"><i class="fa fa-times"></i> Cancel</a>
											</div>
										</div>
									</form>

								</div>
							</div>
					
					</div>
				</div>
              </div>
				
				
			</div>
		</section>







		<!-- Modal -->
		<div class="popupModal " id="FileUploadModal">
		  <div class="modal-dialog" role="document">
				 @csrf
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Book List</h5>
			        <button type="button" class="close" onClick="hidePopupFileUploadModal()" href="javascript:void(0);"><i class="fa fa-times"></i></button>
			      </div>
			      <div class="modal-body">

					<div class="row" style="height:350px;overflow: scroll;">
						<div class="col-lg-12">	
							<table id="tableMainPopup" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="display:none;">BookId</th>
										<th>Department</th>
										<th>Book Name</th>
										<th>Author Name</th>
									</tr>
								</thead>
								<tbody>
								</tbody>				
							</table>
						</div>
					</div>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" onClick="hidePopupFileUploadModal()" href="javascript:void(0);">Close</button>
					<button  class="btn btn-primary" id="btnIssue">Request</button>
			      </div>
			    </div>

		  </div>

		</div>
		<!-- /Testimonial Section -->
 
 @endsection


@section('customjs')

<script>
	var tableMain;
 	var SITEURL = '{{URL::to('')}}';

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

/***Validation***/
/*
jQuery("#addeditform").parsley({
	listeners : {
		onFieldValidate : function(elem) {
			if (!$(elem).is(":visible")) {
                return true;
            }
            else {
                return false;
            }
		},
		onFormSubmit : function(isFormValid, event) {
			if (isFormValid) {
				onConfirmWhenAddEdit();
				return false;
			}
		}
	}
});
*/
	

	/***Data Insert or update***/
	/*
	function onConfirmWhenAddEdit() {

	    $.ajax({
	        type: "post",
	        url: SITEURL+"/addEditBookRequestRoute",
	        data: $("#addeditform").serialize(),
	        success:function(response){
	            //alert("success");
				
				var msg="";
	            if($("#recordId").val() == "") {
	           	    msg = "Data added successfully.";
	            } else {
	           	    msg = "Data updated successfully.";
	            }
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
					toastr.success(msg);

				}, 1300);
	            onListPanel();

	            $("#tableMain").dataTable().fnDraw();
	        },
	        error:function(error){
	            setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
				toastr.error("Operation fail");

				}, 1300);

	        }

	    });
	}*/

	/***Data Delete***/
	function onConfirmWhenDelete(recordId) {

		$.ajax({
            type: "post",
            //url: "http://localhost/olms/deleteBookTypeRoute",
            url: SITEURL+"/deleteBookRequestRoute",
            
            datatype:"json",
            data: {
            	"id":recordId,
        		"_token":$('meta[name="csrf-token"]').attr('content')
    		},
            success:function(response){
                //alert("success");
				//console.log(response);
				//$("#tableMain").dataTable().fnDraw();

				var msg = "Data removed successfully.";
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
					toastr.success(msg);

				}, 1300);
                onListPanel();
                $("#tableMain").dataTable().fnDraw();
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

function getBookList() {

	    $.ajax({
	        type: "post",
	        //url: "http://localhost/olms/BookEntryGetBookTypeListRoute",
	        url: SITEURL+"/getBookListRoute",
	        data: {
	        	"id":1,
        		"_token":$('meta[name="csrf-token"]').attr('content')
        	},
	        success:function(response){
				
				$.each(response, function(i, obj) {
					$("#BookId").append($('<option></option>').val(obj.BookId).html(obj.BookName));
				});
				$("#BookId").trigger("chosen:updated");
				 
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
				toastr.error("Book can not fillup");

				}, 1300);

	        }

	    });
	}



function getRequestedBookCountByUser() {

	    $.ajax({
	        type: "post",
	        url: SITEURL+"/getRequestedBookCountByUserRoute",
	        data: {
	        	"id":1,
        		"_token":$('meta[name="csrf-token"]').attr('content')
        	},
	        success:function(response){

				if(response<=10){
					showPopupFileUploadModal();
				 }
				 else{
				 	
				 	setTimeout(function() {
						toastr.options = {
							closeButton: true,
							progressBar: true,
							showMethod: 'slideDown',
							timeOut: 4000
						};
					toastr.error("You already requested 10 books");

					}, 1300);

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
				toastr.error("Book req can not came");

				}, 1300);

	        }

	    });
	}



 	var PopupFileUploadModal = document.getElementById('FileUploadModal');

	function showPopupFileUploadModal() {


//getRequestedBookCountByUser()



		PopupFileUploadModal.style.display = "block";	

		tableMainPopup = $("#tableMainPopup").dataTable({
		    "bFilter" : false,
		    "bDestroy": true,
			"bAutoWidth": false,
		    "bJQueryUI": true,      
		    "bSort" : false,
		    "bInfo" : false,
		    "bPaginate" : false,
		    "bSortClasses" : true,
		    "bProcessing" : true,
		    "bServerSide" : true,
		    "ajax":{
		        url: SITEURL+"/booklistpopuptabledatafetch",
		        "datatype": "json",
		        "type": "post",
		        "data": {"_token":$('meta[name="csrf-token"]').attr('content')}
		    },
		    "fnDrawCallback" : function(oSettings) {
		        },
		    "columns":[
		        {"data":"BookId","bVisible" : false},
		        {"data":"Department","sWidth": "20%"},
		        {"data":"BookName","sWidth": "40%"},
		        {"data":"AuthorName","sWidth": "40%"}
		    ]
		});


		$('#tableMainPopup tbody').on( 'click', 'tr', function () {
	        $(this).toggleClass('selected');
	    } );

	}





	function hidePopupFileUploadModal() {
		PopupFileUploadModal.style.display = "none";	
	}



	$(document).ready(function() {
		
		$('.chosen-select').chosen({width: "100%"});
		

		getBookList();

		$('#btnAdd').on('click', function(){

			getRequestedBookCountByUser();
			//showPopupFileUploadModal();

		});
		
		$('#btnBack').on('click', function(){
			onListPanel();
		}); 



		/*popup submit*/
	 	$('#btnIssue').click( function () {

	        var sList =  $('#tableMainPopup').DataTable().rows('.selected').data();
		       
		       if(sList.length == 0){
					setTimeout(function() {
						toastr.options = {
							closeButton: true,
							progressBar: true,
							showMethod: 'slideDown',
							timeOut: 4000
						};
					toastr.error("Please, select the book");

					}, 1300);

					return;
				}

				var sBooks = [];
		        $.each(sList, function(i, obj) {				
					 sBooks.push(obj.BookId);
				});
				


				$.ajax({
	            type: "post",
	            url: SITEURL+"/requestFromRequestEntryRoute",
	            
	            datatype:"json",
	            data: {
	            	"sBooks":sBooks,
	        		"_token":$('meta[name="csrf-token"]').attr('content')
	    		},
	            success:function(response){

					var msg = "Book requested successfully.";
					setTimeout(function() {
						toastr.options = {
							closeButton: true,
							progressBar: true,
							showMethod: 'slideDown',
							timeOut: 4000
						};
						toastr.success(msg);

					}, 1300);
	                onListPanel();
	                hidePopupFileUploadModal();
	                $("#tableMain").dataTable().fnDraw();
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


    	});
/*		
		$("#btnSubmit").click(function () {
	        $("#addeditform").submit();
	    });
*/
		tableMain = $("#tableMain").dataTable({
		    "bFilter" : true,
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
		        "url": "<?php route('bookrequesttabledatafetch') ?>",
		        "datatype": "json",
		        "type": "post",
		        "data": {"_token":$('meta[name="csrf-token"]').attr('content')}
		    },
		    "fnDrawCallback" : function(oSettings) {
	
		            if (oSettings.aiDisplay.length == 0) {
		                return;
		            }
		          
		            $('a.itmDrop', tableMain.fnGetNodes()).each(function() {

		                $(this).click(function() {

		                    var nTr = this.parentNode.parentNode;
		                    var aData = tableMain.fnGetData(nTr);

		                    $.confirm({
		                    title: 'Are you sure?!',
		                    content: 'Do you really want to delete this data?',
		                    icon: 'fa fa-question',
		                    theme: 'bootstrap',
		                    closeIcon: true,
		                    animation: 'scale',
		                    type: 'red',
		                    buttons: {
		                        confirm: function () {
		                            onConfirmWhenDelete(aData['RequestId']);
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
		        {"data":"Serial","sWidth": "7%", "sClass": "align-center", "bSortable": false},
		        {"data":"RequestCode","sWidth": "13%", "bSortable": false},
		        {"data":"RequestDate","sWidth": "12%", "bSortable": false},
		        {"data":"Department","sWidth": "12%", "bSortable": false},
		        {"data":"BookName","sWidth": "37%", "bSortable": false},
		        {"data":"Status","sWidth": "8%", "sClass": "align-center", "bSortable": false},
		        {"data":"action","sWidth": "10%", "sClass": "align-center", "bSortable": false}
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
	window.open("./custom_script/report/bookrequestentry_excel.php?loginuserid="+$("#loginuserid").val());
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




/* start Modal css*/
.modal-dialog {
	max-width: 900px;
}
.popupModal {
	display: none; 
	position: fixed; 
	z-index: 999; 
	padding-top: 60px;
	left: 0;
	top: 0;
	width: 100%; 
	height: 100%; 
	overflow: auto; 
	background-color: rgb(0,0,0); 
	background-color: rgba(0,0,0,0.4);
}
.modal-header{
	background: #c6da89;
	padding: 7px;
}

.selected{
	background: #c6da89 !important;
}
.modal-footer{
	padding: 7px;	
}
.font-white {
    color: white !important;
}
</style>
 @endsection
