
<!DOCTYPE html>
<html>
    <head>
          <title>Bootstrap Example</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
        
    </head>
<body>




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
$lastDiameter="";
$currentCapacity="";
$lastCapacity="";

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
            $lastDiameter="";
            $lastCapacity="";            
            //echo "print province head". $currentProvince." <br>";
            ?>

              
                
                <div  style="width:100%;  margin: 0; float: none;">
                  <div  >
                    <div  style="width:30%;  margin: 0; float: left;"><strong>{{$cylinders[$i]->province}}</strong> </div>

                    <div  style="width:20%; margin: 0; float: left;"><strong>{{$cylinders[$i]->city}}</strong> </div>
                    <div style="width:25%;margin: 0; float: left;" ><strong>Lab: {{$cylinders[$i]->labname}}</strong> </div>
                  </div>
                                   
                 <div style="width:100%;  margin: 0; float: none;">
                    <div style="width:30%;  margin: 0; float: left;" >&nbsp;</div>
                    <div style="width:12%;  margin: 0; float: left;" ><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}</div>
                    <div style="width:20%;  margin: 0; float: left;" ><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</div>
                    <div style="width:12%;  margin: 0; float: left;" ><strong>Standard: {{$cylinders[$i]->Standard}}</strong></div>
                    <div style="width:12%;  margin: 0; float: left;" >Method: {{$cylinders[$i]->method}}</div>                                         
                 </div> 

                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>     

                 <div style="width:100%;  margin: 0; float: none;" >                   
                   <div style="width:50%;  margin: 0; float: left;" >&nbsp;</div>
                    <div style="width:12%;  margin: 0; float: left;"><strong>Diameter:</strong></div>
                    <div style="width:12%;  margin: 0; float: left;" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                    <div style="width:12%;  margin: 0; float: left;"><strong>Capacity:</strong></div>
                    <div style="width:12%;  margin: 0; float: left;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div> 


                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>     

                 <div style="width:100%;  margin: 0; float: none;"  >                   
                    <div style="width:10%;  margin: 0; float: left;"  ><strong>Serial</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"  ><strong>Inspection</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Expiry</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Length</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Capacity</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Manufacturing</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Owner</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Vehicle</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>CNIC</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Certificate</strong></div>
                 </div> 

<!--
                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>  -->                    

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


                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
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
               <div  style="width:100%;  margin: 0; float: none;">
                                   
                 <div style="width:100%;  margin: 0; float: none;">
                    <div style="width:30%;  margin: 0; float: left;" >&nbsp;</div>
                    <div style="width:12%;  margin: 0; float: left;" ><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}</div>
                    <div style="width:20%;  margin: 0; float: left;" ><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</div>
                    <div style="width:12%;  margin: 0; float: left;" ><strong>Standard: {{$cylinders[$i]->Standard}}</strong></div>
                    <div style="width:12%;  margin: 0; float: left;" >Method: {{$cylinders[$i]->method}}</div>                                         
                 </div> 

                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>        

                 <div style="width:100%;  margin: 0; float: none;" >                   
                   <div style="width:50%;  margin: 0; float: left;" >&nbsp;</div>
                    <div style="width:12%;  margin: 0; float: left;"><strong>Diameter:</strong></div>
                    <div style="width:12%;  margin: 0; float: left;" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                    <div style="width:12%;  margin: 0; float: left;"><strong>Capacity:</strong></div>
                    <div style="width:12%;  margin: 0; float: left;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div> 


                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>      

                 <div style="width:100%;  margin: 0; float: none;"  >                   
                    <div style="width:10%;  margin: 0; float: left;"  ><strong>Serial</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"  ><strong>Inspection</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Expiry</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Length</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Capacity</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Manufacturing</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Owner</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Vehicle</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>CNIC</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Certificate</strong></div>
                 </div> 

<!--
                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div> -->                    

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
                

                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
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
                $lastDiameter="";
                $lastCapacity="";
            }
            else
            {

                if ($currentDiameter!=$lastDiameter || $currentCapacity!=$lastDiameter){
 

                ?>
               <div  style="width:100%;  margin: 0; float: none;">



                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>       

                 <div style="width:100%;  margin: 0; float: none;" >                   
                   <div style="width:50%;  margin: 0; float: left;" >&nbsp;</div>
                    <div style="width:12%;  margin: 0; float: left;"><strong>Diameter:</strong></div>
                    <div style="width:12%;  margin: 0; float: left;" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                    <div style="width:12%;  margin: 0; float: left;"><strong>Capacity:</strong></div>
                    <div style="width:12%;  margin: 0; float: left;" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div> 


                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>     

                 <div style="width:100%;  margin: 0; float: none;"  >                   
                    <div style="width:10%;  margin: 0; float: left;"  ><strong>Serial</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"  ><strong>Inspection</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Expiry</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Length</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Capacity</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Manufacturing</strong></div>
                    <div style="width:10%;  margin: 0; float: left;"><strong>Owner</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Vehicle</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>CNIC</strong></div>
                    <div style="width:10%;  margin: 0; float: left;" ><strong>Certificate</strong></div>
                 </div> 

                 <!--
                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div> -->                  

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
                
<!--
                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div>  -->   


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
               <div  style="width:100%;  margin: 0; float: none;">

<!--
                <div style="width:100%;  margin: 0; float: none; " > <p>&nbsp;</p>
                </div> -->    
       

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
                

    


                </div>
                 

                <?php 


                }

                
            }
        }
 
    }
?>


</body>
</html>


