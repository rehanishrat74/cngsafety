
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

<table style="border=1;width:100%">
<tbody>
<?php  for ($i=0;$i<count($cylinders);$i++){ ?>

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
                <hr class="hr-border-solid"> 
                    <tr>
                        <td><strong>{{$cylinders[$i]->province}}</strong> </td>
                        <td><strong>{{$cylinders[$i]->city}}</strong> </td>
                        <td><strong>Lab: {{$cylinders[$i]->labname}}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr> 
                                   
                    <tr>
                        <td>&nbsp;</td>                    
                        <td><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}</td>
                        <td><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</td>
                        <td><strong>Standard: {{$cylinders[$i]->Standard}}</strong></td>
                        <td>Method: {{$cylinders[$i]->method}}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>                   
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><strong>Diameter:</strong></td>
                        <td>{{$cylinders[$i]->diameter}}&nbsp;</td>
                        <td><strong>Capacity:</strong></div>
                        <td>{{$cylinders[$i]->capacity}}&nbsp;</td>
                    </tr>

                    <tr>                   
                        <td><strong>Serial</strong></td>
                        <td><strong>Inspection</strong></td>
                        <td><strong>Expiry</strong></td>
                        <td><strong>Length</strong></td>
                        <td><strong>Capacity</strong></td>
                        <td><strong>Manufacturing</strong></td>
                        <td><strong>Owner</strong></td>
                        <td><strong>Vehicle</strong></td>
                        <td><strong>CNIC</strong></td>
                        <td ><strong>Certificate</strong></td>
                    </tr> 

                    <tr>                   
                        <td>{{$cylinders[$i]->SerialNumber}}</td>
                        <td>{{$cylinders[$i]->Date}}</td>
                        <td>{{$cylinders[$i]->InspectionExpiryDate}}</td>
                        <td>{{$cylinders[$i]->length}}</td>
                        <td>{{$cylinders[$i]->capacity}}</td>
                        <td>{{$cylinders[$i]->DateOfManufacture}}</td>
                        <td>{{$cylinders[$i]->ownername}}</td>
                        <td>{{$cylinders[$i]->vehicleRegNo}}</td>
                        <td>{{$cylinders[$i]->ocnic}}</td>
                        <td>{{$cylinders[$i]->certificate}}</td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>                    
                    <td><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}</td>
                    <td><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</td>
                    <td><strong>Standard: {{$cylinders[$i]->Standard}}</strong></td>
                    <td>Method: {{$cylinders[$i]->method}}</td>                                         
                 </tr> 

                <hr style="border-style: solid;">                     
                 <tr>                   
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td >&nbsp;</td>
                    <td><strong>Diameter:</strong></td>
                    <td>{{$cylinders[$i]->diameter}}&nbsp;</td>
                    <td><strong>Capacity:</strong></td>
                    <td>{{$cylinders[$i]->capacity}}&nbsp;</td>
                 </tr> 

                 <tr >                   
                    <td ><strong>Serial</strong></td>
                    <td><strong>Inspection</strong></td>
                    <td><strong>Expiry</strong></td>
                    <td><strong>Length</strong></td>
                    <td><strong>Capacity</strong></td>
                    <td><strong>Manufacturing</strong></td>
                    <td><strong>Owner</strong></td>
                    <td><strong>Vehicle</strong></td>
                    <td><strong>CNIC</strong></td>
                    <td><strong>Certificate</strong></td>
                 </tr> 

                <tr>                   
                    <td >{{$cylinders[$i]->SerialNumber}}</td>
                    <td>{{$cylinders[$i]->Date}}</td>
                    <td>{{$cylinders[$i]->InspectionExpiryDate}}</td>
                    <td>{{$cylinders[$i]->length}}</td>
                    <td>{{$cylinders[$i]->capacity}}</td>
                    <td>{{$cylinders[$i]->DateOfManufacture}}</td>
                    <td>{{$cylinders[$i]->ownername}}</td>
                    <td>{{$cylinders[$i]->vehicleRegNo}}</td>
                    <td>{{$cylinders[$i]->ocnic}}</td>
                    <td>{{$cylinders[$i]->certificate}}</td>
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
                $lastDiameter="";
                $lastCapacity="";
            }
            else
            {

                if ($currentDiameter!=$lastDiameter || $currentCapacity!=$lastDiameter){
 

                ?>

             
                        
                <hr class="hr-border-dotted">                     
                 <tr>                   
                   <td>&nbsp;</td>
                   <td>&nbsp;</div>
                   <td>&nbsp;</div>
                   <td>&nbsp;</div>
                   <td>&nbsp;</div>
                   <td>&nbsp;</div>
                    <td><strong>Diameter:</strong></td>
                    <td>{{$cylinders[$i]->diameter}}&nbsp;</td>
                    <td><strong>Capacity:</strong></td>
                    <td>{{$cylinders[$i]->capacity}}&nbsp;</td>
                 </tr> 

                 <tr>                   
                    <td><strong>Serial</strong></td>
                    <td><strong>Inspection</strong></td>
                    <td><strong>Expiry</strong></td>
                    <td><strong>Length</strong></td>
                    <td><strong>Capacity</strong></td>
                    <td><strong>Manufacturing</strong></td>
                    <td><strong>Owner</strong></td>
                    <td><strong>Vehicle</strong></td>
                    <td><strong>CNIC</strong></td>
                    <td><strong>Certificate</strong></td>
                 </tr> 

                <tr>                   
                    <td>{{$cylinders[$i]->SerialNumber}}</td>
                    <td>{{$cylinders[$i]->Date}}</td>
                    <td>{{$cylinders[$i]->InspectionExpiryDate}}</td>
                    <td>{{$cylinders[$i]->length}}</td>
                    <td>{{$cylinders[$i]->capacity}}</td>
                    <td>{{$cylinders[$i]->DateOfManufacture}}</td>
                    <td>{{$cylinders[$i]->ownername}}</td>
                    <td>{{$cylinders[$i]->vehicleRegNo}}</td>
                    <td>{{$cylinders[$i]->ocnic}}</td>
                    <td>{{$cylinders[$i]->certificate}}</td>
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
                    <td>{{$cylinders[$i]->SerialNumber}}</td>
                    <td>{{$cylinders[$i]->Date}}</td>
                    <td>{{$cylinders[$i]->InspectionExpiryDate}}</td>
                    <td>{{$cylinders[$i]->length}}</td>
                    <td>{{$cylinders[$i]->capacity}}</td>
                    <td>{{$cylinders[$i]->DateOfManufacture}}</td>
                    <td>{{$cylinders[$i]->ownername}}</td>
                    <td>{{$cylinders[$i]->vehicleRegNo}}</td>
                    <td>{{$cylinders[$i]->ocnic}}</td>
                    <td>{{$cylinders[$i]->certificate}}</td>
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


