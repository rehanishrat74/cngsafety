
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
        <meta name ="viewport" content="width=device-width",initial-scale=1.0, maximum-scale=1.0,user-scalable=no/>
        
        

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
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 


        <link href="../assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>
        <!--<link href="../assets/plugins/datatables/css/datatables.min.css" rel="stylesheet" type="text/css" media="screen"/>-->


        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->



<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
      
      <script>
         function searchSticker() {
            //alert('infunction');
              var x = document.getElementById("searchvalue");
              //alert(x.value);
            $.ajax({
               type:'GET',
               url:'/searchSticker/'.concat(x.value) ,
               data:'_token = <?php echo csrf_token() ?>',
               //data:{stickerNo:x.value},
               success:function(data) {
                //console.log(data);
                  $("#kizzlerDisplay").html(data);
                  //$("#kizzlerDisplay").style.display="block";
                    var x = document.getElementById("kizzlerDisplay");
                    if (x.style.display === "none") {
                        x.style.display = "block";
                        }
               }
            });
         }
      </script>

<style>
div.sticky {
  /*position: -webkit-sticky;
  position: relative;
  /*top: 0;
  padding: 5px;*/
  
  background-color: #cae8ca;
  border: 2px solid #4CAF50;
}
</style>

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <!--<body class=" login_page" >-->
    <body class=" login_page" >


        <div class="container-fluid" >

            <div class="login-wrapper row" >


                <div id="login" class="col-xl-12" style="  padding-top: 0; margin-top: 0;   " >

                     <div class="form-group row "  style="background-color: #31A4DD;">       
                        <div class="col-lg-3" >
                            <a href="http://www.ibex-pak.com/">
                            <img id='windscreen'  src="../assets/images/ibex-logo.gif" width="250px;" height="200px" >
                            </a>                            
                        </div>                                                           
                        <div class="col-lg-3" >
                            <a href="https://www.ogra.org.pk/">
                            <img id='windscreen'  src="../assets/images/ogra3.jpg" width="200px;" height="200px"  style="border-color: white; " border="0">
                            </a>                            
                        </div>         
                        <div class="col-lg-3" >
                            <a href="https://www.hdip.com.pk/">
                            <img id='windscreen'  src="../assets/images/hdip-1.jpg" width="250px;" height="200px" >                   
                            </a>         
                        </div>       

                        <div class="col-lg-3" >
                            <a href="http://www.apcngassociation.com/">
                            <img id='windscreen'  src="../assets/images/apcnga.jpg" width="250px;" height="200px" > 
                            </a> 
                        </div>                                                           

                     </div>
                        <!--<div class="col-lg-12" >
                            Helpline: 051-4901444
                            Email: cng.safety.taskforce@gmail.com
                        </div>-->

                     <div class="form-group row " >       
                        <div class="col-lg-1" >
                            &nbsp;
                        </div>                        
                        <div class="col-lg-8" >
                            
                                <h1 style="text-align: center;"><strong>Pakistan Cng Safety</strong></h1>
                                <h5 style="text-align: center; font-style: italic; ">Promoting Green, Clean Fuel with Safety for all</h5>
                                <h6 style="text-align: center;">Compressed Natural Gas is not only a Clean, Green and economical alternative Fuel, it is safe and user friendly</h6>
                                <h6 style="text-align: center;">
                                We need to learn the safety precautions as associated with all types of fuels</h6>
