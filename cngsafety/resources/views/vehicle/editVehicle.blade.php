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
                    <?php }?>      -->

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->functionname=="New Vehicle")
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
                <h1 class="title">Edit Vehicle Registrations</h1>
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
          <h2 class="title float-left">Form</h2>
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
                        <div class="col-12" >
                            <form method="POST" action="{{ route('update-vehicle',$vehicles[0]->Record_no) }}">
                                {{ csrf_field() }}
                                <fieldset  id="myFieldset" >
                                    <div class="form-group row" >
                                      <div class="col-lg-12" style="text-align: center;">
                                          <label class="font-weight-bold">Edit Vehicle Particulars</label>
                                      </div>
                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6 input-group">
                                      </div>                                
                                    </div>

                                    <div class="form-group row" >
                                      <div class="col-lg-4">
                                              <label for="stationno">Work Station</label>
                                              <input type="text" class="form-control{{ $errors->has('stationno') ? ' is-invalid' : '' }}" 
                                              name="stationno" id="stationno" placeholder="Station No" autocomplete="off" value="{{ $vehicles[0]->stationno }}" <?php //if (Auth::user()->regtype=="workshop"){echo "readonly";}
                                              echo "readonly";
                                              ?> >
                                              <input type="hidden" name ="hidden_stationno" value ="{{$vehicles[0]->stationno}}">




                                              @if ($errors->has('stationno'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('stationno') }}</strong>
                                                </span>
                                              @endif                                                                              
                                      </div> 
                                      <div class="col-lg-4">
                                              <label for="maketype">Make & Type</label>
                                              <input type="text" class="form-control{{ $errors->has('maketype') ? ' is-invalid' : '' }}" 
                                              name="maketype" id="maketype" placeholder="Enter Make & Type" autocomplete="off" value="{{  $vehicles[0]->Make_type }}">

                                              @if ($errors->has('maketype'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('maketype') }}</strong>
                                                </span>
                                              @endif                                                                              
                                      </div>
                                      <div class="col-lg-4">
                                              <label for="registrationNo">Registration No</label>
                                              <input type="text" class="form-control{{ $errors->has('registrationNo') ? ' is-invalid' : '' }}"  
                                               name="registrationNo" 
                                               id="registrationNo" 
                                               placeholder="Enter Vehicle Registration No"   
                                                autocomplete="off" value="{{ $vehicles[0]->Registration_no }}" <?php  echo "readonly";?>>
                                                <input type="hidden" name ="hidden_Registration_no" value ="{{$vehicles[0]->Registration_no}}">

                                              @if ($errors->has('registrationNo'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('registrationNo') }}</strong>
                                                </span>
                                              @endif                                                        

                                      </div>
                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-3">
                                              <label for="chasisno">Chasis No</label>
                                              <input type="text" class="form-control{{ $errors->has('chasisno') ? ' is-invalid' : '' }}" 
                                              name="chasisno" id="chasisno" placeholder="Enter Chasis No" autocomplete="off" value="{{ $vehicles[0]->Chasis_no }}">
                                              @if ($errors->has('chasisno'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('chasisno') }}</strong>
                                                </span>
                                              @endif                                                        

                                      </div>
                                      <div class="col-lg-3">
                                              <label for="engineNo">Engine No</label>
                                              <input type="text" class="form-control{{ $errors->has('engineNo') ? ' is-invalid' : '' }}"  
                                              name="engineNo"  id="engineNo" placeholder="Enter Engine No" autocomplete="off" value="{{ $vehicles[0]->Engine_no }}">
                                              @if ($errors->has('engineNo'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('engineNo') }}</strong>
                                                </span>
                                              @endif                                                                                                                              
                                      </div>
                                      <div class="col-lg-3">
                                            <div class="dropdown">
                                                <label for="vcat">Vehicle Categories:</label>
                                                <select class="form-control" id="vcat" name="vcat">
                                                <option value="1" <?php if ($vehicles[0]->Vehicle_catid==1){echo 'selected';} ?>>PSV</option>
                                                <option value="2"  <?php if ($vehicles[0]->Vehicle_catid==2){echo 'selected';} ?>>Private</option>
                                                <option value="3" <?php if ($vehicles[0]->Vehicle_catid==3){echo 'selected';} ?>>Ambulance</option>
                                                <option value="4" <?php if ($vehicles[0]->Vehicle_catid==4){echo 'selected';} ?>>Cargo</option>
                                                <option value="5" <?php if ($vehicles[0]->Vehicle_catid==5){echo 'selected';} ?>>School Van</option>
                                                <option value="6" <?php if ($vehicles[0]->Vehicle_catid==6){echo 'selected';} ?>>Other</option>
                                                </select>
                                            </div>          
                                        </div>                            
                                        <div class="col-lg-3">
                                            <div class="dropdown">
                                                <label for="vcat">Business Type:</label>
                                                <select class="form-control" id="businesstype" name="businesstype">
                                                <option value="Private"  <?php if ($vehicles[0]->businesstype=="Private"){echo 'selected';} ?>>Private</option>
                                                <option value="Commercial"<?php if ($vehicles[0]->businesstype=="Commercial"){echo 'selected';} ?>>Commercial</option>
                                                </select>
                                            </div>                                          
                                        </div>

                                    </div>

                                   <div class="form-group row">
                                      <div class="col-lg-3">
                                              <label for="Stickerno">Sticker No</label>
                                              <input type="text" class="form-control{{ $errors->has('Stickerno') ? ' is-invalid' : '' }}" 
                                              name="Stickerno" id="Stickerno" placeholder="Enter Sticker No" autocomplete="off" value="{{ $vehicles[0]->StickerSerialNo }}" <?php echo "readonly"; ?>>

 <input type="hidden" name ="hidden_StickerSerialNo" value ="{{$vehicles[0]->StickerSerialNo}}">                                              
                                              @if ($errors->has('Stickerno'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('Stickerno') }}</strong>
                                                </span>
                                              @endif                                                        

                                      </div>
                                    </div>

                                    <!--<div class="form-group row" >
                                        

                                    </div>-->

                                    <!--<div class="form-group row" >
                                      <div class="col-lg-12" style="text-align: center;">
                                          <p> &nbsp; </p>
                                      </div>
                                    </div>-->
                                    <p> &nbsp; </p>
                                    <div class="form-group row  " >
                                      <div class="col-lg-12" style="text-align: center;">
                                          <label class="font-weight-bold" > Edit Owner Particulars</label>
                                      </div>
                                    </div>

                                    

                                    <div class="form-group row">
                                      <div class="col-lg-6">
                                              <label for="oname">Name</label>
                                              <input type="text" name="oname"  class="form-control{{ $errors->has('oname') ? ' is-invalid' : '' }}" id="oname" placeholder="Enter Name" autocomplete="off" value="{{ $vehicles[0]->Owner_name }}">
                                              @if ($errors->has('oname'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('oname') }}</strong>
                                                </span>
                                              @endif                                                                              
                                      </div>
                                      <div class="col-lg-6">
                                              <label for="cnic">CNIC</label>
                                              <input type="text" class="form-control{{ $errors->has('cnic') ? ' is-invalid' : '' }}" name="cnic"  id="cnic" placeholder="12345-1234567-9" autocomplete="off" value="{{ $vehicles[0]->OwnerCnic }}" <?php echo "readonly"; ?>>

<input type="hidden" name ="hidden_cnic" value ="{{$vehicles[0]->OwnerCnic}}">

                                              @if ($errors->has('cnic'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('cnic') }}</strong>
                                                </span>
                                              @endif                                                                                                                              
                                      </div>
                                    </div>

                                    <div class="form-group row">
                                      <div class="col-lg-6">
                                              <label for="cellno">Cell No</label>
                                              <input type="text" class="form-control{{ $errors->has('cellno') ? ' is-invalid' : '' }}" 
                                              name = "cellno" id="cellno" placeholder="0123-123-1234" autocomplete="off" value="{{ $vehicles[0]->Cell_No }}">
                                              @if ($errors->has('cellno'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('cellno') }}</strong>
                                                </span>
                                              @endif                                                                                                      
                                      </div>
                                      <div class="col-lg-6">
                                              <label for="address">Address</label>
                                              <textarea class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"  name="address" id="address" placeholder="Enter Address" >{{ $vehicles[0]->Address}}</textarea>
                                              
                                      </div>
                                    </div>
<!------------------------------------------------------------------------------->

                                 <button type="submit" value="submit" class="btn btn-primary">Update</button>
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