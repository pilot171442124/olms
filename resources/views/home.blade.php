@extends('olmslayout')


@section('titlename') Home @endsection

@section('maincontent')

    <!-- Section authentication -->
    <section class="bg-section ysuccess pt-10 pb-10" data-black-overlay="8" style="background-image: url({{ asset('public/images/background/bg-2.jpg') }})">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 align-right">
                     @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                                <a class="notification-ico" href="{{ url('postview') }}"><i class="fa fa-bell"></i> <sup><span id="notificationcount"></span></sup></a>
                                <span>Hi,</span> <a href="{{ url('profile') }}" <span class="font-white"><u>{{ Auth::user()->name }}</u></span> </a>
                                <a class="btn btn-primary mb-0" href="{{ url('logout') }}"><i class="fa fa-lock"></i> {{ __('Logout') }}</a>
                            @else
                                <a class="btn btn-primary mb-0" href="{{ route('login') }}"><i class="fa fa-unlock"></i> {{ __('Login') }}</a>

                                @if (Route::has('register'))
                                    <a class="btn btn-success mb-0" href="{{ route('register') }}"><i class="fa fa-user-plus"></i> {{ __('Register') }}</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /Section authentication-->   

    <!-- Slider Section -->
    <div class="slider-section">
        <div class="single-slider slider-screen" data-black-overlay="5" style="background-image:url({{ asset('public/images/slider/slider-2.jpg') }});">
            <div id="particles-js"></div>
            <div class="container">
                <div class="slider-content style-1">
                    <p>Welcome to Online</p>
                    <h2>Library Management System</h2>
                    <!--<a class="btn blue-btn" href="#">Read More About Us</a>-->
                </div>
            </div>
        </div>
    </div>
    <!-- /Slider Section -->
    <!-- Featured Section -->
    <section class="featured-area style-1">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-3 col-md-3">
                    <div class="featured-item">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        <h3>Admin</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="featured-item active">
                        <i class="fa fa-group" aria-hidden="true"></i>
                        <h3 class="active">Teacher</h3>
                        <p class="active">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="featured-item">
                        <i class="fa fa-group" aria-hidden="true"></i>
                        <h3>Student</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="featured-item active">
                        <i class="fa fa-handshake-o" aria-hidden="true"></i>
                        <h3 class="active">Others</h3>
                        <p class="active">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Featured Section -->

    <!-- About Us Section -->
    <section class="about-area pt-50 pb-90">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <div class="section-heading mb-70">
                        <h2>About Us</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 mb-30">
                    <div class="about-text">
                        <h3>Publicly accessable e-book</h3>
                        <table id="tableMain" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                   <th style="display:none;">BookId</th>
                                    <th>Book Name</th>
                                    <th>Author</th>
                                    <th></th>
                                    <th style="display:none;">isValid</th>
                                    <th style="display:none;">URL</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-lg-5 mb-30">
                    <div class="about-img-1">
                        <img src="{{ asset('public/images/about/about-2.jpg') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /About Us Section -->

@endsection


@section('customjs')

<!-- particles js -->
<script src="{{ asset('public/js/particles.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('public/js/app.js') }}" crossorigin="anonymous"></script>

<script>
    var tableMain;
    var SITEURL = '{{URL::to('')}}';
    $(document).ready(function() {


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
            "aLengthMenu" :[[10, 15], [10, 15]],
            "iDisplayLength" : 10,
            "ajax":{
                "url": "<?php route('publicBookTableDataFetch') ?>",
                "datatype": "json",
                "type": "post",
                "data": {"_token":$('meta[name="csrf-token"]').attr('content')}
            },
            "fnDrawCallback" : function(oSettings) {
                    if (oSettings.aiDisplay.length == 0) {
                        return;
                    }

                     $('a.fileDownload', tableMain.fnGetNodes()).each(function() {

                        $(this).click(function() {

                            var nTr = this.parentNode.parentNode;
                            var aData = tableMain.fnGetData(nTr);

                            if(aData['IsValid'] == 0){
                                setTimeout(function() {
                                    toastr.options = {
                                        closeButton: true,
                                        progressBar: true,
                                        showMethod: 'slideDown',
                                        timeOut: 4000
                                    };
                                toastr.error("Please login first");

                                }, 1300);
                            }
                            if(aData['IsValid'] == 1){
                                //alert(aData['Url']);
                                if(aData['Url'] === null){

                                    setTimeout(function() {
                                        toastr.options = {
                                            closeButton: true,
                                            progressBar: true,
                                            showMethod: 'slideDown',
                                            timeOut: 4000
                                        };
                                    toastr.error("E-book not published yet");

                                    }, 1300);
                                }
                                else{
                                    
                                    window.open("storage/app/"+aData['Url'], '_blank'); 
                                }
                            }
                        });
                    });

                },
               "columns":[
                    {"data":"BookId","bVisible" : false},
                    {"data":"BookName","sWidth": "50%", "sClass": "align-left"},
                    {"data":"AuthorName","sWidth": "40%", "sClass": "align-left"},
                    {"data":"action","sWidth": "10%", "sClass": "align-center", "bSortable": false},
                    {"data":"IsValid","bVisible" : false},
                    {"data":"Url","bVisible" : false}
                ]
        });


        getMyNewPostCount();
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
</script>

<style>

.font-white {
    color: white !important;
}
</style>
@endsection