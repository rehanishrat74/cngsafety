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
                    <?php }?>                     -->


                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            /*if ($node->functionname=="Registered Users")
                            {
                                $highlightclass="open"; //highlight background
                            } else {$highlightclass="";}*/

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
          <h2 class="title float-left">Form  </h2>
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
                      <div class="row" >
                        <!--class="col-lg-8 col-md-9 col-10"-->
<!------------------------Inspection / expiry date ----------------------------------------------->
<?php
use Carbon\Carbon;
$dt=Carbon::today();

//print_r($newvehicle);
?>



                                    <div class="form-group row" >
                                      <div class="col-lg-12" style="text-align: center;">
                                        <div class="form-group row">
                                            <div class="col-lg-3">
                                                <label class="font-weight-bold" >Inspection Date</label>
                                            </div>                                      
                                            <div class="col-lg-3">
                                                 <!--<input type="text" class="form-control datepicker" data-format="mm/dd/yyyy" value="" name="inspectiondate_C1" id="inspectiondate_C1" placeholder="Inspection Date">-->
                                                <input type="text" class="form-control text-dark"  value="<?php echo $dt;?>" name="inspectiondate" id="inspectiondate" placeholder="Inspection Date" data-format="mm/dd/yyyy" disabled>
                                                                                                 
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="font-weight-bold" >Inspection Expired at</label>
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control text-dark" name="expiryDate" id="$expiryDate" value="<?php echo $dt->addMonths(12);?>" disabled="true">                                          
                                            </div>
                                        </div>
                                      </div>      
                                    </div>
<!---------------------------------------------------------------------------------------------->

                        <div class="col-lg-12"  >
                            <form method="POST" action="{{ route('cylinders') }}" 
                            enctype="multipart/form-data" >
                                {{ csrf_field() }}
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
                                              <select class="form-control" id="cylindernos" name="cylindernos">
                                                <option value="1" <?php if (old('cylindernos')=="1") { echo "selected";} ?> >1</option>
                                                <option value="2" <?php if (old('cylindernos')=="2") { echo "selected";} ?>>2</option>
                                                <option value="3" <?php if (old('cylindernos')=="3") { echo "selected";} ?>>3</option>
                                                <option value="4" <?php if (old('cylindernos')=="4") { echo "selected";} ?>>4</option>
                                                <option value="5" <?php if (old('cylindernos')=="5") { echo "selected";} ?>>5</option>
                                                <option value="6" <?php if (old('cylindernos')=="6") { echo "selected";} ?>>6</option>
                                              </select>
                                      </div>
                                      
                                      

                                      <div class="col-lg-3">
                                              <label for="chasisno">Inspection Status</label>
                                              <input type="text" class="form-control text-dark" name="inspectionStatus" id="inspectionStatus" placeholder="Pending" disabled="true">
                                      </div>


                                      <div class="col-lg-3">
                                              <label for="chasisno">Vehicle Registration No</label>
                                              <input type="text" class="form-control text-dark" name="vregno" id="vregno" placeholder="Enter Registration No" 
                                              value="{{$newvehicle}}" readonly>
                                              <input type="hidden" name="record_id" id="record_id" 
                                              value =<?php echo Request("recordid")?>
                                              >
                                      </div>


                                      <div class="col-lg-3">
                                              <label for="chasisno">Work Station Id</label>
                                              <input type="text" class="form-control{{ $errors->has('workstationid') ? ' is-invalid' : '' }}" name="workstationid" id="workstationid" placeholder="Work Station Id" value="{{$stationno[0]->stationno}}" autocomplete="off" readonly>

                                              @if ($errors->has('workstationid'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('workstationid') }}</strong>
                                                </span>
                                              @endif                                

                                      </div>
                                      <!--<div class="col-lg-4">
                                              <label for="chasisno">Inspection Status</label>
                                              <input type="text" class="form-control" name="inspectionStatus" id="inspectionStatus" placeholder="Pending" disabled="true">
                                      </div>-->

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


                                    <div class="form-group row" >
                                        <div class="col-lg-4">
                                          <label class="font-weight-bold">Cylinder1</label>
                                        </div>
                                       
                                        <div class="col-lg-4" >
                                          <div class="form-group row" >
                                            <div class="col-lg-4" >Standard</div>
                                            <div class="col-lg-8" >
                                                <select class="form-control" id="scancode_C1" name="scancode_C1">
                                                  <option value="NZ5454" <?php if (old('scancode_C1')=="NZ5454") { echo "selected";} ?>>NZ5454</option>
                                                  <option value="ISO 11439" <?php if (old('scancode_C1')=="ISO 11439") { echo "selected";} ?>>ISO 11439</option>
                                                </select>
                                                    @if ($errors->has('scancode_C1'))
                                                      <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('scancode_C1') }}</strong>
                                                      </span>
                                                    @endif                                              

                                            </div>
                                          </div>   

                                            <!--<input type="text" class="form-control{{ $errors->has('scancode_C1') ? ' is-invalid' : '' }}" name="scancode_C1" id="scancode_C1" placeholder="Standard" value="{{ old('scancode_C1') }}" autocomplete="off">-->

                                        </div>
