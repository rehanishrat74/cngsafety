
@extends('layouts.home')


<!--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::user()->name =='admin')

                        <script>
                            //return redirect('auth/login');
                        // your "Imaginary javascript"
                        //window.location.href = 'http://homestead1.test/view-records';
                         //window.location.href = '{{url("yoururl")}}';
                        // or
                         window.location.href = '{{route("view-records")}}'; //using a named route
                        </script>
                    @else
                        You are not authorised to view the pages. Please contact support.
                    @endif

                    <?php  ?>
                </div>
            </div>
        </div>
    </div>
</div>-->

@section('content')



                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Home</h1><!-- PAGE HEADING TAG - END -->                            </div>

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

                    <div class="col-xl-12" >
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">Info</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">    
                                <div class="row">
                                    <div class="col-12">




                                            <?php 
                                                if (Auth::user()->activated==0){
                                                    echo "<p style=text-align: center;> To activate your account please contact <br>Email:cng.safety.taskforce@gmail.com <br> Helpline: 051-4901444</p>";
                                                }

                                                if (Auth::user()->regtype=="hdip" || 
                                                    Auth::user()->regtype=="apcng")
                                                {
                                                    $targetroute ="showlabs";
                                                }
                                                else if (Auth::user()->regtype=="laboratory")
                                                {
                                                    $targetroute ="listlabtestedcylinders";
                                                }                                                
                                                else
                                                {
                                                 $targetroute ="registrations";   
                                                }
                                                if (Auth::user()->activated==1){
                                            ?>                                        
                                                <script>
                                                 //window.location.href = '{{route("view-records")}}'; 
                                                 window.location.href = '{{route($targetroute)}}'; 


                                                 //using a named route
                                                </script>
                                            <?php }?>

                                    </div>
                                </div>
                            </div>
                        </section></div>

                    <!-- MAIN CONTENT AREA ENDS -->
                </section>



@endsection


<!--34@if (Auth::user()->name =='admin')
<script>
//window.location.href = '{{route("view-records")}}'; 
window.location.href = '{{route("registrations")}}'; 
//using a named route
</script>
34@else
You are not authorised to view the pages. Please contact support.
34@endif                                        -->