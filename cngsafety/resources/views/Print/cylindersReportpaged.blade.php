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
                                <h2 class="title float-left">Cylinders Data To Print 

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

<span class="input-group-addon" onclick="window.open('{{$loc}}'); return false;" >


                                     

                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <!--<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>-->
                                </div>
                            </header>                            
                            <div class="content-body" style="font-size: 12px;">    

                            	<div class="row">
                             

<!--class open creates background highlight------------------------------------>          
      

<?php 
$pagesize=500;

$number=$cylinders[0]->recs/$pagesize;
$totalPages=number_format($number);


$pageloop=1;
?>

  <h2></h2>

                                    <div class="col-12">
                                    	<?php for ($page=1;$page<=$totalPages;$page++)  { 
                                    		$CalculatedRow= $pageloop   ;
                                    		$pageloop =$pageloop + $pagesize;

                                    		?>
                                  		 <div class="form-group row" >
                                   			 <div class="col-lg-4" >
                                   			 	Page = {{$CalculatedRow}}  
                                   	 		</div>
                                   	 		 <div class="col-lg-1" >
												
                            <a href="{{route('printCylinderIndex',$CalculatedRow)}}"  target="_blank">
                            <img id='windscreen'  src="../assets/images/Printer.png" width="50px;" height="30px" >    
                            </a> 	
                                   	  		</div>

                                    		<div class="col-lg-4" >
                                   			 	Records {{$CalculatedRow}} to {{$pageloop}} 
                                   	 		</div>                                  	  		
                                  		 </div>  
                                  		 <?php 
                                  		 	
                                  		}?>
  	                                      <div class="form-group row" >
                                             <div class="col-lg-4" >
                                                Page > {{$pageloop}}  
                                            </div>
                                             <div class="col-lg-1" >
                                                
                            <a href="{{route('printCylinderIndex',$pageloop+1)}}">
                            <img id='windscreen'  src="../assets/images/Printer.png" width="50px;" height="30px" >    
                            </a>    
                                            </div>

                                            <div class="col-lg-4" >
                                                Records > {{$pageloop}} 
                                            </div>                                              
                                         </div>			
                                     

                                    </div>
                                </div>
                            </div>
                        </section></div>

                    <!-- MAIN CONTENT AREA ENDS -->
                </section>






@endsection