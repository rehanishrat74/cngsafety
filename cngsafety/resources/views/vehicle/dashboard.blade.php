@extends('layouts.dashboard')

@section('lefttree')
                    <ul class='wraplist'>   

                        <!--<li class='menusection'>Main</li>

                    <?php if (Auth::user()->regtype!="hdip") {?>
                        <li class="open"> 
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                    <?php }?>    -->                 

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <li class=""> 
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


<section class="wrapper main-wrapper row" >
    <div class='col-12'>
        <div class="page-title">
            <div class="float-left">
                <!-- PAGE HEADING TAG - START -->
                <h1 class="title">DASHBOARD</h1>
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
<!---------------------Java script counters -------------->
                    <div class="clearfix"></div>
                    <!-- MAIN CONTENT AREA STARTS -->
                    <div class="row margin-0">
                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Cylinder Brands</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="" style="height:200px" id="platform_type_dates"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    
                        </div>



                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Vehicle Registered</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="" style="height:200px" id="user_type"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    
                        </div>



                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Cylinders Tested</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="" style="height:200px" id="browser_type"></div>
                                            </div>


                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    </div>

                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Cylinders Expired</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="chart has-fixed-height" style="height:200px" id="scatter_chart"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    </div>

                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Today Tested Cylinders</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="chart has-fixed-height" style="height:200px" id="page_views_today"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    </div>


                        <div class="col-12 col-lg-6 col-xl-4">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">Total Registerations</h2>
                                    <div class="actions panel_actions float-right">
                                        <a class="box_toggle fa fa-chevron-down"></a>
                                        <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                        <a class="box_close fa fa-times"></a>
                                    </div>
                                </header>
                                <div class="content-body">        <div class="row">
                                        <div class="col-12">
                                            <div class="chart-container">
                                                <div class="chart has-fixed-height" style="height:200px" id="gauge_chart"></div>
                                            </div>
                                        </div>      
                                    </div> <!-- End .row -->
                                </div>
                            </section>    
                        </div>
                    </div>
 <!-- ------javascript counters------------------------------------------------------->







			
<!---------------------------Counters------------------------>
                    <div class="clearfix"></div>
                    <div class="col-xl-12">
                        <section class="box nobox marginBottom0">
                            <div class="content-body">    <div class="row">
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-thumbs-up icon-md icon-rounded icon-primary'></i>
                                            <div class="stats">
                                                <h4><strong>45</strong></h4>
                                                <span>+Vehicles</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-shopping-cart icon-md icon-rounded icon-accent'></i>
                                            <div class="stats">
                                                <h4><strong>243</strong></h4>
                                                <span>Cylinders Tested</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-dollar icon-md icon-rounded icon-purple'></i>
                                            <div class="stats">
                                                <h4><strong>3424</strong></h4>
                                                <span>Cylinders Expired</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="r4_counter db_box">
                                            <i class='float-left fa fa-users icon-md icon-rounded icon-warning'></i>
                                            <div class="stats">
                                                <h4><strong>1433</strong></h4>
                                                <span>Coming Expiries</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End .row -->    
                            </div>
                        </section>
                    </div>

<!---------------------------End of Counters------------------------>

<!----------------world control -------------------------------------->
                    <div class="col-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">CNG Labs</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-12">
                                        <div class="wid-vectormap">
                                            <div class="row">
                                                <div class="col-12 col-md-9">
                                                    <figure>
                                                        <div id="db-world-map-markers" style="width: 100%; height: 300px"></div> 
                                                   <!--<div id="asia-map" style="width: 600px; height: 400px"></div>
                                                 <script>
                                                             $(function(){
                                                                $('#asia-map').vectorMap({map: 'asia_mill'});
                                                            });
                                                </script>     -->  
                                                    </figure>
                                                </div>
                                                <div class="map_progress col-12 col-md-3">
                                                    <h4>Cylinders Tested</h4>
                                                    <span class='text-muted'><small>Last Week Rise by 62%</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%"></div></div>
                                                    <br>
                                                    <h4>Cylinders Registered</h4>
                                                    <span class='text-muted'><small>Up by 57% last 7 days</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%"></div></div>
                                                    <br>
                                                    <h4>Labs Registered</h4>
                                                    <span class='text-muted'><small>Last Month Rise by 22%</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100" style="width: 22%"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div> <!-- End .row -->

                            </div>
                        </section>
                    </div>
<!----------------world control ends-------------------------------------->


<!-------------------------------asia control ---------------------------->
                    <!--<div class="col-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">CNG Labs</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-12">
                                        <div class="wid-vectormap">
                                            <div class="row">
                                                <div class="col-12 col-md-9">
                                                    <figure>

                                            <div id="db-asia-map-markers" style="width: 100%; height: 300px">
                                                the following libraries used in vector map.
                                                //assets/js/scripts.js
                                                
                                                src="../assets/plugins/jvectormap/
                                                jquery-jvectormap-asia-mill.js " 


                                                src="../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"

                                                href="../assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css"

                                            </div>
                                                 

                                                             
                                                
                                                    </figure>
                                                </div>
                                                <div class="map_progress col-12 col-md-3">
                                                    <h4>Cylinders Tested</h4>
                                                    <span class='text-muted'><small>Last Week Rise by 62%</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%"></div></div>
                                                    <br>
                                                    <h4>Cylinders Registered</h4>
                                                    <span class='text-muted'><small>Up by 57% last 7 days</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%"></div></div>
                                                    <br>
                                                    <h4>Labs Registered</h4>
                                                    <span class='text-muted'><small>Last Month Rise by 22%</small></span>
                                                    <div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100" style="width: 22%"></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div> <!-#- End .row -#->

                            </div>
                        </section>
                    </div>
                -->
<!--------------------------end of asia control---------------------------------------------->

            <!-- MAIN CONTENT AREA ENDS -->
</section>

@endsection