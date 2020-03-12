<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\User as User;
use Carbon\Carbon;
use DB;
//use Response;
use Illuminate\Http\Response;
use Cookie;


class Test extends Controller
{
    //
    public function doGetCodes(Request $r) {
        $response = array();
        $userid =6; // $r['userid'];
        $type ="pending"; // $r['type'];  // pending or completed
	    $stationno ="PFJ-1";// $r['stationno']; //Additional Field

        $page =7;// $r['page'];

        //------------code below-------------
        $per_page = 7;
        if($page == 1) {
            $offset = 0;
        } else {
            $offset = ($page - 1) * $per_page;
        }

        $codes = DB::SELECT('SELECT Registration_no,Inspection_Status,businesstype,vehicle_particulars.stickerSerialNo,vehicle_particulars.stationno,vehicle_particulars.lastinspectionid FROM vehicle_particulars LEFT JOIN owner__particulars on vehicle_particulars.Registration_no = owner__particulars.VehicleReg_No and vehicle_particulars.OwnerCnic = owner__particulars.CNIC AND vehicle_particulars.stickerSerialNo = owner__particulars.StickerSerialNo where vehicle_particulars.stationno = ? AND vehicle_particulars.Inspection_Status=?',[$stationno,$type]);
	//querry changed.

        foreach($codes as $c) {
            $response[] = $c;
        }
        echo json_encode($response);
    }

    public function doGetInspectionDetails(Request $r) {
        $response = array();
        $userid = 6; //$r['user_id'];  //instead i need station no.
        $scan_code = "6XMWFH4G9"; //$r['scan_code'];
	    $stationno ="PFJ-1";// $r['stationno']; //Additional fields

//-------------------code below -----------------------------
	    $inspection=array('ResponseMsg'=>"Record not found");
        $vehicle = DB::SELECT('SELECT Registration_no, Chasis_no, Engine_no, Make_type, Inspection_Status, businesstype,vehicle_particulars.lastinspectionid, vehicle_particulars.stationno, vehicle_particulars.stickerSerialNo, vehicle_particulars.Record_no, vehicle_categories.category_name, owner__particulars.CNIC, owner__particulars.Cell_No, owner__particulars.Address, vehicle_particulars.lastinspectionid, users.name as "workshopname",users.address as "workshopaddress" FROM vehicle_particulars LEFT JOIN vehicle_categories on vehicle_particulars.Vehicle_catid=vehicle_categories.category_id LEFT JOIN owner__particulars on vehicle_particulars.Registration_no = owner__particulars.VehicleReg_No and vehicle_particulars.OwnerCnic = owner__particulars.CNIC and vehicle_particulars.stickerSerialNo = owner__particulars.StickerSerialNo LEFT JOIN users on vehicle_particulars.stationno= users.stationno where vehicle_particulars.stickerSerialNo =?  and vehicle_particulars.stationno=?',[$scan_code,$stationno]);
        
        if (!empty($vehicle)) {

			$inspectionid  = $vehicle[0]->lastinspectionid;  
	   		$vehicleNumberPlate = $vehicle[0]->Registration_no;	
	   		$vehicleDbRegistrationNo  = $vehicle[0]->Record_no;

       		$cngKit = DB::SELECT('SELECT formid, Make_Model, CngKitSerialNo, InspectionDate, Cylinder_valve, Filling_valve, Reducer, HighPressurePipe, ExhaustPipe, Total_Cylinders, RegistrationPlate_Pic, WindScreen_Pic,InspectionExpiry,VehicleRecordNo FROM cng_kit where cng_kit.formid=? and cng_kit.VehiclerRegistrationNo=? and cng_kit.VehicleRecordNo=?',[$inspectionid,$vehicleNumberPlate,$vehicleDbRegistrationNo]);

       		$cylinders = DB::SELECT('SELECT formid, Cylinder_no, Make_Model, Cylinder_SerialNo, InspectionDate, ExpiryDate, ImportDate, cylinder_locations.Location_name FROM kit_cylinders LEFT JOIN cylinder_locations on kit_cylinders.cylinderLocation = cylinder_locations.Location_id where formid=?',[$inspectionid]);
	
	   		$inspection = array($vehicle,$cngKit,$cylinders);
	
        	
        }
        echo json_encode($inspection);

    }    

