@extends('layouts.cngapploggedin')
@section('lefttree')
                    <ul class='wraplist'>   

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            
                            if ($node->functionname=="Tested Cylinders")
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




       
                    </ul>
@endsection

@section('content')
<script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>

                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Tested Cylinders</h1><!-- PAGE HEADING TAG - END -->                            </div>

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
                             <form attr.id="searchvehicle" method="POST" class="myform" action="{{route('testedcylinders-search')}}">
                                {{ csrf_field() }}
                              
                            <div class="input-group primary">
                                        <select class="form-control pagesize" attr.id="pagesize" name="pagesize">
                                                <option value="10" 
                                                  <?php if (old("pagesize")=="10" || $pagesize=="10") {echo "selected";}?>
                                                >Page size 10</option>
                                                <option value="50"
                                                  <?php if (old("pagesize")=="50"  || $pagesize=="50") {echo "selected";}?>
                                                >Page size 50</option>
                                                <option value="100"
                                                  <?php if (old("pagesize")=="100"  || $pagesize=="100") {echo "selected";}?>
                                                >Page size 100</option>
                                                <option value="500"
                                                  <?php if (old("pagesize")=="500"  || $pagesize=="500") {echo "selected";}?>
                                                >Page size 500</option>
                                                <option value="1000"
                                                    <?php if (old("pagesize")=="1000"  || $pagesize=="1000" ) {echo "selected";}?>
                                                >Page size 1000</option>

                                        </select>                                                                            
                                        <select class="form-control" attr.id="lab" name="lab">
<?php if ((Auth::user()->regtype=="hdip" || Auth::user()->regtype=="admin") ) {?>
 <option value="*">* (All Labs)</option>
<?php }?>
                                               
                                                @foreach ($labs as $lab)       
                                                  <option value="{{$lab->Labname}}" 
                                                  <?php if (old("lab")=="$lab->Labname") {echo "selected";}?>
                                                    >{{$lab->Labname}}</option>
                                                @endforeach 
                                        </select>       

                                      <select class="form-control searchpicker" attr.id="searchby" name="searchby" 
                                        >

                                                <option value="*" <?php if (old("searchby")=="*") {echo "selected";}?> >* (All Cylinders)</option>
                                                <option value="BrandName" <?php if (old("searchby")=="BrandName") {echo "selected";}?> >Brand Name</option>
                                                <option value="Standard" <?php if (old("searchby")=="Standard") {echo "selected";}?> >Standard</option>
                                                
                                                <option value="SerialNumber" <?php if (old("searchby")=="SerialNumber") {echo "selected";}?> >Serial no</option>

                                                <option value="CountryOfOrigin" <?php if (old("searchby")=="CountryOfOrigin") {echo "selected";}?> >Country</option>

                                                <option value="Date" <?php if (old("searchby")=="Date") {echo "selected";}?> >Date</option>
                                                <option value="InspectionExpiryDate" <?php if (old("searchby")=="InspectionExpiryDate") {echo "selected";}?> >Expiry Date</option>
                                                <option value="stickerSerialNo" <?php if (old("searchby")=="stickerSerialNo") {echo "selected";}?>>Sticker No</option>
                                        </select>

                                <input type="text" class="form-control search-page-input" placeholder="Search" value="" placeholder="Search" autocomplete="off" attr.id="searchvalue" name="searchvalue" disabled>
                               <span class="input-group-addon submitbutton">   
                                    <span class="arrow"></span>
                                    <i class="fa fa-search"></i>
                                </span>  

                            </div> <!--<br>-->
                        </form>
                                     
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>                 

                    <!-- ------IMPLETMENT SEARCH HERE ----->
          
                    <div class="col-xl-12">
                        <section class="box ">
                            <!--<header class="panel_header">
                                <h2 class="title float-left">List </h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>-->
                            <header class="panel_header">
                                <h2 class="title float-left">List 

                                </h2>
                                <div class="actions panel_actions float-right">
                                <?php
                                /*$params="";
                                $params=$params.'printWhere='.session()->get('printWhere');
                                $params=$params.'&printOrderBy='.session()->get('printOrderBy');
                                $params=$params.'&printPaginate='.session()->get('printPaginate');
                                $params=$params.'&function='.session()->get('function');
                                    $loc=route('printVehicles').'/?'.$params; */
                                    $loc=route('printCylinders');;
                                 ?>

              <?php 
               if ((Auth::user()->regtype=="hdip" || Auth::user()->regtype=="admin") )
               {
              ?>
        <span class="input-group-addon" onclick="window.open('{{$loc}}'); return false;" >


                                    <span class="arrow"></span>
                                    <i class="fa fa-print"></i>
                                   </span>  
              <?php }?>
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <!--<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>-->
                                </div>
                            </header>                            
                            <div class="content-body" style="font-size: 12px;">    <div class="row">
                                    <div class="col-12">



                               

