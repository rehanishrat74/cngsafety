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
                    <?php }?>   -->                  

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->functionname=="Registered Vehicles")
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
<?php 
//print_r($vehicles);
?>

                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Registered Vehicles</h1><!-- PAGE HEADING TAG - END -->                            </div>

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
                    <!--------------------------form-control-lg----->

                    <div class="row margin-0">
                        <div class="col-lg-9 col-md-12 col-12" >
                            <form id="searchvehicle" method="POST" action="{{route('registrations-search')}}">
                                {{ csrf_field() }}


                               
                            <div class="input-group primary">
                                        <select class="form-control" id="pagesize" name="pagesize">
                                                <option value="10">Page size 10</option>
                                                <option value="50">Page size 50</option>
                                                <option value="100">Page size 100</option>
                                                <option value="500">Page size 500</option>
                                                <option value="1000">Page size 1000</option>

                                        </select>                                                                            
                                        <select class="form-control" id="searchby" name="searchby" 
                                        onclick="setplaceholder()"
                                        >
                                                <option value="Registration_no">Registration no</option>
                                                <option value="CNIC">CNIC</option>
                                                <option value="serialno">Serial no</option>
                                                <option value="Owner_name">Owner</option>
                                                <option value="stationno">Station no</option>
                                                <option value="created_at">date</option>             
                                                <option value="businesstype">type</option>
                                        </select>


                                <input type="text" class="form-control search-page-input" placeholder="Search" value="" placeholder="Search" autocomplete="off" id="searchvalue" name="searchvalue">
                                <span class="input-group-addon" 
                                onclick="event.preventDefault(); document.getElementById('searchvehicle').submit();">   
                                    <span class="arrow"></span>
                                    <i class="fa fa-search"></i>
                                </span>                               



                            </div> <!--<br>-->
                        </form>
                        </div>
                        <!--<div class="col-lg-3 col-md-12 col-12" >
                            <nav aria-label="Page navigation" class="float-right">
                                <ul class="pagination">
                                    <li class="page-item "> <?=$vehicles->render()?> </li>

                                </ul>
                            </nav>
                        </div>-->
                    </div>                    

                    <!-- ------IMPLETMENT SEARCH HERE ----->
          
                    <div class="col-xl-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">List</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-12">



                               

<!--class open creates background highlight------------------------------------>            
                            
                                
                                
                                
                            


                                        <table class="display table table-hover table-condensed" cellspacing="0" width="100%">
                                            <!--id="example-11" draw with search controlls-->
                                            <thead>
                                               <tr>
                                                <!--<i class="fa fa-chevron-up"></i> -->
                                                 <th><a href="/registrations/?sort=Recordno">Id</a> </th>
                                                 <th><a href="/registrations/?sort=Registrationno">Registration</a></th>
                                                 <th><a href="/registrations/?sort=Make">Make</a></th>
                                                 <th><a href="/registrations/?sort=Type">Type</a></th>
                                                 <th><a href="/registrations/?sort=Owner">Owner</a></th>
                                                 <th><a href="/registrations/?sort=Station">Station</a></th>

                                                 <!--<th><a href="/registrations/?sort=Engine">Engine no</a></th>-->
                                                 <th><a href="/registrations/?sort=Inspection">Inspection</a></th>
                                               </tr>

                                            </thead>


                                            <tbody>
                                                 @foreach ($vehicles as $vehicle)                               
                                                   <tr>
                                                     <td>{{$vehicle->Record_no}}</td>
                                                     <td>Reg: {{$vehicle->Registration_no}}<br>
                                                        Chasis: {{$vehicle->Chasis_no}}<br>Engine: {{$vehicle->Engine_no}}<br>
        <?php if (isset($vehicle->StickerSerialNo)){echo "Sticker: ".$vehicle->StickerSerialNo;}?>
                                                     </td>
                                                     <td>{{$vehicle->Make_type}}</td>
                                                     <td>{{$vehicle->businesstype}}</td>
                                                     <td>{{$vehicle->Owner_name}}<br>Nic: {{$vehicle->OwnerCnic}}<br>Mob: {{$vehicle->Cell_No}}<br>Addr: {{$vehicle->Address}}</td>
                                                     <td>{{$vehicle->stationno}} &nbsp;
<?php 

$inspectionExpired=0;
if (isset($vehicle->InspectionDate))
{


$inspectionDate = strtotime('+12 month',strtotime($vehicle->InspectionDate));
$inspectionDate=date('Y-m-j',$inspectionDate);

$date = date('Y-m-d');

//echo "Inspection date=".$inspectionDate;
//echo " date=".$date;

if($date > $inspectionDate)
{$inspectionExpired=1;?>
<img id='redflag'  src="../assets/images/redflag.png" style="width:20px;height:20px;border:0;">
<?php } }?>

                                                     </td>
                                                     
                                                     <td>
                                                        <?php if (Auth::user()->regtype!="workshop") {?>

                                                        <a href="<?php if ($vehicle->formid==0){if ($inspectionExpired==0){echo route('newcylinderreg',$vehicle->Registration_no.'?recordid='.$vehicle->Record_no.'&stationno='.$vehicle->stationno);}}else{if ($vehicle->Inspection_Status=='completed'){if($inspectionExpired==1){echo route('newcylinderreg',$vehicle->Registration_no.'?recordid='.$vehicle->Record_no.'&stationno='.$vehicle->stationno);}else{echo route('showcylinder',$vehicle->formid);}}else{echo route('editcylinder',$vehicle->formid);}}?>">
                                                        <?php }?>

                                                        <?php if ($vehicle->Inspection_Status =="completed" && Auth::user()->regtype=="workshop")
                                                        {
                                                        ?>

                                                        <a href="<?php if ($vehicle->formid==0){}else{if ($vehicle->Inspection_Status=='completed'){if($inspectionExpired==1){}else{echo route('showcylinder',$vehicle->formid);}}else{}}?>">
                                                            <i class="fa"></i>{{$vehicle->Inspection_Status}}</a>
                                                        <?php } else {echo $vehicle->Inspection_Status;}?>
                                                        
                                                     </td>





                                                   </tr>
                                                 @endforeach  

                                            </tbody>
                                        </table>
                                        <?=$vehicles->render()?>
                                    </div>
                                </div>
                            </div>
                        </section></div>

                    <!-- MAIN CONTENT AREA ENDS -->
                </section>

<script>
function setplaceholder() {
  if (document.getElementById("searchby").value=="created_at") {
        document.getElementById("searchvalue").placeholder="mm/dd/yyyy";
  }
  else
  {
    document.getElementById("searchvalue").placeholder="Search";
  }
}
</script>

@endsection