    public function doUpdateParticulars(Request $r) 
    {
        $response = array();
        $scan_code ="GH3Z6HGC3";
        //"BVHGU0EYG"; //"GH3Z6HGC3" ;// "J5IQ0GAU6"; //$r['scan_code']; //Addoitional field        
        $vcat = 1; //$r['vehicleCategory']; 
        //Additional field e.g Ambulance, Cargo etc. must be numeric. table name = vehicle_categories
        
        $businesstype="Private"; //$r['businesstype']; //Addtional field. e.g Private / Commercial
        $stationno = "PFJ-1"; //$r['stationno']; //Additional fields
        $userid =6; // $r['user_id'];
        $code =0; // $r['code']; 
        $make_n_type = "make n type"; //$r['make_n_type'];
        $chasis_no = "chases2"; // $r['chasis_no'];
        $engine_no = "engine"; //$r['engine_no'];
        $vehicle_name = "vehicle name2"; //$r['vehicle_name'];
        $o_name = "owner name"; //$r['o_name'];
        $o_cnic ="cnic";// $r['o_cnic'];
        $registration_no = "PKR 233"; //$r['registration_no'];
        $o_cell_no ="098908"; // $r['o_cell_no'];
        $o_address = "address"; //$r['o_address'];
	    $maketype = "maketype"; //$vehicle_name.' '.$make_n_type;
        $update_at = time();
        $dt1=Carbon::today();
        $created_at=date('Y-m-d', strtotime($dt1));    
	    $msgws ="In Valid workstation";
	    $ownermsg="Invalid Owner";
	    $vehicleParticularMsg="Invalid Vehicle";
	    $msgResponse="Valid";
        $vehicleRecordNo=0; 
        $stickerCount=0;
        $stickerCnic="0";
        $stickervehicle="0";
        $vehicleRecordNo=0;
                      $stickerCount=0;
                      $isproduction=0;
                $stickerCnic="0";
                $stickervehicle="0";
                $vehicleRecordNo=0;
                $isvalid="Invalid";
                $duplicate="false";
                 if ($r['isproduction'] )
                {
                    $isproduction =$r['isproduction'];
                }
if (env('LOG_API')==1) {
 
                DB::insert('insert into logparticulars (code,vehicleCategory,businesstype,stationno ,user_id ,make_n_type,chasis_no ,engine_no ,vehicle_name,o_name ,o_cnic ,registration_no ,o_cell_no,o_address ,isproduction ,rectime ) values (?,?,?,?,?,?,? ,? ,?,? ,?,?,?,?,? ,?)',[$scan_code,$vcat,$businesstype,$stationno,$userid,$make_n_type,$chasis_no,$engine_no,$vehicle_name,$o_name,$o_cnic,$registration_no,$o_cell_no,$o_address,$isproduction,$created_at]);
}     
        //---------------code below-------------------------------------------
	   $vechicle = DB::SELECT('select IFNULL(count(id),0) as recordfound from users where id=? and stationno =?',[$userid,$stationno]);
		if (!empty($vechicle))
		{
	   		if ($vechicle[0]->recordfound ==1 and $vcat >0 ) //valid work station
	   		{

				$msgws="Valid Workstation ".$stationno;
            	$stickerStatus =DB::table('CodeRollsSecondary')            	
            					->select( DB::Raw('ifnull(cnic,"0") as cnic'), DB::Raw('ifnull(vehicleRegNo,"0") as vehicleRegNo'),DB::Raw('count(batchid) as allocated'))
            					->groupby ('cnic','vehicleRegNo')
            					->where('serialno','=',$scan_code)
            					->get();
            	
            	
            	if (!empty($stickerStatus) && !$stickerStatus->isempty() )
            	{

            		//storing sticker state
            		$stickerCount=$stickerStatus[0]->allocated;            	
            		$stickerCnic=$stickerStatus[0]->cnic;
            		$stickervehicle=$stickerStatus[0]->vehicleRegNo;


            		//checking if owner exists. if not then create it.
		    		$vehicleOwner = DB::select('select count(cnic) as owners from owner__particulars where owner__particulars.CNIC = ? and owner__particulars.VehicleReg_No=?', [$o_cnic,$registration_no]);
            		$countowners = $vehicleOwner[0]->owners;

            		if ($countowners ==0 ) //insert. no owner found
            		{
                		if ($stickerCount ==1)  //sticker exists
                		{
                    		//sticker is free to allocate to any vechicle.
                    		$freesticker=$scan_code;
                    		DB::insert('insert into owner__particulars (Owner_name,CNIC,Cell_No,Address,VehicleReg_No,StickerSerialNo) values (?,?,?,?,?,?)', [$o_name, $o_cnic,$o_cell_no,$o_address,$registration_no,$scan_code]);
                    		$ownermsg="Owner Created";                
                		} else 
                		{
		                	$ownermsg="Invalid Sticker. Sticker allocated to some other owner.";
                			$msgResponse="InValid";
                		    $response =array('FinalResponse' => $ownermsg,'VehicleResponse'=>$vehicleParticularMsg,'OwnerResponse'=> $ownermsg,'WorkstationResponse' => $msgws,'VehicleRecordNo' => $vehicleRecordNo);
       						echo json_encode($response);
       						return;
                		}

            		}  //end of insert owner
            		else //update owner details
		    		{
                		if ($stickerCount ==1 && $stickerCnic ==$o_cnic && $stickervehicle==$registration_no) 
                		{
                    		DB::table('owner__particulars')
                    		->where(['VehicleReg_No'=> $registration_no])
                    		->where(['CNIC'=> $o_cnic])
                    		->where (['StickerSerialNo'=>$scan_code])
                     		->update(['Owner_name' => $o_name,
                                'CNIC' => $o_cnic,
                                'Cell_No' => $o_cell_no,
                                'Address'=> $o_address,
                                'VehicleReg_No'=>$registration_no
                                ]);                             
                    		$ownermsg="Owner Updated against sticker ".$scan_code;                
                		}
		    		} // end of update owner		    
		    
            		$vehicalParticulars = DB::select('select count(Record_no) as vehiclecount from vehicle_particulars where Registration_no = ? and OwnerCnic=?', [$registration_no,$o_cnic]);
            		$countvehicles=$vehicalParticulars[0]->vehiclecount;		    
	       			if ($countvehicles ==0) 
            		{ // vehicle does not exists. Create it.
	                	if ($stickerCount ==1 && $stickerCnic ==0 && $stickervehicle==0) 
                		{
                			//sticker not allocated to vehicle. we can allocate it.
                			DB::insert('insert into vehicle_particulars (Registration_no ,Chasis_no,Engine_no,Vehicle_catid,Make_type ,OwnerCnic,created_at,businesstype,stationno,stickerSerialNo,Inspection_Status ) values (?, ?, ?,?,?,?,?,?,?,?,?)',[$registration_no,$chasis_no,$engine_no,$vcat,$maketype,$o_cnic,$created_at,$businesstype,$stationno,$scan_code,"pending"]);

                    		//updating sticker status in CodeRollsSecondary to avoid reuse of sticker
                			DB::table('CodeRollsSecondary')
                    		->where(['serialno'=> $scan_code])
                    		->update(['cnic' => $o_cnic,
                             		'vehicleRegNo' => $registration_no
                            	]);                             
                    		$vehicleParticularMsg ="Vehicle Record Created.";                        
                		}

            		} // end of insert vechicle
            		 else  // update vehicle.
		    		{
	            		DB::table('vehicle_particulars')
                    	->where(['Registration_no' => $registration_no])
                    	->where(['OwnerCnic' => $o_cnic])
                    	->where(['stickerserialno' => $scan_code])
                    	->where(['stationno'=> $stationno])
                    	->update(['Chasis_no' => $chasis_no,
                               'Engine_no' => $engine_no,
			 	               'Vehicle_catid' => $vcat,
				                'Make_type'=> $maketype,
				                'businesstype'=> $businesstype
                                ]); 
			     		$vehicleParticularMsg ="Vehicle Record Updated.";		
		    		}	// end of update vechicle
                	
                	$vehical = DB::select('select Record_no from vehicle_particulars where Registration_no = ? and OwnerCnic=? and stickerserialno=?', [$registration_no,$o_cnic,$scan_code]); 

                	if(!empty($vehical))
                	{
                		$vehicleRecordNo = $vehical[0]->Record_no;} else {$vehicleRecordNo=0;
                		$msgResponse="InValid";
                	}                
				} // end of $stickerStatus
				else
				{
            	    $response =array('FinalResponse' => "Invalid Sticker",'VehicleResponse'=>$vehicleParticularMsg,'OwnerResponse'=> $ownermsg,'WorkstationResponse' => $msgws,'VehicleRecordNo' => $vehicleRecordNo);
            			$msgResponse="InValid";
       					echo json_encode($response);
       					return;					
				}


	   		}   // end of valid workstation
       		else
	   		{
	            // invalid workstation
		  		$msgws ="InValid workstation ".$stationno." or vehicle category ".$vcat." missing. Cannot update";	
		  		$msgResponse="InValid";				
	   		}

	   		if ($vehicleRecordNo <=0) 
       		{
		  		$vehicleParticularMsg =$vehicleParticularMsg.' Vehicle Record No  in table vehicle_particulars cannot be 0';
		  		$msgResponse="InValid";

	   		}
    
		}        
        	$response =array('FinalResponse' => $msgResponse,'VehicleResponse'=>$vehicleParticularMsg,'OwnerResponse'=> $ownermsg,'WorkstationResponse' => $msgws,'VehicleRecordNo' => $vehicleRecordNo);

       echo json_encode($response);
    }

