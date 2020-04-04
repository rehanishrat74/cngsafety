
<!DOCTYPE html>
<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style type="text/css">
      .col-12 {
  position: relative;
  width: 100%;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}

  </style>
</head>
<body>


<div class="container-fluid">
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

             <div class="row">
                 <div  class="col-12">Print Province here</div>
            
             </div>
 


        <?php 
        }
    else
        {


            if ($CurrentOrgin!=$lastCurrentOrgin || $CurrentBrand!=$lastCurrentBrand || $CurrentStandard !=$lastCurrentStandard ||  $TestMethod!= $lastTestMethod)
            {   
                //echo "print country and brand head".$CurrentBrand.$CurrentOrgin." <br>";
                ?>
                
                Print Brand here


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

                        Print Diameter

                        Print Cylinder Heading



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

                    Print Cylinders Here

                <?php 


                }

                
            }
        }
?>
@endforeach  
</div>
<?php 
print_r($cylinder);
?>
</body>
</html>


