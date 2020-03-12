<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use DateTime;


use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Response;

class PublicController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function  searchKCcode() {
           // echo 'hello';
        //usage: https://cngsafetypakistan.com/searchkccode?kezzler_code=KO6TIZKM9
             $kezzler_code = Input::get('kezzler_code');
            // echo $kezzler_code;
            if (!empty($kezzler_code)) 
            {
              $record = DB::table('vehicle_particulars')
                        ->select ('*')
                        ->where('stickerSerialNo', '=', $kezzler_code)
                        ->get();
               // print_r($record);
               
               
              if (sizeof($record) == 0) {
                $response_array = array('success' => false, 'message' => 'Following Kezzler Code Not Found, Please Try Again');
                $response_code = 200;
                $response = Response::json($response_array, $response_code);
                return $response;
              } else {
                  //print_r($record);
                  
                   $data = array();
                    $data['station'] = $record[0]->stationno;
                    $data['cnic'] = $record[0]->OwnerCnic;
                    $data['kezzler_code'] = $kezzler_code;
                    $data['registeration'] = $record[0]->Registration_no;
                    $data['make_model'] = $record[0]->Make_type;
                    $data['chassis_no'] = $record[0]->Chasis_no;
              
                     $recordowner = DB::table('owner__particulars')
                        ->select ('*')
                        ->where('cnic', '=',$record[0]->OwnerCnic)
                        ->where ('VehicleReg_No','=', $record[0]->Registration_no)
                        ->get();                    
                    $data['name'] =$recordowner[0]->Owner_name;
                         $data['inspection_date']='';  
                         $data['token_expiry'] ='';    
                        $cylindersarr = array();               
                        $cylinderobj = array();
                    if ($record[0]->Registration_no > 0)
                    {
                         $inspection = DB::table('cng_kit')
                        ->select ('*')
                        ->where('formid', '=',$record[0]->lastinspectionid)
                        ->get();   

                         $data['inspection_date']=$inspection[0]->InspectionDate;  
                         $data['token_expiry'] =$inspection[0]->InspectionExpiry;
   
                         $cylinders  = DB::table('kit_cylinders')
                         ->select ('*')
                         ->where('formid', '=',$record[0]->lastinspectionid)
                         ->get();  

                        foreach ($cylinders as $cylinder) {
                            $cylinderobj = array();
                            $cylinderobj['serial'] = $cylinder->Cylinder_SerialNo;
                            $cylinderobj['inspection_expiry'] =$inspection[0]->InspectionExpiry; // $cylinder->ExpiryDate;
                           // array_push($cylindersarr, $cylinderobj);
                            }
                        //$data['cylinders'] = $cylindersarr;                         
                    }
  array_push($cylindersarr, $cylinderobj);
   $data['cylinders'] = $cylindersarr;   

                    
                    $response_array = array('success' => true, 'data' => $data);
                    $response_code = 200;
                    $response = Response::json($response_array, $response_code);
                    return $response;
                    
                }
            }else {
            $response_array = array('success' => false, 'message' => 'Kezzler Code Not provided, Please Try Again');
            $response_code = 200;
            $response = Response::json($response_array, $response_code);
            return $response;
                    }
        }
  public function getcities(Request $data) {
      //print_r($data);
    //alert('in function');
    //->select(DB::raw('CONCAT("<option value=", city ,">", city, "</option>") AS city'))
      $cities=DB::table('cities')      
      ->select('city')
      ->where('province','=',$data->name)
      ->get();

      return response()->json($cities, 200);
  }

public function setCookie(Request $request){

  
    $cname=$request["post"]["cname"];//pagesize,vehicleType,inspectionType
    $cvalue=$request["post"]["cvalue"];//pagesize value
    $expiry=$request["post"]["exdays"];//expiry


    if ($cname=='pagesize') {
        session()->put('pagesize')==$cvalue;
    }
    $response=response('created')->withCookie(cookie($cname, $cvalue, $expiry));

    return $response;
}
/*public function dologinaccess(Request $data){
    
     $id =str_replace("act_","",$data->id);

    if ($data->name=="1")
    {
                    DB::table('users')
                        ->where(['id'=> $id])
                        ->update(['activated' => 1
                                ]);   

        $credentials=DB::table('users')
          ->select(['email','encpwd','regtype'])
          ->where(['id'=> $id])
          ->get();                

        $pwd= Crypt::decryptString($credentials[0]->encpwd);
        $msg ="Your login credentials are: login id = ".$credentials[0]->email. " and password=".$pwd ;                 

        if ($credentials[0]->regtype=="workshop")
        {
        $msg ="Your login credentials are: login id = ".$credentials[0]->email. " and password=".$pwd.". You can download the app from ".env('App_Link') ;
        } 

    }
    
    $status="id=".$id." data->name=".$data->name;
    //Mail::to($data['email'])->send(new WelcomeMail($user,$msg));
    Mail::to($credentials[0]->email)->send($msg);
    
    return response()->json("login credentials sent at ".$credentials[0]->email, 200);
}*/
public function DisableLoginAccess ($userid){

}

    public function searchSticker($stickerNo) {


        $stickerdetails="Code: ".$stickerNo." not found.";

        if (!isset($stickerNo))
        {
            $stickerNo="Not Found";

        }

        if ( !is_null($stickerNo) && !empty($stickerNo) && isset($stickerNo) ) 
        {
            $vehicle=DB::table('vehicle_particulars')      
            ->select('Record_no','Registration_no','Make_type','lastinspectionid','StickerSerialNo' )
            ->where('StickerSerialNo','=',$stickerNo)
            ->get();

            
    $stickerdetails="Sticker:".$stickerNo.". This is <strong>".$vehicle[0]->Make_type."</strong> registration <strong>#".$vehicle[0]->Registration_no."</strong>. Inspection Pending."; 


            if (  isset($vehicle[0]->lastinspectionid)  ) 
            {  
              
                $cylinders=DB::table('kit_cylinders')      
                ->select('Cylinder_SerialNo','InspectionDate','formid' )
                ->where('formid','=',$vehicle[0]->lastinspectionid)                
                ->get();    
   

                $formid=$cylinders[0]->formid;

                if (isset($formid)  )                 
                {

                    $date = strtotime(date("Y-m-d", strtotime($cylinders[0]->InspectionDate)) . " +60 month");
                    $cylinderExpiry = date("Y-m-d",$date);

                   // str_replace("carrying cylinders <strong>"," Inspection Pending.",$stickerdetails);

                        foreach ($cylinders as $cylinder){
                            $stickerdetails=$stickerdetails."#".$cylinder->Cylinder_SerialNo;
                        }


                            $stickerdetails=$stickerdetails."</strong>, duly tested and passed for CNG Kit and cylinder in compliance with requirement of Standard Code of Practice Part III, CNG Safety Ruld: 1992. This inspection expires on <strong> ".$cylinderExpiry."</strong>. It is illegal to refuel untested CNG cylinder. HDIP considers public safety as top priority. For complains and guidelines please dial 051-4901444 or visit our weblink <a href='http://www.hdip.com.pk' target='_blank'>www.hdip.com.pk</a>";

                }

            }

        }

      
    return response()->json($stickerdetails, 200);
  }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