<!--------------cylinder location----------->
                                          <div class="col-lg-4">
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Cylinder location</div>
                                              <div class="col-lg-8">
                                                <select class="form-control" id="location_C1" name="location_C1">

                                               @foreach ($cylinder_locations as $location)
                                                    <option value="{{$location->Location_id}}"   <?php if (old('location_C1')==$location->Location_id) { echo "selected";} ?>
                                                    >{{ $location->Location_name }}</option>
                                               @endforeach

                                                </select>                                                

                                              </div>
                                            </div>
                                              

                                          </div>
<!--------------cylinder location----------->

                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('serialno_C1') ? ' is-invalid' : '' }}" name="serialno_C1"  id="serialno_C1" placeholder=" Serial No" value="{{ old('serialno_C1') }}" autocomplete="off">

                                              @if ($errors->has('serialno_C1'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('serialno_C1') }}</strong>
                                                </span>
                                              @endif                               
                                        </div>



                                        <!--<div class="col-lg-4">
                                             <input type="text" class="form-control datepicker" data-format="mm/dd/yyyy" value="" name="inspectiondate_C1" id="inspectiondate_C1" placeholder="Inspection Date">
                                        </div>-->
                                            

                                        <div class="col-lg-4">
                                             <input type="text" class="form-control{{ $errors->has('importdate_C1') ? ' is-invalid' : '' }} datepicker" data-format="mm/dd/yyyy" value="{{ old('importdate_C1') }}" name="importdate_C1" id="importdate_C1" placeholder="Import Date" autocomplete="off">
                                              @if ($errors->has('importdate_C1'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('importdate_C1') }}</strong>
                                                </span>
                                              @endif                                                                                                    
                                            
                                        </div>

                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('makenmodel_C1') ? ' is-invalid' : '' }}" name="makenmodel_C1" id="makenmodel_C1" placeholder="Make & Model" value="{{ old('makenmodel_C1') }}" autocomplete="off">

                                              @if ($errors->has('makenmodel_C1'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('makenmodel_C1') }}</strong>
                                                </span>
                                              @endif                                

                                        </div>                                        
<!-----------serial no loc ----------->                                        

<!---------------serial no loc ---------------->
                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                                    
