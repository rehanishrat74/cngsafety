<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use DateTime;


use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

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
 /*$msg = "This is a simple message.";
    $msg = $data->user ;
      return response()->json(array('msg'=> $msg), 200);*/
      //$users=DB::table('users')->where('name', 'like', '%'.$data->name.'%')->get();      
      //return response()->json(array('msg'=> $msg), 200);


      /*use homestead;
SELECT Record_no,Registration_no,Make_type,lastinspectionid,StickerSerialNo 
FROM homestead.vehicle_particulars where StickerSerialNo ='6XMWFH4G9' and lastinspectionid is not null;
select Cylinder_SerialNo,InspectionDate from kit_cylinders where formid =37;*/

       //$stickerNo = $_GET['stickerNo'];

        $stickerdetails="Code: ".$stickerNo." not found";

        if (!isset($stickerNo))
        {
            $stickerNo="NOtfound";

        }

        if ( !is_null($stickerNo) && !empty($stickerNo) && isset($stickerNo) ) 
        {
            $vehicle=DB::table('vehicle_particulars')      
            ->select('Record_no','Registration_no','Make_type','lastinspectionid','StickerSerialNo' )
            ->where('StickerSerialNo','=',$stickerNo)
            ->where('lastinspectionid','!=',null)
            ->get();

            //print_r($vehicle).'<br>';
            //print_r($vehicle[0]->Record_no);


            if (  isset($vehicle[0]->lastinspectionid)  ) 
            {        
                $cylinders=DB::table('kit_cylinders')      
                ->select('Cylinder_SerialNo','InspectionDate','formid' )
                ->where('formid','=',$vehicle[0]->lastinspectionid)                
                ->get();                
                
                $formid=$cylinders[0]->formid;
                if (isset($formid)  )                 
                {

//                        $cylinderExpiry=$cylinders[0]->InspectionDate;
                    $date = strtotime(date("Y-m-d", strtotime($cylinders[0]->InspectionDate)) . " +60 month");
                    $cylinderExpiry = date("Y-m-d",$date);
                    

                        $stickerdetails="Code:".$stickerNo.". This is <strong>".$vehicle[0]->Make_type."</strong> registration <strong>#".$vehicle[0]->Registration_no."</strong>. carrying cylinders <strong>";

//                        print_r($cylinders);
                        foreach ($cylinders as $cylinder){
                            $stickerdetails=$stickerdetails."#".$cylinder->Cylinder_SerialNo;
                        }




                            //$stickerdetails=$stickerdetails."#232,#2342";

                            $stickerdetails=$stickerdetails."</strong>, duly tested and passed for CNG Kit and cylinder in compliance with requirement of Standard Code of Practice Part III, CNG Safety Ruld: 1992. This inspection expires on <strong> ".$cylinderExpiry."</strong>. It is illegal to refuel untested CNG cylinder. HDIP considers public safety as top priority. For complains and guidelines please dial 051-4901444 or visit our weblink <a href='http://www.hdip.com.pk' target='_blank'>www.hdip.com.pk</a>".", sticker=".$stickerNo;

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