<!--class open creates background highlight------------------------------------>            
                            
                                
                                
                                
                            


                                        <table class="display table table-hover table-condensed" cellspacing="0" width="100%">
                                            <!--id="example-11" draw with search controlls-->
                                            <thead>
                                               <tr>
                                                <!--<i class="fa fa-chevron-up"></i> -->



                                                 <th><a href="/listlabtestedcylinders/?sort=id">Id</a> </th>
                                                 <th><a href="/listlabtestedcylinders/?sort=LabCTS">Lab</a> </th>
                                                 <th><a href="/listlabtestedcylinders/?sort=BrandName">Brand</a></th>
                                                 <th><a href="/listlabtestedcylinders/?sort=Standard">Standard</a></th>
                                                 <th><a href="/listlabtestedcylinders/?sort=SerialNumber">SerialNo</a></th>
                                                 <th><a href="/listlabtestedcylinders/?sort=method">Method</a></th>
                                                 <th><a href="/listlabtestedcylinders/?sort=CountryOfOrigin">Country</a></th>
                                                 <th><a href="/listlabtestedcylinders/?sort=Date">Date</a></th>
                                                 <th><a href="/listlabtestedcylinders/?sort=InspectionExpiryDate">Expiry</a></th>
                                                 
                                               </tr>

                                            </thead>


                                            <tbody>

                                                 @foreach ($testedcylinders as $cylinder)                               
                                                   <tr>

<?php if ((Auth::user()->regtype=="hdip" || Auth::user()->regtype=="admin") && Auth::user()->readonly!=1) {?>
<td><a href="{{route('editformfortestedcylinders',$cylinder->id)}}">{{$cylinder->row_number}}</a></td>
<td><a href="{{route('editformfortestedcylinders',$cylinder->id)}}">{{$cylinder->LabCTS}}</a></td>
<?php 
} 
else
{
?>
                                               <td>{{$cylinder->row_number}}</td>
                                               <td>{{$cylinder->LabCTS}}</td>
<?php }

?>


                                                     
                                                     
                                                     <td>{{$cylinder->BrandName}}</td>
                                                     <td>{{$cylinder->Standard}}</td>
                                                     <td>{{$cylinder->SerialNumber}}

                                                     </td>
                                                     <td>{{$cylinder->method}}</td>                                                        
                                                     <td>{{$cylinder->CountryOfOrigin}}</td>
                                                     <td>{{$cylinder->Date}}</td>
                                        
                                                     <td>{{$cylinder->InspectionExpiryDate}}
<?php 

$date = date('Y-m-d');
if($date > $cylinder->InspectionExpiryDate)
{//its already expired?>
<img id='redflag'  src="../assets/images/redflag.png" style="width:20px;height:20px;border:0;">
<?php } ?>

                                                     </td>
                                                    


                                                   </tr>
                                                 @endforeach  

                                            </tbody>
                                        </table>
                                        <?=$testedcylinders->render()?>
                                    </div>
                                </div>
                            </div>
                        </section></div>

                    <!-- MAIN CONTENT AREA ENDS -->
                </section>




<script>
$(document).ready(function(){

  if($(".searchpicker").val()!="*"){$(".search-page-input").removeAttr("disabled"); }


  
  //xt$(".search-page-input").placeholder.value="sdfa";

  $(".searchpicker").change(function(){
    var searchValue = $(this).val();
    if (searchValue=="*"){
      //hide
     //$(".search-page-input").hide();
    
         $(".search-page-input").attr("disabled", "disabled"); 

     } else {
      //display
     
         $(".search-page-input").removeAttr("disabled"); 
     }
     if (searchValue=="Date" || searchValue=="InspectionExpiryDate"){
        $(".search-page-input").attr("placeholder", "mm/dd/yyyy");
      } else {
        $(".search-page-input").attr("placeholder", "Search");
      }
    
  });

  $(".submitbutton").click(function(){
    //alert('hello');
    $(".myform").submit(); 
    
  });


  $(".pagesize").change(function(){

    var cname, cvalue, exdays
    cname="pagesize";
    cvalue=$(this).val();
    exdays=1;
    setCookie(cname,cvalue,exdays);

  });
   
}); // end of ready function

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
                
                // the function is expected to receive "created"
                //var data = responseD.d;                
                //console.log(responseD);
                //nothing is not done
                }

    }
</script>


@endsection