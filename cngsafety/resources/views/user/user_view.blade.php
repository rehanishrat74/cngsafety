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
                        </li>   -->

<!-- left treee categoroes -------------4a-left tree categories.txt--------------->

                        <li class='menusection'>Applications</li>
                        
                        @foreach ($treeitems as $node)

                            <?php  
                            $highlightclass="";
                            if ($node->functionname=="Registered Users")
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
        <!--<script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
        <script src="../assets/js/popper.min.js" type="text/javascript"></script> -->

        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 

        <!--<script src="../assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>-->



                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Registered Users</h1><!-- PAGE HEADING TAG - END -->                            </div>

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

                                    <div id =ratings>
                                        <!-- ********************************************** -->


                                        <table  class="display table table-hover table-condensed " cellspacing="0" width="100%">
                                            <!--id="example-11" draw with search controlls-->
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Type</th>
                                                    <th>Province</th>
                                                    <th>City</th>
                                                    <th></th>
                                                    <!--<th>NickName</th>-->

                                            </thead>

                                            <tbody>
                                                   @foreach ($users as $user)
                                                   <tr>
                                                    <?php if(Auth::user()->regtype  =="admin"){ ?>
                                                     <td><a href="{{route('showuser',$user->id)}}" > {{ $user->id }}</a></td>
                                                     <td><a href="{{route('showuser',$user->id)}}" ><?php echo $user->name.'<br>'.$user->contactno;?></a></td>
                                                    <?php } else { ?>

                                                     <td> {{ $user->id }}</td>
                                                     <td><?php echo $user->name.'<br>'.$user->contactno;?></td>
                                                    <?php }?>

                                                     <td><?php echo $user->email.'<br>Postal: '.$user->address.'<br> Status: '  ;?>
                                                         <font color="red">
                                                         <?php if ($user->activated==0){ echo "Suspended.";} else { echo "Activated";} ?>
                                                        </font>
                                                     </td>
                                                     <td><?php if ($user->regtype=="workshop"){echo $user->regtype.'<br>'.$user->stationno;}else if ($user->regtype=="laboratory"){echo $user->regtype.'<br>'.$user->labname; }else{echo $user->regtype;}?> 
                                                     </td>
                                                     <td>{{ $user->province }}</td>
                                                     <td>{{ $user->city }}</td>
                                                     <td>
                                                        <?php  if (Auth::user()->readonly !=1){ ?>


                                                        <!--<a href="{{route('deleteuser',$user->id)}}">-->
                                                        <img id="del_<?php echo $user->id ?>"  src="../assets/images/cross.jpg" width="30px;" height="30px" class="delctrl" alt="-1">
                                                        <!--</a>-->
                                                        <?php  if ($user->activated ==0){ ?>
                                                        
                                                        <img id="act_<?php echo $user->id ?>"  src="../assets/images/activate.png" width="30px;" height="30px" alt="<?php echo "1"; ?>" class="imgctrl">
                                                        
                                                        <?php } /*else { ?>  

                                                        <a href="{{route('disableuser',$user->id)}}">
                                                        <img id="deact_<?php echo $user->id ?>"  src="../assets/images/suspend-black.png" width="30px;" height="30px" class="imgctrl" alt="0">
                                                        </a>

                                                        <?php }*/
                                                        ?>
                                                        <?php }?>

                                                    </td>
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
                            </div>
                        </section></div>

                    <!-- MAIN CONTENT AREA ENDS -->
                </section>


<script>

        
            $(".delctrl").mouseup(function (event)
            //$(".delctrl").live ("click",function (event)
        {
            event.preventDefault();
            
            var $post = {};

            $post.id = $(this).attr('id');
            //$post.name = $(this).attr('alt');   //got the province name here.            
            //$post._token = document.getElementsByName("_token")[0].value;          
            //-----------start ajax----------------------
             var r = confirm("Do you want to delete the user");
             if (r==true){
                $(this).closest('tr').remove();

                   $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                    url: 'deleteuser',
                    type: 'POST',
                    data: $post,
                    cache: false,
                    success: function (data) {                        
                        //alert(data);                        
                        console.log(data);
                        return data;
                                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                    
                        console.log(textStatus);                    
                                    }
                    }); //end of ajax
                }

            //---------del ajax----------------------
            
        }); // end of ratings click

    $(function () {
        //$('#ratings').on('click', '.imgctrl', function(e){
            //$("#ratings").click(function (event)
        $("#ratings").on('click','.imgctrl',function (event)    
        //$("#imgctrl").click(function (event)
        {
            event.preventDefault();
            var $post = {};

            $post.id = $(this).attr('id');
            $post.name = $(this).attr('alt');   //got the province name here.            
            $post._token = document.getElementsByName("_token")[0].value;          
            //console.log($(this).parents("tr"));            
            //console.log($(this).parents("tr")[0].innerText );
                //var str=$(this).parents("tr")[0].innerText ;
                //str=str.replace("Suspended", "Activated");
                //$(this).parent('tr').append(str);                                    
                $(this).closest('tr').remove();
            $(this).hide();
                        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                url: 'dologinaccess',
                type: 'POST',
                data: $post,
                cache: false,
                success: function (data) {
                        alert(data);

                        //$(this).closest('tr').remove();
                        //$(this).hide();
                        
                        

                       //$(this).parents("tr").remove();
                        //$(this).parent('tr').next('tr').remove();
                        //$(this).parent('tr').append(str);                                    

                        //console.log(data);
                         //var id = $(imgctrl).data("Email");
                         //alert(id);
                         //alert($(this).closest("tr"));
                         //console.log($(this).closest("tr").find());

                    //var row = $(this).parents("tr").val();
                    //console.log(row);


                         //console.log($(this).parents("tr").val());
                        //alert($(.imgctrl).parents("tr").val());
                        //$(this).closest('tr').remove();
                        //alert($(this).closest("tr").innerhtml());
                         //alert( $(".imgctrl").val($(this).closest("tr")));

                        
                        return data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    
                    console.log(textStatus);                    
                }
            }); //end of ajax
        }); // end of ratings click

//--------------------------------------------------
        //$("#ratings").on('click','.delctrl',function (event)



//-----------------------------------------------------
    }); //end of $start
</script>

@endsection