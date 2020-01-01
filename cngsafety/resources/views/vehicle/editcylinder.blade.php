@extends('layouts.cngappdtpicker')
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
                    <?php }?>   -->                  

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->routename=="newcylinderreg")
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
          <h2 class="title float-left">Edit Inspection Form {{ $InspectionForm[0]->formid}}</h2>
          <div class="actions panel_actions float-right">
            <a class="box_toggle fa fa-chevron-down"></a>
            <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
            <a class="box_close fa fa-times"></a>
          </div>
        </header>
        <div class="content-body">    
          <div class="row">
            <div class="col-12">
<!--              ++++++++++++++++++++                      -->

                  <!--<div class="content-body">-->
                      <div class="form-group row" >
                        <!--class="col-lg-8 col-md-9 col-10"-->
<!------------------------Inspection / expiry date ----------------------------------------------->
<?php
use Carbon\Carbon;
$dt=Carbon::today();
?>
<form method="POST" action="{{ route('editcylinder',$InspectionForm[0]->formid) }}" enctype="multipart/form-data" >
  {{ csrf_field() }}
                             <div class="col-lg-12" >   
                                    <div class="form-group row" >
                                      <div class="col-lg-12" >
                                        <div class="form-group row"  >
                                            <div class="col-lg-3">
                                                <label class="font-weight-bold" >Inspection Date</label>
                                            </div>                                      
                                            <div class="col-lg-3">
                                                 

                                        <?php 
                                            $mmddyy = date('m/d/Y', strtotime($InspectionForm[0]->InspectionDate));
                                        ?>

                                                <!--<label class="form-control" >{{ $mmddyy}}</label> -->
                                                <input type="text" class="form-control"  
                                                value="<?php echo  $mmddyy;?>" name="inspectiondate" id="inspectiondate" placeholder="Inspection Date" data-format="mm/dd/yyyy" readonly>


                                            </div>
                                            <div class="col-lg-3">
                                                <label class="font-weight-bold" >Inspection Expired at</label>
                                            </div>
                                            <div class="col-lg-3">
                                        
                                        <?php 
                                            $mmddyy = date('m/d/Y', strtotime($InspectionForm[0]->InspectionExpiry));
                                        ?>                                              
                                                
                                                <label class="form-control" >{{$mmddyy }}</label>                                                                                         
                                            </div>
                                        </div>
                                      </div>      
                                    </div>
                              </div>