<script id="godaddy-security-s" src="https://cdn.sucuri.net/badge/badge.js" data-s="2002" data-i="dfac4ca75999863a0c7b8c6ca49322e7a73bbadcf4" data-p="o" data-c="d" data-t="g"></script>
                        </div>
                        <div class="sticky col-xl-3" >
                            <h6 style="text-align: center;"><strong>Email:</strong></h6>
                            <h6 style="text-align: center;">cng.safety.taskforce@gmail.com</h6>
                            <h6 style="text-align: center;"><strong>Helpline:</strong></h6>
                            <h6 style="text-align: center;">051-4901444</h6>
                        </div>                            
                     </div>
                    <!--<form id="searchkizzler" method="POST" action="{{route('testedcylinders-search')}}">
                                    {{ csrf_field() }}-->
                     <div class="form-group row " >
                        
                            <div class="col-lg-4" ></div>
                            <div class="col-lg-4" >
                                <div class="form-group row " >
                                    <div class="col-lg-8" >

                                        <input type="text" class="form-control search-page-input" placeholder="Sticker No" value="" autocomplete="off" id="searchvalue" name="searchvalue">
                                    </div>
                                    <div class="col-lg-4" >
                                            <div class="input-group">
                                                    <p class="submit">
                                                        <input type="button" name="wp-button" id="wp-button" class="btn btn-primary  float-right" value="Search" style="background-color: #31A4DD; " 
                                                            onclick="searchSticker() ;"/>
                                                     </p>     
                                            </div>                                
                                    </div>
                                </div>              
                            </div>
                            <div class="col-lg-4" ></div>                    
                     </div>                     
                     <div id="kizzlerDisplay" class="form-group row " style=" display: none; text-align: center;">

                     </div>
                     <!--</form> -->


                    <!--<div class="form-group row " >       
                        <div class="col-lg-12" >
                            <p></p>
                        </div>                        
                    </div> -->

                                    <div class="form-group row " >       
                                        <div class="col-lg-12"  >
                                            <div class="form-group row"  >

                                            <div class="col-lg-3" style="border-color: #B6B6B6; border-width:5px; border-style: solid;  border-bottom-color: #31A4DD; margin: 0 auto;"  >


                                                <div class="form-group row "  >
                                                    
                                                    <div class="col-lg-12"  >
                                                        <a href="{{route('login')}}" >
                                                        <div class="adminsignup">
                                                            <!--<a href="{{route('login')}}" >
                                                                <img id='windscreen'  src="../assets/images/Administrator.jpg" style="width:21em;height:200px;border:0; ">
                                                                -
                                                            </a>-->
                                                        </div>                    
                                                        </a>                                    
                                                    </div>

                                                    <div class="col-lg-12"  >
                                                        <div class="input-group">
                                                            <h1 style="  color: #31A4DD; text-align: center; "> Administrator</h1>                  
                                                        </div>
                                                    </div>                                           

                                                    <div class="col-lg-12"  >
                                                        <div class="input-group">
                                                            <p class="submit">
                                                                <input type="button" name="wp-button" id="wp-button" class="btn btn-primary btn-block float-right" value="Sign Up" style="background-color: #31A4DD; " 
                                                                onclick="document.location.href= '{{route('login')}}' ;"/>
                                                            </p>                        
                                                        </div>
                                                    </div>         
                                                </div>






                                            </div>                                         



                                            <div class="col-lg-3"  style="border-color: #B6B6B6; border-width:5px; border-style: solid; margin: 0 auto; border-bottom-color: #31A4DD;">



                                                <div class="form-group row "  >
                                                    <div class="col-lg-12"  >
                                                        <!--<a href="{{route('preworkshoplogin')}}">-->
                                                        <a href="http://cngsafety.test/signup_workshop">
                                                        <div class="workshopsignup">          
                                                        </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-12"  >
                                                        <div class="input-group">
                                                        <h1 style="  color: #31A4DD; text-align: center;">Workshops </h1>                     
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12"  >
                                                        <div class="input-group">
                                                            <p class="submit">
                                                                <input type="button" name="wp-button" id="wp-button" class="btn btn-primary btn-block float-right" value="Sign Up" style="background-color: #31A4DD; " 
                                                                onclick="document.location.href= '{{route('preworkshoplogin')}}' ;"/>
                                                            </p>                                                                                                                           
                                                        </div>
                                                    </div>    
                                                </div>

                                            </div>    




                                            <div class="col-lg-3"  style="border-color: #B6B6B6; border-width:5px; border-style: solid; margin: 0 auto; border-bottom-color: #31A4DD;">                          

                                                <div class="form-group row "  >

                                                    <div class="col-lg-12"  >
                                                        <a href="{{route('prelablogin')}}">
                                                        <div class="labsignup"> 
                                                        </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-12"  >
                                                        <div class="input-group">
                                                            <h2 style="  color: #31A4DD; text-align: center; ">Cng Laboratories </h2>             
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12"  >
                                                        <div class="input-group">
                                                            <p class="submit">
                                                                <input type="button" name="wp-button" id="wp-button" class="btn btn-primary btn-block float-right" value="Sign Up" style="background-color: #31A4DD; " 
                                                                onclick="document.location.href= '{{route('prelablogin')}}' ;"/>
                                                            </p>                                                                                                                           
                                                        </div>
                                                    </div>                                                                                                        
                                                </div>


                                            </div>
                                            </div> 
                                        </div>
                                    </div>     
                            




                    <p id="nav">
                        <!--<a class="float-left" href="{{ route('password.request') }}" title="Password Lost and Found">Forgot password?</a>-->
                        <!--<a class="float-right" href="{{ route('register') }}" title="Sign Up">Sign Up</a>-->
                    </p>


                </div>
            </div>
                <!--<div class="container-fluid" style=" padding-left: 0px; padding-right: 0px; ">
                    <img id='windscreen'  src="../assets/images/footer.jpeg" style="height:250px;border:0;" >                            
                </div> -->



           <div class="form-group row "  >
               <div class="col-lg-12 divimg bold"  >
                        <!--<p>
                        <h1 style="text-align: center; color:white; "> DATA ENTRY FOR CYLINDER TESTING LABS,</h1><br>
                        <h1 style="text-align: center;color:white;"> TEST STATIONS AND CNG KIT INSPECTION</h1><br>
                        <h1 style="text-align: center;color:white;"> WORKSHOPS.</h1><br>
                        </p>-->
                        
                        <p>&nbsp;</p>
                        <p style="margin: 0 auto;">
                        <h1 style="text-align: center; color:white; "> DATA ENTRY FOR CYLINDER TESTING LABS,<br>
                        TEST STATIONS AND CNG KIT INSPECTION<br>
                        WORKSHOPS.</h1>
                        </p>                        
               </div>
            </div>







<!--style="background-image: url('../assets/images/tomb.jpg');background-repeat: no-repeat;background-size: 100% 100% ;-->
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

        <script>
function hideKizzler() {
  var x = document.getElementById("kizzlerDisplay");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
        <!-- CORE JS FRAMEWORK - END --> 
        <!-- modal end -->



    </body>
</html>






