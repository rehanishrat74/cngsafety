
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
$lastDiameter="-1";
$currentCapacity="";
$lastCapacity="-1";

$i = 0;
?>

                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-3" >
                        <img src="../assets/images/Printer.png" width="50px;" height="30px"  onclick="window.print();">
                    </div>
                  </div>
                </div>

<table>
    <tbody>
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

                <tr>
                    <td style="word-wrap: break-word"><strong>{{$cylinders[$i]->province}}</strong></td>
                    <td style="word-wrap: break-word"><strong>{{$cylinders[$i]->city}}</strong></td>
                    <td style="word-wrap: break-word"><strong>Lab: {{$cylinders[$i]->labname}}</strong></td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                </tr>
                
                <tr>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</td>
                    <td style="word-wrap: break-word"><strong>Standard: {{$cylinders[$i]->Standard}}</strong>&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Method:</strong> {{$cylinders[$i]->method}}&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>                                        
                </tr>
                <tr>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Diameter:</strong></td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->diameter}}</td>
                    <td style="word-wrap: break-word"><strong>Capacity:</strong></td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->capacity}}</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>        
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>                                  
                </tr>

                <tr>
                    <td style="word-wrap: break-word"><strong>Serial</strong></td>
                    <td style="word-wrap: break-word"><strong>Inspection</strong></td>        
                    <td style="word-wrap: break-word"><strong>Expiry</strong></td>
                    <td style="word-wrap: break-word"><strong>Length</strong></td>
                    <td style="word-wrap: break-word"><strong>Capacity</strong></td>                                  
                    <td style="word-wrap: break-word"><strong>Manufacturing</strong></td>
                    <td style="word-wrap: break-word"><strong>Owner</strong></td>        
                    <td style="word-wrap: break-word"><strong>Vehicle</strong></td>
                    <td style="word-wrap: break-word"><strong>CNIC</strong></td>
                    <td style="word-wrap: break-word"><strong>Certificate</strong></td>                                                                          
                </tr>
 
                <tr>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->SerialNumber}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->Date}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->InspectionExpiryDate}}</td>                                        
                    <td style="word-wrap: break-word">{{$cylinders[$i]->length}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->capacity}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->DateOfManufacture}}</td>                    
                    <td style="word-wrap: break-word">{{$cylinders[$i]->ownername}}</td>                                        
                    <td style="word-wrap: break-word">{{$cylinders[$i]->vehicleRegNo}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->ocnic}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->certificate}}</td>                    
                </tr>


                
        <?php 
        }
    else
        {


            if ($CurrentOrgin!=$lastCurrentOrgin || $CurrentBrand!=$lastCurrentBrand || $CurrentStandard !=$lastCurrentStandard ||  $TestMethod!= $lastTestMethod)
            {   
                //echo "print country and brand head".$CurrentBrand.$CurrentOrgin." <br>";
                ?>

                <tr>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</td>
                    <td style="word-wrap: break-word"><strong>Standard: {{$cylinders[$i]->Standard}}</strong>&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Method:</strong> {{$cylinders[$i]->method}}&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>                                        
                </tr>
                <tr>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Diameter:</strong></td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->diameter}}</td>
                    <td style="word-wrap: break-word"><strong>Capacity:</strong></td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->capacity}}</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>        
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>                                  
                </tr>

                <tr>
                    <td style="word-wrap: break-word"><strong>Serial</strong></td>
                    <td style="word-wrap: break-word"><strong>Inspection</strong></td>        
                    <td style="word-wrap: break-word"><strong>Expiry</strong></td>
                    <td style="word-wrap: break-word"><strong>Length</strong></td>
                    <td style="word-wrap: break-word"><strong>Capacity</strong></td>                                  
                    <td style="word-wrap: break-word"><strong>Manufacturing</strong></td>
                    <td style="word-wrap: break-word"><strong>Owner</strong></td>        
                    <td style="word-wrap: break-word"><strong>Vehicle</strong></td>
                    <td style="word-wrap: break-word"><strong>CNIC</strong></td>
                    <td style="word-wrap: break-word"><strong>Certificate</strong></td>                                                                          
                </tr>
 
                <tr>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->SerialNumber}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->Date}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->InspectionExpiryDate}}</td>                                        
                    <td style="word-wrap: break-word">{{$cylinders[$i]->length}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->capacity}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->DateOfManufacture}}</td>                    
                    <td style="word-wrap: break-word">{{$cylinders[$i]->ownername}}</td>                                        
                    <td style="word-wrap: break-word">{{$cylinders[$i]->vehicleRegNo}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->ocnic}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->certificate}}</td>                    
                </tr>

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

                <tr>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word"><strong>Diameter:</strong></td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->diameter}}</td>
                    <td style="word-wrap: break-word"><strong>Capacity:</strong></td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->capacity}}</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>        
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>
                    <td style="word-wrap: break-word">&nbsp;</td>                                  
                </tr>

                <tr>
                    <td style="word-wrap: break-word"><strong>Serial</strong></td>
                    <td style="word-wrap: break-word"><strong>Inspection</strong></td>        
                    <td style="word-wrap: break-word"><strong>Expiry</strong></td>
                    <td style="word-wrap: break-word"><strong>Length</strong></td>
                    <td style="word-wrap: break-word"><strong>Capacity</strong></td>                                  
                    <td style="word-wrap: break-word"><strong>Manufacturing</strong></td>
                    <td style="word-wrap: break-word"><strong>Owner</strong></td>        
                    <td style="word-wrap: break-word"><strong>Vehicle</strong></td>
                    <td style="word-wrap: break-word"><strong>CNIC</strong></td>
                    <td style="word-wrap: break-word"><strong>Certificate</strong></td>                                                                          
                </tr>
 
                <tr>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->SerialNumber}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->Date}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->InspectionExpiryDate}}</td>                                        
                    <td style="word-wrap: break-word">{{$cylinders[$i]->length}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->capacity}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->DateOfManufacture}}</td>                    
                    <td style="word-wrap: break-word">{{$cylinders[$i]->ownername}}</td>                                        
                    <td style="word-wrap: break-word">{{$cylinders[$i]->vehicleRegNo}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->ocnic}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->certificate}}</td>                    
                </tr>

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
                <tr>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->SerialNumber}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->Date}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->InspectionExpiryDate}}</td>                                        
                    <td style="word-wrap: break-word">{{$cylinders[$i]->length}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->capacity}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->DateOfManufacture}}</td>                    
                    <td style="word-wrap: break-word">{{$cylinders[$i]->ownername}}</td>                                        
                    <td style="word-wrap: break-word">{{$cylinders[$i]->vehicleRegNo}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->ocnic}}</td>
                    <td style="word-wrap: break-word">{{$cylinders[$i]->certificate}}</td>                    
                </tr>
      

                <?php 


                }

                
            }
        }
 
    }
?>


    </tbody>
</table>

</body>
</html>


