@extends('layouts.cngapploggedin')

@section('lefttree')
                    <ul class='wraplist'>   
<!--class open creates background highlight------------------------------------>                                    

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
        <script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
        <!--<script src="../assets/js/popper.min.js" type="text/javascript"></script> -->

        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 

        <!--<script src="../assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>-->



                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Registered Labs / Workshops </h1><!-- PAGE HEADING TAG - END -->                   </div>

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
<!------------------>
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
<!--  ==============================================  -->
<?php
//temp setup
 $pagesize=10;
?>

 


                            <div class="content-body">
                                <div class="row" >
                                        <form id="searchuserregistration" method="POST" action="{{route('searchuserregistration')}}">
                                        {{ csrf_field() }}                                    
                                    <div class ="col-12">

                                         <div class="row" >
                                            <div class ="col-4">
                                                <div class="input-group primary user_regtype" >                                                         <select class="form-control user_regtype" id="user_regtype" name="user_regtype">
                                        <?php 
                                        if (Auth::user()->regtype =='hdip' || Auth::user()->regtype =='apcng') {
                                        ?>
                                                <option value="laboratory" 
<?php if (!empty($selectedRegType)){if ($selectedRegType=="laboratory"){echo 'selected';}}?>                                                
                                                >Labs</option>
                                        <?php } else {?>
                                                <option value="All"
<?php if (!empty($selectedRegType)){if ($selectedRegType=="All"){echo 'selected';}}?>                                                 
                                                >* (All Accounts)</option>
                                                <option value="Admin"
<?php if (!empty($selectedRegType)){if ($selectedRegType=="Admin"){echo 'selected';}}?>                                                
                                                >Admin</option>
                                                <option value="laboratory"
<?php if (!empty($selectedRegType)){if ($selectedRegType=="laboratory"){echo 'selected';}}?>                                                
                                                >Labs</option>
                                                <option value="Workshop"
<?php if (!empty($selectedRegType)){if ($selectedRegType=="Workshop"){echo 'selected';}}?>                                                
                                                >Workshops</option>
                                        <?php }?>

                                                
                                                    </select>                                 
                                                </div>  
                                            </div>
                                            <div class ="col-4">
                                                <div class="input-group primary" >          
                                                 <select class="form-control province" id="province" name="province">
                                                <option value="All">* (All Provinces)</option>
                                                        @foreach ($provinces as $province)
                                                <option value="{{$province->province}}"
<?php if (!empty($selectedProvince)){if ($selectedProvince==$province->province){echo 'selected';}}?>                                                
                                                    > {{$province->province}} </option>
                                                        @endforeach 

                                                    </select>                                 
                                                </div>  
                                            </div>                                        
                                            <div class="col-4">
                                                <div class="input-group primary" >
                                                    <select class="form-control cities" id="cities" name="cities">
                                                    <option value="All">* (All  Cities)</option>
                                                    </select>                             
                                                </div>        
                                            </div>
                                        </div>

<!------------------------All rows--------------------------------->
                            <div class="row" >
                                <div class ="col-4">
                                    <div class="input-group primary" >
                                        <select class="form-control pagesize" id="pagesize" name="pagesize">
                                            <option value="10" <?php if (session()->get('pagesize')==10  || $pagesize=="10"){echo 'selected';} ?> >Page size 10</option>
                                            <option value="50" <?php if (session()->get('pagesize')==50  || $pagesize=="50"){echo 'selected';} ?>>Page size 50</option>
                                            <option value="100" <?php if (session()->get('pagesize')==100  || $pagesize=="100"){echo 'selected';} ?> >Page size 100</option>
                                            <option value="500" <?php if (session()->get('pagesize')==500  || $pagesize=="500"){echo 'selected';} ?>>Page size 500</option>
                                            <option value="1000" <?php if (session()->get('pagesize')==1000  || $pagesize=="1000"){echo 'selected';} ?>>Page size 1000  </option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class ="col-4">
                                    <div class="input-group primary"> 
                                          
                                <input type="text" class="form-control search-page-input" placeholder="Search" value="" placeholder="Search" autocomplete="off" id="searchvalue" name="searchvalue">
                                
                                <span class="input-group-addon" 
                                onclick="event.preventDefault(); document.getElementById('searchuserregistration').submit();">   
                                    <span class="arrow"></span>
                                    <i class="fa fa-search"></i>
                                </span>                         
                                    </div>
                                 </div>
                             </div>
<!-------------------------------------------------------------->
                                       
                                    </div>    <!-- end of col 12-->             
<!------------------------------------------------------>

<!------------------------------------------------------->
                                 </form>                       
                                </div>  <!-- end of row -->
                            </div>
<!-- =============================================== -->

                        </section>
                    </div>
<!--------------------->
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
                                                        
                                                        <?php } 
                                                        ?>
                                                        <?php }?>

                                                    </td>
                                                  
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
$(document).ready(function(){
    $(".user_regtype").change(function(){
        cname="user_searchType";
        cvalue=$(this).val();
        exdays=1;
        //console.log(cvalue);
        setCookie(cname,cvalue,exdays);
        //setCities($(this).val());
    });

    $(".province").change(function(){
        cname="user_Province";
        cvalue=$(this).val();
        exdays=1;
        //console.log(cvalue);
        setCookie(cname,cvalue,exdays);
        setCities(cvalue);
    });
    $(".pagesize").change(function(){
    var cname, cvalue, exdays
    cname="pagesize";
    cvalue=$(this).val();
    exdays=1;
    //console.log(cvalue);
    setCookie(cname,cvalue,exdays);
    });    

    $(".cities").change(function(){       
    cname="user_cities";
    cvalue=$(this).val();
    exdays=1;
    //console.log(cvalue);
    setCookie(cname,cvalue,exdays);        
    //setStations($(this).val());
   //document.getElementById('selectedCity').innerHTML=cvalue;
    });

}); // end of document.ready
        
        $(".delctrl").mouseup(function (event)
            
        {
            event.preventDefault();
            
            var $post = {};

            $post.id = $(this).attr('id');
      
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

        $("#ratings").on('click','.imgctrl',function (event)    
        
        {
            event.preventDefault();
            var $post = {};

            $post.id = $(this).attr('id');
            $post.name = $(this).attr('alt');   //got the province name here.            
            $post._token = document.getElementsByName("_token")[0].value;          
                                        
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

                   
                        return data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    
                    console.log(textStatus);                    
                }
            }); //end of ajax
        }); // end of ratings click


//-----------------------------------------------------
    }); //end of $start


   function setCities(provincename)
    {


            var $post = {};
            $post.provincename=provincename;           
            $post._token = document.getElementsByName("_token")[0].value;

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
            $.ajax({
           
                url: 'getProvinceCities',
                type: 'POST',
                method: 'POST',                
                data: $post,
                data:  {'post' : $post },  
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",         
                // above content type must for php. must not be json       
                async: true,
                datatype: "json",

                success: setCities,
                failure: function (message) {
                    alert("failure");         
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("error");
                    alert(errorThrown);
                }

            });

            function setCities(responseD) 
            {
                
               
                var citycount=responseD.length;
                var cities = document.getElementById('cities'); 
                cities.remove(0);
                cities.options.length=0;


                var opt = document.createElement('option');
                opt.value = 'All';
                opt.text = '* (All cities)';
                cities.options.add(opt);

                for (var i =0;i<citycount;i++){
                var opt = document.createElement('option');
                opt.value = responseD[i].city;
                opt.text = responseD[i].city;
                cities.options.add(opt);                    
                }

                
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