<!---------------------------------------------------------------------------------------------->

                        <div class="col-lg-12"  >

                            <!--<form method="POST" action="{{ route('editcylinder',$InspectionForm[0]->formid) }}">-->
                                
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
                                              <label for="maketype">No of cylinders:</label>

                                                <input type="text" class="form-control"  
                                                 name="cylindernos" id="cylindernos"   
                                                 value="{{ $InspectionForm[0]->Total_Cylinders}}" readonly>


                                      </div>

                                      <div class="col-lg-3">
                                              <label for="chasisno">Inspection Status</label>
                                              <input type="text" class="form-control" name="inspectionStatus" id="inspectionStatus" placeholder="Pending" disabled="true" value="{{$vehicles[0]->Inspection_Status}}">
                                      </div>


        

                                      <div class="col-lg-3">
                                              <label for="chasisno">Vehicle Registration No</label>
                                              <input type="text" class="form-control" name="vregno" id="vregno" placeholder="Enter Registration No" value="{{ $InspectionForm[0]->VehiclerRegistrationNo}}" readonly>

                                      </div>
                                      <div class="col-lg-3">
                                              <label for="chasisno">Work Station Id</label>
                                              <input type="text" class="form-control{{ $errors->has('workstationid') ? ' is-invalid' : '' }}" name="workstationid" id="workstationid" placeholder="Work Station Id" value="{{ $InspectionForm[0]->Workshop_identity }}" autocomplete="off" readonly>

                                              @if ($errors->has('workstationid'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('workstationid') }}</strong>
                                                </span>
                                              @endif                                

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
                                <?php $count=1; ?>
                                @foreach ($Cylinders as $Cylinder)
                                    <div class="form-group row" >
                                        <div class="col-lg-4" >
                                          <label class="font-weight-bold">Cylinder<?php echo $count;?> {{ $Cylinder->cylinderStatus }}
                                            
                                          </label>
                                        </div>
                                       
                                        <?php $makenmodel='makenmodel_C'.$count ?>
                                        <div class="col-lg-4">
                                          <div class="form-group row" >
                                            <div class="col-lg-4">Make/Model</div>
                                              <div class="col-lg-8">
                                                  <input type="text" class="form-control{{ $errors->has($makenmodel) ? ' is-invalid' : '' }}" 
                                                  name="<?php echo $makenmodel;?>" id="<?php echo $makenmodel;?>" placeholder="Make & Model" value="{{ $Cylinder->Make_Model}}" autocomplete="off">

                                                    @if ($errors->has($makenmodel))
                                                      <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first($makenmodel) }}</strong>
                                                      </span>
                                                    @endif                                

                                              </div>

                                          </div>
                                        </div>


                                        <?php $serialno='serialno_C'.$count ?>
                                        <div class="col-lg-4" >
                                          <div class="form-group row" >
                                            <div class="col-lg-4">Serial No</div>
                                              <div class="col-lg-8">
                                                  <input type="text" class="form-control{{ $errors->has($serialno) ? ' is-invalid' : '' }}" name="<?php echo $serialno;?>"  id="<?php echo $serialno;?>" placeholder=" Serial No" value="{{  $Cylinder->Cylinder_SerialNo }}" autocomplete="off">
          

                                                    @if ($errors->has($serialno))
                                                      <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first($serialno) }}</strong>
                                                      </span>
                                                    @endif

                                              </div>                                            
                                          </div>      


                                        </div>

                                      
                                        <?php $importdate='importdate_C'.$count ?>

                                        <?php 
                                            $mmddyy = date('m/d/Y', strtotime($Cylinder->ImportDate));
                                        ?>
                                        <div class="col-lg-4">
                                          <div class="form-group row" >
                                            <div class="col-lg-5">Import-date</div>
                                              <div class="col-lg-7">
                                                   <input type="text" class="form-control{{ $errors->has($importdate) ? ' is-invalid' : '' }} datepicker" data-format="mm/dd/yyyy" value="{{ $mmddyy}}" name="<?php echo $importdate;?>" id="<?php echo $importdate;?>" placeholder="Import Date" autocomplete="off">
                                                    @if ($errors->has($importdate))
                                                      <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first($importdate) }}</strong>
                                                      </span>
                                                    @endif                                                      
                                              </div>                                            
                                          </div>
                                        </div>                                        


                                        <?php $scancode='scancode_C'.$count ?>
                                        <div class="col-lg-4" >
                                          <div class="form-group row" >
                                            <div class="col-lg-4" >Standard</div>
                                              <div class="col-lg-8" >
                                                  <!--<input type="text" class="form-control{{ $errors->has($scancode) ? ' is-invalid' : '' }}" 
                                                  name="<?php //echo $scancode;?>" id="<?php //echo $scancode;?>" placeholder="Standard" value="{{$Cylinder->Standard}}" autocomplete="off">
                                                    @if ($errors->has($scancode))
                                                      <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first($scancode) }}</strong>
                                                      </span>
                                                    @endif   --> 
                                                    <select class="form-control" id="<?php echo $scancode;?>"  name="<?php echo $scancode;?>" >
                                                          <option value="NZ5454" <?php if ($Cylinder->Standard=="NZ5454") { echo "selected";} ?>>NZ5454</option>
                                                          <option value="ISO 11439" <?php if ($Cylinder->Standard=="ISO 11439") { echo "selected";} ?>>ISO 11439</option>
                                                    </select>

                                                        @if ($errors->has($scancode))
                                                          <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first($scancode) }}</strong>
                                                          </span>
                                                        @endif           

                                              </div>                                            
                                          </div>
                                        </div>

                                    
                                    <?php $locationcode='location_C'.$count ?>
                                    <div class="col-lg-4" >
                                      <div class="form-group row">
                                        <div class="col-lg-4">Location</div>
                                        <div class="col-lg-8">
                                                <select class="form-control" id="<?php echo $locationcode ?>" name="<?php echo $locationcode ?>">

                                               @foreach ($cylinder_locations as $location)
                                                    <option value="{{$location->Location_id}}"   <?php if ($Cylinder->cylinderlocation==$location->Location_id) { echo "selected";} ?>
                                                    >{{ $location->Location_name }}</option>

                                               @endforeach

                                                </select>                                          

                                        </div>
                                      </div>
                                    </div>                                        
                                    </div>
                                    

                                  

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>
                                    <?php ++$count; ?>
                                @endforeach
