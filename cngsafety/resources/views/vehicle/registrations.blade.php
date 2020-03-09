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
<script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
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
                        </div>

                    </div>                    

                    <!-- ------IMPLETMENT SEARCH HERE ----->
                    <div class="col-xl-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">Search</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">   
                                <div class="row" >
                                    <div class ="col-12">
                                <!----------------------------->
                            <form id="searchvehicle" method="POST" action="{{route('registrations-search')}}">
                                {{ csrf_field() }}

                              
                            <div class="input-group primary" >

                      
                                        <select class="form-control pagesize" id="pagesize" name="pagesize">
                                                <option value="10" <?php if (session()->get('pagesize')==10  || $pagesize=="10"){echo 'selected';} ?> >Page size 10</option>
                                                <option value="50" <?php if (session()->get('pagesize')==50  || $pagesize=="50"){echo 'selected';} ?>>Page size 50</option>
                                                <option value="100" <?php if (session()->get('pagesize')==100  || $pagesize=="100"){echo 'selected';} ?> >Page size 100</option>
                                                <option value="500" <?php if (session()->get('pagesize')==500  || $pagesize=="500"){echo 'selected';} ?>>Page size 500</option>
                                                <option value="1000" <?php if (session()->get('pagesize')==1000  || $pagesize=="1000"){echo 'selected';} ?>>Page size 1000  </option>

                                        </select>   

                                    <select class="form-control businesstype" id="businesstype" name="businesstype" >
                                        <option value="All" <?php if ($businessType=="All"){echo "selected";} ?> >* (All types)</option>
                                        <option value="Commercial" <?php if ($businessType=="Commercial"){echo "selected";} ?> >Commercial</option>
                                        <option value="Private" <?php if ($businessType=="Private"){echo "selected";} ?> >Private</option>
                                    </select>

                                    <select class="form-control inspectionType" id="inspectionType" name="inspectionType" >
                                        <option value="All" <?php if ($inspectionType=="All"){echo "selected";} ?>  >* (All Inspections)</option>
                                        <option value="pending" <?php if ($inspectionType=="pending"){echo "selected";} ?>>pending</option>
                                        <option value="completed" <?php if ($inspectionType=="completed"){echo "selected";} ?>>completed</option>
                                    </select>

                                        <select class="form-control" id="searchby" name="searchby" 
                                        onclick="setplaceholder()"
                                        >
                                                <option value="All" <?php if ($searchby=="All") {echo "selected";}?>>* (All)</option>
                                                <option value="Registration_no"  <?php if ($searchby=="Registration_no") {echo "selected";}?>>Registration no</option>
                                                <option value="CNIC"  <?php if ($searchby=="CNIC") {echo "selected";}?>>CNIC</option>
                                                <option value="serialno"  <?php if ($searchby=="serialno") {echo "selected";}?> >Sticker</option>
                                                <option value="Owner_name"  <?php if ($searchby=="Owner_name") {echo "selected";}?> >Owner</option>
                                                <option value="stationno"  <?php if ($searchby=="stationno") {echo "selected";}?> >Station no</option>
                                                <option value="created_at"  <?php if ($searchby=="created_at") {echo "selected";}?>>date</option>
                                                <option value="businesstype"  <?php if ($searchby=="businesstype") {echo "selected";}?> >type</option>
                                        </select>


                                <input type="text" class="form-control search-page-input" placeholder="Search" value="" placeholder="Search" autocomplete="off" id="searchvalue" name="searchvalue">
                                
                                <span class="input-group-addon" 
                                onclick="event.preventDefault(); document.getElementById('searchvehicle').submit();">   
                                    <span class="arrow"></span>
                                    <i class="fa fa-search"></i>
                                </span>                             



                            </div> <!--<br> end of selection criteria  -->

                        </form>

                                <!----------------------------->                
                                    </div>
                                </div>                             
                             </div>   
                        </section>
                    </div>

                <!-- ----------------------------------------------- -->
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
                            <div class="content-body">    


                    
          <!--  -------------new search bar----------------------   ------------->

          <!--  ----------------end of new search bar-----------   ------------->
                                <div class="row">
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

                                                 <?php if (Auth::user()->regtype!="hdipexclude") {?>
                                                 <th><a href="/registrations/?sort=Inspection">Inspection</a></th>
                                                 <?php }?>
                                               </tr>

                                            </thead>


                                            <tbody>
                                                 @foreach ($vehicles as $vehicle)                               
                                                   <tr>
                                                     <td>{{$vehicle->Record_no}}</td>
                                                     <!-- td starts here -->
                                                        <?php 
                                                        if (Auth::user()->regtype=="hdip")
                                                        {?>

                                                     <td>
                                                        Reg: {{$vehicle->Registration_no}}<br>
                                                        Chasis: {{$vehicle->Chasis_no}}<br>Engine: {{$vehicle->Engine_no}}<br>
                                                    <?php if (isset($vehicle->StickerSerialNo)){echo "Sticker: ".$vehicle->StickerSerialNo;}?>
                                                        
                                                     </td>
                                                    <?php } else
                                                    {?>
                                                     <td><a href="{{route('edit-vehicle',$vehicle->Record_no)}}">
                                                        Reg: {{$vehicle->Registration_no}}<br>
                                                        Chasis: {{$vehicle->Chasis_no}}<br>Engine: {{$vehicle->Engine_no}}<br>
                                                    <?php if (isset($vehicle->StickerSerialNo)){echo "Sticker: ".$vehicle->StickerSerialNo;}?>
                                                        </a>
                                                     </td>
                                                    <?php }
                                                    ?>
                                                    <!-- td ends  here -->
                                                    
                                                     <td>{{$vehicle->Make_type}}</td>
                                                     <td>{{$vehicle->businesstype}}</td>
                                                     <td>{{$vehicle->Owner_name}}<br>Nic: {{$vehicle->OwnerCnic}}<br>Mob: {{$vehicle->Cell_No}}<br>Addr: {{$vehicle->Address}}</td>
                                                     <td>{{$vehicle->stationno}} &nbsp;
