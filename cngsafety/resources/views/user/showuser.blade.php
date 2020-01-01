@extends('layouts.cngappdtpicker')
@section('lefttree')
                    <ul class='wraplist'>   

                        <li class='menusection'>Main</li>

                    <!--<?php if (Auth::user()->regtype!="hdip") {?>
                        <li class=""> 
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                    <?php }?>   -->                  

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->functionname=="Registered Users")
                            {
                                $highlightclass="open"; //highlight background
                            } else {$highlightclass="";}

                            ?>
                            <li class="{{$highlightclass}}"> 
                                <a href="/{{$node->routename}}">
                                    <i class="fa {{$node->iconClass}}"></i>
                                    <span class="title">{{$node->functionname}}</span>
                                </a>
                            </li> 

                        @endforeach                        




<!-- left tree categories -------4-lefttreecategories.txt-------------------------------->          
                    </ul>
@endsection

@section('content')
<script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 

                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Edit User</h1><!-- PAGE HEADING TAG - END -->                            </div>

                            <div class="float-right d-none">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="index.html"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li>
                                        <a href="uni-professors.html">Professors</a>
                                    </li>
                                    <li class="active">
                                        <strong>Add Professor</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <!-- MAIN CONTENT AREA STARTS -->
                    <div class="col-12" >
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">User</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">
                                <div class="form-group row" > <!-- style="border-style: solid;"-->
                                    <form id="editusers" action ="{{route('edituser')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="col-12" >
                                            <div class="form-group row">

                                                <div class="col-7" > <!--  style="border-style: solid;"-->
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <div class="controls">
                                                                @if(session()->has('message'))
                                                                    <div class="alert alert-success">
                                                                        {{ session()->get('message') }}
                                                                    </div>
                                                                @endif                                                                
                                                            </div>
                                                        </div>
                                                    </div>
<!------------------------->


                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >User id</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->id}}" class="form-control" 
                                                                id="userid" name="userid"  disabled 
                                                                >
                                                                <input type="hidden" value="{{$userdetails[0]->id}}" id ="useridhidden" name="useridhidden" >
                                              <!--@if ($errors->has('userid'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userid') }}</strong>
                                                </span>
                                              @endif                                                     -->                                                                 
                                                            </div>
                                                        </div>
                                                    </div>

<!-------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Email</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->email}}" class="form-control" 
                                                                id="useremail" name="useremail" placeholder="Email" autocomplete="off"  disabled 
                                                                >
                                                                <input type="hidden" value="{{$userdetails[0]->email}}" id ="useremailhidden" name="useremailhidden" >
                                              <!--@if ($errors->has('useremail'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('useremail') }}</strong>
                                                </span>
                                              @endif                                                     -->                                                                 
                                                            </div>
                                                        </div>
                                                    </div>


<!-------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >User Type</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->regtype}}" class="form-control{{ $errors->has('regtype') ? ' is-invalid' : '' }}" 
                                                                id="usertype" name="usertype" placeholder="UserType" autocomplete="off"  disabled 
                                                                >
                                                                <input type="hidden" value="{{$userdetails[0]->regtype}}" id ="userregtypehidden" name="userregtypehidden" >
                                              <!--@if ($errors->has('usertype'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('usertype') }}</strong>
                                                </span>
                                              @endif                                                     -->                                                                 
                                                            </div>
                                                        </div>
                                                    </div>


