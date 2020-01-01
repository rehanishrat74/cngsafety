@extends('layouts.cngapploggedin')
@section('lefttree')
                    <ul class='wraplist'>   

                        <!--<li class='menusection'>Main</li>
                    <?php if (Auth::user()->regtype!="hdip") {?>
                        <li class=""> 
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                    <?php }?> -->                    

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->routename=="showcylinder")
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


<section class="wrapper main-wrapper row" style=''>

    <div class='col-12'>
        <div class="page-title">

            <div class="float-left">
                <!-- PAGE HEADING TAG - START -->
                <h1 class="title">Cylinder Registrations</h1>
                <!-- PAGE HEADING TAG - END -->                            
            </div>

            <div class="float-right d-none">
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html"><i class="fa fa-home"></i>Home</a>
                    </li>
                    <li>
                       <a href="hos-payments.html">Billing</a>
                    </li>
                    <li class="active">
                         <strong>Payments</strong>
                    </li>
                </ol>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>
       <!-- MAIN CONTENT AREA STARTS -->

    <div class="col-xl-12">
      <section class="box ">
        <header class="panel_header">

          <h2 class="title float-left">Inspection Form {{ $InspectionForm[0]->formid}}</h2>
          <div class="actions panel_actions float-right">
            <a class="box_toggle fa fa-chevron-down"></a>
            <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
            <a class="box_close fa fa-times"></a>
          </div>
        </header>
        <div class="content-body">    
          <div class="row">
            <div class="col-12">


                      <div class="form-group row" >

<!------------------------Inspection / expiry date ----------------------------------------------->
                              <div class="col-12">
                                    <div class="form-group row" >
                                      <div class="col-lg-12" >
                                        <div class="form-group row">
                                            <div class="col-lg-3">
                                                <label  >Inspection Date</label>
                                            </div>                                      
                                            <div class="col-lg-3">
                                                 <label class="form-control" >{{ $InspectionForm[0]->InspectionDate}}</label>
                                                                                                                                                 
                                            </div>
                                            <div class="col-lg-3">
                                                <label  >Inspection Expired at</label>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-control" >{{ $InspectionForm[0]->InspectionExpiry}}</label>                                          
                                            </div>
                                        </div>
                                      </div>      
                                    </div>
                              </div>      
<!---------------------------------------------------------------------------------------------->

                        <div class="col-lg-12"  >
                            <!--<form method="POST" action="{{ route('cylinders') }}">
                                {{ csrf_field() }}-->
                                <fieldset  id="myFieldset" >
                                    <div class="form-group row" >
                                      <div class="col-lg-12" style="text-align: center;">
                                          <label class="font-weight-bold">Vehicle Particulars</label>
                                      </div>
                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>

<!--------------------------------row 1-------------------------------------------------->


                                    <div class="form-group row" >
                                      <div class="col-lg-3">
                                              <label >No of cylinders:</label>
                                              <label class="form-control" >{{ $InspectionForm[0]->Total_Cylinders}}</label>

                                      </div>
                                      <!--<div class="col-lg-4">
                                              <label for="registrationNo">Location of cylinders:</label>
                                              <label class="form-control" >{{ $InspectionForm[0]->Location_name}}</label>
                                      </div>-->
                                      <div class="col-lg-3">
                                              <label for="chasisno">Inspection Status</label>
                                              <label class="form-control" >{{ $InspectionForm[0]->Inspection_Status}}</label>
                                      </div>

                                    
                                      <div class="col-lg-3">
                                              <label for="chasisno">Vehicle Registration No</label>
                                              <label class="form-control" >{{ $InspectionForm[0]->VehiclerRegistrationNo}}</label>

                                      </div>
                                      <div class="col-lg-3">
                                              <label for="chasisno">Work Station Id</label>
                                              <label class="form-control" >{{ $InspectionForm[0]->Workshop_identity}}</label>

                                      </div>

                                    </div>
<!--------------------------------row 3-------------------------------------------------->
                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                                    

                                    <div class="form-group row">
                                      <div class="col-lg-12" style="text-align: center;">
                                          <label class="font-weight-bold">Cylinder Details</label>
                                      </div>                                      
                                    </div>


<!--------------------------------row 4------------------------------------------------->
                                    <?php $counter=1;?>


                                    @foreach ($Cylinders as $Cylinder)
                                    <div class="form-group row" >
                                        <div class="col-lg-4">
                                          <label >Cylinder No</label>
                                          <label class="form-control">Cylinder<?php echo $counter;?></label>
                                        </div>

                                        <div class="col-lg-4">
                                            <label >Make & Model</label>
                                            <label class="form-control" >{{ $Cylinder->Make_Model}}</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label >Serial No</label>
                                            <label class="form-control" >{{ $Cylinder->Cylinder_SerialNo}}
                                            </label>

                                        </div>                                            

                                        <div class="col-lg-4">
                                          <label >Import Date</label>
                                          <label class="form-control" >{{ $Cylinder->ImportDate}}</label>
                                            
                                        </div>
                                        <div class="col-lg-4">
                                          <label >Standard</label>
                                          <label class="form-control" >{{ $Cylinder->Standard}}</label>  
                                            
                                        </div>
                                    </div>
                                    <?php $counter=$counter+1;?>

                                    @endforeach



                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                                    
