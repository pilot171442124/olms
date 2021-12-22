
@extends('olmslayout')

@section('titlename') Post View @endsection

@section('maincontent')
	

		<!-- Section -->
		<section class="bg-section ysuccess pt-10 pb-10" data-black-overlay="8" style="background-image: url({{ asset('public/images/background/bg-2.jpg') }})">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-7">
						<i class="fa fa-home white"></i> <span> / Post View</span>	
					</div>
					<div class="col-lg-5 align-right">
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

				<div id="postlist">
				
					<!--
					<div class="row">
						<div class="col-md-12">
							<article class="post style-2">
								<div class="post-header">
									<div class="post-meta">
										<span><i class="fa fa-clock-o"></i>01 September</span>
										<span><i class="fa fa-user"></i>Rubel</span>
										<span><i class="fa fa-gear"></i>Admin</span>
									</div>
									<div class="post-title">
										<span>Lorem ipsum dolor sit amet</span>
									</div>
								</div>
								<div class="post-content">
									<p>
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.
									</p>
								</div>
							</article>
						</div>
					</div>-->
				
				


				</div>
				
				
				
			</div>
		</section>

 		<!-- /Testimonial Section -->
		

 @endsection


@section('customjs')
<script>
var tableMain;
var SITEURL = '{{URL::to('')}}';

$(document).ready(function() {

	$.ajax({
        type: "post",
        dataType: "json",
        url: SITEURL+"/postviewRoute",
        data: {"_token":$('meta[name="csrf-token"]').attr('content')},
        success:function(response){

			var posthtml = "";
            //console.log(response);

			$.each(response, function(i, obj) {
				//$("#CarId").append($('<option></option>').val(obj.CarId).html(obj.CarName));
			
			    posthtml = '<div class="row">'+
							'<div class="col-md-12">'+
								'<article class="post style-2">'+
									'<div class="post-header">'+
										'<div class="post-meta">'+
											'<span><i class="fa fa-clock-o"></i>'+obj.PostDate+'</span>'+
											'<span><i class="fa fa-user"></i>'+obj.name+'</span>'+
											'<span><i class="fa fa-gear"></i>'+obj.userrole+'</span>'+
										'</div>'+
										'<div class="post-title">'+
											'<span>'+obj.PostTitle+'</span>'+
										'</div>'+
									'</div>'+
									'<div class="post-content">'+
										'<p>'+obj.Post+'</p>'+
									'</div>'+
								'</article>'+
							'</div>'+
						'</div>';

					 $("#postlist").append(posthtml);
				});


			
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
			toastr.error("Operation fail");

			}, 1300);

        }

    });


 updateLastPostViewDateByUser();
});



function updateLastPostViewDateByUser() {

	    $.ajax({
	        type: "post",
	        url: SITEURL+"/updateLastPostViewDateByUserRoute",
	        data: {
	        	"id":1,
        		"_token":$('meta[name="csrf-token"]').attr('content')
        	},
	        success:function(response){
	        	//$("#notificationcount").html(response);
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
				toastr.error("Last post view date cann't updated successfully");

				}, 1300);

	        }

	    });
	}


</script>

<style>
	.post-title{
		font-size: 20px;
	}
	.font-white {
    color: white !important;
}
</style>


 @endsection