<!-------------------------------------------------->


                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->name}}" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" 
                                                                id="username" name="username" placeholder="User Name" autocomplete="off"  
                                                                >
                                              @if ($errors->has('username'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>


<!-------------------------------------------------->

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Address</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->address}}" class="form-control{{ $errors->has('useraddress') ? ' is-invalid' : '' }}" 
                                                                id="useraddress" name="useraddress" placeholder="User Address" autocomplete="off"  
                                                                >

                                              @if ($errors->has('useraddress'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('useraddress') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>


<!-------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Contact No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->contactno}}" class="form-control{{ $errors->has('usercontact') ? ' is-invalid' : '' }}" 
                                                                id="usercontact" name="usercontact" placeholder="User Contact" autocomplete="off"  
                                                                >

                                              @if ($errors->has('usercontact'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('usercontact') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!-------------------------------------------------->

<?php if ($userdetails[0]->regtype=="workshop"){?>

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Station No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="label" value="<?php echo  $userdetails[0]->stationno.' '.$userdetails[0]->city.' '.$userdetails[0]->province ?>" class="form-control{{ $errors->has('regtype') ? ' is-invalid' : '' }}" 
                                                                id="usertype" name="usertype" placeholder="UserType" autocomplete="off"  disabled 
                                                                >
                                                                <input type="hidden" value="{{$userdetails[0]->regtype}}" id ="userregtypehidden" name="userregtypehidden" >
         
                                                            </div>
                                                        </div>
                                                    </div>


<!-------------------------------------------------->

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Owner Mobile No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->ownercellno}}" class="form-control{{ $errors->has('userownercellno') ? ' is-invalid' : '' }}" 
                                                                id="userownercellno" name="userownercellno" placeholder="Owner Mobile No" autocomplete="off"  
                                                                >

                                              @if ($errors->has('userownercellno'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userownercellno') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!-------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Owner Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->ownername}}" class="form-control{{ $errors->has('userownername') ? ' is-invalid' : '' }}" 
                                                                id="userownername" name="userownername" placeholder="Owner Name" autocomplete="off"  
                                                                >

                                              @if ($errors->has('userownername'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userownername') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!-------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Technician</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->technician}}" class="form-control{{ $errors->has('usertechnician') ? ' is-invalid' : '' }}" 
                                                                id="usertechnician" name="usertechnician" placeholder="Technician" autocomplete="off"  
                                                                >

                                              @if ($errors->has('usertechnician'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('usertechnician') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!-------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" ><strong>Note:</strong></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">


                                              
                                                <font color="red">
                                                  <strong>Changing values below will get resulted in re-installing the app.</strong>
                                                </font>
                                                
                                                                                                                                                
                                                            </div>
                                                        </div>
                                                    </div>
<!-------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Cell No For Inspection</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                
                                                                <input type="text" value="{{$userdetails[0]->cellnoforinspection}}" class="form-control{{ $errors->has('usercellnoforinspection') ? ' is-invalid' : '' }}" 
                                                                id="usercellnoforinspection" name="usercellnoforinspection" placeholder="Cell No For Inspection" autocomplete="off"  
                                                                >

                                              @if ($errors->has('usercellnoforinspection'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('usercellnoforinspection') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>

<!------------------------------------------------>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Cell Verified</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="checkbox" value="<?php echo $userdetails[0]->cellverified; ?>" <?php if ($userdetails[0]->cellverified==1){echo "checked";} ?> id="isverified" name ="isverified" onclick="getcheckbox()" ></label>                           
                                                            </div>
                                                        </div>
                                                    </div>

<!------------------------------------------------>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >IMEI</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->imei}}" class="form-control{{ $errors->has('userimei') ? ' is-invalid' : '' }}" 
                                                                id="userimei" name="userimei" placeholder="IMEI No" autocomplete="off"  disabled 
                                                                >

                                                                <input type ="hidden" id ="userimeihidden" name= "userimeihidden" value="{{$userdetails[0]->imei}}">

                                                                <input type ="hidden" value="{{$userdetails[0]->latitude}}" id="userlatitude" name="userlatitude">

                                                                <input type ="hidden" value="{{$userdetails[0]->longitude}}" id ="userlongitude" name="userlongitude">

                                              @if ($errors->has('userimei'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userimei') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>

<!------------------------------------------------>

<?php
} elseif ($userdetails[0]->regtype=="laboratory")

{?>

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Lab Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->labname}}" class="form-control{{ $errors->has('userlabname') ? ' is-invalid' : '' }}" 
                                                                id="userlabname" name="userlabname" placeholder="Lab Name" autocomplete="off"  
                                                                >

                                              @if ($errors->has('userlabname'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userlabname') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>

<!------------------------------------------------>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Owner Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->ownername}}" class="form-control{{ $errors->has('userownername') ? ' is-invalid' : '' }}" 
                                                                id="userownername" name="userownername" placeholder="Owner Name" autocomplete="off"  
                                                                >

                                              @if ($errors->has('userownername'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userownername') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!------------------------------------------------>

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Company Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->companyname}}" class="form-control{{ $errors->has('usercompanyname') ? ' is-invalid' : '' }}" 
                                                                id="usercompanyname" name="usercompanyname" placeholder="Company Name" autocomplete="off"  
                                                                >

                                              @if ($errors->has('usercompanyname'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('usercompanyname') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!------------------------------------------------>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Engineer Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->engineername}}" class="form-control{{ $errors->has('userengineername') ? ' is-invalid' : '' }}" 
                                                                id="userengineername" name="userengineername" placeholder="Engineer Name" autocomplete="off"  
                                                                >

                                              @if ($errors->has('userengineername'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userengineername') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!------------------------------------------------>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Land Line No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->landlineno}}" class="form-control{{ $errors->has('userlandlineno') ? ' is-invalid' : '' }}" 
                                                                id="userlandlineno" name="userlandlineno" placeholder="Land Line No" autocomplete="off"  
                                                                >

                                              @if ($errors->has('userlandlineno'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userlandlineno') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!------------------------------------------------>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Mobile No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->mobileno}}" class="form-control{{ $errors->has('usermobileno') ? ' is-invalid' : '' }}" 
                                                                id="usermobileno" name="usermobileno" placeholder="Mobile No" autocomplete="off"  
                                                                >

                                              @if ($errors->has('usermobileno'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('usermobileno') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!------------------------------------------------>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >HDIP LIC No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->hdip_lic_no}}" class="form-control{{ $errors->has('userhdip_lic_no') ? ' is-invalid' : '' }}" 
                                                                id="userhdip_lic_no" name="userhdip_lic_no" placeholder="HDIP LIC NO" autocomplete="off"  
                                                                >

                                              @if ($errors->has('userhdip_lic_no'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('userhdip_lic_no') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!------------------------------------------------>

<?php
} elseif ($userdetails[0]->regtype=="admin")
{?>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Mobile No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="{{$userdetails[0]->mobileno}}" class="form-control{{ $errors->has('usermobileno') ? ' is-invalid' : '' }}" 
                                                                id="usermobileno" name="usermobileno" placeholder="Mobile No" autocomplete="off"  
                                                                >

                                              @if ($errors->has('usermobileno'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('usermobileno') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<?php }
?>


<!------------------------------------------------->                                                    

                       

                                                </div>  <!-- end of left column -->

                                            </div>
                                        </div>


                                        <div class="col-12 col-md-9 col-lg-8 padding-bottom-30">
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <!--<button type="button" class="btn">Cancel</button>-->
                                            </div>
                                        </div>                                        
                                    </form>
                                    

                                </div> <!-- end of first body row-->


                            </div>  <!-- end of content body -->
                        </section>
                    </div>  <!-- end of Main Content Area Col12-->
                </section> <!-- end of main wrapper -->

<script>
function getcheckbox() {
  var checkBox = document.getElementById("isverified");

  if (checkBox.checked == true){
    checkBox.value=1;
  } else {
     checkBox.value=0;
  }
  
}
</script>



@endsection