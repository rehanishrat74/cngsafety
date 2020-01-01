@extends('layouts.cngappdtpicker')
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
                            $highlightghtclass="";
                            if ($node->functionname=="Cylinder Inspection")
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

                <section class="wrapper main-wrapper row" style=''>

                    <div class='col-12'>
                        <div class="page-title">

                            <div class="float-left">
                                <!-- PAGE HEADING TAG - START --><h1 class="title">Cylinder Inspection</h1><!-- PAGE HEADING TAG - END -->                            </div>

                            <div class="float-right d-none">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="index.html"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li>
                                        <a href="uni-professors.html">Professors</a>
                                    </li>
                                    <li class="active">
                                        <strong>Add Professor</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <!-- MAIN CONTENT AREA STARTS -->
                    <div class="col-12" >
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">Test Cylinders</h2>
                                <div class="actions panel_actions float-right">
                                    <a class="box_toggle fa fa-chevron-down"></a>
                                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                    <a class="box_close fa fa-times"></a>
                                </div>
                            </header>
                            <div class="content-body">
                                <div class="form-group row " > <!-- style="border-style: solid;"-->
                                    <form id="savecylinders" action ="{{route('savetestcylinders')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="col-12" >
                                            <div class="form-group row">

                                                <div class="col-7" > <!--  style="border-style: solid;"-->
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <div class="controls">
                                                                @if(session()->has('message'))
                                                                    <div class="alert alert-success">
                                                                        {{ session()->get('message') }}
                                                                    </div>
                                                                @endif                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Country of Origin</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <!--countries<input type="text" value="" class="form-control" 
                                                                id="CountryOfOrigin" name="CountryOfOrigin" placeholder="Country Of Origin" 
                                                                >-->

                                                                <select class="form-control" id ="CountryOfOrigin" name="CountryOfOrigin">
                                                                    @foreach ($countries as $country)
                                                                    <option value="<?php echo $country->countries;?>"
                                                        <?php if(old("CountryOfOrigin")==$country->countries){echo 'selected';} ?>
                                                                    >

                                                                    <?php echo $country->countries;?></option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div><!-- end of country origin -->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Brand Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                
                                                                <select class="form-control" id ="brand" name="brand">
                                                                    @foreach ($brands as $brand)
                                                                    <option value="<?php echo $brand->brandname;?>"
                                                        <?php if(old("brand")==$brand->brandname){echo 'selected';} ?>

                                                                    ><?php echo $brand->brandname;?></option>
                                                                    @endforeach
                                                                </select>                                                                
                                                            </div>                                                
                                                        </div>
                                                    </div> <!-- end of brand name -->

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Diameter</label>
                                                            </div>
                                                        </div>
<?php 
 $diameters = array("267 mm","273 mm","280 mm","317 mm","323 mm","325 mm","340 mm","other");

?>                                                        
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                
                                                                <select class="form-control" id ="diameter" name="diameter"> 
<?php 
    $d=0;
    for ($d=0;$d<8;$d++){ ?>

                    <option value="<?php echo $diameters[$d];?>" 
                        <?php if (old("diameter")==$diameters[$d]){echo 'selected';}?> 
                    >
                        <?php echo $diameters[$d];?>                            
                    </option>
<?php    }
?>

                                                  
                                                                </select>                                                                
                                                            </div>                                                
                                                        </div>
                                                    </div> <!-- end of diameter -->
<!---------------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Length</label>
                                                            </div>
                                                        </div>
<?php 
    $lengths = array("730 mm","830 mm","900 mm","912 mm","1725 mm","other");

?>                                                        
                                                        <div class="col-6">
                                                            <div class="controls">

                                                                <select class="form-control" id ="length" name="length"> 
<?php 
    $l=0;
    for($l=0;$l <6;$l++){ ?>
          <option value="<?php echo $lengths[$l];?>" <?php if (old("length")==$lengths[$l]){echo 'selected';} ?> > 
            <?php echo $lengths[$l];?>              
          </option>
<?php 
    }
?>

                      
                                                                </select>                                                                
                                                            </div>                                                
                                                        </div>
                                                    </div> <!-- end of diameter -->                                                    

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Capacity</label>
                                                            </div>
                                                        </div>