<!---------------------------------row 5----------------------------------------------->

                                    <div class="form-group row" >
                                        <div class="col-lg-4">
                                          <label class="font-weight-bold">Cylinder2</label>
                                        </div>

                                        <div class="col-lg-4">
                                            <!--<input type="text" class="form-control{{ $errors->has('scancode_C2') ? ' is-invalid' : '' }}"  name="scancode_C2" id="scancode_C2" placeholder="Standard"
                                            value="{{ old('scancode_C2') }}" autocomplete="off">-->
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Standard</div>
                                              <div class="col-lg-8">
                                                    <select class="form-control" id="scancode_C2" name="scancode_C2">
                                                          <option value="NZ5454" <?php if (old('scancode_C2')=="NZ5454") { echo "selected";} ?>>NZ5454</option>
                                                          <option value="ISO 11439" <?php if (old('scancode_C2')=="ISO 11439") { echo "selected";} ?>>ISO 11439</option>
                                                    </select>

                                                        @if ($errors->has('scancode_C2'))
                                                          <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('scancode_C2') }}</strong>
                                                          </span>
                                                        @endif           

                                              </div>
                                            </div>

                                         
                                        </div>
                                          <div class="col-lg-4">
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Cylinder location</div>
                                              <div class="col-lg-8">
                                                <select class="form-control" id="location_C2" name="location_C2">

                                               @foreach ($cylinder_locations as $location)
                                                    <option value="{{$location->Location_id}}"   <?php if (old('location_C2')==$location->Location_id) { echo "selected";} ?>
                                                    >{{ $location->Location_name }}</option>
                                               @endforeach

                                                </select>                                                

                                              </div>
                                            </div>
                                              

                                          </div>                                        
                                        
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('serialno_C2') ? ' is-invalid' : '' }}" name="serialno_C2"  id="serialno_C2" placeholder=" Serial No" value="{{ old('serialno_C2') }}" autocomplete="off">
                                              @if ($errors->has('serialno_C2'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('serialno_C2') }}</strong>
                                                </span>
                                              @endif                                                 
                                        </div>

                                        <!--<div class="col-lg-4">
                                            <input type="text" class="form-control datepicker" data-format="mm/dd/yyyy" value="" name="inspectiondate_C2" id="inspectiondate_C2" placeholder="Inspection Date">
                                        </div>-->
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('importdate_C2') ? ' is-invalid' : '' }} datepicker" data-format="mm/dd/yyyy" value="" name="importdate_C2" id="importdate_C2" placeholder="Import Date"
                                            value="{{ old('importdate_C2') }}" autocomplete="off">           
                                              @if ($errors->has('importdate_C2'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('importdate_C2') }}</strong>
                                                </span>
                                              @endif                                                 


                                        </div>

                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('makenmodel_C2') ? ' is-invalid' : '' }}" 
                                            name="makenmodel_C2" id="makenmodel_C2" placeholder="Make & Model" value="{{ old('makenmodel_C2') }}" autocomplete="off">
                                              @if ($errors->has('makenmodel_C2'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('makenmodel_C2') }}</strong>
                                                </span>
                                              @endif     
                                        </div>



                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                                    
<!---------------------------------row 6----------------------------------------------->

                                    <div class="form-group row" >
                                        <div class="col-lg-4">
                                          <label class="font-weight-bold">Cylinder3</label>
                                        </div>
                      

                                        <div class="col-lg-4">
                                            <!--<input type="text" class="form-control{{ $errors->has('scancode_C3') ? ' is-invalid' : '' }}" name="scancode_C3" id="scancode_C3" placeholder="Standard" value="{{ old('scancode_C3') }}" autocomplete="off">-->

                                            <div class="form-group row" >
                                              <div class="col-lg-4">Standard</div>
                                              <div class="col-lg-8">
                                                  <select class="form-control" id="scancode_C3" name="scancode_C3">
                                                        <option value="NZ5454" <?php if (old('scancode_C3')=="NZ5454") { echo "selected";} ?>>NZ5454</option>
                                                        <option value="ISO 11439" <?php if (old('scancode_C3')=="ISO 11439") { echo "selected";} ?>>ISO 11439</option>
                                                  </select>

                                                      @if ($errors->has('scancode_C3'))
                                                        <span class="invalid-feedback" role="alert">
                                                          <strong>{{ $errors->first('scancode_C3') }}</strong>
                                                        </span>
                                                      @endif                                                  
                                              </div>
                                            </div>
                                               
                                        </div>
                                          <div class="col-lg-4">
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Cylinder location</div>
                                              <div class="col-lg-8">
                                                <select class="form-control" id="location_C3" name="location_C3">

                                               @foreach ($cylinder_locations as $location)
                                                    <option value="{{$location->Location_id}}"   <?php if (old('location_C3')==$location->Location_id) { echo "selected";} ?>
                                                    >{{ $location->Location_name }}</option>
                                               @endforeach

                                                </select>                                                

                                              </div>
                                            </div>
                                              

                                          </div>
                                            
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('serialno_C3') ? ' is-invalid' : '' }}"
                                             name="serialno_C3"  id="serialno_C3" placeholder=" Serial No"
                                             value="{{ old('serialno_C3') }}" autocomplete="off">
                                              @if ($errors->has('serialno_C3'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('serialno_C3') }}</strong>
                                                </span>
                                              @endif                                                                                                    
                                        </div>

                                        <!--<div class="col-lg-4">
                                            <input type="text" class="form-control datepicker" data-format="mm/dd/yyyy" value="" name="inspectiondate_C3" id="inspectiondate_C3" placeholder="Inspection Date">   

                                        </div>-->
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('importdate_C3') ? ' is-invalid' : '' }} datepicker" data-format="mm/dd/yyyy" value="{{ old('importdate_C3') }}" name="importdate_C3" id="importdate_C3" placeholder="Import Date" autocomplete="off">   
                                              @if ($errors->has('importdate_C3'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('importdate_C3') }}</strong>
                                                </span>
                                              @endif                                                                                                   

                                        </div>
                      
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('makenmodel_C3') ? ' is-invalid' : '' }}" name="makenmodel_C3" id="makenmodel_C3" placeholder="Make & Model"
                                            value="{{ old('makenmodel_C3') }}" autocomplete="off">
                                              @if ($errors->has('makenmodel_C3'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('makenmodel_C3') }}</strong>
                                                </span>
                                              @endif                                               
                                        </div>


                      
                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                                    