    // create n update cng kit. OK
    public function doUpdateCngKit(Request $r) {

    	$response=array();
        $userid =6;// $r['userid'];
        $code = $r['code'];
        $workstationid='PFJ-1'; // $r['stationno']; //Additional Field
        $cylindernos =2; // $r['totalcylinders']; //Additional Field. Range: 1-6
        $dt1=Carbon::today();            
        $inspectiondate = date('Y-m-d', strtotime($dt1)); // Field calculated automatically.
        $expiryDate=date('Y-m-d', strtotime($dt1)); // Additional Field. must.
                        
        $registration_no = 'PKR 233' ; //$r['registration_no'];   
        $vehicleRecordNo  = 0; 
        $scan_code = 'J5IQ0GAU6';
        $o_cnic = 'cnic';       
        $ck_make_n_model = "makenmodel";// $r['ck_make_model'];
        $ck_serial_no ="kitserialno1"; // $r['ck_serial_no'];
        $ck_is_cylinder_valve = ($r['ck_is_cylinder_valve'] == 'true') ? 'on' : 'off';
        $ck_is_filling_valve = ($r['ck_is_filling_valve'] == 'true') ? 'on' : 'off';
        $ck_is_reducer = ($r['ck_is_reducer'] == 'true') ? 'on' : 'off';
        $ck_is_high_pressure_pipe = ($r['ck_is_high_pressure_pipe'] == 'true') ? 'on' : 'off';
        $ck_is_exhaust_pipe = ($r['ck_is_exhaust_pipe'] == 'true') ? 'on' : 'off';
       // $entry_status = 'completed'; // not valid

         $inspectionId=0;
         $formid=0;
        $update_at = time();
        $finalResponse ="InValid";
        $msg ="Error In CngKit Process";
        $trace ="getting vechicle record no.";
        //----------------------------------
	

	
	   $vechicle = DB::SELECT('select IFNULL(count(id),0) as recordfound from users where id=? and stationno =?',[$userid,$workstationid]);
	   
		if (!empty($vechicle))
		{
		
	   		if ($vechicle[0]->recordfound ==1  ) //valid work station
	   		{
	   	
				$msg="Valid Workstation ".$workstationid;
            	$stickerStatus =DB::table('CodeRollsSecondary')            	
            					->select( DB::Raw('ifnull(cnic,"0") as cnic'), DB::Raw('ifnull(vehicleRegNo,"0") as vehicleRegNo'),DB::Raw('count(batchid) as allocated'))
            					->groupby ('cnic','vehicleRegNo')
            					->where('serialno','=',$scan_code)
            					->get();
            	
            	
			    	if (!empty($stickerStatus) && !$stickerStatus->isempty() )
			    	{

			    		//storing sticker state
			    		$stickerCount=$stickerStatus[0]->allocated;            	
			    		$stickerCnic=$stickerStatus[0]->cnic;
			    		$stickervehicle=$stickerStatus[0]->vehicleRegNo;

        //finding record no from vehicle particulars.
        $initinspection = DB::SELECT('SELECT vehicle_particulars.Inspection_Status,vehicle_particulars.Record_no FROM vehicle_particulars where Registration_No=? and vehicle_particulars.stationno=? and vehicle_particulars.stickerSerialNo=? and vehicle_particulars.OwnerCnic=?',[$registration_no,$workstationid,$scan_code,$o_cnic]); 

        	if (!empty($initinspection) && $cylindernos >0 )
        	{
        		$vehicleRecordNo= $initinspection[0]->Record_no;
        
        		$trace =$trace."/ finding number of inspections done.";
        		$cngkit = DB::SELECT('select count(CngKitSerialNo) as kitcount from cng_kit where CngKitSerialNo=? and vehicleRecordNo=?',[$ck_serial_no,$vehicleRecordNo]);
        		$countkits = $cngkit[0]->kitcount; 

           		if ($countkits==0 && !is_null($expiryDate) && $cylindernos >0 && !is_null($workstationid) &&
                !is_null($ck_serial_no) && !empty($ck_serial_no) && null !==$ck_serial_no 
            	) 
            	{

                	$trace =$trace."/ No inspection found. creating first inspection in cng_kit.";
                	DB::insert('insert into cng_kit(Make_Model,CngKitSerialNo,Cylinder_valve,Filling_valve,Reducer,HighPressurePipe,ExhaustPipe,Workshop_identity,Total_Cylinders,Inspection_Status,VehiclerRegistrationNo,InspectionDate,Location_cylinder,InspectionExpiry,VehicleRecordNo)
                	values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$ck_make_n_model,$ck_serial_no,$ck_is_cylinder_valve,$ck_is_filling_valve,$ck_is_reducer,$ck_is_high_pressure_pipe,$ck_is_exhaust_pipe,$workstationid,$cylindernos,'pending',$registration_no,$inspectiondate,1,$expiryDate,$vehicleRecordNo]);

                	$inspection = DB::SELECT('select  formid from  cng_kit where  CngKitSerialNo =?  and  InspectionDate =?',[$ck_serial_no,$inspectiondate]);
                	$inspectionId =$inspection[0]->formid; // it is the auto increament no. retrieving new inspection id
               		DB::table('vehicle_particulars')
                    ->where(['Registration_no'=> $registration_no])
                    ->where(['Record_no'=> $vehicleRecordNo])
                    ->update(['lastinspectionid' => $inspectionId,
                              'Inspection_Status' => 'pending'
                            ]);                             
                 	$finalResponse ="Valid";
                 	$msg ="Inspection Created in cng kit";         
           		} 
           		elseif ($countkits > 0 && !is_null($expiryDate) && $cylindernos >0 && !is_null($workstationid) &&
                	!is_null($ck_serial_no) && !empty($ck_serial_no) && null !== $ck_serial_no 
            			) 
           		{
               		$trace =$trace."/ many inspections found. checking last completed inspection.";

               		$lastinspection = DB::SELECT('SELECT lastinspectionid,cng_kit.Inspection_Status,cng_kit.formid FROM cng_kit LEFT JOIN vehicle_particulars on cng_kit.formid = vehicle_particulars.lastinspectionid and cng_kit.VehicleRecordNo = vehicle_particulars.Record_no where vehiclerRegistrationNo=? and vehicle_particulars.stationno=? and vehicle_particulars.stickerSerialNo=? and vehicle_particulars.OwnerCnic=?',[$registration_no,$workstationid,$scan_code,$o_cnic]);             
               		if ($lastinspection[0]->Inspection_Status=="completed") 
               		{
                  		// we need to create new inspection
                      	$trace =$trace."/ creating new inspection after last completed inspection.";
                     	DB::insert('insert into cng_kit(Make_Model,CngKitSerialNo,Cylinder_valve,Filling_valve,Reducer,HighPressurePipe,ExhaustPipe,Workshop_identity,Total_Cylinders,Inspection_Status,VehiclerRegistrationNo,InspectionDate,Location_cylinder,InspectionExpiry,VehicleRecordNo)
                        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$ck_make_n_model,$ck_serial_no,$ck_is_cylinder_valve,$ck_is_filling_valve,$ck_is_reducer,$ck_is_high_pressure_pipe,$ck_is_exhaust_pipe,$workstationid,$cylindernos,'pending',$registration_no,$inspectiondate,1,$expiryDate,$vehicleRecordNo]);

                    	$inspection = DB::SELECT('select  formid from  cng_kit where  CngKitSerialNo =?  and  InspectionDate =?',[$ck_serial_no,$inspectiondate]);
                    	// it is the auto increament no. getting newly created inspection id
                    	$inspectionId =$inspection[0]->formid; 
                    
                    	DB::table('vehicle_particulars')
                    	->where(['Registration_no'=> $registration_no])
                    	->where(['Record_no'=> $vehicleRecordNo])
                    	->update(['lastinspectionid' => $inspectionId,
                              'Inspection_Status' => 'pending'
                            ]);                             
                     	$finalResponse ="Valid";
                     	$msg ="new CngKit record created for new inspection";                     
           
                	} 
                	else 
                	{
                  		// last inspection is the pending inspection.we need to update inspection
                  		$trace =$trace."/ updating last pending inspection";

                  		$inspectionId =$lastinspection[0]->lastinspectionid;
        				$formid = $lastinspection[0]->formid;
                    	if (!is_null($expiryDate) && $formid > 0 && $cylindernos > 0 && $lastinspection[0]->Inspection_Status =="pending") //cannot edit completed inspection
                    	{       
	                        $trace =$trace.$inspectionId."/";

                           	DB::table('cng_kit')
                            ->where(['VehiclerRegistrationNo'=> $registration_no])
                            ->where(['formid'=> $inspectionId])
                            ->update(['Make_Model' => $ck_make_n_model,
                                  'CngKitSerialNo' => $ck_serial_no,                  
                                    'Cylinder_valve' => $ck_is_cylinder_valve,
                                    'Filling_valve' => $ck_is_filling_valve,
                                    'Reducer' => $ck_is_reducer,
                                    'HighPressurePipe' => $ck_is_high_pressure_pipe,
                                    'ExhaustPipe' => $ck_is_exhaust_pipe,
                                    'Total_Cylinders' => $cylindernos,
                                    'InspectionExpiry' => $expiryDate
                                ]);      
                             $finalResponse ="Valid";                       
                            $msg ="CngKit for inspection ".$formid." updated";
                    	} // end of cngkit_update                 
                	} // end of last pending transaction           
           		} // last inspection
        	}
        	else
        	{
                 $finalResponse ="InValid";
                 $msg ="Vechicle Record not found";                 		
        	}


					}
					else
					{
						
                 		$finalResponse ="InValid";
                 		$msg ="Invalid sticker ";                 								
					}						




			}else
			{
										
                 	$finalResponse ="InValid";
                 	$msg ="Invalid workstation ";                 								
			}
		}


        //---------------------------------------


    
    $response = array(
    			'finalresponse' => $finalResponse,
    			'msg' => $msg,
    			'inspectionid' => $inspectionId,
    			'trace' => $trace,'totalcylinders'=> $cylindernos); 


        echo json_encode($response);




    }

