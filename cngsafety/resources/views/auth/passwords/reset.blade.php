
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
        <title>Cng Safety Pakistan : Login Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="../../assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="../../assets/images/apple-touch-icon-57-precomposed.png">   <!-- For iPhone -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../assets/images/apple-touch-icon-114-precomposed.png">    <!-- For iPhone 4 Retina display -->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->




        <!-- CORE CSS FRAMEWORK - START -->
        <link href="../../assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- <link href="../assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> -->
        <link href="../../assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 


        <link href="../../assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="../../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" login_page">

        <div class="container-fluid">
            <div class="login-wrapper row">
                <div id="login" class="col-xl-12" style=" padding-top: 0; margin-top: 0; ">


                     <div class="form-group row "  style="background-color: #31A4DD;">       
                        <div class="col-lg-3" >
                            <a href="http://www.ibex-pak.com/">
                            <img id='windscreen'  src="../../assets/images/ibex-logo.gif" width="250px;" height="200px" >
                            </a>                            
                        </div>                                                           
                        <div class="col-lg-3" >
                            <a href="https://www.ogra.org.pk/">
                            <img id='windscreen'  src="../../assets/images/ogra3.jpg" width="200px;" height="200px"  style="border-color: white; " border="0">
                            </a>                            
                        </div>         
                        <div class="col-lg-3" >
                            <a href="https://www.hdip.com.pk/">
                            <img id='windscreen'  src="../../assets/images/hdip-1.jpg" width="250px;" height="200px" >                   
                            </a>         
                        </div>       

                        <div class="col-lg-3" >
                            <a href="http://www.apcngassociation.com/">
                            <img id='windscreen'  src="../../assets/images/apcnga.jpg" width="250px;" height="200px" > 
                            </a> 
                        </div>                                                           

                     </div>




                 <h1 style="text-align: center;"><strong>Pakistan Cng Safety</strong></h1></div>

                <div id="login" class="login loginpage offset-xl-4 offset-lg-3 offset-md-3 offset-0 col-12 col-md-6 col-xl-4" >

                    <!--<h1><a href="#" title="Login Page" tabindex="-1">Cng Safety Pakistan</a></h1>-->

                    <form name="loginform" id="loginform" action="{{ route('password.update') }}" method="post">
                        {{ csrf_field() }}
                        <p>
                            updatelink: {{ route('password.update') }}
                            email:     {{ $email }}
                             
                            <label for="email">Email<br />
                                <input type="email" name="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}"  size="20" required autocomplete="off" placeholder="Email" /></label>
                                <span class="desc">e.g. "me@somesite.com"</span>
                                @if ($errors->has('email'))
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('email') }}</strong>
                                 </span>
                                @endif                                               
                        </p>

                        <p>
                            <label for="password">{{ __('Password') }}<br />
                                <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  size="20" required />
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif                 

                            </label>

                        </p>


                        <p>
                            <label for="password">{{ __('Confirm Password') }}<br />
                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  size="20" required />
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif                 

                            </label>

                        </p>



                        <p class="submit">
                            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-accent btn-block" value="{{ __('Reset Password') }}" />
                        </p>


                    </form>

                   
          


                </div>
            </div>


           <div class="form-group row "  >
               <div class="col-lg-12 divimg bold"  >
                        <p>
                        <h1 style="text-align: center; color:white; "> DATA ENTRY FOR CYLINDER TESTING LABS,</h1><br>
                        <h1 style="text-align: center;color:white;"> TEST STATIONS AND CNG KIT INSPECTION</h1><br>
                        <h1 style="text-align: center;color:white;"> WORKSHOPS.</h1><br>
                        </p>
               </div>
            </div>

        </div>




        <!-- MAIN CONTENT AREA ENDS -->
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

        <script src="../assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <!--<script src="../assets/js/scripts.js" type="text/javascript"></script> -->
        <!-- END CORE TEMPLATE JS - END --> 


        <!-- General section box modal start -->
        <!--<div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-hidden="true">
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
        </div>-->
        <!-- modal end -->

        <!--<div class="container-fluid" style=" padding-left: 0px; padding-right: 0px; ">
            <img id='windscreen'  src="../assets/images/cylinder.jpg" style="width:100%;height:250px;border:0;">
                    
        </div>  -->





    </body>
</html>






