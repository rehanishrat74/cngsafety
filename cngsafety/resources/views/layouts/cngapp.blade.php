
<!DOCTYPE html>
<html class=" " lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <!-- 
         * @Package: Complete Admin - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: BS4-1.0
         * This file is part of Complete Admin Theme.
        -->
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>CNG Safety Pakistan </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

            <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Registration') }}</title>


        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="../assets/images/apple-touch-icon-57-precomposed.png">	<!-- For iPhone -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/images/apple-touch-icon-114-precomposed.png">    <!-- For iPhone 4 Retina display -->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->




        <!-- CORE CSS FRAMEWORK - START -->
        <link href="../assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- <link href="../assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> -->
        <link href="../assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 


        <link href="../assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
            <div class='quick-area'>
                <div class='float-left'>
                    <ul class="info-menu left-links list-inline list-unstyled">
                        <li class="sidebar-toggle-wrap list-inline-item">
                            <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                        <li class="message-toggle-wrapper list-inline-item">
                            <a href="#" data-toggle="dropdown" class="toggle">
                                <i class="fa fa-envelope"></i>
                                <span class="badge badge-pill badge-accent">7</span>
                            </a>
                            <ul class="dropdown-menu messages animated fadeIn">

                                <li class="list dropdown-item">
                                    <!-- displaying icons top left-->

                                    <ul class="dropdown-menu-list list-unstyled ps-scrollbar">

                                    </ul>

                                </li>

                                <!--<li class="external">
                                    <a href="javascript:;">
                                        <span>Read All Messages</span>
                                    </a>
                                </li>-->
                            </ul>

                        </li>
                        <li class="notify-toggle-wrapper list-inline-item">
                            <a href="#" data-toggle="dropdown" class="toggle">
                                <i class="fa fa-bell"></i>
                                <span class="badge badge-pill badge-accent">3</span>
                            </a>
                            <!--<ul class="dropdown-menu notifications animated fadeIn">

                            </ul>-->
                        </li>
                    </ul>
                </div>		
                <div class='float-right'>
                    <ul class="info-menu right-links list-inline list-unstyled">
                        <li class="profile list-inline-item">
                            <a href="#" data-toggle="dropdown" class="toggle">
                                <img src="../data/profile/profile.jpg" alt="user-image" class="rounded-circle img-inline">
                                <span>{{ Auth::user()->name }} <i class="fa fa-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu profile animated fadeIn">
                                <li class="dropdown-item">
                                    <a href="#settings">
                                        <i class="fa fa-wrench"></i>
                                        Settings
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="#profile">
                                        <i class="fa fa-user"></i>
                                        Profile
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="#help">
                                        <i class="fa fa-info"></i>
                                        Help
                                    </a>
                                </li>
                                <li class="last dropdown-item">
                                    <a href="ui-login.html">
                                        <i class="fa fa-lock"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>			
                </div>		
            </div>

        </div>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid container-fluid">

            <!-- Left SIDEBAR - START -->

            <div class="page-sidebar fixedscroll">

                <!-- MAIN MENU - START -->
                <div class="page-sidebar-wrapper" id="main-menu-wrapper"> 

                    <!-- USER INFO - START -->
                    <div class="profile-info row">

                        <div class="profile-image col-4">
                            <a href="ui-profile.html">
                                <img alt="" src="../data/profile/profile.jpg" class="img-fluid rounded-circle">
                            </a>
                        </div>

                        <div class="profile-details col-8">

                            <h3>
                                <a href="ui-profile.html">Admin</a>

                                <!-- Available statuses: online, idle, busy, away and offline -->
                                <span class="profile-status online"></span>
                            </h3>

                            <p class="profile-title"></p> <!- rehanishrat ->

                        </div>

                    </div>
                    <!-- USER INFO - END -->


                    <!-- Left tree itesm -->
                    <ul class='wraplist'>	

                        <li class='menusection'>Main</li>
                        <li class="open"> 
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>

                        <li class=""> 
                            <a href="/categories">
                                <i class="fa fa-sort-amount-asc"></i>
                                <span class="title">Cylinders</span>
                            </a>
                        </li>


                    </ul>



                </div>
                <!-- MAIN MENU - END -->



            </div>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START -->
                                <h1 class="title">Dashboard</h1>
                                <!-- PAGE HEADING TAG - END -->              
                            </div>


                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- MAIN CONTENT AREA STARTS -->
                    <div class="row margin-0">
                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Cylinders Made</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="" style="height:200px" id="platform_type_dates"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    
                        </div>



                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Vehicle Registered</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="" style="height:200px" id="user_type"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    
                        </div>



                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Vehicle Expired</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="" style="height:200px" id="browser_type"></div>
                                            </div>


                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    
                        </div>



                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Coming Expiries</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="chart has-fixed-height" style="height:200px" id="scatter_chart"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    
                        </div>-

                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Today Registrations</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="chart has-fixed-height" style="height:200px" id="page_views_today"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    
                        </div>


                        <!--<div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Server Load</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="chart has-fixed-height" style="height:200px" id="gauge_chart"></div>
                                            </div>
                                        </div>      
                                    </div> <!-#- End .row -#->
                                </div>
                            </section>    
                        </div>
                    </div>-->

                    <div class="clearfix"></div>
                    <div class="col-xl-12">
                        <section class="box nobox marginBottom0">
                            <div class="content-body">    
                                <div class="row">
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-thumbs-up icon-md icon-rounded icon-primary'></i>
                                            <div class="stats">
                                                <h4><strong>5000</strong></h4>
                                                <span>+Registerations</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-shopping-cart icon-md icon-rounded icon-accent'></i>
                                            <div class="stats">
                                                <h4><strong>4000</strong></h4>
                                                <span>Cylinders Tested</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-dollar icon-md icon-rounded icon-purple'></i>
                                            <div class="stats">
                                                <h4><strong>$500</strong></h4>
                                                <span>Cylinders Expired</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-users icon-md icon-rounded icon-warning'></i>
                                            <div class="stats">
                                                <h4><strong>1000</strong></h4>
                                                <span>Coming Expiries</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End .row -->    
                            </div>
                        </section>
                    </div>


                    <div class="col-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">CNG Labs</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">    
                                <div class="row">
                                    <div class="col-12">
                                        <div class="wid-vectormap">
                                            <div class="row">
                                                <div class="col-12 col-md-9">
                                                    <figure>
                                                        <div id="db-world-map-markers" style="width: 100%; height: 300px"></div>        
                                                    </figure>
                                                </div>
                                                <div class="map_progress col-12 col-md-3">
                                                    <h4>New Vehicle Registrations</h4>
                                                    <span class='text-muted'><small>Last Week Rise by 62%</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%"></div></div>
                                                    <br>
                                                    <h4>Cylinders Tested</h4>
                                                    <span class='text-muted'><small>Up by 57% last 7 days</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%"></div></div>
                                                    <br>
                                                    <h4>Cylinders Expired</h4>
                                                    <span class='text-muted'><small>Last Month Rise by 22%</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100" style="width: 22%"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div> <!-- End .row -->


                            </div>
                        </section>
                        
                    </div>