<!---------------------------------row 7----------------------------------------------->
                                    <div class="form-group row" >
                                        <div class="col-lg-4">
                                          <label class="font-weight-bold">Cylinder4</label>
                                        </div>                                      

                                        <div class="col-lg-4">
                                            <!--<input type="text" class="form-control{{ $errors->has('scancode_C4') ? ' is-invalid' : '' }} " name="scancode_C4" id="scancode_C4" placeholder="Standard" value="{{ old('scancode_C4') }}" autocomplete="off">-->

                                            <div class="form-group row" >
                                              <div class="col-lg-4">Standard</div>
                                              <div class="col-lg-8">
                                          <select class="form-control" id="scancode_C4" name="scancode_C4">
                                                <option value="NZ5454" <?php if (old('scancode_C4')=="NZ5454") { echo "selected";} ?>>NZ5454</option>
                                                <option value="ISO 11439" <?php if (old('scancode_C4')=="ISO 11439") { echo "selected";} ?>>ISO 11439</option>
                                          </select>

                                              @if ($errors->has('scancode_C4'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('scancode_C4') }}</strong>
                                                </span>
                                              @endif                                                                                                    

                                              </div>
                                            </div>
                                               
                                        </div>
                                          <div class="col-lg-4">
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Cylinder location</div>
                                              <div class="col-lg-8">
                                                <select class="form-control" id="location_C4" name="location_C4">

                                               @foreach ($cylinder_locations as $location)
                                                    <option value="{{$location->Location_id}}"   <?php if (old('location_C4')==$location->Location_id) { echo "selected";} ?>
                                                    >{{ $location->Location_name }}</option>
                                               @endforeach

                                                </select>                                                

                                              </div>
                                            </div>
                                              

                                          </div>

                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('serialno_C4') ? ' is-invalid' : '' }}" name="serialno_C4"  id="serialno_C4" placeholder=" Serial No" value="{{ old('serialno_C4') }}" autocomplete="off">
                                              @if ($errors->has('serialno_C4'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('serialno_C4') }}</strong>
                                                </span>
                                              @endif                                                                                                   
                                        </div>

                                        <!--<div class="col-lg-4">
                                            <input type="text" class="form-control datepicker" data-format="mm/dd/yyyy" value="" name="inspectiondate_C4" id="inspectiondate_C4" placeholder="Inspection Date">   

                                        </div>-->
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('importdate_C4') ? ' is-invalid' : '' }} datepicker" data-format="mm/dd/yyyy" value="{{ old('importdate_C4') }}" name="importdate_C4" id="importdate_C4" placeholder="Import Date" autocomplete="off">   
                                              @if ($errors->has('importdate_C4'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('importdate_C4') }}</strong>
                                                </span>
                                              @endif                                                                                                   

                                        </div>
                    

                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('makenmodel_C4') ? ' is-invalid' : '' }}" name="makenmodel_C4" id="makenmodel_C4" placeholder="Make & Model"
                                            value="{{ old('makenmodel_C4') }}" autocomplete="off">
                                              @if ($errors->has('makenmodel_C4'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('makenmodel_C4') }}</strong>
                                                </span>
                                              @endif                               
                                        </div>



                        
                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                                    
