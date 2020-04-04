
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="">
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
?>


@foreach ($cylinders as $cylinder)         
<?php

 

    $currentProvince=$cylinder->province;
    $currentcity=$cylinder->city;
    $currentlab = $cylinder->labname;

                $CurrentOrgin=$cylinder->CountryOfOrigin;
                $CurrentBrand=$cylinder->BrandName;
                $CurrentStandard=$cylinder->Standard;
                $TestMethod=$cylinder->method; 

    $currentDiameter=$cylinder->diameter;
    $currentCapacity=$cylinder->capacity;

    if ($currentProvince!=$lastProvince || $currentcity!=$lastcity || $currentlab!=$lastlab)
        {   //swap province
            $lastProvince=$currentProvince;
            $currentProvince=$cylinder->province;   

            $lastcity = $currentcity;
            $currentcity=$cylinder->city;

            $lastlab= $currentlab;
            $currentlab=$cylinder->labname;

            //resetting lower origin loop
            $lastCurrentOrgin ="";
            $lastCurrentBrand="";
            $lastCurrentStandard="";
            $lastTestMethod="";

            //echo "print province head". $currentProvince." <br>";
            ?>


                <?php
               // echo '<br>'.$recordCount.'<br>'; 
                //if rec count > 1 and province has changed then close serial no
                if ($recordCount>1) {?>
                    </table>
                    </tbody>
                <?php $serialClosed="yes"; 
                //echo '<br> serial closed <br> ';
                        } else {$serialClosed="no";
                        //echo '<br> serial does not closed <br> ';
                    }
                //-------------------------------------------------
                 ?>

            <hr>
            <table style="border=1;width:100%">

                <tbody>
                    <tr><td>{{$cylinder->province}}</td>
                        <td>{{$cylinder->city}}</td>
                        <td>{{$cylinder->labname}}</td>
                    </tr>
                </tbody>
            </table>     
            <hr style="border-top: 1px dashed;">

        <?php 
        }
    else
        {


            if ($CurrentOrgin!=$lastCurrentOrgin || $CurrentBrand!=$lastCurrentBrand || $CurrentStandard !=$lastCurrentStandard ||  $TestMethod!= $lastTestMethod)
            {   
                //echo "print country and brand head".$CurrentBrand.$CurrentOrgin." <br>";
                ?>


                <?php 
                //echo '<br>'.$recordCount.'<br>'; 
                //if rec count > 1 and brand has changed then close serial no
                if ($recordCount>1 ) {?>
                    </table>
                    </tbody>
                    <hr style="border-top: 1px dashed;">
                <?php $serialClosed="yes"; //echo '<br> serial closed <br> ';
                        } else {$serialClosed="no";
                            //echo '<br> serial does not closed <br> ';
                        }
                //-------------------------------------------------
                 ?>

                <table style="border=1;width:100%">
                    <tbody>
                        <tr>
                            <td>{{$cylinder->CountryOfOrigin}}</td>
                            <td>{{$cylinder->BrandName}}</td>
                            <td>{{$cylinder->Standard}}</td>
                             <td>{{$cylinder->method}}</td>

                        </tr>
                    </tbody>
                </table>

                <?php 
                //swap country and brand                
                $lastCurrentOrgin=$CurrentOrgin;
                $lastCurrentBrand=$CurrentBrand;
                $lastCurrentStandard=$CurrentStandard;
                $lastTestMethod=$TestMethod;

                $CurrentOrgin=$cylinder->CountryOfOrigin;
                $CurrentBrand=$cylinder->BrandName;
                $CurrentStandard=$cylinder->Standard;
                $TestMethod=$cylinder->method;                  
                //resetting lower loop
                $lastDiameter="";
                $lastCapacity="";
            }
            else
            {

                if ($currentDiameter!=$lastDiameter){
                    //echo ' <br> print Diameter'.$currentDiameter.' and capacity'.$currentCapacity."<br>" ;  

                ?>

                <?php 
                //echo '<br>'.$recordCount.'<br>'; 
                //if rec count > 1 and diameter has changed then close serial no
                if ($recordCount>1 && $serialClosed=="no") {?>
                    </table>
                    </tbody>
                <?php $serialClosed="yes"; 
                //echo '<br> serial closed <br> ';
                        } else {$serialClosed="no";
                        //echo '<br> serial does not closed <br> ';
                    }
                //-------------------------------------------------
                 ?>

                <table style="border=1;width:100%">
                    <tbody>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>Diameter</td>
                            <td>{{$cylinder->diameter}}</td>
                            <td>Capacity</td>
                            <td>{{$cylinder->capacity}}</td>

                        </tr>
                    </tbody>
                </table>
                <hr style="border-top: 1px dashed;">

                <table style="width:100%">
                    <tbody>
                        <tr>

                            <th>Serial</th>
                            <th>Inspection</th>
                            <th>Expiry</th>
                            <th>Length</th>
                            <th>Capacity</th>
                            <th>Manufacturing</th>
                            <th>Owner</th>
                            <th>Vehicle</th>
                            <th>CNIC</th>
                            <th>Certificate</th>
                        </tr>



                <?php 

                    //swap diameter and capacity
                    $lastDiameter=$currentDiameter;
                    $lastCapacity=$currentCapacity;

                    $currentDiameter=$cylinder->diameter;
                    $currentCapacity=$cylinder->capacity;

                }

                else
                {   
                    //echo 'print cylinder <br>';  
                        $recordCount=$recordCount+1;    
                ?>

                        <tr> 
                                                        
                            <td>{{$cylinder->SerialNumber}}</td>
                            <td>{{$cylinder->Date}}</td>
                            <td>{{$cylinder->InspectionExpiryDate}}</td>
                            <td>{{$cylinder->length}}</td>
                            <td>{{$cylinder->capacity}}</td>
                            <td>{{$cylinder->DateOfManufacture}}</td>
                            <td>{{$cylinder->ownername}}</td>
                            <td>{{$cylinder->vehicleRegNo}}</td>
                            <td>{{$cylinder->ocnic}}</td>
                            <td>{{$cylinder->certificate}}</td> 
                        </tr>

                <?php 


                }

                
            }
        }
?>
@endforeach  

</body>
</html>