<!--  ----------------my pages area -------------------------->
                    <div class="col-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">Cylinder Categories</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">    
                                <div class="row">
                                    <div class="col-12">
                                        <div class="wid-vectormap">
                                            <div class="row">
                                                <div class="col-12 col-md-9">
                                                    <figure>
                                                        <div id="db-world-map-markers" style="width: 100%; height: 300px">hello testing</div>        
                                                    </figure>
                                                </div>
                                                <div class="map_progress col-12 col-md-3">
                                                    right div for notifications
                                                    <!--<h4>Unique Visitors</h4>
                                                        right div for notifications
                                                    <span class='text-muted'><small>Last Week Rise by 62%</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%"></div></div>
                                                    <br>
                                                    <h4>Registrations</h4>
                                                    <span class='text-muted'><small>Up by 57% last 7 days</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%"></div></div>
                                                    <br>
                                                    <h4>Direct Sales</h4>
                                                    <span class='text-muted'><small>Last Month Rise by 22%</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100" style="width: 22%"></div></div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div> <!-- End .row -->


                            </div>
                        </section>
                        
                    </div>
<!-- ++++++++++++++++++++++++end my page area ---------------->

                    <!-- MAIN CONTENT AREA ENDS -->
                </section>
            </section>
            <!-- END CONTENT -->
            <div class="page-chatapi hideit">
                <div class="chat-wrapper">
                    <!-- this div displays user icon over top - right-->
                </div>
            </div>

        </div>
        <!-- END CONTAINER -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
        <script src="../assets/js/popper.min.js" type="text/javascript"></script> 
        <script src="../assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="../assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="../assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="../assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <script>window.jQuery || document.write('<script src="../assets/js/jquery-1.11.2.min.js"><\/script>');</script>
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 

        <script src="../assets/plugins/jvectormap/jquery-jvectormap-2.0.1.min.js" type="text/javascript"></script>
        <script src="../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <script src="../assets/js/dashboard.js" type="text/javascript"></script>
        <script src="../assets/plugins/echarts/echarts-custom-for-dashboard.js" type="text/javascript"></script>
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="../assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 


        <!-- General section box modal start -->
        <div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Section Settings</h4>
                    </div>
                    <div class="modal-body">
                                    
                                        @yield('content')
                                    

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                        <button class="btn btn-success" type="button">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
    </body>
</html>