<?php 
$capacities=array("30 WLC","40 WLC","41 WLC","45 WLC","50 WLC","55 WLC","58 WLC","60 WLC","62 WLC","64 WLC","65 WLC","70 WLC","74 WLC","75 WLC","80 WLC","85 WLC","90 WLC","30-85 WLC","30-90 WLC","40-90 WLC","50-140 WLC","other");

?>                                                        
                                                        <div class="col-6">
                                                            <div class="controls">

             
                                                                <select class="form-control" id ="capacity" name="capacity"> 
<?php 
    $c=0;
    for ($c=0;$c<22;$c++){ ?>
        <option value="<?php echo  $capacities[$c]; ?>" <?php if (old("capacity")==$capacities[$c]){echo 'selected';}?>    ><?php echo $capacities[$c]; ?></option>
   <?php }
?>

                                                                    
                      
                                                                </select>                                                                
                                                            </div>                                                
                                                        </div>
                                                    </div> <!-- end of diameter -->            
<!---------------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Stamdard</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <select class="form-control" id="standard"  name="standard" >
                                                                    <option value ="NZS 5454-1989" <?php if(old('standard')=="NZS 5454-1989"){echo 'selected';} ?> >NZS 5454-1989</option>
                                                                    <option value ="ISO 11439" <?php if(old('standard')=="ISO 11439"){echo 'selected';} ?> >ISO 11439</option>
                                                                 </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Test Method</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <select class="form-control" id="method"  name="method" >
                                                                    <option value ="Hydrostatic - Direct" <?php if(old('method')=="Hydrostatic - Direct"){echo 'selected';} ?> >Hydrostatic - Direct</option>
                                                                    <option value ="Hydrostatic - Water Jaket" <?php if(old('method')=="Hydrostatic - Water Jaket"){echo 'selected';} ?> >Hydrostatic - Water Jaket</option>
                                                                 </select>
                                                            </div>
                                                        </div>
                                                    </div>

<!------------------------------------------------------->
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >3rd Party Inspector</label>
                                                            </div>
                                                        </div>
<?php
$inspectors = array("Lloyd's, Bureau Vertas, ABS, SGS", "-SGS-All Tests carried out by International Lab Powertech Inc, Canada", "-Bureau Veritas","-SGS-" );

?>

                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <select class="form-control" id="inspector"  name="inspector" >
<?php 
    $i=0;
    for ($i=0;$i<4;$i++)
    { ?>
<option value ="<?php echo $inspectors[$i];?>"  <?php if(old('inspector') ==$inspectors[$i]){echo ' selected';} ?> >
    <?php echo $inspectors[$i]; ?></option>
 <?php  }
?>                                                                    


                                                       
                                                                 </select>
                                                            </div>
                                                        </div>
                                                    </div>
