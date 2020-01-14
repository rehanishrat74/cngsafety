<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Jenssegers\Agent\Facades\Agent;
use App\User as User;
use Carbon\Carbon;
use DB;

class apiController extends Controller
{

    private $API_KEY = '';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
    public function __construct() {
        $this->API_KEY = '0J1wuM7aCPjdYhraeZR6abnVlvRHKfdT';
    }

    // upload files
    public function uploadFiles(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            //if(Agent::isMobile()) {
                $type = $r['type'];
                $user_id = $r['user_id'];
                $scan_code = $r['scan_code'];
                $stationno = $r['stationno']; //Additional Field

                // vars needs to be rewrite
                $o_cnic = $r['o_cnic']; //Additional field
                $registration_no = $r['registration_no']; //Additional field

                $finalResponse = "invalid";
                $msg="x";
                $trace="getting file";

                $file = $r->file('file');
                $name = $file->getClientOriginalName();
                $extension=$file->getClientOriginalExtension();  //image type

                $imgStr = (string) Image::make( $file )->resize( 300, null, function ( $c ) { $c->aspectRatio(); })->encode( $extension );
                $base64img = base64_encode( $imgStr );

                $trace=$trace."/ base64 encoded";
                $trace=$trace."/ fileype=".$type;

                if($type == 'wind-screen') {
                    $image = array(
                        'WindScreen_Pic' => $base64img,
                        'WindScreen_Pic_imagetype' => $extension,
                        'updated_at' => time()
                    );
                } else if($type == 'number-plate') {
                    $image = array(
                        'RegistrationPlate_Pic' => $base64img,
                        'RegistrationPlate_Pic_imagetype' => $extension,
                        'updated_at' => time()
                    );
                }
                $trace=$trace."/ finding last inspection.";
                
                
                
                $inspection = DB::SELECT('SELECT count(vehicle_particulars.record_no) as recordfound, beta.Record_no FROM vehicle_particulars where vehicle_particulars.stickerSerialNo=? and Inspection_Status="pending" and vehicle_particulars.OwnerCnic=? and vehicle_particulars.Registration_no=?',[$scan_code,$o_cnic,$registration_no]);
                if ($inspection[0]->recordfound ==1)
                {
                    $trace=$trace."/ last inspection found.";
                    $where = array('scan_code' => $scan_code,
                        'Record_no' =>$inspection[0]->Record_no
                    );
                    DB::table('cng_kit')->where($where)->update($image);
                    $finalResponse = "valid";
                    $msg="File Uploaded";            
                }
                $response = array();
                $response['response'] = strtolower($finalResponse);
                $response['message'] = $msg;
                echo json_encode($response);

            //} else {
              //  echo 'Inspection API is available for only Mobile Apps';
            //}
        }
    }

    // login user
    public function doLogin(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            //if(Agent::isMobile()) {
                $response = array();
                $email = $r['email'];      
                $user_code = $r['email'];
                $password = $r['pass'];
                $cred = array(
                    'email' => $user_code, //email
                    'password' => $password,
                    'deleted' => 0,
                    'activated' => 1,
                    'cellverified'=>1
                );
                if(Auth::attempt($cred)) {
                    // update user details
                    $uid = Auth::user()->id;
                    $lat = $r['lat'];
                    $lng = $r['lng'];
                    $device_id = $r['device'] . '-' . $uid;
                    // make sure device id is empty
                    $where = array(['device_id', '=', '']);
                    $c = DB::table('users')->where($where)->count();
                    if($c == 1) {
                        $user = array(
                            'latitude' => $lat,
                            'longitude' => $lng,
                            'device_id' => $device_id
                        );
                        DB::table('users')->where('id', $uid)->update($user);
                        $response['response'] = 'valid';
                        $response['id'] = Auth::user()->id;
                        $response['name'] = Auth::user()->name;
                        $response['email'] = Auth::user()->email;
                        $response['stationno'] = Auth::user()->stationno;
                        $response['cellnoforinspection'] = Auth::user()->cellnoforinspection;
                        $response['latitude'] = Auth::user()->latitude;
                        $response['longitude'] = Auth::user()->longitude;
                        $response['is_mobile_verified'] = Auth::user()->is_mobile_verified;
                    } else {
                        // compare the device and provide response
                        $cd_id = $device_id;
                        $od_id = Auth::user()->device_id;
                        if($cd_id == $od_id) {
                            $response['response'] = 'valid';
                            $response['id'] = Auth::user()->id;
                            $response['name'] = Auth::user()->name;
                            $response['email'] = Auth::user()->email;
                            $response['stationno'] = Auth::user()->stationno;
                            $response['cellnoforinspection'] = Auth::user()->cellnoforinspection;
                            $response['latitude'] = Auth::user()->latitude;
                            $response['longitude'] = Auth::user()->longitude;
                            $response['is_mobile_verified'] = Auth::user()->is_mobile_verified;
                        } else {
                            $response['response'] = 'invalid';
                            $response['message'] ="invalid device id";// Auth::user()->device_id;
                        }
                    }
                } else {
                    $response['response'] = 'invalid';
                    $response['message'] = 'invalid credentials';

                }
                echo json_encode($response);
            // else {
            //     echo 'Inspection API is available for only Mobile Apps';
            // }
        }
    }

    // verify mobile and generate pin
    public function doGeneratePin(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            $response = array();
            $userid = $r['userid'];
            $mobile = $r['mobile'];
            $where = array(
                'id' => $userid,
                'cellnoforinspection' => $mobile
            );
            $c = DB::table('users')->where($where)->count();
            if($c > 0) {
                // update pin code
                $digits = 4;
                $pin = rand(pow(10, $digits-1), pow(10, $digits)-1);
                $pinData = array(
                    'pin_code' => $pin,
                );
                DB::table('users')->where('id', $userid)->update($pinData);

                // send sms to the user mobile number
                $mobile = $r['mobile']; //Recepient Mobile Number
                $sender = "iBex";
                $message = "Greetings from iBex Your OTP Code is " . $pin . " enter this code to verify";
     
                //sending sms
                $post = "sender=".urlencode($sender)."&mobile=".urlencode($mobile)."&message=".urlencode($message)."";
                $url = "https://sendpk.com/api/sms.php?username=923065353533&password=4619";
                $ch = curl_init();
                $timeout = 30; // set to zero for no timeout
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $result = curl_exec($ch); 
                $response['response'] = 'valid';
            } else {
                $response['response'] = 'invalid';
                $response['message'] = 'invalid user id or mobileno';
            }
            echo json_encode($response);
        }
    }

    // verify pin
    public function doVerifyPin(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            $response = array();
            $userid = $r['userid'];
            $pin = $r['pin'];
            $where = array(
                'id' => $userid,
                'pin_code' => $pin
            );
            $c = DB::table('users')->where($where)->count();
            if($c > 0) {
                $mStatus = array(
                    'is_mobile_verified' => 1
                );
                DB::table('users')->where('id', $userid)->update($mStatus);
                $response['response'] = 'valid';
            } else {
                $response['response'] = 'invalid';
                $response['message'] = 'invalid userid or pin';
            }
            echo json_encode($response);
        }
    }

    // verify scanned code
    public function doVerifyCode(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            // if(!Agent::isMobile()) {
                $stationno = $r['stationno']; //Additional Field
                $scan_code = $r['code']; //Additional Field
                $responsecode = "null";
                $responsemsg="null";
                $isproduction=0;
                if ($r['isproduction'] )
                {
                    $isproduction =$r['isproduction'];
                    
                }
                //$dbsticker = DB::SELECT('SELECT count(CodeRollsSecondary.batchid) as validShopSticker ,ifnull(beta.cnic,0) as cnic,ifnull(beta.vehicleRegNo,0) as vehicleRegNo FROM CodeRollsSecondary LEFT JOIN users on CodeRollsSecondary.allotedto = users.email LEFT JOIN CodeRollsSecondary beta on CodeRollsSecondary.serialno=beta.serialno WHERE CodeRollsSecondary.serialno = ? and users.stationno=?',[$scan_code,$stationno]);
                $validShopsticker =DB::SELECT('SELECT count(CodeRollsSecondary.batchid) as validShopSticker from CodeRollsSecondary WHERE CodeRollsSecondary.serialno = ?',[$scan_code]);
                if (empty($validShopsticker ))
                {
                $response['response']="invalid";
                $response['message']="Invalid sticker";
                echo json_encode($response);
                return;
                }

                $dbsticker = DB::SELECT('SELECT ifnull(beta.cnic,0) as cnic,ifnull(beta.vehicleRegNo,0) as vehicleRegNo FROM CodeRollsSecondary LEFT JOIN users on CodeRollsSecondary.allotedto = users.email LEFT JOIN CodeRollsSecondary beta on CodeRollsSecondary.serialno=beta.serialno WHERE CodeRollsSecondary.serialno = ? and users.stationno=?',[$scan_code,$stationno]);
              if (empty($dbsticker ))
                {
                $response['response']="invalid";
                $response['message']="Invalid sticker for this station";
                echo json_encode($response);
                return;
                }

                if ($validShopsticker[0]->validShopSticker==0){
                    $responsecode = "invalid";
                    $responsemsg="Invalid sticker for this shop.";
                     $response['response'] = 'invalid';
                    $response['message'] = 'invalid sticker or station no.';
                    echo json_encode($response);
                    return; 
                }
                else if ($validShopsticker[0]->validShopSticker==1)
                {  
                    //sticker is valid for the workshop
                    if ($dbsticker[0]->cnic=="0"){
                        $responsecode = "valid"; // changed 1 to valid
                        $responsemsg="valid sticker to register new vehicle.";
                    }
                    if ($dbsticker[0]->cnic!="0"){
                        $dbstickerstatus = DB::SELECT('SELECT Inspection_Status FROM vehicle_particulars WHERE stickerserialno=? and stationno = ?',[$scan_code,$stationno]);
                        if ($dbstickerstatus[0]->Inspection_Status =="completed") {
                            $responsecode ="valid";
                            $responsemsg="no-reissue-completed";;
                        }
                        else {
                            $responsecode ="valid";
                            $responsemsg="no-reissue-pending";
                        }
                        //$responsemsg="valid sticker to retrieve details of the vehicle.";
                    }
                }

                //$response = array('responsecode'=>$responsecode,'responsemsg'=>$responsemsg);  
                $response['response'] = $responsecode;
                $response['message'] = $responsemsg;
                //if ($isproduction==1) {

                //}
                echo json_encode($response);
            // } else {
            //     echo 'Inspection API is available for only Mobile Apps';
            // }
        }
    }

    // get codes
    public function doGetCodes(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            // if(!Agent::isMobile()) {
                $response = array();
                $userid = $r['userid'];
                $type = $r['type'];  // pending or completed
                $stationno = $r['stationno']; //Additional Field

                $page = $r['page'];
                $per_page = 10;
                if($page == 1) { $offset = 0; } else { $offset = ($page - 1) * $per_page; }

                $codes = DB::SELECT('SELECT Registration_no,OwnerCnic,Inspection_Status,businesstype,vehicle_particulars.stickerSerialNo,vehicle_particulars.stationno,vehicle_particulars.lastinspectionid FROM vehicle_particulars LEFT JOIN owner__particulars on vehicle_particulars.Registration_no = owner__particulars.VehicleReg_No and vehicle_particulars.OwnerCnic = owner__particulars.CNIC AND vehicle_particulars.stickerSerialNo = owner__particulars.StickerSerialNo where vehicle_particulars.stationno = ? AND vehicle_particulars.Inspection_Status=?  and vehicle_particulars.stickerSerialNo is not null',[$stationno,$type]);

                if (empty($codes)){
                    $response['response']="invalid";
                    $response['message']="No record found";
                }
                else
                {
                // $response['response']="valid";   
                 //$response['message']=$codes;
                   // $response[]=$codes;
                    $response = $codes;
                }
               // foreach($codes as $c) { $response['message'] = $c; }
                
                echo json_encode($response);

            // } else {
            //     echo 'Inspection API is available for only Mobile Apps';
            // }
        }
    }

    // get inspection details
    public function doGetInspectionDetails(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            // if(!Agent::isMobile()) {
                $inspection = array();
                
                $user_id = $r['user_id'];  //instead i need station no.
                $scan_code = $r['scan_code'];
                $stationno = $r['stationno']; //Additional fields

                    //echo 'userid';
                    //echo  intval($user_id);    
                    //echo is_numeric($user_id);

                /*if(!intval($user_id) =true) {
                        $response['response']="invalid";
                        $response['message']="invalid user";
                        echo json_encode($response);
                        return;
                }*/
                //$inspection = array('ResponseMsg'=>"Record not found");
                $vehicle = collect(DB::SELECT('SELECT Registration_no, Chasis_no, Engine_no, Make_type, Inspection_Status, users.id,businesstype,vehicle_particulars.lastinspectionid, vehicle_particulars.stationno, vehicle_particulars.stickerSerialNo, vehicle_particulars.Record_no, vehicle_categories.category_name, owner__particulars.Owner_name, owner__particulars.CNIC, owner__particulars.Cell_No, owner__particulars.Address, vehicle_particulars.lastinspectionid, users.name as "workshopname",users.address as "workshopaddress" FROM vehicle_particulars LEFT JOIN vehicle_categories on vehicle_particulars.Vehicle_catid=vehicle_categories.category_id LEFT JOIN owner__particulars on vehicle_particulars.Registration_no = owner__particulars.VehicleReg_No and vehicle_particulars.OwnerCnic = owner__particulars.CNIC and vehicle_particulars.stickerSerialNo = owner__particulars.StickerSerialNo LEFT JOIN users on vehicle_particulars.stationno= users.stationno  where vehicle_particulars.stickerSerialNo =?  and vehicle_particulars.stationno=? and users.id=?',[$scan_code,$stationno,$user_id]))->first();
                //print_r($vehicle);
                if (!empty($vehicle)) {
                    $inspectionid  = $vehicle->lastinspectionid;  
                    $vehicleNumberPlate = $vehicle->Registration_no; 
                    $vehicleDbRegistrationNo  = $vehicle->Record_no;

                    $cngKit = collect(DB::SELECT('SELECT formid, Make_Model, CngKitSerialNo, InspectionDate, Cylinder_valve, Filling_valve, Reducer, HighPressurePipe, ExhaustPipe, Total_Cylinders, RegistrationPlate_Pic, WindScreen_Pic,InspectionExpiry,VehicleRecordNo FROM cng_kit where cng_kit.formid=? and cng_kit.VehiclerRegistrationNo=? and cng_kit.VehicleRecordNo=?',[$inspectionid,$vehicleNumberPlate,$vehicleDbRegistrationNo]))->first();                    
                    $cylinders = DB::SELECT('SELECT Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation, cylinder_locations.Location_name FROM kit_cylinders LEFT JOIN cylinder_locations on kit_cylinders.cylinderLocation = cylinder_locations.Location_id where formid=?',[$inspectionid]);
                    $response['response'] = 'valid'; 
                    $response['scan_code'] = $scan_code;
                    $response['make_n_type'] = $vehicle->Make_type;
                    $response['registration_no'] = $vehicle->Registration_no;
                    $response['chasis_no'] = $vehicle->Chasis_no;
                    $response['engine_no'] = $vehicle->Engine_no;
                    $response['vehicle_name'] = '????';
                    $response['category'] = $vehicle->category_name;
                    $response['o_name'] = $vehicle->Owner_name;
                    $response['o_cnic'] = $vehicle->CNIC;
                    $response['o_cell_no'] = $vehicle->Cell_No;
                    $response['o_address'] = $vehicle->Address;
                    // cylinder
                    $total_cylinders = count($cylinders);
                    $dummy_cylinders = 6 - $total_cylinders;
                    $i = 1;
                    foreach($cylinders as $c) {
                        $response['c' . $i . '_location'] = $c->cylinderLocation;
                        $response['c' . $i . '_iso_model'] = $c->Standard;
                        $response['c' . $i . '_make_model'] = $c->Make_Model;
                        $response['c' . $i . '_serial_no'] = $c->Cylinder_SerialNo;
                        $response['c' . $i . '_import_date'] = $c->ImportDate;
                        $i++;
                    }
                    for($j = 1; $j <= $dummy_cylinders; $j++) {
                        $response['c' . $i . '_location'] = '';
                        $response['c' . $i . '_iso_model'] = '';
                        $response['c' . $i . '_make_model'] = '';
                        $response['c' . $i . '_serial_no'] = '';
                        $response['c' . $i . '_import_date'] = '';
                        $i++;
                    }
                    // cng kit
                    $response['ck_make_n_model'] = $cngKit->Make_Model;
                    $response['ck_serial_no'] = $cngKit->CngKitSerialNo;
                    $response['ck_is_cylinder_valve'] = $cngKit->Cylinder_valve;
                    $response['ck_is_filling_valve'] = $cngKit->Filling_valve;
                    $response['ck_is_reducer'] = $cngKit->Reducer;
                    $response['ck_is_high_pressure_pipe'] = $cngKit->HighPressurePipe;
                    $response['ck_is_exhaust_pipe'] = $cngKit->ExhaustPipe;
                    $response['wind_screen_image'] = $cngKit->WindScreen_Pic;
                    $response['number_plate_image'] = $cngKit->RegistrationPlate_Pic;
                    
                } else {
                    $response['response'] = 'invalid';                     
                    $response['message'] = 'invalid sticker or station no';
                    echo json_encode($response);
                    return;                     
                }

                echo json_encode($response);
            // } else {
            //     echo 'Inspection API is available for only Mobile Apps';
            // }
        }
    }

    // update particulars
    public function doUpdateParticulars(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            // if(!Agent::isMobile()) {
                $response = array();
                $scan_code = $r['code']; //Addoitional field        
                $vcat =$r['vehicleCategory']; 
                //Additional field e.g Ambulance, Cargo etc. must be numeric. table name = vehicle_categories
                
                $businesstype=$r['businesstype']; //Addtional field. e.g Private / Commercial
                $stationno = $r['stationno']; //Additional fields
                $userid = $r['user_id'];
                $code = $r['code']; 
                $make_n_type = $r['make_n_type'];
                $chasis_no = $r['chasis_no'];
                $engine_no = $r['engine_no'];
                $vehicle_name = $r['vehicle_name'];
                $o_name = $r['o_name'];
                $o_cnic = $r['o_cnic'];
                $registration_no = $r['registration_no'];
                $o_cell_no = $r['o_cell_no'];
                $o_address = $r['o_address'];
                $maketype = $vehicle_name.' '.$make_n_type;
                $update_at = time();
                $dt1=Carbon::today();
                $created_at=date('Y-m-d', strtotime($dt1));    
                $msgws ="Valid workstation";
                $ownermsg= "null"; //"Invalid Owner";
                $vehicleParticularMsg="null"; //"Invalid Particular";
                $msgResponse="null";
                $isproduction ="0";
                $vehicleRecordNo=0; 
                $stickerCount=0;
                $stickerCnic="0";
                $stickervehicle="0";
                $vehicleRecordNo=0;
                $isvalid="Invalid";

                 if ($r['isproduction'] )
                {
                    $isproduction =$r['isproduction'];
                    
                }

        
                //-------------------code below---------------------------------------
                $vechicle = DB::SELECT('select IFNULL(count(id),0) as recordfound from users where id=? and stationno =?',[$userid,$stationno]);
                if (!empty($vechicle))
                {
                    //$response['response'] = 'invalid';
                    //$response['message'] = 'invalid userid or station no';
                    //echo json_encode($response);
                    //return; 
                    if ($vechicle[0]->recordfound ==1 and $vcat > 0) //valid work station
                    {
                        $msgws="Valid Workstation ". $stationno;
                        $stickerStatus =DB::table('CodeRollsSecondary')         
                        ->select( DB::Raw('ifnull(cnic,"0") as cnic'), DB::Raw('ifnull(vehicleRegNo,"0") as vehicleRegNo'),DB::Raw('count(batchid) as allocated'))
                        ->groupby ('cnic','vehicleRegNo')
                        ->where('serialno','=',$scan_code)
                        ->get();     
                        //echo  $scan_code;
                        //print_r($stickerStatus);
                        //return $scan_code;
                        if (!empty($stickerStatus) && !$stickerStatus->isempty() )
                        {
                            //storing sticker state
                            $stickerCount=$stickerStatus[0]->allocated;             
                            $stickerCnic=$stickerStatus[0]->cnic;
                            $stickervehicle=$stickerStatus[0]->vehicleRegNo;

                            //checking if owner exists. if not then create it.
                            $vehicleOwner = DB::select('select count(cnic) as owners from owner__particulars where owner__particulars.CNIC = ? and owner__particulars.VehicleReg_No=?', [$o_cnic,$registration_no]);
                            $countowners = $vehicleOwner[0]->owners;

                            if($countowners ==0 ) //insert. no owner found
                            {
                                if ($stickerCount ==1)  //sticker exists
                                {
                                    //sticker is free to allocate to any vechicle.
                                    $freesticker=$scan_code;
                                    DB::insert('insert into owner__particulars (Owner_name,CNIC,Cell_No,Address,VehicleReg_No,StickerSerialNo) values (?,?,?,?,?,?)', [$o_name, $o_cnic,$o_cell_no,$o_address,$registration_no,$scan_code]);
                                    $ownermsg="Owner Created";                
                                    $isvalid="valid";
                                } else {
                                    $ownermsg="Invalid Sticker. Sticker allocated to some other owner.";
                                    $msgResponse=$ownermsg;
                                    $isvalid="Invalid";
                                    
                                    $response = array();
                                    
                                    $response['response'] = 'invalid';
                                    $response['message'] = 'invalid sticker for this user';
                                    echo json_encode($response);
                                    return;                                     
                                            

                                    /*$response['response'] = $isvalid;
                                    $response[] = $isvalid;                                    
                                    if ($isproduction==0) {
                                        
                                        $response['FinalMessage'] = $isvalid;
                                        $response['message'] = $ownermsg;
                                        $response['vehicleparticulars']=$vehicleParticularMsg;
                                        $response['Msgresponse'] =$msgResponse;
                                        $response['msgws']=$msgws;
                                        $response['owner'] =$ownermsg;

                                    }
                                    
                                    echo json_encode($response);
                                    return;*/
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
                                    $isvalid="Valid";

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
                                    $isvalid="valid";                        
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
                                $isvalid="valid"; 
                            }   // end of update vechicle
                            $vehical = DB::select('select Record_no from vehicle_particulars where Registration_no = ? and OwnerCnic=? and stickerserialno=?', [$registration_no,$o_cnic,$scan_code]); 
                            if(!empty($vehical))
                            {
                                $vehicleRecordNo = $vehical[0]->Record_no;} else {$vehicleRecordNo=0;
                                $msgResponse="Vehicle Particulars not updated for registrationno=".$registration_no." cnic=".$o_cnic." scancode=".$scan_code;
                                $isvalid="invalid";  

                                $response['response'] = 'invalid';
                                $response['message'] = 'owner is not registered with this scancode and cnic';
                                echo json_encode($response);
                                return;                                 
                            }                
                        } // end of $stickerStatus
                        else
                        {
                            //$response =array('FinalResponse' => "Invalid Sticker",'VehicleResponse'=>$vehicleParticularMsg,'OwnerResponse'=> $ownermsg,'WorkstationResponse' => $msgws,'VehicleRecordNo' => $vehicleRecordNo);
                            
                            $isvalid="invalid"; 
                            $msgResponse="Sticker not updated in CodeRollsSecondary";
                            $response = array();

                            $response['response'] = 'invalid';
                            $response['message'] = 'sticker does not exists';
                            echo json_encode($response);
                            return; 

                            $response[] = $isvalid;
                           // $response['message'] = $ownermsg;
                            if ($isproduction==0) {             
                                
                                        $response['FinalMessage'] = $isvalid;
                                        $response['message'] = $ownermsg;
                                        $response['vehicleparticulars']=$vehicleParticularMsg;
                                        $response['Msgresponse'] =$msgResponse;
                                        $response['msgws']=$msgws;
                                        $response['owner'] =$ownermsg;
                                        $response['response'] = $isvalid;

                            }
                            echo json_encode($response);
                            return;                 
                        }
                    }   // end of valid workstation
                    else
                    {
                        // invalid workstation
                        $msgws ="InValid workstation ".$stationno." or vehicle category ".$vcat." missing. Cannot update";  
                        $isvalid="InValid";             
                        $response['response'] = 'invalid';
                        $response['message'] = 'invalid workstation or userid or vehicle category';
                        echo json_encode($response);
                        return; 

                    }
                    /*if ($vehicleRecordNo <= 0)
                    {
                        $vehicleParticularMsg =$vehicleParticularMsg.' Vehicle Record No  in table vehicle_particulars cannot be 0';
                        
                        $isvalid="Invalid";
                    }*/
                }        
                else {
                    $ownermsg="record not found in users table. userid=".$userid." stationno=".$stationno;
                    $response['response'] = 'invalid';
                    $response['message'] = 'owner not registered';
                    echo json_encode($response);
                    return; 
                }
                
                //$response = array('FinalResponse' => $msgResponse,'VehicleResponse'=>$vehicleParticularMsg,'OwnerResponse'=> $ownermsg,'WorkstationResponse' => $msgws,'VehicleRecordNo' => $vehicleRecordNo);
                
                $response = array();
                $response['response'] = $isvalid;
               // $response['message'] = $ownermsg;
                if ($isproduction==0) {

                                        $response['FinalMessage'] = $isvalid;
                                        $response['message'] = $ownermsg;
                                        $response['vehicleparticulars']=$vehicleParticularMsg;
                                        $response['Msgresponse'] =$msgResponse;
                                        $response['msgws']=$msgws;
                                        $response['owner'] =$ownermsg;
                                        $response['response'] = $isvalid;

                                        
                }
               
               if ($isvalid="valid"){$response['message'] = "Your inspection particulars updated successfully";}
                echo json_encode($response);
            // } else {
            //     echo 'Inspection API is available for only Mobile Apps';
            // }
        }
    }

    // update cylinders
    public function doUpdateCylinders(Request $r) {
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            //if(!Agent::isMobile()) {
                $response = array();
                $userid = $r['user_id'];
                $code = $r['code'];
                $scan_code = $r['code']; //Additional fields
                $o_cnic = $r['o_cnic'];       // Additional fields
                $totalcylinders = $r['totalcylinderss'];  //Additional fields
                $lastinspectionid = $r['inspectionid']; //Addtitional field. doUpdateCngKit returns this field.
                $workstationid= $r['stationno']; // Additional field.
                $registration_no = $r['registration_no']; //Additional field
                $inspectiondate =  $r['inspectiondate']; //Additional field
                $kitserialno   =$r['cngkitserialno']; //Additional field

                $location_1 = !empty($r['c1_location']) ? $r['c1_location'] : ''; //Additional field
                $standard_1 = !empty($r['c1_iso_model']) ? $r['c1_iso_model'] : '';    //Additional field
                $makenmodel_1 = !empty($r['c1_make_model']) ? $r['c1_make_model'] : '';
                $serialno_1 = !empty($r['c1_serial_no']) ? $r['c1_serial_no'] : '';
                $importdate_1 = $r['c1_import_date']; //Additional field

                $location_2 = !empty($r['c2_location']) ? $r['c2_location'] : ''; //Additional field
                $standard_2 = !empty($r['c2_iso_model']) ? $r['c2_iso_model'] : ''; //Additional field
                $makenmodel_2 = !empty($r['c2_make_model']) ? $r['c2_make_model'] : '';
                $serialno_2 = !empty($r['c2_serial_no']) ? $r['c2_serial_no'] : '';
                $importdate_2 = $r['c2_import_date']; //Additional field

                $location_3 = !empty($r['c3_location']) ? $r['c3_location'] : ''; //Additional field
                $standard_3 = !empty($r['c3_iso_model']) ? $r['c3_iso_model'] : '';   //Additional field      
                $makenmodel_3 = !empty($r['c3_make_model']) ? $r['c3_make_model'] : '';
                $serialno_3 = !empty($r['c3_serial_no']) ? $r['c3_serial_no'] : '';
                $importdate_3 = $r['c3_import_date'];        //Additional field

                $location_4 = !empty($r['c4_location']) ? $r['c4_location'] : ''; //Additional field
                $standard_4 = !empty($r['c4_iso_model']) ? $r['c4_iso_model'] : '';  //Additional field
                $makenmodel_4 = !empty($r['c4_make_model']) ? $r['c4_make_model'] : '';
                $serialno_4 = !empty($r['c4_serial_no']) ? $r['c4_serial_no'] : '';
                $importdate_4 = $r['c4_import_date']; //Additional field

                $location_5 = !empty($r['c5_location']) ? $r['c5_location'] : ''; //Additional field
                $standard_5 = !empty($r['c5_iso_model']) ? $r['c5_iso_model'] : '';    //Additional field     
                $makenmodel_5 = !empty($r['c5_make_model']) ? $r['c5_make_model'] : '';
                $serialno_5 = !empty($r['c5_serial_no']) ? $r['c5_serial_no'] : '';
                $importdate_5 = $r['c5_import_date'];        //Additional field
                
                $location_6 = !empty($r['c6_location']) ? $r['c6_location'] : ''; //Additional field
                $standard_6 = !empty($r['c6_iso_model']) ? $r['c6_iso_model'] : '';        //Additional field
                $makenmodel_6 = !empty($r['c6_make_model']) ? $r['c6_make_model'] : '';
                
                $serialno_6 = !empty($r['c6_serial_no']) ? $r['c6_serial_no'] : '';
                $importdate_6 = $r['c6_import_date']; //Additional field
                $vehicleParticularMsg="null";
                $finalResponse ="invalid";
                $msg ="null";   
                $record_no=0;
                $cylinderserialnocount =0;
                $inspectionStatus='pending';
                $ownermsg="null";
                $msgws="null";
                $stickerCount=0;
                $stickerCnic="0";
                $stickervehicle="0";
                $vehicleRecordNo=0;

                $cylinderlist="";
                $parameters=array();
                $trace="checking sticker status,";
                $isproduction="0";
                 if ($r['isproduction'] )
                {
                    $isproduction =$r['isproduction'];
                    
                }
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
                                                    }
                                                    if (!is_null($serialno_2) && !empty($serialno_2) && isset($serialno_2) ) {   
                                                        $trace=$trace."/ in cylinder2";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 2 ,$serialno_2,$kitserialno,$inspectiondate,$importdate_2,$standard_2,$makenmodel_2,$location_2]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_2;
                                                    }
                                                    if (!is_null($serialno_3) && !empty($serialno_3) && isset($serialno_3) )
                                                    {                       
                                                        $trace=$trace."/ in cylinder3";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 3 ,$serialno_3,$kitserialno,$inspectiondate,$importdate_3,$standard_3,$makenmodel_3,$location_3]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_3;
                                                    }
                                                    if (!is_null($serialno_4) && !empty($serialno_4) && isset($serialno_4) )
                                                    {                        
                                                        $trace=$trace."/ in cylinder4";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 4 ,$serialno_4,$kitserialno,$inspectiondate,$importdate_4,$standard_4,$makenmodel_4,$location_4]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_4;
                                                    }
                                                    if (!is_null($serialno_5) && !empty($serialno_5) && isset($serialno_5) )
                                                    {                       
                                                        $trace=$trace."/ in cylinder5";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 5 ,$serialno_5,$kitserialno,$inspectiondate,$importdate_5,$standard_5,$makenmodel_5,$location_5]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_5;
                                                    }
                                                    if (!is_null($serialno_6) && !empty($serialno_6) && isset($serialno_6) )
                                                    {                        
                                                        $trace=$trace."/ in cylinder6";
                                                        DB::insert('insert into kit_cylinders
                                                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$lastinspectionid, 6 ,$serialno_6,$kitserialno,$inspectiondate,$importdate_6,$standard_6,$makenmodel_6,$location_6]);
                                                        $cylinderserialnocount=$cylinderserialnocount+1;
                                                        $cylinderlist=$cylinderlist.",".$serialno_6;
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
                                                            $Cylinders = DB::SELECT('SELECT count(formid) as UnregisteredCylinders FROM kit_cylinders LEFT JOIN RegisteredCylinders on kit_cylinders.Cylinder_SerialNo = RegisteredCylinders.SerialNumber where formid =? and RegisteredCylinders.Date is null',[$lastinspectionid]);        
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
                                                    //                    $msg ="valid inspection id ".$lastinspectionid." to process ".$totalcylinders." cylinders against vehicle ".$registration_no." with scancode ".$scan_code." with inspection status as ".$inspectionStatus;
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
                                                    else {                                            $msg="Cylinders cound does not match";
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
                    // $response['response'] =$finalResponse;
                }
               
                echo json_encode($response);
            //} else {
            //    echo 'Inspection API is available for only Mobile Apps';
            //}
        }
    }

    // update cng kit
    public function doUpdateCngKit(Request $r) {
        
        if($r['API_Key'] != $this->API_KEY) {
            echo 'API Autorization Failed';
        } else {
            //if(!Agent::isMobile()) {
                $response=array();
                $userid = $r['userid'];
                $code = $r['code'];
                $workstationid= $r['stationno']; //Additional Field
                $cylindernos =$r['totalcylinders']; //Additional Field. Range: 1-6
                $dt1=Carbon::today();            
                $inspectiondate = date('Y-m-d', strtotime($dt1)); // Additional Field calculated automatically.
                $expiryDate=$r['expiryDate']; // Additional Field. must.
                                
                $registration_no = $r['registration_no'];   
                $vehicleRecordNo  = 0; 
                $scan_code = $r['code'];
                $o_cnic = $r['o_cnic'];
                $ck_make_n_model = $r['ck_make_model'];
                $ck_serial_no = $r['ck_serial_no'];
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

               $isproduction="0";
                 if ($r['isproduction'] )
                {
                    $isproduction =$r['isproduction'];
                    
                }



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
                        
                        //print_r($stickerStatus);
                        if (!empty($stickerStatus) && !$stickerStatus->isempty()) {
                            //storing sticker state
                            $stickerCount=$stickerStatus[0]->allocated;             
                            $stickerCnic=$stickerStatus[0]->cnic;
                            $stickervehicle=$stickerStatus[0]->vehicleRegNo;

                            //finding record no from vehicle particulars.
                            $initinspection = DB::SELECT('SELECT vehicle_particulars.Inspection_Status,vehicle_particulars.Record_no FROM vehicle_particulars where Registration_No=? and vehicle_particulars.stationno=? and vehicle_particulars.stickerSerialNo=? and vehicle_particulars.OwnerCnic=?',[$registration_no,$workstationid,$scan_code,$o_cnic]); 
                        //print_r($initinspection);
                        if (!empty($initinspection) && $cylindernos >0 ) {
                            $vehicleRecordNo= $initinspection[0]->Record_no;
                            $trace =$trace."/ finding number of inspections done.";
                            $cngkit = DB::SELECT('select count(CngKitSerialNo) as kitcount from cng_kit where CngKitSerialNo=? and vehicleRecordNo=?',[$ck_serial_no,$vehicleRecordNo]);
                            //print_r($cngkit);
                            $countkits = $cngkit[0]->kitcount; 
                            //-----------------------
                            //echo 'kitcount='.$countkits;
                            //echo 'expiry='.$expiryDate;
                            //echo 'cylindernos='.$cylindernos;
                            //echo 'workstationid='.$workstationid;

                                         
                            //--------------------------
                            
                            if ($countkits==0 && !is_null($expiryDate) && $cylindernos >0 && !is_null($workstationid) &&
                            !is_null($ck_serial_no) && !empty($ck_serial_no) && null !==$ck_serial_no && $initinspection[0]->Inspection_Status=="completed")  //here inspection status was missing
                             {
                                $trace =$trace."/ No inspection found. creating first inspection in cng_kit.";
                                DB::insert('insert into cng_kit(Make_Model,CngKitSerialNo,Cylinder_valve,Filling_valve,Reducer,HighPressurePipe,ExhaustPipe,Workshop_identity,Total_Cylinders,Inspection_Status,VehiclerRegistrationNo,InspectionDate,Location_cylinder,InspectionExpiry,VehicleRecordNo)
                                values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$ck_make_n_model,$ck_serial_no,$ck_is_cylinder_valve,$ck_is_filling_valve,$ck_is_reducer,$ck_is_high_pressure_pipe,$ck_is_exhaust_pipe,$workstationid,$cylindernos,'pending',$registration_no,$inspectiondate,1,$expiryDate,$vehicleRecordNo]); //last value pending

                                $inspection = DB::SELECT('select  formid from  cng_kit where  CngKitSerialNo =?  and  InspectionDate =? and Inspection_Status="pending"',[$ck_serial_no,$inspectiondate]);
                                $inspectionId =$inspection[0]->formid; // it is the auto increament no. retrieving new inspection id
                                DB::table('vehicle_particulars')
                                ->where(['Registration_no'=> $registration_no])
                                ->where(['Record_no'=> $vehicleRecordNo])
                                ->update(['lastinspectionid' => $inspectionId,'Inspection_Status' => 'pending']);                             
                                $finalResponse ="valid";
                                    $msg ="Inspection Created in cng kit";   
                                    
                                    $response['response']="valid";
                                    $response['message'] ="New inspection created";
                                    echo json_encode($response);
                                    return;                                                                
                                    
                            }
                            elseif ($countkits > 0 && !is_null($expiryDate) && $cylindernos >0 && !is_null($workstationid) &&
                                !is_null($ck_serial_no) && !empty($ck_serial_no) && null !== $ck_serial_no) {
                                $trace =$trace."/ many inspections found. checking last completed inspection.";
                                //echo 'getting lastinspection';
                                //$lastinspection = DB::SELECT('SELECT lastinspectionid,cng_kit.Inspection_Status,cng_kit.formid FROM cng_kit LEFT JOIN vehicle_particulars on cng_kit.formid = vehicle_particulars.lastinspectionid and cng_kit.VehicleRecordNo = vehicle_particulars.Record_no where vehiclerRegistrationNo=? and vehicle_particulars.stationno=? and vehicle_particulars.stickerSerialNo=? and vehicle_particulars.OwnerCnic=?',[$registration_no,$workstationid,$scan_code,$o_cnic]);     //switching inspection status to particulars
                                $lastinspection = DB::SELECT('SELECT lastinspectionid,vehicle_particulars.Inspection_Status,cng_kit.formid FROM cng_kit LEFT JOIN vehicle_particulars on cng_kit.formid = vehicle_particulars.lastinspectionid and cng_kit.VehicleRecordNo = vehicle_particulars.Record_no where vehiclerRegistrationNo=? and vehicle_particulars.stationno=? and vehicle_particulars.stickerSerialNo=? and vehicle_particulars.OwnerCnic=?',[$registration_no,$workstationid,$scan_code,$o_cnic]);     

                                if ($lastinspection[0]->Inspection_Status=="completed") {
                                    // we need to create new inspection
                                    $trace =$trace."/ creating new inspection after last completed inspection.";
                                    DB::insert('insert into cng_kit(Make_Model,CngKitSerialNo,Cylinder_valve,Filling_valve,Reducer,HighPressurePipe,ExhaustPipe,Workshop_identity,Total_Cylinders,Inspection_Status,VehiclerRegistrationNo,InspectionDate,Location_cylinder,InspectionExpiry,VehicleRecordNo)
                                    values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$ck_make_n_model,$ck_serial_no,$ck_is_cylinder_valve,$ck_is_filling_valve,$ck_is_reducer,$ck_is_high_pressure_pipe,$ck_is_exhaust_pipe,$workstationid,$cylindernos,'pending',$registration_no,$inspectiondate,1,$expiryDate,$vehicleRecordNo]); //pending

                                    $inspection = DB::SELECT('select  formid from  cng_kit where  CngKitSerialNo =?  and  InspectionDate =? and Inspection_Status="pending"',[$ck_serial_no,$inspectiondate]);
                                    // it is the auto increament no. getting newly created inspection id
                                    $inspectionId =$inspection[0]->formid; 
                                
                                    DB::table('vehicle_particulars')
                                    ->where(['Registration_no'=> $registration_no])
                                    ->where(['Record_no'=> $vehicleRecordNo])
                                    ->update(['lastinspectionid' => $inspectionId,'Inspection_Status' => 'pending']);                             
                                    $finalResponse ="valid";
                                    $msg ="new inspection created..";

                                    $response['response']="valid";
                                    $response['message'] ="New inspection created.";
                                    echo json_encode($response);
                                    return;                                                                                           
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
                                        $finalResponse ="valid";                       
                                        $msg ="CngKit for inspection ".$formid." updated";
                                        
                                        $response['response']="valid";
                                        //$response['message'] ="inspection ".$formid." updated.";
                                        $response['message'] ="Your inspection details for CNG Kit successfully updated";
                                        echo json_encode($response);
                                        return;                                                                                                                        
                                    } // end of cngkit_update                 
                                } // end of last pending transaction           
                            } // last inspection
                        }
                        else  {
                            $finalResponse ="invalid";
                            $msg ="Vechicle Record not found";                    

                            $response['response']="invalid";

                            if ($cylindernos <=0 )
                            {
                                 $response['message'] ="Cylinders must be >=1";
                            }
                            else
                            {
                            $response['message'] ="Vehicle not registered against NIC and Sticker for this station";                                
                            }
                            echo json_encode($response);
                            return;                                                   

                            
                        }
                    }
                    else {           
                        $finalResponse ="invalid";
                        $msg ="Invalid sticker ";     
                        $response['response']="invalid";
                        $response['message'] ="Invalid userid or workstation against this sticker";         
                        echo json_encode($response);
                        return;                                                                                                                         
                    }                       
                } else {
                        $finalResponse ="invalid";
                        $msg ="Invalid workstation ";

                        $response['response']="invalid";
                        $response['message'] ="Invalid userid or workstation against this sticker";         
                        echo json_encode($response);
                        return;                                                                        
                    }
                }

                //---------------------------------------
                
                if ($isproduction==0) {
                $response = array(
                    'finalresponse' => $finalResponse,
                    'msg' => $msg,
                    'inspectionid' => $inspectionId,
                    'trace' => $trace,'totalcylinders'=> $cylindernos
                ); 

                $response = array();
                $response['response'] = strtolower($finalResponse);
                $response['message'] = $msg;                    
                }
                else {
                    //$response['finalresponse'] = $finalResponse;
                }

                echo json_encode($response);
            //} else {
            //    echo 'Inspection API is available for only Mobile Apps';
            //}
        }
    }

}