<!---------------------------------row 5----------------------------------------------->
<!---------------------------------row 6----------------------------------------------->
<!---------------------------------row 7----------------------------------------------->
<!---------------------------------row 8----------------------------------------------->
<!---------------------------------row 9----------------------------------------------->
<!--------------------------cng kit---------------------------------------------------->                                    <div class="form-group row" >
                                      <div class="col-lg-12" style="text-align: center;">
                                          <label class="font-weight-bold">Cng Kit</label>
                                      </div>                                        
                                    </div>    


                                    <div class="form-group row" >
                                        <div class="col-lg-6" >
                                          <div class="form-group row" >
                                            <!--left col row 1-->
                                            <div class="col-lg-6">
                                                <label >Make & Model</label>
                                              <label class="form-control" >{{ $InspectionForm[0]->Make_Model}}</label>
                                                
                                            </div>
                                            <div class="col-lg-6">  
                                            <label >Serial No</label>                        
                                              <label class="form-control" >{{ $InspectionForm[0]->CngKitSerialNo}}</label>                                                
                                            </div>                                            
                                          </div>
                                          
                                          <!--left col row 2-->
                                          <div class="form-group row" >
                                            <div class="col-lg-6">
                                                <label> Registration Plate</label>
                                                      <div class="input-group">
                                                          <!--<span class="input-group-btn">
                                                              <span class="btn btn-default btn-file">
                                                                   <input type="file" id="imgRegPlate">
                                                              </span>
                                                          </span>-->
                                                    <?php 
                                                      $regplate="data:image/";              
                                                      $regplate = $regplate.$InspectionForm[0]->RegistrationPlate_Pic_imagetype;
                                                      $regplate = $regplate.";base64,";
                                                      $regplate = $regplate.$InspectionForm[0]->RegistrationPlate_Pic;
                                                    ?>

                                                          <img id='img-regplate' src="{{ $regplate}}">

                                                      </div>
                                                      
                                            </div>                                            
                                          </div>
                                          <!--left col row 3-->
                                          <div class="form-group row" >
                                            <div class="col-lg-6">
                                                <label> Wind Screen</label>
                                                      <div class="input-group">
                                                      <!--    <span class="input-group-btn">
                                                              <span class="btn btn-default btn-file">
                                                                   <input type="file" id="imgWndScreen">
                                                              </span>
                                                          </span>                -->
                                                    <?php 
                                                      $WindScreen="data:image/";              
                                                      $WindScreen = $WindScreen.$InspectionForm[0]->WindScreen_Pic_imagetype;
                                                      $WindScreen = $WindScreen.";base64,";
                                                    $WindScreen = $WindScreen.$InspectionForm[0]->WindScreen_Pic;
                                                    ?>

                                                        <img id='windscreen'  src="{{ $WindScreen}}">

                                                      </div>

                                                      
                                            </div>                                            
                                          </div>

                                        </div>
                                         <!--right column  --> 
                                        <div class="col-lg-6" >
                                            <div class="form-group row" >
                                                <div class="col-lg-6">                                    
                                                  <label >Cylinder valve</label>
                                                </div>
                                                
                                                <div class="col-lg-6">                                    
                                                  <div class="checkbox">
                                                    <input type="checkbox"  name ="cylindervalve" 
                                                    id ="cylindervalve"  <?php if ($InspectionForm[0]->Cylinder_valve =="on"){echo "checked";}?> disabled>
                                                  </div>                                    
                                                </div>                     

                                            </div>
                                            <!----------row2------------------->

                                            <div class="form-group row" >
                                                <div class="col-lg-6">                                    
                                                <label >Filling valve</label>
                                                </div>
                                                
                                                <div class="col-lg-6">                                    
                                                  <div class="checkbox">
                                                    <input type="checkbox" id ="fillingvalve" 
                                                    name ="fillingvalve"  <?php if ($InspectionForm[0]->Filling_valve =="on"){echo "checked";}?> disabled>
                                                  </div>                                    
                                                </div>                                

                                            </div> 

                                            <!-------------row 3f-------------------->
                                          <div class="form-group row" >
                                              <div class="col-lg-6">                                    
                                              <label>Reducer</label>
                                              </div>
                                              
                                              <div class="col-lg-6">                                    
                                                <div class="checkbox">
                                                  <input type="checkbox" id = "Reducer" name = "Reducer" 
                                                  <?php if ($InspectionForm[0]->Reducer =="on"){echo "checked";}?> disabled
                                                  >
                                                </div>                                    
                                              </div>                                

                                          </div>                                     


                                          <!---------row4------------------------------>

                                          <div class="form-group row" >
                                              <div class="col-lg-6">                                    
                                              <label>High Pressure Pipe</label>
                                              </div>
                                              
                                              <div class="col-lg-6">                                    
                                                <div class="checkbox">
                                                  <input type="checkbox" id="hpp"  name="hpp"
                                                    <?php if ($InspectionForm[0]->HighPressurePipe =="on"){echo "checked";}?> disabled
                                                  >
                                                </div>                                    
                                              </div>                                

                                          </div>                
                                                               
                                          <!----row 5-------------------------------->
                                            <div class="form-group row" >
                                                <div class="col-lg-6">                                    
                                                <label for="engineNo">Exhaust Pipe</label>
                                                </div>
                                                
                                                <div class="col-lg-6">                                    
                                                  <div class="checkbox">
                                                    <input type="checkbox"  id="exhaustpipe"  name="exhaustpipe" 
                                                      <?php if ($InspectionForm[0]->ExhaustPipe =="on"){echo "checked";}?> disabled
                                                    >
                                                  </div>                                    
                                                </div>                                

                                            </div> 

                                        </div>                                        

                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                                                                 

<!--------------------------------------------------------------------------------------------->


<!------------------------------------------------------------------------------->

                                 <!--<button type="submit" value="submit" class="btn btn-primary">Submit</button>-->
                               </fieldset>
                            <!--</form>-->
                        </div>
                      </div>

<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
            </div>
          </div>
        </div>
      </section>
    </div>
      <!-- MAIN CONTENT AREA ENDS -->
</section>

@endsection