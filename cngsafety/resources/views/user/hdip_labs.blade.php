@extends('layouts.cngapploggedin')

@section('lefttree')
                    <ul class='wraplist'>   

                        <li class='menusection'>Main</li>
                        <li class=""> 
<!--class open creates background highlight------------------------------------>            
                            <!--<a href="{{ route('dashboard') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>-->
                        </li>                        

<!-- left treee categoroes -------------4a-left tree categories.txt--------------->

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->functionname=="Labs")
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
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Registered Labs</h1><!-- PAGE HEADING TAG - END -->                            </div>

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


                                        <!-- ********************************************** -->


                                        <table  class="display table table-hover table-condensed " cellspacing="0" width="100%">
                                            <!--id="example-11" draw with search controlls-->
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Contact</th>
                                                    <th>Province</th>
                                                    <th>City</th>
                                                    <!--<th>NickName</th>-->

                                            </thead>

                                            <tbody>
                                                <?php $Address; $Contact;?>
                                                   @foreach ($users as $user)
                                                   <?php 
                                                        $Address="";
                                                        $Contact="";
                                                        $Address= $user->email;
                                                        $Address=$Address.'<br>Postal: '.$user->address;
                                                        if (isset($user->companyname))
                                                        {$Address=$Address.'<br>Company: '.$user->companyname;}
                                                        if (isset($user->ownername))
                                                        {$Address=$Address.'<br>Owner: '.$user->ownername;}
                                                        if (isset($user->engineername))
                                                        {$Address=$Address.'<br>Engineer: '.$user->engineername;}

                                                        if (isset($user->landlineno))
                                                        {$Contact='LandLine: '.$user->landlineno;}
                                                   
                                                        if (isset($user->mobileno))
                                                        {$Contact=$Contact.'<br>Mob: '.$user->mobileno;}                               
                                                   ?> 

                                                   <tr>
                                                     <td>{{ $user->id }}</td>
                                                     <td><?php echo $user->name.'<br>Ph# '.$user->contactno.'<br>Lic# '.$user->hdip_lic_no;?></td>
                                                     <td><?php echo $Address;?></td>
                                                     <td><?php echo $Contact;?></td>
                                                     <td>{{ $user->province }}</td>
                                                     <td>{{ $user->city }}</td>
                                                     <!--<td>{{ $user->nickname }}</td>-->
                                                   </tr>
                                                   @endforeach
                                            </tbody>
                                        </table>
                                        <!-- ********************************************** -->
                                        <?=$users->render()?>




                                    </div>
                                </div>
                            </div>
                        </section></div>









                    <!-- MAIN CONTENT AREA ENDS -->
                </section>


@endsection