<!DOCTYPE html>
<html class=" ">
    <head>
        <!-- 
         * @Package: Complete Admin - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: BS4-1.0
         * This file is part of Complete Admin Theme.
        -->
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Cng Safety Pakistan </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="../assets/images/apple-touch-icon-57-precomposed.png">   <!-- For iPhone -->
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


        <link href="../assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->
        <div class='page-topbar' >
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
    <!----------------------- showing envelop---------------------->
                            <!--<a href="#" data-toggle="dropdown" class="toggle">
                                data-toggle="dropdown" open dive to display messages
                            -->
                            <!--<a href="#"  class="toggle">
                                <i class="fa fa-envelope"></i>
                                <span class="badge badge-pill badge-accent">7</span>
                            </a>-->
        <!--------------------------- showing envelop-------------------->
    <!------6-envelopmessages.txt--------------->   
                            <ul class="dropdown-menu messages animated fadeIn">

                                <li class="list dropdown-item">
                                    <!-- displaying icons top left-->

                                    <ul class="dropdown-menu-list list-unstyled ps-scrollbar">

                                    </ul>

                                </li>


                            </ul>

                        </li>
                        <li class="notify-toggle-wrapper list-inline-item">
    <!-- showing bell -------------------------------------------------------------------->
                            <!-- <a href="#" data-toggle="dropdown" class="toggle">
                                aata-toggle="dropdown" displays popup fornotifications
                            -->
                            <!--<a href="#"  class="toggle">
                                <i class="fa fa-bell"></i>
                                <span class="badge badge-pill badge-accent">3</span>
                            </a>-->
    <!-- showing bell ---------------------------------------------------------------------->
                            <ul class="dropdown-menu notifications animated fadeIn">
                                <li class="total dropdown-item">
                                    <span class="small">
                                        You have <strong>3</strong> new notifications.
                                        <a href="javascript:;" class="float-right">Mark all as Read</a>
                                    </span>
                                </li>

                                <li class="list dropdown-item">
<!---- error comes with out this li --------------------------------------------------->                                    
<!-- bell messages ----------5-bell messages.txt--------------------------------------->


                                </li>-

<!---------------5b-bell messages2.txt-------------------------------------------->
                            </ul>
                        </li>
<!---------------5c-bell messages3.txt-------------------------------------------->                        

                    </ul>
                </div> 
<!----following div is for admin dropdown menue top right ----------------->     
                <div class='float-right'>
                    <ul class="info-menu right-links list-inline list-unstyled">
                        <li class="profile list-inline-item">
                            <a href="#" data-toggle="dropdown" class="toggle">
                                <img src="../data/profile/profile.jpg" alt="user-image" class="rounded-circle img-inline">
                                <span>{{ Auth::user()->name }} <i class="fa fa-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu profile animated fadeIn">
                                <!--<li class="dropdown-item">
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
                                </li> -->
                                <li class="last dropdown-item">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-lock"></i>
                                        {{ __('Logout') }}
                                        
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          {{ csrf_field() }}
                                    </form>
                                </li>


                            </ul>
                        </li>
<!------------------------------------------ showing top right comments---->

                        <!--<li class="chat-toggle-wrapper list-inline-item">
                            
                            <a href="#" data-toggle="chatbar" class="toggle_chat">
                                
                                <i class="fa fa-comments"></i>
                                <span class="badge badge-pill badge-accent">9</span>
                                <i class="fa fa-times"></i>
                            </a>                            
                        </li>-->
<!------------------------------------------ showing top right comments---->
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
                            <a href="#ui-profile">
                                <img alt="" src="../data/profile/profile.jpg" class="img-fluid rounded-circle">
                            </a>
                        </div>

                        <div class="profile-details col-8">

                            <h3>
                                <?php 
                                    
                                    $display ="Admin";
                                    if (Auth::user()->regtype=="admin" )
                                    {
                                        $display ="Admin";

                                    }else if (Auth::user()->regtype=="workshop" )
                                    {                                        
                                        if (Auth::user()->email =="4StarCNG@gmail.com")
                                        {
                                            $display='Demo Shop '.Auth::user()->stationno;    

                                        }   
                                        else {
                                        $display='Workshop '.Auth::user()->stationno;    
                                        }                         
                                    }else if (Auth::user()->regtype=="laboratory" )
                                    {
                                        $display=Auth::user()->labname;
                                    }

                                ?>
                                <a href="#">{{$display}}</a>
                                
                                <!--href = ui-profile.html-->

                                <!-- Available statuses: online, idle, busy, away and offline -->
                                <span class="profile-status online"></span>
                            </h3>

                            <p class="profile-title"></p> <!-- rehan-->

                        </div>

                    </div>
                    <!-- USER INFO - END -->


                    <!-- Left tree itesm -->
                    @yield('lefttree')
                    <!-- end of left categories -->
<!-----Left tree bottorm area------3-lefttreebottomarea.txt--------->                    


                </div>
                <!-- MAIN MENU - END -->



            </div>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                    @yield('content')
            </section>
            <!-- END CONTENT -->
            <div class="page-chatapi hideit">
                <!-- src="../assets/js/scripts.js"-->

                <!--<div class="search-bar">
                    <input type="text" placeholder="Search" class="form-control">
                </div>-->

                <div class="chat-wrapper" >
<!--javascript gives error with out this div------------1-chatwrapper.txt-------------------->
                    <!-- this div displays user icon over top - right-->
                    
                </div>
            </div>


<!--            <div class="chatapi-windows ">




            </div>    -->
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

        <script src="../assets/plugins/datepicker/js/datepicker.js" type="text/javascript"></script> <script src="../assets/plugins/autosize/autosize.min.js" type="text/javascript"></script>
        <script src="../assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
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

                        Body goes here...


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



