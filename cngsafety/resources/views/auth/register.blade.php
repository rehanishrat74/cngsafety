

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
        <title>Cng Safety Pakistan : Registration Page</title>
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


        <link href="../assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" login_page">



        <div class="container-fluid">



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



            <h1 style="text-align: center;"><strong>Pakistan Cng Safety</strong></h1>
            <div class="register-wrapper row" style=" padding-top: 0; margin-top: 0; ">

                <!--<div id="login" class="col-xl-12" style=" padding-top: 0; margin-top: 0; ">
                 <h1 style="text-align: center;"><strong>Pakistan Cng Safety</strong></h1></div>-->                
                <div id="register" class="login loginpage offset-xl-4 offset-lg-3 offset-md-3 offset-0 col-12 col-md-6 col-xl-4" >
                    <!--<h1><a href="#" title="Login Page" tabindex="-1">CNG Safety Pakistan</a></h1>-->

                    <form name="loginform" id="loginform" action="{{ route('register') }}" method="post">
                        {{ csrf_field() }}
                        <?php 
                            $regtype="admin";
                            $superuserlabel="Registration Type";
                            $labelname="Name";
                            $lableworkshoporlab="Laboratory Name";

                            $route=Request::route()->getName();
                            
                            if ($route=="register")
                            {
                                $regtype="admin";
                                $superuserlabel="Super admin";
                                $labelname="Admin Name";

                            }
                            else if ($route=="workshoplogin"){
                                $regtype="workshop";
                                $labelname="Workshop Name";
                                $lableworkshoporlab="Workshp Name";
                            }
                            else if ($route=="laboratorylogin"){
                                $regtype="laboratory";
                                $labelname=''; //"Owner Name";
                                $lableworkshoporlab="Laboratory Name";
                            }
                            else if ($route=="ogralogin"){
                                $regtype="Ogra";

                            }

                        ?>


                                <input type="hidden" name="regtype" id="regtype" class="form-control{{ $errors->has('regtype') ? ' is-invalid' : '' }}" 
                                value="{{ $regtype }}" required size="20" autocomplete="off" 
                                 />


                                <!--<input type="hidden" name="name" id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$regtype}} "  size="20"/>-->

                        
                                <!--<label for="nickname">{{$labelname}}</label>-->
                                @if ($regtype=="admin") 
                                <input type="text" name="nickname" id="nickname" class=" text-dark form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" value="{{ old('nickname') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Admin Name" 
                                />                                

                                    @if ($errors->has('nickname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nickname') }}</strong>
                                        </span>
                                    @endif
                                @endif
                            
                        <!--<p> </p>-->
                            @if ($regtype=="laboratory") 
                                <!--<label for="labname">{{$lableworkshoporlab}}</label>-->
                                <input type="text" name="labname" id="labname" class=" text-dark form-control{{ $errors->has('labname') ? ' is-invalid' : '' }}" value="{{ old('labname') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="{{$lableworkshoporlab}}" 
                                />                                

                                @if ($errors->has('labname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('labname') }}</strong>
                                    </span>
                                @endif                            

                                 <input type="text" name="companyname" id="companyname" class=" text-dark form-control{{ $errors->has('companyname') ? ' is-invalid' : '' }}" value="{{ old('companyname') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Company Name" 
                                />    
                                @if ($errors->has('companyname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('companyname') }}</strong>
                                    </span>
                                @endif                            

                                 <input type="text" name="engineername" id="engineername" class=" text-dark form-control{{ $errors->has('engineername') ? ' is-invalid' : '' }}" value="{{ old('engineername') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Princple Engineer Name" 
                                />    
                                @if ($errors->has('engineername'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('engineername') }}</strong>
                                    </span>
                                @endif                            

                                 <input type="text" name="landlineno" id="landlineno" class=" text-dark form-control{{ $errors->has('landlineno') ? ' is-invalid' : '' }}" value="{{ old('landlineno') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Land Line No" 
                                />    
                                @if ($errors->has('landlineno'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('landlineno') }}</strong>
                                    </span>
                                @endif                            


                                 <input type="text" name="mobileno" id="mobileno" class=" text-dark form-control{{ $errors->has('mobileno') ? ' is-invalid' : '' }}" value="{{ old('mobileno') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Mobile No" 
                                />    
                                @if ($errors->has('mobileno'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobileno') }}</strong>
                                    </span>
                                @endif                            


                            @endif

                            @if ($regtype=="workshop") 
                                
                                <input type="text" name="nickname" id="nickname" class=" text-dark 
                                form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" value="{{ old('nickname') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Workshop Name" 
                                />                                

                                    @if ($errors->has('nickname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nickname') }}</strong>
                                        </span>
                                    @endif

                                

                               <!--<label for="ownername">Owner Name</label><br />-->
                                <input type="text" name="ownername" id="ownername" class=" text-dark form-control{{ $errors->has('ownername') ? ' is-invalid' : '' }}" value="{{ old('ownername') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Owner Name" 
                                />    
                                @if ($errors->has('ownername'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ownername') }}</strong>
                                    </span>
                                @endif                            


                               <!--<label for="ownercellno">Owner Cell No</label><br />-->
                                <input type="text" name="ownercellno" id="ownercellno" class=" text-dark form-control{{ $errors->has('ownercellno') ? ' is-invalid' : '' }}" value="{{ old('ownercellno') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Owner Cell No" 
                                />    
                                @if ($errors->has('ownercellno'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ownercellno') }}</strong>
                                    </span>
                                @endif                            

                               <!--<label for="technician">Name Of Principle Technician</label><br />-->
                                <input type="text" name="technician" id="technician" class=" text-dark form-control{{ $errors->has('technician') ? ' is-invalid' : '' }}" value="{{ old('technician') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Name Of Principle Technician" 
                                />    
                                @if ($errors->has('technician'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('technician') }}</strong>
                                    </span>
                                @endif                            

                               <!--<label for="cellnoforinspection">Cell No To Be Used For Inspection</label><br />-->
                                <input type="text" name="cellnoforinspection" id="cellnoforinspection" class=" text-dark form-control{{ $errors->has('cellnoforinspection') ? ' is-invalid' : '' }}" value="{{ old('cellnoforinspection') }}"  required size="20" autocomplete="off" placeholder="Cell To Be Used For Inspection" 
                                style="border: 0.5px solid #e1e1e1 !important" 
                                />    
                                @if ($errors->has('cellnoforinspection'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cellnoforinspection') }}</strong>
                                    </span>
                                @endif                            

                            @endif

                               <!--<label for="province">Province</label><br />-->

                                <select class="form-control" id="province" name="province" >
                                    <option value="Capital">Capital</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Sindh" >Sindh</option>
                                    <option value="Khyber Pakhtunkhwa">Khyber Pakhtunkhwa</option>
                                    <option value="Balochistan">Balochistan</option>
                                </select>

                                <br>
                               <!--<label for="city">City</label><br />-->
                                <select class="form-control" id="city" name="city" >
                                    <option value="Islamabad">Islamabad</option>

                                </select>                                


                               <!--<label for="address">Address</label><br />-->
                                <input type="text" name="address" id="address" class=" text-dark form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Address" 
                                />    
                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif

                               <!--<label for="address">Contact No</label><br />-->
                                <input type="text" name="contactno" id="contactno" class=" text-dark form-control{{ $errors->has('contactno') ? ' is-invalid' : '' }}" value="{{ old('contactno') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Contact No" 
                                />    
                                @if ($errors->has('contactno'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('contactno') }}</strong>
                                    </span>
                                @endif

                                
                        
                            <!--<label for="email">Email</label><br />-->
                                <input type="email" name="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required value="{{ old('email') }}" size="20" autocomplete="off" placeholder="Email" /></label>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif                                
                        <!--<p></p>-->

                        
                            <!--<label for="password">Password<br />-->
                                <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required  size="20" placeholder="Password" />
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif                                

                            </label>
                        <!--<p></p>-->

                        
                            <!--<label for="password-confirm">Confirm Password<br />-->
                                <input type="password" name="password_confirmation" required id="password-confirm" class="form-control" value="" size="20" placeholder="Confirm Password" /></label>
                        <!--<p></p>-->




                            @if ($regtype=="laboratory") 

                                 <input type="text" name="ownername" id="ownername" class=" text-dark form-control{{ $errors->has('ownername') ? ' is-invalid' : '' }}" value="{{ old('ownername') }}"  required size="20" autocomplete="off" 
                                style="border: 0.5px solid #e1e1e1 !important" placeholder="Owner Name" 
                                />    
                                @if ($errors->has('ownername'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ownername') }}</strong>
                                    </span>
                                @endif                            

                               <!--<label for="hdip_lic_no">HDIP Lic No<br />-->
                                <input type="text" name="hdip_lic_no" id="hdip_lic_no" class=" text-dark form-control{{ $errors->has('hdip_lic_no') ? ' is-invalid' : '' }}" value="{{ old('hdip_lic_no') }}"  required size="20" autocomplete="off" placeholder="HDIP Lic No" 
                                style="border: 0.5px solid #e1e1e1 !important" 
                                />    
                                @if ($errors->has('hdip_lic_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hdip_lic_no') }}</strong>

                                    </span>
                                @endif

                                <!--</label> -->
                               <!--<label for="hdip_loginid">HDIP Login Email<br />-->
                                <!--<input type="email" name="hdip_loginid" id="hdip_loginid" class=" text-dark form-control{{ $errors->has('hdip_loginid') ? ' is-invalid' : '' }}" value="{{ old('hdip_loginid') }}"  required size="20" autocomplete="off" placeholder="HDIP Login Email" 
                                style="border: 0.5px solid #e1e1e1 !important" 
                                />    
                                @if ($errors->has('hdip_loginid'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hdip_loginid') }}</strong>
                                    </span>
                                @endif 
                            </label>--->

                            <!--<label for="password">HDIP Password <br />-->
                                <!--<input type="password" name="hdip_password" id="hdip_password" class="form-control{{ $errors->has('hdip_password') ? ' is-invalid' : '' }}" required  size="20" placeholder="HDIP Password" />
                                @if ($errors->has('hdip_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hdip_password') }}</strong>
                                    </span>
                                @endif                                

                            </label>-->

                            @endif
                                        <!--{{print_r($errors)}}  -->

                        <p class="forgetmenot">
                            <label class="icheck-label form-label" for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" class="icheck-minimal-aero" checked> I agree to terms to conditions</label>
                        </p>



                        <p class="submit">
                            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-accent btn-block"  value="Sign Up" />
                        </p>
                    </form>

                    <p id="nav">
                        <!--<a class="float-left" href="#" title="Password Lost and Found">Forgot password?</a>-->
                        <!--<a class="float-right" href="{{route('login')}}" title="Sign Up">Sign In
                        </a>-->
                    </p>
                    <div class="clearfix"></div>
                    <!--<div class="text-center register-social">

                        <a href="#" class="btn btn-primary btn-lg facebook"><i class="fa fa-facebook icon-sm"></i></a>
                        <a href="#" class="btn btn-primary btn-lg twitter"><i class="fa fa-twitter icon-sm"></i></a>
                        <a href="#" class="btn btn-primary btn-lg google-plus"><i class="fa fa-google-plus icon-sm"></i></a>
                        <a href="#" class="btn btn-primary btn-lg dribbble"><i class="fa fa-dribbble icon-sm"></i></a>

                    </div>-->

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

<!----------------------------------------------------------------------->
     <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>

<!--      <script>
               function getMessage() {
                  $.ajax({
                     type:'POST',
                     url:'/getajax',
                     data:'_token = <?php echo csrf_token() ?>',
                     success:function(data) {
                        $("#msg").html(data.msg);
                     }
                  });
               }
            </script>
$('#selectBox').empty();
$('#selectBox').empty().append('<option>New Option</option>');            
-->
<script>
    $(function () {
        $("#province").click(function (event)
        {
            event.preventDefault();
            var $post = {};
            var item;
            var mcity;
            //$post.petid = $('#petid').val();
            $post.name = $('#province').val(); //got the province name here.

            //alert($post.name);
            //$post.ocheck = ($("#ocheck").prop("checked") == true ? '1' : '0');
            $post._token = document.getElementsByName("_token")[0].value;
            //alert($post._token);

            
            $.ajax({
                //url: 'getajax',
                url: 'getcities',
                type: 'POST',
                data: $post,
                cache: false,
                success: function (data) {
                    //alert('Your data updated');
                    //console.log(data);
                    //console.log(data[0]["id"]);
                    //$("#msg").html(print_r(data));
                    //alert ($(data).length);
                    if ( $(data).length ){
                        $('#city').empty();
                        
                        //$("table tbody").remove();
                        /*var $tbody ="<tbody><tr><td>".concat(data[0]["id"],"</td><td>",data[0]["name"],"</td><td>",data[0]["email"],"</td><td>",data[0]["nickname"],"</td></tr></tbody>") ;*/
                        
                        for (item=0;item < data.length;++item)
                        {

                            if (item==0)
                            {
                                mcity="";
                                mcity="<option value=".concat(data[item]["city"]," selected>",data[item]["city"],"</option>" );

                                $('#city').append( mcity);
                                //console.log(mcity);

                            }
                            else
                            {
                                mcity="";
                                mcity="<option value=".concat(data[item]["city"]," >",data[item]["city"],"</option>" );

                                //console.log(mcity);

                                $('#city').append( mcity);
                            }
                                
                        }

                        
                        //$('#city').append('<option>New Option</option>');                        
                        //$("table").append($tbody);
                      } else { alert("No record found");}

                    return data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    
                    console.write(textStatus);
                    //console.write(errorThrown);
                }
            });
        });
    });
</script>
<!----------------------------------------------------------------------->        
    </body>
</html>