<!---------------------------------row 5----------------------------------------------->

                                    <!--
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('serialno_C6') ? ' is-invalid' : '' }}" name="serialno_C6"  id="serialno_C6" placeholder=" Serial No" value="{{ old('serialno_C6') }}">
                                              @if ($errors->has('serialno_C6'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('serialno_C6') }}</strong>
                                                </span>
                                              @endif                                                                                                   
                                        </div>


                                         end of cyl 6  -->       
<!--------------------------cng kit------------------------------------------------------------>                                    <div class="form-group row" >
                                      <div class="col-lg-12" >
                                          <label class="font-weight-bold">Cng Kit</label>
                                      </div>                                        
                                    </div>    


                                    <div class="form-group row"  >
                                        <div class="col-lg-6" >
                                          <div class="form-group row" >
                                            <!--left col row 1-->
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control{{ $errors->has('kitmnm') ? ' is-invalid' : '' }} " name="kitmnm" id="kitmnm" placeholder="Make & Model" 
                                                value="{{ $InspectionForm[0]->Make_Model}}" autocomplete="off">
                                              @if ($errors->has('kitmnm'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('kitmnm') }}</strong>
                                                </span>
                                              @endif                                                                                                       
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control{{ $errors->has('kitseriano') ? ' is-invalid' : '' }} " name="kitseriano"  id="kitseriano" placeholder=" Serial No" 
                                                value="{{ $InspectionForm[0]->CngKitSerialNo }}" autocomplete="off">
                                              @if ($errors->has('kitseriano'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('kitseriano') }}</strong>
                                                </span>
                                              @endif                                                                                                       
                                            </div>                                            
                                          </div>
                                          
                                          <!--left col row 2-->
                                          <div class="form-group row" >
                                            <div class="col-lg-6">
                                                <label> Edit Registration Plate</label>
                                                      <div class="input-group">
                                                          <span class="input-group-btn">
                                                              <span class="btn btn-default btn-file">
                                                                   <input type="file" id="imgRegPlate" name="imgRegPlate">
                                                              </span>
                                                          </span>        
                                                      </div>                                                

                                                      <div class="input-group">

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
                                                <label> Edit Wind Screen</label>
                                                      <div class="input-group">
                                                          <span class="input-group-btn">
                                                              <span class="btn btn-default btn-file">
                                                                   <input type="file" id="imgWndScreen" 
                                                                   name="imgWndScreen">
                                                              </span>
                                                          </span>        
                                                      </div>
                                                      <div class="input-group">

                                                    <?php 
                                                      $WindScreen="data:image/";              
                                                      $WindScreen = $WindScreen.$InspectionForm[0]->WindScreen_Pic_imagetype;
                                                      $WindScreen = $WindScreen.";base64,";
                                                    $WindScreen = $WindScreen.$InspectionForm[0]->WindScreen_Pic;
                                                    ?>

                                                        <img id='img-windscreen'  src="{{ $WindScreen}}">

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
                                                    id ="cylindervalve" <?php if ($InspectionForm[0]->Cylinder_valve =="on"){echo "checked";}?>>
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
                                                    name ="fillingvalve" <?php if ($InspectionForm[0]->Filling_valve =="on"){echo "checked";}?>>
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
                                                  <?php if ($InspectionForm[0]->Reducer =="on"){echo "checked";}?>
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
                                                      <?php if ($InspectionForm[0]->HighPressurePipe =="on"){echo "checked";}?>
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
                                                    <?php if ($InspectionForm[0]->ExhaustPipe =="on"){echo "checked";}?>
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


                                 <button type="submit" value="submit" class="btn btn-primary">Submit</button>
                               </fieldset>
                            </form>
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