<!---------------------------------row 8----------------------------------------------->
                                    <div class="form-group row" >
                                        <div class="col-lg-4">
                                          <label class="font-weight-bold">Cylinder5</label>
                                        </div>
                      
                                        <div class="col-lg-4">
                                            <!--<input type="text" class="form-control{{ $errors->has('scancode_C5') ? ' is-invalid' : '' }}" name="scancode_C5" id="scancode_C5" placeholder="Standard" value="{{ old('scancode_C5') }}" autocomplete="off">-->
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Standard</div>
                                              <div class="col-lg-8">
                                          <select class="form-control" id="scancode_C5" name="scancode_C5">
                                                <option value="NZ5454" <?php if (old('scancode_C5')=="NZ5454") { echo "selected";} ?>>NZ5454</option>
                                                <option value="ISO 11439" <?php if (old('scancode_C5')=="ISO 11439") { echo "selected";} ?>>ISO 11439</option>
                                          </select>

                                              @if ($errors->has('scancode_C5'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('scancode_C5') }}</strong>
                                                </span>
                                              @endif                                                                                                    

                                              </div>
                                            </div>
                                               
                                        </div>
                                          <div class="col-lg-4">
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Cylinder location</div>
                                              <div class="col-lg-8">
                                                <select class="form-control" id="location_C5" name="location_C5">

                                               @foreach ($cylinder_locations as $location)
                                                    <option value="{{$location->Location_id}}"   <?php if (old('location_C5')==$location->Location_id) { echo "selected";} ?>
                                                    >{{ $location->Location_name }}</option>
                                               @endforeach

                                                </select>                                                

                                              </div>
                                            </div>
                                              

                                          </div>

                      

                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('serialno_C5') ? ' is-invalid' : '' }} " name="serialno_C5"  id="serialno_C5" placeholder=" Serial No" 
                                            value="{{ old('serialno_C5') }}" autocomplete="off"
                                            >
                                              @if ($errors->has('serialno_C5'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('serialno_C5') }}</strong>
                                                </span>
                                              @endif                                                                                                   
                                        </div>

                                        <!--<div class="col-lg-4">
                                            <input type="text" class="form-control datepicker" data-format="mm/dd/yyyy" value="" name="inspectiondate_C5" id="inspectiondate_C5" placeholder="Inspection Date">              
                                        </div>-->
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('importdate_C5') ? ' is-invalid' : '' }} datepicker"
                                            name="importdate_C5" data-format="mm/dd/yyyy" id="importdate_C5" placeholder="Import Date" value="{{ old('importdate_C5') }}" autocomplete="off">
                                              @if ($errors->has('importdate_C5'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('importdate_C5') }}</strong>
                                                </span>
                                              @endif                                                                                                   
                                        </div>
                              <!-------------begin cylinder--------->
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('makenmodel_C5') ? ' is-invalid' : '' }} " name="makenmodel_C5" id="makenmodel_C5" placeholder="Make & Model" value="{{ old('makenmodel_C5') }}" autocomplete="off">
                                              @if ($errors->has('makenmodel_C5'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('makenmodel_C5') }}</strong>
                                                </span>
                                              @endif           
                                        </div>


                            <!-------------end  cylinder--------->
                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                       
