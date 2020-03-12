$(function(){
var expiry =document.getElementById("expiry");
var expiryyear =document.getElementById("year");
var expirymonth =document.getElementById("month");
var expiryday =document.getElementById("day");
    
    
    /*setting expiry at the time of loading the page. this value is in db*/
    var inityear5= new Date(expiry.value);    
     expiryyear.value =inityear5.getFullYear();
     expirymonth.value =inityear5.getMonth() +1; //get month returns value from 0 to 11
     expiryday.value =inityear5.getDate() ;    
    /*setting expiry at the time of loading the page*/

   $(".datepicker").change(function() {
    var addressinput = $(this).val();
    var d = new Date(addressinput); //"03/25/2015"

    var year = d.getFullYear();
    var month = d.getMonth() ;
    var day = d.getDate();
    var year5 = new Date(year + 5, month, day)
    if ($(this)[0].id=="edate"){
     expiryyear.value =year5.getFullYear();
     expirymonth.value =year5.getMonth()+1;
     expiryday.value =year5.getDate() ;
    
    expiry.value=year5.toLocaleDateString();;
        }
    //console.log(year5);
   });

   $(".datepicker").focusout(function() {
    var addressinput = $(this).val();
    var d = new Date(addressinput); //"03/25/2015"

    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var year5 = new Date(year + 5, month, day)
//d.toLocaleDateString();
    if ($(this)[0].id=="edate"){
    expiry.value=year5.toLocaleDateString();;
     
     expiryyear.value =year5.getFullYear();
     expirymonth.value =year5.getMonth()+1;
     expiryday.value =year5.getDate() ;    
    //console.log(year5);
    //console.log(addressinput);
        }
   });

   $(".datepickerddm").change(function() {

    var domyear =document.getElementById("domyear");
     var dommonth =document.getElementById("dommonth");
      var domday =document.getElementById("domday");


    if ($(this)[0].id=="ddmanufacture"){

   var ddm =$(this);
   //console.log (ddm);
   //alert(ddm[0].value);
   var ddmdate = new Date(ddm[0].value); //"03/25/2015"
   //console.log(ddmdate);
   //console.log(ddmdate.getFullYear());
     domyear.value =ddmdate.getFullYear();
     dommonth.value =ddmdate.getMonth()+1;
     domday.value =ddmdate.getDate() ;

    }  
   });


//====================================

   $(".pickdiameter").change(function() {

   // var domyear =document.getElementById("domyear");
    // var dommonth =document.getElementById("dommonth");
    //  var domday =document.getElementById("domday");


    if ($(this)[0].id=="brand"){

        var brandName=$(this)[0].value; //brand1
        var brandNameIndex=brandName.replace(/brand/,''); //1
        var brandscount=<?php  echo $brandscount ;?>;   //9
        var passedArray =  
            <?php echo json_encode($brandStructures); ?>;


        //console.log(brandName);
        //console.log(brandNameIndex);        
        //console.log(brandscount);
        //console.log(passedArray); 

        var selectedBrand=passedArray[brandName];
        //console.log(selectedBrand["brandName"]);       //EKC
        var ctrbrandname =document.getElementById("hiddenbrandname");
        ctrbrandname.value=selectedBrand["brandName"];

        console.log(ctrbrandname.value);

        var dimensions = selectedBrand["dimensions"];
        //console.log(dimensions);
        
        var diameter = document.getElementById('diameter');        
       diameter.remove(0);  //x.remove(2);
       diameter.options.length = 0;

       //console.log(dimensions.length);
       var singlediameter=dimensions[0];
       //console.log(singlediameter["diameter"]);
       //console.log(singlediameter["wlc"]);

       //alert(dimensions[0].diameter);
       var wlcArray=[];
 
       var wlc = document.getElementById('capacity'); 
       wlc.remove(0);
       wlc.options.length=0;

       for (var i =0; i < dimensions.length;i++)
       {
     
diameter.options[diameter.options.length] = new Option(dimensions[i].diameter, '0', false, false); 

        //wlcArray.push(generateString(dimensions[i].wlc));
        wlcArray = wlcArray.concat(generateString(dimensions[i].wlc));
       }

// removing duplicates from array

//var names = ["Mike","Matt","Nancy","Adam","Jenny","Nancy","Carl"];
var uniqueWLC = [];
$.each(wlcArray, function(i, el){
    if($.inArray(el, uniqueWLC) === -1) uniqueWLC.push(el);
});
//-------------------------------------





       uniqueWLC.sort();
       //console.log(wlcArray);

       for (var i =0; i< uniqueWLC.length; i++)
       {
          var   WLCname=uniqueWLC[i] + ' WLC';
wlc.options[wlc.options.length] = new Option(WLCname, '0', false, false);        

       }
    }  

   });
  

});




    function generateString( wlcstring)
    {
        //echo '------------splitting wlc-(finding seperator=/)------------  <br> ';
        //  "12 to 34"        = Array ( [0] => 12 to 34 )
        //  12 to 34/50 to 60 = Array ( [0] => 12 to 34 [1] => 50 to 60 ...)
        //  12/30             = Array ( [0] => 12 [1] => 30 )
        //  12                = Array ( [0] => 12 )
   
         //echo $wlcstring;
         var wlcArray=wlcstring.split("/"); //explode("/", $wlcstring);
         //print_r($wlcArray);
        
         var wlcMin=0;
         var wlcMax=0;
         var wlcList=[]; //=array();
         var itemindex=0;


         for (var i=0;i<wlcArray.length;i++)
         {
           
            var wlc= wlcArray[i] ;
                //echo $wlc;  //"12", "12/13", "12 to 34"

             if (wlc.search("to")>0){
                // for 12 to 34;
                var wlcTo = wlc.split(" to ") ;//explode(" to ",$wlc);
                wlcMax=wlcTo[1];
                wlcMin=wlcTo[0];
                
                for (var j=wlcMin;j<=wlcMax;j++)
                {
                    //PUSHING 12,13,14 FROM "12 TO 34"
                    //array_push($wlcList,$j);
                    //array_push(wlcList,$j);
                    wlcList.push(j);
                }
             }
             else
             {
                //PUSHING 12,13,14 FROM 12/13/14
                //array_push($wlcList,$wlc);
                wlcList.push(wlc);
             }
          
         }  
         
         wlcList.sort();
         //asort($wlcList);
         //print_r($wlcList);
         return wlcList;
    }

    ---------------------------------------
    
$keys_array=[];
$values_array=[];

array_push($keys_array, "vehicle_particulars.Inspection_Status");            
array_push($values_array, $registrations_inspectionType);

$whereArray=array_combine( $keys_array, $values_array );