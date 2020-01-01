@extends('layouts.cngapploggedin')
@section('lefttree')
                    <ul class='wraplist'>   
<!--class open creates background highlight------------------------------------>            
                        <!--<li class='menusection'>Main</li>


                        <li class=""> 

                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>-->

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->functionname=="Cylinder Categories")
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
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Cylinder categories</h1><!-- PAGE HEADING TAG - END -->                            </div>

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
                                <h2 class="title float-left">List</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-12">


                                        <table  class="display table table-hover table-condensed" cellspacing="0" width="100%">
                                            <!--id="example-11" draw with search controlls-->
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                </tr>


                                            </thead>

                                            <tbody>
                                               @foreach ($categories as $category)
                                               <tr>
                                                 <td>{{ $category->category_id }}</td>
                                                 <td>{{ $category->category_name }}</td>
                                               </tr>
                                               @endforeach         

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </section></div>

                    <!-- MAIN CONTENT AREA ENDS -->
                </section>



@endsection