<!---------------------------------row 9----------------------------------------------->                                    <div class="form-group row" >
                                          <div class="col-lg-4">
                                          <label class="font-weight-bold">Cylinder6</label>
                                        </div>

                                        <div class="col-lg-4">
                                            <!--<input type="text" class="form-control{{ $errors->has('scancode_C6') ? ' is-invalid' : '' }} " name="scancode_C6" id="scancode_C6" placeholder="Standard" value="{{ old('scancode_C6') }}" autocomplete="off">-->
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Standard</div>
                                              <div class="col-lg-8">
                                          <select class="form-control" id="scancode_C6" name="scancode_C6">
                                                <option value="NZ5454" <?php if (old('scancode_C6')=="NZ5454") { echo "selected";} ?>>NZ5454</option>
                                                <option value="ISO 11439" <?php if (old('scancode_C6')=="ISO 11439") { echo "selected";} ?>>ISO 11439</option>
                                          </select>

                                              @if ($errors->has('scancode_C6'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('scancode_C6') }}</strong>
                                                </span>
                                              @endif                                                                                                    

                                              </div>
                                            </div>
                                               
                                        </div>
                                          <div class="col-lg-4">
                                            <div class="form-group row" >
                                              <div class="col-lg-4">Cylinder location</div>
                                              <div class="col-lg-8">
                                                <select class="form-control" id="location_C6" name="location_C6">

                                               @foreach ($cylinder_locations as $location)
                                                    <option value="{{$location->Location_id}}"   <?php if (old('location_C6')==$location->Location_id) { echo "selected";} ?>
                                                    >{{ $location->Location_name }}</option>
                                               @endforeach

                                                </select>                                                

                                              </div>
                                            </div>
                                              

                                          </div>

                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('serialno_C6') ? ' is-invalid' : '' }}" name="serialno_C6"  id="serialno_C6" placeholder=" Serial No" value="{{ old('serialno_C6') }}" autocomplete="off">
                                              @if ($errors->has('serialno_C6'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('serialno_C6') }}</strong>
                                                </span>
                                              @endif                                                                                                   
                                        </div>

                                        <!--<div class="col-lg-4">
                                            <input type="text" class="form-control datepicker" 
                                            name="inspectiondate_C6" id="inspectiondate_C6" placeholder="Inspection Date" data-format="mm/dd/yyyy">
                                        </div>-->
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('importdate_C6') ? ' is-invalid' : '' }}  datepicker" name="importdate_C6" id="importdate_C6" placeholder="Import Date" data-format="mm/dd/yyyy" value="{{ old('importdate_C6') }}" autocomplete="off">
                                              @if ($errors->has('serialno_C6'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('importdate_C6') }}</strong>
                                                </span>
                                              @endif                                                                                                   
                                        </div>


                                        <div class="col-lg-4">
                                            <input type="text" class="form-control{{ $errors->has('makenmodel_C6') ? ' is-invalid' : '' }}" name="makenmodel_C6" id="makenmodel_C6" placeholder="Make & Model" value="{{ old('makenmodel_C6') }}" autocomplete="off">
                                              @if ($errors->has('makenmodel_C6'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('makenmodel_C6') }}</strong>
                                                </span>
                                              @endif                                                                                                                                             
                                        </div>





                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>                                                                        
<!--------------------------cng kit------------------------------------------------------------>                                    <div class="form-group row" >
                                      <div class="col-lg-12" style="text-align: center;">
                                          <label class="font-weight-bold">Cng Kit</label>
                                      </div>                                        
                                    </div>    


                                    <div class="form-group row" >
                                        <div class="col-lg-6" >
                                          <div class="form-group row" >
                                            <!--left col row 1-->
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control{{ $errors->has('kitmnm') ? ' is-invalid' : '' }} " name="kitmnm" id="kitmnm" placeholder="Make & Model" value="{{ old('kitmnm') }}" autocomplete="off">
                                              @if ($errors->has('kitmnm'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('kitmnm') }}</strong>
                                                </span>
                                              @endif                                                                                                       
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control{{ $errors->has('kitseriano') ? ' is-invalid' : '' }} " name="kitseriano"  id="kitseriano" placeholder=" Serial No" value="{{ old('kitseriano') }}" autocomplete="off">
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
                                                <label> Registration Plate</label>
                                                      <div class="input-group">
                                                          <span class="input-group-btn">
                                                              <span class="btn btn-default btn-file">
                                                                   <input type="file" id="imgRegPlate" name="imgRegPlate">
                                                              </span>
                                                          </span>        
                                                      </div>
                                                      <img id='img-upload'/>
                                            </div>                                            
                                          </div>
                                          <!--left col row 3-->
                                          <div class="form-group row" >
                                            <div class="col-lg-6">
                                                <label> Wind Screen</label>
                                                      <div class="input-group">
                                                          <span class="input-group-btn">
                                                              <span class="btn btn-default btn-file">
                                                                   <input type="file" id="imgWndScreen" name="imgWndScreen">
                                                              </span>
                                                          </span>        
                                                      </div>
                                                      <img id='img-upload'/>
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
                                                    <input type="checkbox"  name ="cylindervalve" id ="cylindervalve" <?php if (old('cylindervalve') =="on"){echo 'checked';} ?>>
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
                                                    name ="fillingvalve" <?php if (old('fillingvalve') =="on"){echo 'checked';} ?> >
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
                                                  <input type="checkbox" id = "Reducer" name = "Reducer" <?php if (old('Reducer') =="on"){echo 'checked';} ?>>
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
                                                  <input type="checkbox" id="hpp"  name="hpp" <?php if (old('hpp') =="on"){echo 'checked';} ?>>
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
                                                    <input type="checkbox"  id="exhaustpipe"  name="exhaustpipe" <?php if (old('exhaustpipe') =="on"){echo 'checked';} ?>>
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