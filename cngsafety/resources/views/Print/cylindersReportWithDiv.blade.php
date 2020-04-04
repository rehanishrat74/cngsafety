
<!DOCTYPE html>
<html>
    <head>
          <title>Bootstrap Example</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <style>
            hr {
              margin-top: 1rem;
              margin-bottom: 1rem;
              border: 0;
              border-top: 1px  ;
            } 
            .hr-border-solid{
                border-top: solid;
                border-top-color: rgba(0, 0, 0, 0.1);
            } 
            .hr-border-dotted{
                border-top: dashed;
                 border-top-color: rgba(0, 0, 0, 0.1);
            }            
        </style>          
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
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-3" ><strong>{{$cylinders[$i]->province}}</strong> </div>
                    <div class="col-sm-3" ><strong>{{$cylinders[$i]->city}}</strong> </div>
                    <div class="col-sm-3" ><strong>Lab: {{$cylinders[$i]->labname}}</strong> </div>
                  </div>
                                   
                 <div class="row">
                    <div class="col-sm-4" >&nbsp;</div>                    
                    <div class="col-sm-2" ><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}</div>
                    <div class="col-sm-2" ><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</div>
                    <div class="col-sm-2" ><strong>Standard: {{$cylinders[$i]->Standard}}</strong></div>
                    <div class="col-sm-2" >Method: {{$cylinders[$i]->method}}</div>                                         
                 </div> 

                <hr class="hr-border-dotted">                     
                 <div class="row" >                   
                   <div class="col-sm-6" >&nbsp;</div>
                    <div class="col-sm-1" ><strong>Diameter:</strong></div>
                    <div class="col-sm-1" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                    <div class="col-sm-1" ><strong>Capacity:</strong></div>
                    <div class="col-sm-1" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div> 

                 <div class="row" >                   
                    <div class="col-sm-1" ><strong>Serial</strong></div>
                    <div class="col-sm-1" ><strong>Inspection</strong></div>
                    <div class="col-sm-1" ><strong>Expiry</strong></div>
                    <div class="col-sm-1" ><strong>Length</strong></div>
                    <div class="col-sm-1" ><strong>Capacity</strong></div>
                    <div class="col-sm-1" ><strong>Manufacturing</strong></div>
                    <div class="col-sm-2" ><strong>Owner</strong></div>
                    <div class="col-sm-1" ><strong>Vehicle</strong></div>
                    <div class="col-sm-1" ><strong>CNIC</strong></div>
                    <div class="col-sm-1" ><strong>Certificate</strong></div>
                 </div> 

                <div class="row" >                   
                    <div class="col-sm-1" >{{$cylinders[$i]->SerialNumber}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->Date}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->InspectionExpiryDate}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->length}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->capacity}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->DateOfManufacture}}</div>
                    <div class="col-sm-2" >{{$cylinders[$i]->ownername}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->vehicleRegNo}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->ocnic}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->certificate}}</div>
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
               
                <div class="container-fluid">
                 <div class="row">
                    <div class="col-sm-4" >&nbsp;</div>                    
                    <div class="col-sm-2" ><strong>Origin:</strong> {{$cylinders[$i]->CountryOfOrigin}}</div>
                    <div class="col-sm-2" ><strong>Brand:</strong>  {{$cylinders[$i]->BrandName}}</div>
                    <div class="col-sm-2" ><strong>Standard: {{$cylinders[$i]->Standard}}</strong></div>
                    <div class="col-sm-2" >Method: {{$cylinders[$i]->method}}</div>                                         
                 </div> 

                <hr class="hr-border-dotted">                     
                 <div class="row" >                   
                   <div class="col-sm-6" >&nbsp;</div>
                    <div class="col-sm-1" ><strong>Diameter:</strong></div>
                    <div class="col-sm-1" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                    <div class="col-sm-1" ><strong>Capacity:</strong></div>
                    <div class="col-sm-1" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div> 

                 <div class="row" >                   
                    <div class="col-sm-1" ><strong>Serial</strong></div>
                    <div class="col-sm-1" ><strong>Inspection</strong></div>
                    <div class="col-sm-1" ><strong>Expiry</strong></div>
                    <div class="col-sm-1" ><strong>Length</strong></div>
                    <div class="col-sm-1" ><strong>Capacity</strong></div>
                    <div class="col-sm-1" ><strong>Manufacturing</strong></div>
                    <div class="col-sm-2" ><strong>Owner</strong></div>
                    <div class="col-sm-1" ><strong>Vehicle</strong></div>
                    <div class="col-sm-1" ><strong>CNIC</strong></div>
                    <div class="col-sm-1" ><strong>Certificate</strong></div>
                 </div> 

                <div class="row" >                   
                    <div class="col-sm-1" >{{$cylinders[$i]->SerialNumber}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->Date}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->InspectionExpiryDate}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->length}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->capacity}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->DateOfManufacture}}</div>
                    <div class="col-sm-2" >{{$cylinders[$i]->ownername}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->vehicleRegNo}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->ocnic}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->certificate}}</div>
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

             
                        <div class="container-fluid">
                <hr class="hr-border-dotted">                     
                 <div class="row" >                   
                   <div class="col-sm-6" >&nbsp;</div>
                    <div class="col-sm-1" ><strong>Diameter:</strong></div>
                    <div class="col-sm-1" >{{$cylinders[$i]->diameter}}&nbsp;</div>
                    <div class="col-sm-1" ><strong>Capacity:</strong></div>
                    <div class="col-sm-1" >{{$cylinders[$i]->capacity}}&nbsp;</div>
                 </div> 

                 <div class="row" >                   
                    <div class="col-sm-1" ><strong>Serial</strong></div>
                    <div class="col-sm-1" ><strong>Inspection</strong></div>
                    <div class="col-sm-1" ><strong>Expiry</strong></div>
                    <div class="col-sm-1" ><strong>Length</strong></div>
                    <div class="col-sm-1" ><strong>Capacity</strong></div>
                    <div class="col-sm-1" ><strong>Manufacturing</strong></div>
                    <div class="col-sm-2" ><strong>Owner</strong></div>
                    <div class="col-sm-1" ><strong>Vehicle</strong></div>
                    <div class="col-sm-1" ><strong>CNIC</strong></div>
                    <div class="col-sm-1" ><strong>Certificate</strong></div>
                 </div> 

                <div class="row" >                   
                    <div class="col-sm-1" >{{$cylinders[$i]->SerialNumber}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->Date}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->InspectionExpiryDate}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->length}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->capacity}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->DateOfManufacture}}</div>
                    <div class="col-sm-2" >{{$cylinders[$i]->ownername}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->vehicleRegNo}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->ocnic}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->certificate}}</div>
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

                   
                        <div class="container-fluid">

                <div class="row" >                   
                    <div class="col-sm-1" >{{$cylinders[$i]->SerialNumber}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->Date}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->InspectionExpiryDate}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->length}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->capacity}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->DateOfManufacture}}</div>
                    <div class="col-sm-2" >{{$cylinders[$i]->ownername}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->vehicleRegNo}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->ocnic}}</div>
                    <div class="col-sm-1" >{{$cylinders[$i]->certificate}}</div>
                </div>
                        </div>
                   

                <?php 


                }

                
            }
        }
//@endforeach  
    }
?>

</tbody>
</table>
<?php 
//print_r($cylinders);
//echo '<br>';
//print("<pre>".print_r($cylinders,true)."</pre>");
?>
</body>
</html>


