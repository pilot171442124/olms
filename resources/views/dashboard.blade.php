
@extends('olmslayout')

@section('titlename') Dashboard @endsection

@section('maincontent')
	

		<!-- Section -->
		<section class="bg-section ysuccess pt-10 pb-10" data-black-overlay="8" style="background-image: url({{ asset('public/images/background/bg-2.jpg') }})">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-7">
						<i class="fa fa-home white"></i> <span> / Dashboard</span>	
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

 
				<div class="row">
					<div class="col-lg-2">
						<div class="ibox ">
							<div class="ibox-content">
								<h1 class="no-margins" id="totalTeachers">0</h1>
								<span class="no-margins">Total Teachers</span>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="ibox">
							<div class="ibox-content">
								<h1 class="no-margins" id="totalStudents">0</h1>
								<span class="no-margins">Total Students</span>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="ibox">
							<div class="ibox-content">
								<h1 class="no-margins" id="totalMembers">0</h1>
								<span class="no-margins">Others Members</span>
							</div>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="ibox">
							<div class="ibox-content">
								<h1 class="no-margins" id="totalBookPending">0</h1>
								<span>Book Pending Request</span>
							</div>
						</div>
					</div>
					
					<div class="col-lg-2">
						<div class="ibox">
							<div class="ibox-content">
								<h1 class="no-margins" id="totalBooksinField">0</h1>
								<span>Books in Field</span>
							</div>
						</div>
					</div>
				</div>
 

				<div class="row">
					<div class="col-lg-12">
						<div class="ibox-content">
							<div id="issuedtrendbymonth"></div>
						</div>
					</div>
				</div>	

				
			</div>
		</section>

		

 @endsection

@section('extralibincludefooter')
   <!-- Highchart -->
	<script src="{{ asset('public/js/highcharts.js') }}" crossorigin="anonymous"></script>
	<script src="{{ asset('public/js/exporting.js') }}" crossorigin="anonymous"></script>
@endsection


@section('customjs')
<script>
	var tableMain;
 	var SITEURL = '{{URL::to('')}}';


	function getIssuedTrendData(){


		$.ajax({
	        type: "post",
	        url: SITEURL+"/getIssuedTrendDataRoute",
	        data: {
	        	"id":1,
	    		"_token":$('meta[name="csrf-token"]').attr('content')
	    	},
	        success:function(response){


				$("#issuedtrendbymonth").highcharts({
				chart: {
						type: "spline",
						height:350
					},
				title: {
					text: "Books Issued by Year-Month"
				},
				// subtitle: {
					// text: $("#StartDate").val()+" to "+$("#EndDate").val()+" and Accounts Head: "+$('#CarId').find(":selected").text()
				// },
				yAxis: {
					//gridLineWidth: 0,
					title: {
						text: 'Number of books'
					}
				},
				xAxis: {
					// categories: ["1 Aug 18", "2 Aug 18", "3 Aug 18", "4 Aug 18", "5 Aug 18", "6 Aug 18", "7 Aug 18", "8 Aug 18"]
					categories: response.category
					,labels: {
								 //enabled:false,//default is true
								 y : 20, rotation: -45, align: 'right' 
							}
				},
				legend: {
					layout: 'horizontal'
				},
				credits: {
						enabled: false
					},
				exporting: {
						filename: "Books_Issued_by_Year_Month"
					},
				tooltip: {
					shared: true,
					crosshairs: true
				},
				plotOptions: {
					series: {
						label: {
							connectorAllowed: false
						},
						marker: {
							//fillColor: '#FFFFFF',
							lineWidth: 1//,
							//lineColor: null // inherit from series
						}
					}
				},
				series: response.series
			});


	        },
	        error:function(error){
	            setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
				toastr.error("Can not fillup");

				}, 1300);

	        }

	    });


	}


function getDashboardBasicInfo() {

	    $.ajax({
	        type: "post",
	        url: SITEURL+"/getDashboardBasicInfoRoute",
	        data: {
	        	"id":1,
        		"_token":$('meta[name="csrf-token"]').attr('content')
        	},
	        success:function(response){
				$("#totalTeachers").html(response.gTeachersCount);
				$("#totalStudents").html(response.gStudentCount);
				$("#totalMembers").html(response.gMemberCount);
				$("#totalBooksinField").html(response.gBooksinFieldCount);
				$("#totalBookPending").html(response.gBookPendingCount);
	        },
	        error:function(error){
	            setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
				toastr.error("Can not fillup");

				}, 1300);

	        }

	    });
	}

	$(document).ready(function() {
		
		getDashboardBasicInfo();
		getIssuedTrendData();

	} );

</script>

<style>
.ibox {
	clear: both;
	margin-bottom: 25px;
	margin-top: 0;
	padding: 0;
}

.ibox-content {
	clear: both;
}
.ibox-content {
	background-color: #00587E;
	color: white;
	padding: 15px 20px 20px 20px;
	border-color: #e7eaec;
	border-image: none;
	border-style: solid solid none;
	border-width: 1px 0;
	text-align: center;
}

.ibox-content h1{
	color: white;
}
		
.font-white {
    color: white !important;
}

</style>


 @endsection