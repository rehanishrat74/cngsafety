
<!DOCTYPE html>
<html>
    <head>
          <title>Bootstrap Example</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
        
    </head>
<body>

<td style="word-break:break-all;">longtextwithoutspace</td>


<?php

$recordCount=0;
$serialClosed="no";

$lastProvince=""; 
$currentProvince="";
$lastcity=""; 
$currentcity=""; 
$lastlab="";
$currentlab="";


            $CurrentOrgin="";
            $CurrentBrand="";
            $CurrentStandard="";
            $TestMethod="";
            $lastCurrentOrgin="";
            $lastCurrentBrand="";
            $lastCurrentStandard="";
            $lastTestMethod="";


$currentDiameter="";
$lastDiameter="-1";
$currentCapacity="";
$lastCapacity="-1";

$i = 0;
?>

                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-3" >
                        <img src="../assets/images/Printer.png" width="50px;" height="30px"  onclick="window.print()">
                    </div>
                  </div>
                </div>
<?php  for ($i=0;$i< count($cylinders);$i++){ ?>

<?php

    $currentProvince=$cylinders[$i]->province;
    $currentcity=$cylinders[$i]->city;
    $currentlab = $cylinders[$i]->labname;

                $CurrentOrgin=$cylinders[$i]->CountryOfOrigin;
                $CurrentBrand=$cylinders[$i]->BrandName;
                $CurrentStandard=$cylinders[$i]->Standard;
                $TestMethod=$cylinders[$i]->method; 

    $currentDiameter=$cylinders[$i]->diameter;
    $currentCapacity=$cylinders[$i]->capacity;

    if ($currentProvince!=$lastProvince || $currentcity!=$lastcity || $currentlab!=$lastlab)
        {   //swap province
            $lastProvince=$currentProvince;
            $currentProvince=$cylinders[$i]->province;   

            $lastcity = $currentcity;
            $currentcity=$cylinders[$i]->city;

            $lastlab= $currentlab;
            $currentlab=$cylinders[$i]->labname;

            //resetting lower origin loop
            $lastCurrentOrgin ="";
            $lastCurrentBrand="";
            $lastCurrentStandard="";
            $lastTestMethod="";
            $lastDiameter="-1";
            $lastCapacity="-1";            
            //echo "print province head". $currentProvince." <br>";
            ?>

              
                
                <div  style="width:1000px;  margin: 0; float: none;">
                    <hr>
                    
                  <div  style="width:1000px">
                    <div  style="width:200px;  margin: 0; float: left;word-wrap: break-word;"><strong>{{$cylinders[$i]->province}}</strong> </div>

                    <div  style="width:200px; margin: 0; float: left;word-wrap: break-word;"><strong>{{$cylinders[$i]->city}}</strong> </div>
                    <div style="width:500px;margin: 0; float: left;word-wrap: break-word;" ><strong>Lab: {{$cylinders[$i]->labname}}</strong> </div>


                  </div><br>
                <div style="width:1500px;  margin: 0; float: none;" ></div>
                
                 <div style="width:1500px;  margin: 0; float: none;">
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>

                     <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}</div>
                     <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</div>
                     <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Standard: {{$cylinders[$i]->Standard}}</strong></div>
                     <div style="width:400px;  margin: 0; float: left;word-wrap: break-word;" >
                        <strong>Method:</strong> {{$cylinders[$i]->method}}</div>                                         
                 </div> <br>
                 <!-----------End of origin------------------------->
  

                 <div style="width:1500px;  margin: 0; float: none;" > 
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>                  
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Diameter:</strong></div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Capacity:</strong></div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div><br> 
                 <!---------End of Diameter------------->

               
                 <div style=" width:1500px;  margin: 0; float: none; " >                   
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;"  ><strong>Serial</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"  ><strong>Inspection</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Expiry</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Length</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Capacity</strong></div>
                    <div style="width:110px;  margin: 0; float: left;word-wrap: break-word;"><strong>Manufacturing</strong></div>
                    <div style="width:200px; margin: 0; float: left;word-wrap: break-word;"><strong>Owner</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Vehicle</strong></div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>CNIC</strong></div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Certificate</strong></div>
                 </div><br> 


                <div style="width:1500px;  margin: 0; float: none;" >                   
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->SerialNumber}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->Date}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->InspectionExpiryDate}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->length}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                    <div style="width:110px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->DateOfManufacture}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->ownername}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->vehicleRegNo}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->ocnic}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->certificate}}&nbsp;</div>
                </div>

                
                <div style="width:1200px;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>   
            
                </div>
                
        <?php 
        }
    else
        {


            if ($CurrentOrgin!=$lastCurrentOrgin || $CurrentBrand!=$lastCurrentBrand || $CurrentStandard !=$lastCurrentStandard ||  $TestMethod!= $lastTestMethod)
            {   
                //echo "print country and brand head".$CurrentBrand.$CurrentOrgin." <br>";
                ?>
               <div  style="width:1500px;  margin: 0; float: none;">
            <hr>
<br>
                <div style="width:1500px;  margin: 0; float: none;" ></div>
                
                 <div style="width:1500px;  margin: 0; float: none;">
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>

                     <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}</div>
                     <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</div>
                     <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Standard: {{$cylinders[$i]->Standard}}</strong></div>
                     <div style="width:400px;  margin: 0; float: left;word-wrap: break-word;" >
                        <strong>Method:</strong> {{$cylinders[$i]->method}}</div>                                         
                 </div> <br>
                 <!-----------End of origin------------------------->
  

                 <div style="width:1500px;  margin: 0; float: none;" > 
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>                  
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Diameter:</strong></div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Capacity:</strong></div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div><br> 
                 <!---------End of Diameter------------->

               
                 <div style=" width:1500px;  margin: 0; float: none; " >                   
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;"  ><strong>Serial</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"  ><strong>Inspection</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Expiry</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Length</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Capacity</strong></div>
                    <div style="width:110px;  margin: 0; float: left;word-wrap: break-word;"><strong>Manufacturing</strong></div>
                    <div style="width:200px; margin: 0; float: left;word-wrap: break-word;"><strong>Owner</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Vehicle</strong></div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>CNIC</strong></div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Certificate</strong></div>
                 </div><br> 


                <div style="width:1500px;  margin: 0; float: none;" >                   
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->SerialNumber}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->Date}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->InspectionExpiryDate}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->length}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                    <div style="width:110px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->DateOfManufacture}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->ownername}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->vehicleRegNo}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->ocnic}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->certificate}}&nbsp;</div>
                </div>

                
                <div style="width:1200px;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>  


                </div>                


                <?php 
                //swap country and brand                
                $lastCurrentOrgin=$CurrentOrgin;
                $lastCurrentBrand=$CurrentBrand;
                $lastCurrentStandard=$CurrentStandard;
                $lastTestMethod=$TestMethod;

                $CurrentOrgin=$cylinders[$i]->CountryOfOrigin;
                $CurrentBrand=$cylinders[$i]->BrandName;
                $CurrentStandard=$cylinders[$i]->Standard;
                $TestMethod=$cylinders[$i]->method;                  
                //resetting lower loop
                $lastDiameter="-1";
                $lastCapacity="-1";
            }
            else
            {

                if ($currentDiameter!=$lastDiameter || $currentCapacity!=$lastCapacity){
 
                   /* echo 'cd='.$currentDiameter.'<br>';
                    echo 'ld='.$lastDiameter.'<br>';
                    echo 'cc='.$currentCapacity.'<br>';
                    echo 'lc='.$lastCapacity.'<br>';*/

                ?>
               <div  style="width:100%;  margin: 0; float: none;">

                 <div style="width:1500px;  margin: 0; float: none;" > 
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>                  
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >&nbsp;</div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Diameter:</strong></div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Capacity:</strong></div>
                     <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div>

                 <br> 
                 <!---------End of Diameter------------->

               
                 <div style=" width:1500px;  margin: 0; float: none; " >                   
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;"  ><strong>Serial</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"  ><strong>Inspection</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Expiry</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Length</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;"><strong>Capacity</strong></div>
                    <div style="width:110px;  margin: 0; float: left;word-wrap: break-word;"><strong>Manufacturing</strong></div>
                    <div style="width:200px; margin: 0; float: left;word-wrap: break-word;"><strong>Owner</strong></div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Vehicle</strong></div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>CNIC</strong></div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" ><strong>Certificate</strong></div>
                 </div><br> 


                <div style="width:1500px;  margin: 0; float: none;" >                   
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->SerialNumber}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->Date}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->InspectionExpiryDate}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->length}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                    <div style="width:110px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->DateOfManufacture}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->ownername}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->vehicleRegNo}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->ocnic}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->certificate}}&nbsp;</div>
                </div>

                
                <div style="width:1200px;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>  


                </div> 


                <?php 

                    //swap diameter and capacity
                    $lastDiameter=$currentDiameter;
                    $lastCapacity=$currentCapacity;

                    $currentDiameter=$cylinders[$i]->diameter;
                    $currentCapacity=$cylinders[$i]->capacity;


                }

                else
                {   
   
                ?>
               <div  style="width:1500px;  margin: 0; float: none;">

                <div style="width:1500px;  margin: 0; float: none;" >                   
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->SerialNumber}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->Date}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->InspectionExpiryDate}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->length}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                    <div style="width:110px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->DateOfManufacture}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->ownername}}&nbsp;</div>
                    <div style="width:100px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->vehicleRegNo}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->ocnic}}&nbsp;</div>
                    <div style="width:200px;  margin: 0; float: left;word-wrap: break-word;" >{{$cylinders[$i]->certificate}}&nbsp;{{$cylinders[$i]->id}}</div>
                </div><br>
      
                <!--
                <div style="width:100%;  margin: 0; float: none;" >                   
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->SerialNumber}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->Date}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->InspectionExpiryDate}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->length}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->capacity}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->DateOfManufacture}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->ownername}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->vehicleRegNo}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->ocnic}}</div>
                    <div style="width:10%;  margin: 0; float: left;" >{{$cylinders[$i]->certificate}}</div>
                </div>
                    -->    

    


                </div>
                 

                <?php 


                }

                
            }
        }
 
    }
?>


</body>
</html>