// update cylinders
    public function doUpdateCylinders(Request $r) {

        //if($r['API_Key'] != $this->API_KEY)
        $i=1;
        if($i== 2)
         {
            echo 'API Autorization Failed';
        } else {
                $response = array();
                $userid =6;// $r['user_id'];
                $code ="6XMWFH4G9";// $r['code'];6XMWFH4G9
                $scan_code ="6XMWFH4G9";// $r['scan_code']; //Additional fields
        $o_cnic ="3720114584115";// $r['o_cnic'];       // Additional fields
        $totalcylinders =2;// $r['totalcylinders'];  //Additional fields
        $lastinspectionid =0; // $r['inspectionid']; //Addtitional field. doUpdateCngKit returns this field.
        $workstationid="PFJ-1";// $r['stationno']; // Additional field.
        $registration_no ="KZ66 ZYT"; // $r['registration_no']; //Additional field

                $oinspectiondate = "2019-10-16"; //  $r['inspectiondate']; //Additional field
                if($oinspectiondate != '') {
                    $date = strtotime($oinspectiondate);
                    $inspectiondate = date('Y-n-j', $date);
                } else {
                    $inspectiondate = '';
                }

               $kitserialno   ="kitserialno1"; //$r['cngkitserialno']; //Additional field
                $location_1 ="1"; // !empty($r['c1_location']) ? $r['c1_location'] : ''; //Additional field
                $standard_1 ="NZ5454"; // !empty($r['c1_iso_model']) ? $r['c1_iso_model'] : '';    //Additional field
                $makenmodel_1 ="INFLEX"; // !empty($r['c1_make_model']) ? $r['c1_make_model'] : '';
                $serialno_1 ="412412b"; // !empty($r['c1_serial_no']) ? $r['c1_serial_no'] : '';

                $oimportdate_1 ="2019-10-16";// $r['c1_import_date']; //Additional field
                if($oimportdate_1 != '') {
                    $date = strtotime($oimportdate_1);
                    $importdate_1 = date('Y-n-j', $date);
                } else {
                    $importdate_1 = '';
                }
                
                $location_2 = "2"; //!empty($r['c2_location']) ? $r['c2_location'] : ''; //Additional field
                $standard_2 ="NZ5454"; // !empty($r['c2_iso_model']) ? $r['c2_iso_model'] : ''; //Additional field
                $makenmodel_2 ="INFLEX"; // !empty($r['c2_make_model']) ? $r['c2_make_model'] : '';
                $serialno_2 = "546235"; //!empty($r['c2_serial_no']) ? $r['c2_serial_no'] : '';
                
                $oimportdate_2 ="2019-10-16"; // $r['c2_import_date']; //Additional field
                if($oimportdate_2 != '') {
                    $date = strtotime($oimportdate_2);
                    $importdate_2 = date('Y-n-j', $date);
                } else {
                    $importdate_2 = '';
                }
                
                $location_3 =  null ;//!empty($r['c3_location']) ? $r['c3_location'] : ''; //Additional field
                $standard_3 =null ;// !empty($r['c3_iso_model']) ? $r['c3_iso_model'] : '';   //Additional field      
                $makenmodel_3 =null ;// !empty($r['c3_make_model']) ? $r['c3_make_model'] : '';
                $serialno_3 =null ;//  !empty($r['c3_serial_no']) ? $r['c3_serial_no'] : '';
                
                $oimportdate_3 = null ;// $r['c3_import_date'];        //Additional field
                if($oimportdate_3 != '') {
                    $date = strtotime($oimportdate_3);
                    $importdate_3 = date('Y-n-j', $date);
                } else {
                    $importdate_3 = '';
                }
                
                $location_4 =null ;// !empty($r['c4_location']) ? $r['c4_location'] : ''; //Additional field
                $standard_4 =null ;// !empty($r['c4_iso_model']) ? $r['c4_iso_model'] : '';  //Additional field
                $makenmodel_4 =null ;// !empty($r['c4_make_model']) ? $r['c4_make_model'] : '';
                $serialno_4 =null ;// !empty($r['c4_serial_no']) ? $r['c4_serial_no'] : '';

                $oimportdate_4 = null ;//$r['c4_import_date']; //Additional field
                if($oimportdate_4 != '') {
                    $date = strtotime($oimportdate_4);
                    $importdate_4 = date('Y-n-j', $date);
                } else {
                    $importdate_4 = '';
                }

                $location_5 = null ;// !empty($r['c5_location']) ? $r['c5_location'] : ''; //Additional field
                $standard_5 =null ;// !empty($r['c5_iso_model']) ? $r['c5_iso_model'] : '';    //Additional field     
                $makenmodel_5 =null ;// !empty($r['c5_make_model']) ? $r['c5_make_model'] : '';
                $serialno_5 =null ;// !empty($r['c5_serial_no']) ? $r['c5_serial_no'] : '';
                
                $oimportdate_5 =null ;//  $r['c5_import_date'];        //Additional field
                if($oimportdate_5 != '') {
                    $date = strtotime($oimportdate_5);
                    $importdate_5 = date('Y-n-j', $date);
                } else {
                    $importdate_5 = '';
                }
                
                $location_6 =null ;// !empty($r['c6_location']) ? $r['c6_location'] : ''; //Additional field
                $standard_6 =null ;// !empty($r['c6_iso_model']) ? $r['c6_iso_model'] : '';        //Additional field
                $makenmodel_6 =null ;// !empty($r['c6_make_model']) ? $r['c6_make_model'] : '';
                $serialno_6 = null ;//!empty($r['c6_serial_no']) ? $r['c6_serial_no'] : '';
                
                $oimportdate_6 = null ;// $r['c6_import_date']; //Additional field
                if($oimportdate_6 != '') {
                    $date = strtotime($oimportdate_6);
                    $importdate_6 = date('Y-n-j', $date);
                } else {
                    $importdate_6 = '';
                }
                
                $vehicleParticularMsg="null";
        $ownermsg="null";
        $msgws="null";
                $vehicleRecordNo=0;
                $finalResponse ="invalid";
                $msg ="null";   
                $record_no=0;
                $cylinderserialnocount =0;
                $inspectionStatus='pending';
                $cylindersWhereData= array();
                $cylindersWhereData1=array();
                $cylindersWhereData2=array();
                $cylindersWhereData3=array();
                $cylindersWhereData4=array();
                $cylindersWhereData5=array();
                $cylindersWhereData6=array();

                $stickerCount=0;
                $stickerCnic="0";
                $stickervehicle="0";

                $cylinderlist="";
                $parameters=array();
                $trace="checking sticker status,";
                $isproduction="0";
                 if ($r['isproduction'] )
                {
                    $isproduction =$r['isproduction'];
                }
                //dd ($totalcylinders);
                if (!$totalcylinders>=1)
                {
                    $finalResponse ="invalid"; //invalid
                    $inspectionStatus='invalid';
                    $response['response'] = 'invalid'; //invalid
                    $response['message'] = 'There must be at least one cylinder. Invalid total cylinders';
                    echo json_encode($response);
                    return;                                
                }
                $vechicle = DB::SELECT('select IFNULL(count(id),0) as recordfound from users where id=? and stationno =?',[$userid,$workstationid]);
                if (!empty($vechicle))
                {
                    if ($vechicle[0]->recordfound==1)
                    {
                        $stickerStatus =DB::table('CodeRollsSecondary')             
                        ->select( DB::Raw('ifnull(cnic,"0") as cnic'), DB::Raw('ifnull(vehicleRegNo,"0") as vehicleRegNo'),DB::Raw('count(batchid) as allocated'))
                        ->groupby ('cnic','vehicleRegNo')
                        ->where('serialno','=',$scan_code)
                        ->get();
                        if (!empty($stickerStatus) && count($stickerStatus))
                        {
                            if ($stickerStatus[0]->allocated==1)
                            {
                                if($stickerStatus[0]->allocated==1)
                                {
                                    if (!empty($stickerStatus) && count($stickerStatus) )    //count is safest to empty()
                                    {       

                                        //retrieving sticker state
                                        $stickerCount=$stickerStatus[0]->allocated;
                                        $stickerCnic=$stickerStatus[0]->cnic;
                                        $stickervehicle=$stickerStatus[0]->vehicleRegNo;
                                        $trace=$trace."finding inspection";
                                        $inspection = DB::SELECT('SELECT formid , vehicle_particulars.Inspection_Status,vehicle_particulars.Record_no FROM cng_kit LEFT JOIN vehicle_particulars on cng_kit.formid = vehicle_particulars.lastinspectionid and cng_kit.VehicleRecordNo = vehicle_particulars.Record_no where vehiclerRegistrationNo=? and vehicle_particulars.stationno=? and vehicle_particulars.stickerSerialNo=? and vehicle_particulars.OwnerCnic=? ',[$registration_no,$workstationid,$scan_code,$o_cnic]); 



                                        if (!empty($inspection) && count($inspection))
                                        {

                                            $trace=$trace."<br> inside inspection";
                                            $lastinspectionid=$inspection[0]->formid;
                                            if ($inspection[0]->Inspection_Status=="completed")
                                            {

                                                $finalResponse ="invalid"; //invalid
                                                $inspectionStatus='completed';
                                                $response['response'] = 'invalid'; //invalid
                                                $response['message'] = 'cannot modify completed inspection';
                                                echo json_encode($response);
                                                return;                                                 
                                            }
                                            if ($inspection[0]->Inspection_Status=="pending" && $totalcylinders > 0 && $stickerCount > 0 && $stickerCnic == $o_cnic && $stickervehicle ==$registration_no) 
                                            {

                                                $trace=$trace."/ finding recordno";  
                                                $record_no = $inspection[0]->Record_no;     
                                                if (!is_null($lastinspectionid) && !empty($lastinspectionid) && null !==$lastinspectionid && 
                                                !is_null($kitserialno) && !empty($kitserialno) && null !==$kitserialno &&
                                                !is_null($inspectiondate) && !empty($inspectiondate) && null !==$inspectiondate && null !== $serialno_1 && $record_no >0)
                                                {   

                                                    $trace=$trace."<br> start cylinders checks";
                                                    if (!is_null($serialno_1) && !empty($serialno_1) && null!==$serialno_1 ) {   
                                                        //at least 1 serial no is reqd to delete old cylinder records
                                                        $trace=$trace."/ in cylinder1";
                                                        DB::delete('delete from kit_cylinders where formid = ?',[$lastinspectionid]);                      
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 1 ,$serialno_1,$kitserialno,$inspectiondate,$importdate_1,$standard_1,$makenmodel_1,$location_1]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$serialno_1; // to be used in 'inclause'
//cylinder changings brand and serial is the pk.
                                                        $cylindersWhereData1 = [
                                                            ['SerialNumber','=', $serialno_1],
                                                            ['Make_Model', '=', $makenmodel_1]
                                                                            ];                                        


                                                    }
                                                    if (!is_null($serialno_2) && !empty($serialno_2) && isset($serialno_2) ) {   
                                                        $trace=$trace."/ in cylinder2";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 2 ,$serialno_2,$kitserialno,$inspectiondate,$importdate_2,$standard_2,$makenmodel_2,$location_2]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_2;
//cylinder changings brand and serial is the pk.
                                                        $cylindersWhereData2 = [
                                                            ['SerialNumber','=', $serialno_2],
                                                            ['Make_Model', '=', $makenmodel_2]
                                                                            ];                                                          
                                                    }
                                                    if (!is_null($serialno_3) && !empty($serialno_3) && isset($serialno_3) )
                                                    {                       
                                                        $trace=$trace."/ in cylinder3";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 3 ,$serialno_3,$kitserialno,$inspectiondate,$importdate_3,$standard_3,$makenmodel_3,$location_3]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_3;
//cylinder changings brand and serial is the pk.
                                                        $cylindersWhereData3 = [
                                                            ['SerialNumber','=', $serialno_3],
                                                            ['Make_Model', '=', $makenmodel_3]
                                                                            ];                        

                                                    }
                                                    if (!is_null($serialno_4) && !empty($serialno_4) && isset($serialno_4) )
                                                    {                        
                                                        $trace=$trace."/ in cylinder4";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 4 ,$serialno_4,$kitserialno,$inspectiondate,$importdate_4,$standard_4,$makenmodel_4,$location_4]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_4;

//cylinder changings brand and serial is the pk.
                                                        $cylindersWhereData4 = [
                                                            ['SerialNumber','=', $serialno_4],
                                                            ['Make_Model', '=', $makenmodel_4]
                                                                            ];                                                         
                                                    }
                                                    if (!is_null($serialno_5) && !empty($serialno_5) && isset($serialno_5) )
                                                    {                       
                                                        $trace=$trace."/ in cylinder5";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 5 ,$serialno_5,$kitserialno,$inspectiondate,$importdate_5,$standard_5,$makenmodel_5,$location_5]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_5;
//cylinder changings brand and serial is the pk.
                                                        $cylindersWhereData5 = [
                                                            ['SerialNumber','=', $serialno_5],
                                                            ['Make_Model', '=', $makenmodel_5]
                                                                            ];                                                         
                                                    }
                                                    if (!is_null($serialno_6) && !empty($serialno_6) && isset($serialno_6) )
                                                    {                        
                                                        $trace=$trace."/ in cylinder6";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 6 ,$serialno_6,$kitserialno,$inspectiondate,$importdate_6,$standard_6,$makenmodel_6,$location_6]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_6;

//cylinder changings brand and serial is the pk.
                                                        $cylindersWhereData6 = [
                                                            ['SerialNumber','=', $serialno_6],
                                                            ['Make_Model', '=', $makenmodel_6]
                                                                            ];                  

                                                                                                             
                                                    }
                                                    if ($cylinderserialnocount==$totalcylinders) 
                                                    {   
                                                        $trace=$trace."/ cylinder count check ok. checking kit inspection";
                                                        //stopping valves test upon request
                                                        //total cylinders data matched.
                                                        //$cngKitInspection = DB::SELECT('SELECT count(formid) as incompleteInspection FROM cng_kit WHERE formid =? and Cylinder_valve <> "on" or Filling_valve <> "on" or Reducer <> "on" or HighPressurePipe <> "on" or ExhaustPipe <> "on"',[$lastinspectionid]);
                                                        $cngKitInspection = DB::SELECT('SELECT count(formid) as incompleteInspection FROM cng_kit WHERE formid =? ',[$lastinspectionid]);                                                
                                                        //$msg="All cngkit valves are not tested.";
                                                        $msg="cngkit passed.";
                                                        $finalResponse ="valid";  //incomplete
                                                        $response['response']="valid"; //incomplete
                                                        $response['message']=$msg;
                                                        if ($cngKitInspection[0]->incompleteInspection ==1) //last value was 0. chanaged upon request
                                                        {
                                                            $trace=$trace."/ kit inspection completed. checking any unregistered cylinder";
                                                            //kit inspection is completed.
                                                            //Checking in registered cylinders, if import date is null then pending because testing record in the registered cylinder is missing. 

                                                            //commenting for model and serial no is unique.
          
switch ($totalcylinders ) {
    case '1':
        # code...
            $cylindersWhereData= $cylindersWhereData1;     
        break;
    case '2':
        # code...
        $cylindersWhereData=array_merge( $cylindersWhereData1,$cylindersWhereData2);     
        break;
    case '3':
        # code...
        $cylindersWhereData=array_merge( $cylindersWhereData1,$cylindersWhereData2,$cylindersWhereData3);     
        break;        
    case '4':
        # code...
        $cylindersWhereData=array_merge( $cylindersWhereData1,$cylindersWhereData2,$cylindersWhereData3,$cylindersWhereData4);     
        break; 
    case '5':
        # code...
        $cylindersWhereData=array_merge( $cylindersWhereData1,$cylindersWhereData2,$cylindersWhereData3,$cylindersWhereData4,$cylindersWhereData5);    
        break;  
    case '6':
        # code...
        $cylindersWhereData=array_merge( $cylindersWhereData1,$cylindersWhereData2,$cylindersWhereData3,$cylindersWhereData4,$cylindersWhereData5,$cylindersWhereData6);    
        break;             
    default:
        # code...
        $cylindersWhereData= $cylindersWhereData1;     
        break;
}
//dd($cylindersWhereData);

 $Cylinders=DB::Table('kit_cylinders')
                    ->leftjoin('RegisteredCylinders',function($join){
                        $join->on('kit_cylinders.Cylinder_SerialNo','=','RegisteredCylinders.SerialNumber');
                        $join->on('kit_cylinders.Make_Model','=','RegisteredCylinders.BrandName');
                    })
                    ->select(DB::Raw('count(formid) as UnregisteredCylinders'))
                    ->where('formid','=',$lastinspectionid)
                    ->where('RegisteredCylinders.Date','=',null)
                    ->where($cylindersWhereData)                    
                    ->get();
                    
//rehan is here.

                                                            //RegisteredCylinders.Date = inspection date by labs
                                                            if ($Cylinders[0]->UnregisteredCylinders ==0)
                                                            {   
                                                                //all cylinders have inspection dates
                                                                //update stickerserialno in registered cylinders
                                                                $trace=$trace."/ all cylinders are verified by labs";
                                                                //all cylinders are tested by hdip labs
                                                                $inspectionStatus='completed';
                                                                $UnregisteredCylinders=DB::table('RegisteredCylinders')
                                                                ->select(DB::Raw('count(id) as cylinderscount'))                
                                                                ->where('InspectionExpiryDate', '<', $inspectiondate)
                                                                ->where('SerialNumber', 'in', $cylinderlist)
                                                                ->get();
                                                                $UnregisteredCylindersCount=0;
                                                                if (!empty($UnregisteredCylinders) && !$UnregisteredCylinders->isempty() )
                                                                {
                                                                    if ($UnregisteredCylinders[0]->cylinderscount>0) 
                                                                    {
                                                                        $inspectionStatus='pending';
                                                                        $finalResponse ="valid"; //incomplete
                                                                        $msg="Cylinder Inspection id required by the approved labs";
                                                                        $finalResponse ="invalid";  //incomplete
                                                                        $response['response']="invalid"; //incomplete
                                                                        $response['message']=$msg;
                                                                    }
                                                                    else
                                                                    {
                                                                        $trace=$trace."/ updating cylinders";                                                      
                                                                        DB::table('vehicle_particulars')
                                                                        ->where(['Registration_no' => $registration_no])
                                                                        ->where(['OwnerCnic' => $o_cnic])
                                                                        ->where(['stickerserialno' => $scan_code])
                                                                        ->where(['stationno'=> $workstationid])
                                                                        ->update(['Inspection_Status' => $inspectionStatus]); 
                                                                        DB::table('cng_kit')
                                                                        ->where(['VehiclerRegistrationNo'=> $registration_no])
                                                                        ->where(['formid'=> $lastinspectionid])
                                                                        ->where(['VehicleRecordNo'=> $record_no])
                                                                        ->update(['Inspection_Status' => $inspectionStatus]);      
                                                                        DB::table('RegisteredCylinders')
                                                                        ->where('SerialNumber', 'in', $cylinderlist)
                                                                        ->update(['stickerserialno' => $scan_code]); 
                                                                        $finalResponse ="valid";
                                                                        //  $msg ="valid inspection id ".$lastinspectionid." to process ".$totalcylinders." cylinders against vehicle ".$registration_no." with scancode ".$scan_code." with inspection status as ".$inspectionStatus;
                                                                        $msg="Inspection status is completed against vehicle ".$registration_no."  and inspectionid ".$lastinspectionid;
                                                                        $finalResponse ="valid";  //incomplete
                                                                        $response['response']="valid"; //incomplete
                                                                        $response['message']=$msg;
                                                                    }
                                                                } // end of unregistered cylinders empty check
                                                            }  // end of unregistered cylinders
                                                            else
                                                            {
                                                                $finalResponse ="invalid"; //incomplete
                                                                $msg ="Inspection cannot complete because cylinders are not approved by labs";
                                                                $response['message']="Not all cylinders are tested by labs";
                                                            }
                                                        } //end of incomplete inspections         
                                                    }//cylinder count check
                                                    else {
                                                        $msg="Cylinders cound does not match";
                                                        $finalResponse ="invalid";  //incomplete
                                                        $response['response']="invalid"; //incomplete
                                                        $response['message']=$msg;
                                                        echo json_encode($response);
                                                        return;                                                        
                                                    }
                                                } // end of inserting in kit_cylinders      
                                            } //valid inspection id found to process the inspection
                                            else {
                                                if ($inspectionStatus=="completed") {
                                                   $msg="vechicle inspection completed. cannot continue";
                                                    $response['response']="invalid"; //completed
                                                    $response['message']="Cannot modify completed inspection";
                                                   echo json_encode($response);
                                                   return;
                                                } else {
                                                   if ($totalcylinders < 0 ) { 
                                                    $response['response']="invalid";
                                                    $response['message'] ="Total cylinders must be >=1 ";     
                                                    echo json_encode($response);           
                                                   return;
                                                    }
                                                    if ($stickerCount  <= 0 ) { 
                                                        $response['response']="invalid";
                                                        $response['message'] ="Invalid sticker against this vehicle"; 
                                                        echo json_encode($response);
                                                        return;
                                                    }
                                                    if ($stickerCnic != $o_cnic ) { 
                                                        $response['response']="invalid";
                                                        $response['message'] ="Vehicle not registered for this NIC ";            
                                                        echo json_encode($response);
                                                        return;
                                                    }
                                                }
                                            }
                                        }
                                        else {
                                            if ($isproduction==0) {
                                                    $response =array('FinalResponse' => "invalid Sticker",
                                                        'VehicleResponse'=>$vehicleParticularMsg,
                                                        'OwnerResponse'=> $ownermsg,'WorkstationResponse' => $msgws,'VehicleRecordNo' => $vehicleRecordNo);
                                                    $msgResponse="invalid";
                                                    $response = array();
                                                    $response['response'] = $finalResponse;
                                                     $response['message'] = $msg;
                                            } else {
                                                        $response['response']="invalid";
                                                        $response['message'] ="No inspection exists against this Sticker,nic and vehicle";
                                                        echo json_encode($response);
                                                        return;
                                            }
                                            //echo json_encode($response);
                                            //return;                                     
                                        }
                                    }
                                    else
                                    {
                                        //$trace=$trace."/ last inspection not found";    
                                        //$msg="inspection not found";
                                        $finalResponse="invalid";
                                        $response['response']="invalid";
                                        $response['message'] ="Invalid Sticker against this vehicle";
                                        echo json_encode($response);
                                        return;                                        
                                    }
                                } 
                            } else {
                                //echo 'sticker count is 0';
                                //$msg="Sticker count is 0. not found";
                                    $response['response']="invalid";
                                    $response['message'] ="Invalid Sticker against this vehicle.";
                                    echo json_encode($response);
                                    return;                                
                            }
                        } else {
                            //echo 'sticker not found';
                            //$msg="Sticker not found";
                                $response['response']="invalid";
                                $response['message'] ="Invalid Sticker against this NIC..";
                                echo json_encode($response);
                                return;                            
                        }
                    }
                    else {       
                        //$trace=$trace."/ Invalid workstation";  
                        //$msg="workstation not found";
                        //$finalResponse="invalid";                        
                        $response['response']="invalid";
                        $response['message'] ="Invalid userid or workstation";
                        echo json_encode($response);
                        return;                        
                    }
                }
                $parameters=array(
                    'inspectionid'=>$lastinspectionid,
                    'totalcylinders'=>$totalcylinders,
                    'llotedstickerCount'=>$stickerCount,
                    'allotedstickerCnic'=>$stickerCnic,
                    'o_cnic'=>$o_cnic,
                    'allotedvehicletosticker'=>$stickervehicle,
                    'registration_no'=>$registration_no,
                    'kitsercialno' =>$kitserialno,
                    'inspectiondate'=>$inspectiondate,
                    'cylinders'=>$cylinderlist,
                    'recordno'=>$record_no,
                    'inspectionstatus'=>$inspectionStatus,
                    'stickercount'=>$stickerCount,
                    'stickercnic'=>$stickerCnic,
                    'passedcnic'=>$o_cnic,
                    'RegisteredStickerVehicle'=>$stickervehicle
                );
                if ($isproduction==0) {
                     $response =array(
                    'response'=>$finalResponse,
                    'msg'=>$msg,
                    'inputparams'=>$parameters,
                    'trace' => $trace
                    );
                } else {
                     $response['response'] =$finalResponse;
                }
                echo json_encode($response);
            //} else {
            //    echo 'Inspection API is available for only Mobile Apps';
            //}
        }
    }

    public function testWhere()
    {
        $cylindersWhereData1 = [
                    ['serialno','=', '1234'],
                     ['Make_Model', '=', 'Inflex']
            ];
        $cylindersWhereData2 = [
                    ['serialno','=', '5678'],
                     ['Make_Model', '=', 'EKC']
            ];  

        $cylindersWhereData3=[
                    ['serialno','=', '1234'],
                     ['Make_Model', '=', 'Inflex'],
                    ['serialno','=', '5678'],
                     ['Make_Model', '=', 'EKC']                     
        ];     

        print_r($cylindersWhereData1);
        echo '<p><br></p>';
        print_r($cylindersWhereData2);
        echo '<p><br></p>';

        echo 'manual cat'.'<br>';
        print_r($cylindersWhereData3);
        echo '<p><br></p>';


        echo 'arraymerge<br>'; // this seems ok.
        print_r(array_merge( $cylindersWhereData1,$cylindersWhereData2));
        echo '<p><br></p>';

        echo 'arraypush<br>';
        array_push($cylindersWhereData1,$cylindersWhereData2);
        print_r($cylindersWhereData1);

    }
    public function testImage()
    {
        echo 'hello';

    }
    public function getAvailableBrands()
    {
        $brandsDB=array(
            "brand1"=>array("brandName"=>"Associate High Pressure Technologies Pvt
Ltd (India)",
                  "dimensions"=>array(
                        array("diameter"=>"232 mm","wlc"=>"22/30"),
                        array("diameter"=>"267 mm","wlc"=>"40/50"),
                        array("diameter"=>"325 mm","wlc"=>"55/60")
                            )
                ),
             "brand2"=>array("brandName"=>"EKC",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"30/37/40/45/50/55/60/65/70/80/90/95/100"),
                    array("diameter"=>"316 mm","wlc"=>"40/45/50/55/60/65/70/75/80/85/90/95/100/110/120/130/140"),
                    array("diameter"=>"356 mm","wlc"=>"55/58/60/62/64/65/70/73/80/85/90/95/100/110/120/130/145/152")
                            )
                ),          
              "brand3"=>array("brandName"=>"Euro, India cylinders ltd",
                  "dimensions"=>array(
                        array("diameter"=>"232 mm","wlc"=>"20/22"),
                        array("diameter"=>"267 mm","wlc"=>"40/50/55/60/80"),
                        array("diameter"=>"316 mm","wlc"=>"50/55/60")
                            )
                ),                
            
              "brand4"=>array("brandName"=>"Everest Kanto Cylinder Ltd",
                  "dimensions"=>array(
                        array("diameter"=>"232 mm","wlc"=>"21.5/22/24/25/28/30/35/40/45/50/55/60/65/70/75/80"),
                        array("diameter"=>"267 mm","wlc"=>"30/34/40/48/49/50/55/60/65/70/75/80/85/90/95/100")
                       )
                ),  
             "brand5"=>array("brandName"=>"Faber Industries",
                  "dimensions"=>array(
                        array("diameter"=>"228 mm","wlc"=>"20/30"),
                        array("diameter"=>"267 mm","wlc"=>"40"),
                        array("diameter"=>"313.6 mm","wlc"=>"55/60"),
                        array("diameter"=>"316 mm","wlc"=>"*")
                            )
                ),  
             "brand6"=>array("brandName"=>"Inprocil S.A",
                  "dimensions"=>array(
                        array("diameter"=>"273 mm","wlc"=>"40"),
                        array("diameter"=>"280 mm","wlc"=>"55")             
                            )
                ), 
             "brand7"=>array("brandName"=>"Kioshi compression",
                  "dimensions"=>array(
                        array("diameter"=>"280 mm","wlc"=>"55")
                            )
                ) ,             
             "brand8"=>array("brandName"=>"M/s. International Gas Vessels Industries
(IGVI)",
                  "dimensions"=>array(
                        array("diameter"=>"232 mm","wlc"=>"18 to 30"),
                        array("diameter"=>"273 mm","wlc"=>"40 to 80")               
                            )
                ),                                                                     
             "brand9"=>array("brandName"=>"Rama Cylinders (Pvt) Ltd",
                  "dimensions"=>array(
                        array("diameter"=>"317 mm","wlc"=>"50/60"),
                        array("diameter"=>"","wlc"=>""),
                        array("diameter"=>"","wlc"=>"")
                            )
                )  
                  
        );         

        return $brandsDB;
    }
    public function testArray()
    {
/*
        $brandStructures=array(
            "brand1"=>array("brandName"=>"fiber",
                  "dimensions"=>array(
                        array("diameter"=>"dimArray111fiber","wlc"=>"1/1/1"),
                        array("diameter"=>"dimArray222fiber","wlc"=>"2/2/2")
                            )
                ),
            "brand2"=>array("brandName"=>"kioshi",
                  "dimensions"=>array(
                        array("diameter"=>"dimArray333kioshi","wlc"=>"3/3/3"),
                        array("diameter"=>"dimArray444kioshi","wlc"=>"4/4/4")
                            )
                 ),
            "brand3"=>array("brandName"=>"ekc",
                  "dimensions"=>array(
                        array("diameter"=>"dimArray333ekc","wlc"=>"5/5/5"),
                        array("diameter"=>"dimArray444ekc","wlc"=>"6/6/6")
                            )
                 ),
            "brand4"=>array("brandName"=>"india",
                  "dimensions"=>array(
                        array("diameter"=>"dimArray333ekc","wlc"=>"7/7/7"),
                        array("diameter"=>"dimArray444ekc","wlc"=>"8/8/8")
                            )
                 ),
            "brand5"=>array("brandName"=>"pakistan",
                  "dimensions"=>array(
                        array("diameter"=>"dimArray555ggg","wlc"=>"9/9/9"),
                        array("diameter"=>"dimArray666ggg","wlc"=>"10/10/10")
                            )
                 )                                         
        ); 
*/        
      $brandStructures=$this->getAvailableBrands();
        echo "<br>";

        //printing brand names?
        echo '-------brand names------------  <br>';
        for ($i=1;$i<=5;$i++){
            $brandNameKey='brand'.$i;       //brand1  <= store this key in list
            echo $brandStructures[$brandNameKey]["brandName"]; // print fiber e.g
            echo '<br>';

        }
        echo '-----------selecting single brand--------------------- <br> ';
        //executing onclick e.g "brand1". it will load the dia and wlc as
        $brand= $this->getBrand($brandStructures,1,5); //brand range is 1-5
        print_r($brand);

        echo '<br> ----------getting diameter by index number-------------------  <br>';
        $brandDimensions=count($brand);
        for ($i=0;$i<=$brandDimensions;$i++)
        {   
            //store the value of i in the list
           echo "diameter=".$brand["brand1"]["dimensions"][$i]["diameter"]."<br>";
           echo "<br>";
        }

        echo '----------getting wlc by index number-----------------   <br> ';
        //printing wlc e.g of diameter0. using the value of i.
         echo "wlc of diameter index 0 =".$brand["brand1"]["dimensions"][0]["wlc"]."<br>";
         echo "<br>";



         echo '------------splitting wlc-(seperator=/)------------  <br> ';


         $wlcstring="1/2/3".'<br>';
         echo $wlcstring ;
         $wlc=explode("/",$wlcstring);
         //print_r($wlc);
         for($i=0 ;$i<count($wlc);$i++){
           echo  $wlc[$i].'<br>';
         }

         echo '------------splitting wlc-(seperator=to)------------  <br> ';
         $wlcstring="12 to 34";
         $wlc=explode(" to ",$wlcstring);  
         for ($i=$wlc[0];$i <= $wlc[1];$i++)
         {
            echo $i.'<br>';
         }
        
        echo '<br>=======calling genearate string=from 12/13/14========== <br>';
        $this->generateString("12/13/14");


        echo '<br>======now genearating WLC string= 12 to 34/50 to 60========== <br>';
        $this->generateString("12 to 34/50 to 60");

    }
    function testSql()
    {
        echo 'test sql';
       
        $scan_code='ZA5DVII43';
        $o_cnic='65543-7437892-7';
        $registration_no ='f-785';


        /*                $inspection = DB::SELECT('SELECT count(vehicle_particulars.record_no) as recordfound, beta.Record_no,beta.lastinspectionid FROM vehicle_particulars where vehicle_particulars.stickerSerialNo=? and Inspection_Status="pending" and vehicle_particulars.OwnerCnic=? and vehicle_particulars.Registration_no=?',[$scan_code,$o_cnic,$registration_no]);*/

                    $image = array(
                        'WindScreen_Pic' => 'xy34',
                        'WindScreen_Pic_imagetype' => 'bmp',
                    );
                    $where = array(
                        'formid' => 12,
                        'VehicleRecordNo' =>16
                    );
                    DB::table('cng_kit')->where($where)->update($image);

      echo 'kit updated';
    }

    function testCookie()
    {
    
    $pagesize='pagesize';
    $pagevalue=20;
    $expiry=2000000;


    echo 'user='.env('SMS_User');    
    $response=response('hello')->withCookie(cookie($pagesize, $pagevalue, $expiry));   
    return $response;      

    }

   public function getCookie() {
    if  (Cookie::get('pagesize') !== null)
    {echo 'cooke is set <br> ';
        echo Cookie::get('pagesize');
    }
    else
    {echo 'cookie isnt set';}

}
    function generateString($wlcstring)
    {
        //echo '------------splitting wlc-(finding seperator=/)------------  <br> ';
        //  "12 to 34"        = Array ( [0] => 12 to 34 )
        //  12 to 34/50 to 60 = Array ( [0] => 12 to 34 [1] => 50 to 60 ...)
        //  12/30             = Array ( [0] => 12 [1] => 30 )
        //  12                = Array ( [0] => 12 )
   
         //echo $wlcstring;
         $wlcArray=explode("/", $wlcstring);
         //print_r($wlcArray);
        
         $wlcMin=0;
         $wlcMax=0;
         $wlcList=array();
         $itemindex=0;


         for ($i=0;$i<count($wlcArray);$i++)
         {
           
            $wlc= $wlcArray[$i] ;
                //echo $wlc;  //"12", "12/13", "12 to 34"
             if (strpos($wlc,"to",0)>0){
                // for 12 to 34;
                $wlcTo = explode(" to ",$wlc);
                $wlcMax=$wlcTo[1];
                $wlcMin=$wlcTo[0];
                
                for ($j=$wlcMin;$j<=$wlcMax;$j++)
                {
                    //PUSHING 12,13,14 FROM "12 TO 34"
                    array_push($wlcList,$j);
                }
             }
             else
             {
                //PUSHING 12,13,14 FROM 12/13/14
                array_push($wlcList,$wlc);
             }
          
         }  
         

         asort($wlcList);
         print_r($wlcList);
    }

    function getBrand($brandStructures,$index,$count)  //5
    {
        $holding=array();
        $arraykey=array();        
        $i=0;
        $init=0;        
        $returnindex=0;

        echo 'index='.$index;
        echo '<br>';
        echo 'count='.$count;
        echo '<br>';

        switch($index){
            case 0:
                // Code to be executed if n=label1
                $returnindex=0;        
//                return array_slice($brandStructures, 0,1); // brand1
                break;

            default:
                // Code to be executed if n is different from all labels
                for ($i=$count-1;$i>0;$i--)
                {            
                    $arraykey = array($init => $i * -1 );
                    array_push($holding, $arraykey);
                    $init++;
                }

/*
                echo '0';                       //0 => brand1


                                                //   -4     brand2
                print_r($holding);
                $tempArray=$holding[0];
                echo '<br><br>';
                print_r($tempArray);
                echo '<br>';
                echo $tempArray[0];
                echo '<br><br>';
                

                $tempArray=$holding[1]; //-3        brand3
                echo '<br><br>';
                print_r($tempArray);
                echo '<br>';
                echo $tempArray[1];                
                echo '<br><br>';



                $tempArray=$holding[2];     //-2    brand 4
                echo '<br><br>';
                print_r($tempArray);
                echo '<br>';
                echo $tempArray[2];                
                echo '<br><br>';                
                



                $tempArray=$holding[3]; //-1    brand 5
                echo '<br><br>';
                print_r($tempArray);
                echo '<br>';
                echo $tempArray[3];                
                echo '<br><br>';                  



            echo '<br> ------------------------------------ <br> ';*/


            if ($index==1){
                return array_slice($brandStructures, 0,1); 
            }
            else
            {
                $returnindex= $holding[$index-2][$index-2];
                return array_slice($brandStructures, $returnindex,1);                
            }



        }

    }
        function arem($array,$value){
            $holding=array();
            foreach($array as $k => $v){
                if($value!=$v){
                    $holding[$k]=$v;
                }
            }   
            return $holding;
        }

        function akrem($array,$key){
            $holding=array();
            foreach($array as $k => $v){
                if($key=$k){
                    $holding[$k]=$v;
                }
            }   
            return $holding;
        }



        public function url()
        {
        
       if ($vehicle->formid==0)
            {
                if ($inspectionExpired==0)
                    {
                        echo route('newcylinderreg',$vehicle->Registration_no.'?recordid='.$vehicle->Record_no.'&stationno='.$vehicle->stationno);
                    }
            }
        else
            {
                if ($vehicle->Inspection_Status=='completed')
                    {
                        if($inspectionExpired==1)
                            {
                                echo route('newcylinderreg',$vehicle->Registration_no.'?recordid='.$vehicle->Record_no.'&stationno='.$vehicle->stationno);
                            }
                        else{
                            echo route('showcylinder',$vehicle->formid);
                            }
                    }
                else
                    {
                        echo route('editcylinder',$vehicle->formid);
                    }
            }
                                                        
        }

//setting cookie
//document.cookie = "username=John Doe; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
//reading cookie
//var x = document.cookie;
//document.cookie will return all cookies in one string much like: cookie1=value; cookie2=value; cookie3=value;        

//-----------------------------------
/*function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}*/

/*function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}*/

/*function checkCookie() {
  var user = getCookie("username");
  if (user != "") {
    alert("Welcome again " + user);
  } else {
    user = prompt("Please enter your name:", "");
    if (user != "" && user != null) {
      setCookie("username", user, 365);
    }
  }
}*/

//--------------end of cookie---------------------        
}
