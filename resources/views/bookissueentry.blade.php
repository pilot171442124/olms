
@extends('olmslayout')

@section('titlename') Book Issue and Return Entry @endsection

@section('maincontent')
	

		<!-- Section -->
		<section class="bg-section ysuccess pt-10 pb-10" data-black-overlay="8" style="background-image: url({{ asset('public/images/background/bg-2.jpg') }})">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-7">
						<i class="fa fa-home white"></i> <span> / Admin / Book Issue and Return Entry</span>	
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
								<button class="btn btn-primary" id="btnAdd">Add</button>
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
										<th>Issue Date</th>
										<th>Book Name</th>
										<th>Request Code</th>
										<th>Issued to ID</th>
										<th>Fine</th>
										<th>Return Date</th>
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




 
		<!-- Modal -->
		<div class="popupModal " id="FileUploadModal">
		  <div class="modal-dialog" role="document">
				 @csrf
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Requested Book</h5>
			        <button type="button" class="close" onClick="hidePopupFileUploadModal()" href="javascript:void(0);"><i class="fa fa-times"></i></button>
			      </div>
			      <div class="modal-body">



					<div class="row">
						<div class="col-lg-12">	
							<table id="tableMainPopup" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="display:none;">RequestId</th>
										<th>Request Code</th>
										<th>Date</th>
										<th>Book Name</th>
										<th>Req From ID</th>
										<th>Name</th>
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
					<button  class="btn btn-primary" id="btnIssue">Issue</button>
			      </div>
			    </div>

		  </div>

		</div>
		<!-- /Testimonial Section -->
		

 @endsection


@section('customjs')
<script>
	var tableMain;
	var tableMainPopup;
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
	

	/***Data Delete***/
	function onConfirmWhenIssueDelete(recordId) {

		$.ajax({
            type: "post",
            //url: "http://localhost/olms/deleteBookTypeRoute",
            url: SITEURL+"/deleteBookIssueRoute",
            
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
 



	/***Data return***/
	function onConfirmWhenReturnBook(recordId) {

		$.ajax({
            type: "post",
            //url: "http://localhost/olms/deleteBookTypeRoute",
            url: SITEURL+"/bookReturnRoute",
            
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

/***Data Delete***/
	function onConfirmWhenReturnDelete(recordId) {

		$.ajax({
            type: "post",
            //url: "http://localhost/olms/deleteBookTypeRoute",
            url: SITEURL+"/deleteBookReturnRoute",
            
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
 
 	var PopupFileUploadModal = document.getElementById('FileUploadModal');

	function showPopupFileUploadModal() {
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
		        url: SITEURL+"/bookrequestlistpopuptabledatafetch",
		        "datatype": "json",
		        "type": "post",
		        "data": {"_token":$('meta[name="csrf-token"]').attr('content')}
		    },
		    "fnDrawCallback" : function(oSettings) {
		        },
		    "columns":[
		        {"data":"RequestId","bVisible" : false},
		        {"data":"RequestCode","sWidth": "10%"},
		        {"data":"RequestDate","sWidth": "10%"},
		        {"data":"BookName","sWidth": "35%"},
		        {"data":"usercode","sWidth": "18%"},
		        {"data":"name","sWidth": "27%"}	       
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

		$('#btnAdd').on('click', function(){
			showPopupFileUploadModal();
		});


	 $('#btnIssue').click( function () {

	        //alert(  $('#tableMainPopup').DataTable().rows('.selected').data().length +' row(s) selected' );
	        var sList =  $('#tableMainPopup').DataTable().rows('.selected').data();
	       
	       if(sList.length == 0){
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
				toastr.error("Please, select requested book");

				}, 1300);

				return;
			}

			var sBooks = [];
	        $.each(sList, function(i, obj) {				
				 sBooks.push(obj.RequestId);
			});
			


			$.ajax({
            type: "post",
            url: SITEURL+"/IssueFromRequestListRoute",
            
            datatype:"json",
            data: {
            	"sBooks":sBooks,
        		"_token":$('meta[name="csrf-token"]').attr('content')
    		},
            success:function(response){

				var msg = "Book issueed successfully.";
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
		        "url": "<?php route('bookissuetabledatafetch') ?>",
		        "datatype": "json",
		        "type": "post",
		        "data": {"_token":$('meta[name="csrf-token"]').attr('content')}
		    },
		    "fnDrawCallback" : function(oSettings) {
	
		            if (oSettings.aiDisplay.length == 0) {
		                return;
		            }
		            
					$('a.fileUpload', tableMain.fnGetNodes()).each(function() {
		               
		                $(this).click(function() {
							
							var nTr = this.parentNode.parentNode;
		                    var aData = tableMain.fnGetData(nTr);

							$('#idFileUp').val(aData['BookId']);

							showPopupFileUploadModal();
		                    
		                });
		            });

		            $('a.issueDrop', tableMain.fnGetNodes()).each(function() {

		                $(this).click(function() {

		                    var nTr = this.parentNode.parentNode;
		                    var aData = tableMain.fnGetData(nTr);

		                    $.confirm({
		                    title: 'Are you sure?!',
		                    content: 'Do you really want to delete this issue?',
		                    icon: 'fa fa-question',
		                    theme: 'bootstrap',
		                    closeIcon: true,
		                    animation: 'scale',
		                    type: 'red',
		                    buttons: {
		                        confirm: function () {
		                            onConfirmWhenIssueDelete(aData['RequestId']);
		                        },
		                        cancel: function () {
		                            //$.alert('Canceled!');
		                        }
		                    }
		                });

		                });
		            });

		           

					
					$('a.returnItem', tableMain.fnGetNodes()).each(function() {

		                $(this).click(function() {

		                    var nTr = this.parentNode.parentNode;
		                    var aData = tableMain.fnGetData(nTr);
							
							
							if(aData['FineAmount']>0 && aData['FinePaid']!=1){
								setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
								toastr.error("Please, payment first fine amount.");
								}, 1300);
							}
							else{
								$.confirm({
									title: 'Are you sure?!',
									content: 'Do you really want to return this book?',
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
							}

		                });
		            });


 					$('a.returnDrop', tableMain.fnGetNodes()).each(function() {

		                $(this).click(function() {

		                    var nTr = this.parentNode.parentNode;
		                    var aData = tableMain.fnGetData(nTr);

		                    $.confirm({
		                    title: 'Are you sure?!',
		                    content: 'Do you really want to delete this return?',
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
		        {"data":"FineAmount","sWidth": "9%", "sClass": "align-right"},		        
		        {"data":"ReceiveDate","sWidth": "12%"},
		        {"data":"Status","sWidth": "10%", "sClass": "align-center"},
		        {"data":"action","sWidth": "10%", "sClass": "align-center", "bSortable": false},
		        {"data":"FinePaid", "bVisible": false}		       
		    ]
		});



	getMyNewPostCount();






/*

		
		
*/


	});


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
	window.open("./custom_script/report/bookissueandreturnlist_excel.php?loginuserid="+$("#loginuserid").val());
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