<?php 

$inspectionExpired=0;
if (isset($vehicle->InspectionDate))
{


//$inspectionDate = strtotime('+12 month',strtotime($vehicle->InspectionDate));
$inspectionDate = strtotime($vehicle->InspectionDate);
$inspectionDate=date('Y-m-j',$inspectionDate);

$kitExpiryDate=strtotime($vehicle->InspectionExpiry);
$kitExpiryDate =date('Y-m-j',$kitExpiryDate);

$date = date('Y-m-d'); //today date

//echo "Inspection date=".$inspectionDate;
//echo " date=".$date;
//echo 'today='.$date.'<br>';
//echo 'expiry='.$kitExpiryDate.'<br>';
if($date > $kitExpiryDate ) // old case was =if($date > $inspectionDate)
{$inspectionExpired=1;?>
<img id='redflag'  src="../assets/images/redflag.png" style="width:20px;height:20px;border:0;">
<?php } }?>

                                                     </td>
                                                     <?php  if (Auth::user()->regtype!="hdipexclue" ){ // restricting hdip access to inspecton
                                                        ?>
                                                     <td>
                                                        <?php if (Auth::user()->regtype=="workshop" || Auth::user()->regtype=="admin" || Auth::user()->regtype=="hdip") {?>

                                                        <a href="<?php if ($vehicle->formid==0){if ($inspectionExpired==0){echo route('newcylinderreg',$vehicle->Registration_no.'?recordid='.$vehicle->Record_no.'&stationno='.$vehicle->stationno);}}else{if ($vehicle->Inspection_Status=='completed'){if($inspectionExpired==1){echo route('newcylinderreg',$vehicle->Registration_no.'?recordid='.$vehicle->Record_no.'&stationno='.$vehicle->stationno);}else{echo route('showcylinder',$vehicle->formid);}}else{echo route('editcylinder',$vehicle->formid);}}?>">
                                                        <?php }?>

                                                        <?php if ($vehicle->Inspection_Status =="completed" && Auth::user()->regtype=="workshop")
                                                        {
                                                        ?>

                                                        <a href="<?php if ($vehicle->formid==0){}else{if ($vehicle->Inspection_Status=='completed'){if($inspectionExpired==1){}else{echo route('showcylinder',$vehicle->formid);}}else{}}?>">
                                                            <i class="fa"></i>{{$vehicle->Inspection_Status}}</a>
                                                        <?php } else {echo $vehicle->Inspection_Status;}?>
                                                        
                                                     </td>

                                                    <?php }?>



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

$(document).ready(function(){

    $(".pagesize").change(function(){
    var cname, cvalue, exdays
    cname="pagesize";
    cvalue=$(this).val();
    exdays=1;
    setCookie(cname,cvalue,exdays);
    });
    //--------------------------------------
    $(".businesstype").change(function(){
    var cname, cvalue, exdays
    cname="registrations_businessType";
    cvalue=$(this).val();
    exdays=1;
    //console.log("businessType="+cname+"="+cvalue);
    setCookie(cname,cvalue,exdays);
    });
    // --------------------------------------
    $(".inspectionType").change(function(){
    var cname, cvalue, exdays
   
    cname="registrations_inspectionType";
    cvalue=$(this).val();
    exdays=1;
    //console.log("inspectiontype="+cname+"="+cvalue);
    setCookie(cname,cvalue,exdays);
    });

    //---------------------------------------------    
});

function setplaceholder() {
  if (document.getElementById("searchby").value=="created_at") {
        document.getElementById("searchvalue").placeholder="mm/dd/yyyy";
  }
  else
  {
    document.getElementById("searchvalue").placeholder="Search";
  }

}


   function setCookie(cname,cvalue,exdays)
    {

            var cookiexpire = new Date();
            cookiexpire.setTime(cookiexpire.getTime() + (exdays * 24 * 60 * 60 * 1000));
            

            var $post = {};
            $post.cname=cname;
            $post.cvalue=cvalue;
            $post.exdays=cookiexpire.toUTCString();            
            $post._token = document.getElementsByName("_token")[0].value;

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
            $.ajax({
           
                url: 'setCookie',
                type: 'POST',
                method: 'POST',                
                data: $post,
                data:  {'post' : $post },  
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",         
                // above content type must for php. must not be json       
                async: true,
                datatype: "json",

                success: responseOut,
                failure: function (message) {
                    alert("failure");         
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("error");
                    alert(errorThrown);
                }

            });

            function responseOut(responseD) {
                
                // the function is expected to receive "created" afater creating cookie
                //var data = responseD.d;                
                //console.log(responseD);
                //nothing is not done
                console.log(responseD);
                }

    }






</script>

@endsection



--------------------------------------

