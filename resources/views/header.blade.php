<!-- header -->
    <header id="sticky-header" class="header style-1">
    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('public/images/logo.png') }}" alt="logo" />
                        </a>
                    </div>
                </div>

                <div class="col-lg-8 col-md-8">
                    <!-- Main Menu -->
                    <div class="menu-area d-none d-md-block">
                        <nav>
                            <ul class="main-menu pull-right clearfix">
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="https://www.24livenewspaper.com/bangla-newspaper" target="_blank">News</a></li>
                                @if(Auth::check())
          
                                    @if(Auth::user()->userrole =='Admin' || Auth::user()->userrole =='Teacher'  || Auth::user()->userrole =='Student')
                                        <li><a href="{{ url('dashboard') }}">Dashboard</a></li>

                                        <li><a href="JavaScript:Void(0);">Reports<span class="tp-angle pull-right"><i class="fa fa-angle-down"></i></span></a>
                                            <ul class="submenu">
                                               <li><a href="{{ url('availablebooklist') }}">Available Book List</a></li>
                                            </ul>
                                        </li>                                   


                                        <li><a href="JavaScript:Void(0);">Entry<span class="tp-angle pull-right"><i class="fa fa-angle-down"></i></span></a>
                                            <ul class="submenu">                                                     
                                                 <li><a href="{{ url('bookrequestentry') }}">Book Request Entry</a></li>
                                                @if(Auth::user()->userrole =='Admin') 
                                                    <li><a href="{{ url('bookrequestlist') }}">Pending Book Request List</a></li>
                                                    <li><a href="{{ url('bookissueentry') }}">Book Issue and Return Entry</a></li>
                                                    <li><a href="{{ url('alertsmslist') }}">Alert SMS List</a></li>
                                                    <li><a href="{{ url('finebooklist') }}">Fine Book List</a></li>
                                                @endif
                                            </ul>
                                        </li>                                        
                                    @endif      

                                    @if(Auth::user()->userrole =='Admin')  
                                        <li><a href="JavaScript:Void(0);">Admin<span class="tp-angle pull-right"><i class="fa fa-angle-down"></i></span></a>
                                            <ul class="submenu">
                                                <li><a href="{{ url('userentry') }}">User Entry</a>
                                                <li><a href="{{ url('bookentry') }}">Book Entry</a></li>
                                                <li><a href="{{ url('departmententry') }}">Department Entry</a></li>
                                                <li><a href="{{ url('booktypeentry') }}">Book Type Entry</a></li>
                                                <li><a href="{{ url('bookaccesstypeentry') }}">Book Access Type Entry</a></li>
                                                <li><a href="https://www.tidio.com/panel/dashboard" target="_blank">Chat Monitoring</a></li>
                                            </ul>
                                        </li>
                                    @endif


                                     @if(Auth::user()->userrole =='Admin' || Auth::user()->userrole =='Teacher'  || Auth::user()->userrole =='Student')
                                        <li><a href="{{ url('postentry') }}">Post</a></li>                                   
                                     @endif
                                   
                                @endif
                                <li><a href="{{ url('/') }}">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /Main Menu -->

                    <!-- Mobile Menu -->
                    <!--<div class="mobile-menu-area">
                        <nav id="mobile-menu">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="dashboard.php">Dashboard</a></li>
                                
                                <li><a href="#">Reports</a>
                                    <ul>
                                        <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                        <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Admin</a>
                                    <ul>
                                        <li><a href="shortcodes-testimonial.html">Testimonial</a></li>
                                        <li><a href="shortcodes-team.html">Team</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>-->
                    <!-- /Mobile Menu -->
                </div>
            </div>
        </div>
    </div>
</header>

<!-- /header -->