<!------------------------------------------------------->                                                    
               

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Serial No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="" class="form-control{{ $errors->has('SerialNo') ? ' is-invalid' : '' }}" 
                                                                id="SerialNo" name="SerialNo" placeholder="Serial No" autocomplete="off" 
                                                                >
                                              @if ($errors->has('SerialNo'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('SerialNo') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>
<!---------------------------------------------------------->

                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label">Notes</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="controls">
                                              <textarea class="form-control"  name="notes" id="notes" placeholder="Notes" ></textarea>
           
                                                            </div>                                                
                                                        </div>
                                                    </div> <!-- end of brand name -->                                              
<!---------------------------------------------------------->


                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Inspection Date</label>
                                                            </div>
                                                        </div> 
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <input type="text" value="" class="form-control{{ $errors->has('edate') ? ' is-invalid' : '' }} datepicker" data-format="mm/dd/yyyy"  id="edate" name="edate" placeholder="date (e.g. 04/03/2015)" autocomplete="off">

                                              @if ($errors->has('edate'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('edate') }}</strong>
                                                </span>
                                              @endif                                                                                                                      
                                                            </div>
                                                        </div>
                                                    </div>                        
                                                    <div class="form-group row" >
                                                        <div class="col-6">
                                                            <div class="controls">
                                                            <label class="form-label" >Inspection Expiry</label>
                                                            </div>
                                                        </div> 
                                                        <div class="col-6">
                                                            <div class="controls">
                                                                <!--<input type="text" value="" class="form-control" data-format="mm/dd/yyyy" placeholder="Expiry Date" id="expiry" name="expiry" readonly>-->
                                                                <input type="text" value="" class="form-control{{ $errors->has('expiry') ? ' is-invalid' : '' }} datepicker" data-format="mm/dd/yyyy"  id="expiry" name="expiry" placeholder="date (e.g. 04/03/2015)" autocomplete="off">                              
                                              @if ($errors->has('expiry'))
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('expiry') }}</strong>
                                                </span>
                                              @endif                                                                             
                                                            </div>
                                                        </div>
                                                    </div>   
                                                    <input type="hidden" id ="year" name="year">
                                                    <input type="hidden" id ="month" name="month">
                                                    <input type="hidden" id ="day" name="day">
                                                </div>  <!-- end of left column -->
                                                <div class="col-5" > <!--  style="border-style: solid;"-->
                                                                                                    


                                                    <div class="form-group row">
                                                        <p>&nbsp;</p>
                                                        <div class="col-12" style="height:50em;overflow-y: auto;  background-color:#dddddd;color:black">
                                                            <div class="controls">
                                                                Serial nos added <br>
                                                                 <?php echo  session()->get('registeredcylinders') ?>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>




                                            </div>
                                        </div>


                                        <div class="col-12 col-md-9 col-lg-8 padding-bottom-30" >
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <!--<button type="button" class="btn">Cancel</button>-->
                                            </div>
                                        </div>                                        
                                    </form>
                                    

                                </div> <!-- end of first body row-->


                            </div>  <!-- end of content body -->
                        </section>
                    </div>  <!-- end of Main Content Area Col12-->
                </section> <!-- end of main wrapper -->



<script>
/*function setexpirydate() {

    var entrydate =document.getElementById("date");
    alert(entrydate.value);

}*/
$(function(){
var expiry =document.getElementById("expiry");
var expiryyear =document.getElementById("year");
var expirymonth =document.getElementById("month");
var expiryday =document.getElementById("day");

   $(".datepicker").change(function() {

    
    //console.log($(this)[0].id); =edate
    
    var addressinput = $(this).val();
    var d = new Date(addressinput); //"03/25/2015"

    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var year5 = new Date(year + 5, month, day)

    if ($(this)[0].id=="edate"){
    expiryyear.value =year5.getFullYear();
    expirymonth.value =year5.getMonth()+1;
    expiryday.value =year5.getDate() ;    
    expiry.value=year5.toLocaleDateString();   
    //$('#expiry').datepicker('setDate', expiry).trigger('change');
    //$('#expiry').defaultValue=expiry.value;
    //expiry.defaultValue=expiry.value;

    //---------------------------------------
/*
//var date1 = new Date(); // now
var input = document.createElement("input"); input.type = "date";

input.valueAsDate = new Date(Date.UTC(year5.getFullYear(), year5.getMonth(), year5.getDate()));
console.log(input.valueAsDate); 

var midnightUtcDate = input.valueAsDate;
var date2 = new Date(midnightUtcDate.getUTCFullYear(), midnightUtcDate.getUTCMonth(), midnightUtcDate.getUTCDate());
console.log(date2);    */
//expiry.defaultValue=date2;
    //----------------------------------------

    //console.log($('#expiry'));    

        }

    //console.log(expiry.value);

    //console.log(year5);
   });

   $(".datepicker").focusout(function() {
    var addressinput = $(this).val();
    var d = new Date(addressinput); //"03/25/2015"

    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var year5 = new Date(year + 5, month, day)

    if ($(this)[0].id=="edate"){
    expiry.value=year5.toLocaleDateString();;
     expiryyear.value =year5.getFullYear();
     expirymonth.value =year5.getMonth()+1;
     expiryday.value =year5.getDate() ;
     //expiry.defaultValue=expiry.value;
     //$('#expiry').defaultValue=expiry.value;
     //$('#expiry').datepicker('setDate', expiry).trigger('change');
    }

  //console.log(year5);
    //console.log(addressinput);
   });


});




</script>




@endsection