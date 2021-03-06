<?php
use Intervention\Image\ImageManagerStatic as Image;
namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Image;
use App\Rules\engravedCylinderno;
use App\Rules\engravedCylindernoUpdate;
use File;
use DateTime;
use Cookie;
class CylindersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);


        $results = DB::SELECT('select Location_id,Location_name FROM cylinder_locations order by Location_id;');        

        return view('vehicle.cylinders',['cylinder_locations'=>$results,'treeitems'=>$treeitems]);
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
    public function createcylinder($id)
    {

        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);


        $results = DB::SELECT('select Location_id,Location_name FROM cylinder_locations order by Location_id;');        
        //$newvehicle=array([$id]);
        $recordid=Request("recordid");
        $stationno=DB::SELECT('select stationno,stickerSerialNo FROM vehicle_particulars where Record_no=?',[$recordid]);
        
        return view('vehicle.cylinders',['cylinder_locations'=>$results,'newvehicle'=>$id,'treeitems'=>$treeitems,'stationno'=>$stationno ]);        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function setEntryDateAttribute($input)
    {
        //$this->attributes['entry_date'] = 
          //Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');

          //$this->attributes['entry_date'] = 
          return Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
    }
    public function store(Request $cylinderRequest)
    {

//echo 'here';
        //dd($request);
        
        $kitfields =array('kitmnm' => 'required','kitseriano' => 'required');
        
        $cylinderfields=array();
        $cylinderfield=array();
        $cylindernos= $cylinderRequest->input('cylindernos');
//echo 'cylinder nos ='.$cylindernos;
//return;
       for ($count=1 ;$count<= $cylindernos;++$count){
       
            $cylinderfield = array('makenmodel_C'.$count =>'required',
                                    'serialno_C'.$count => 'required',
                                    'importdate_C'.$count=>'required',
                                    'scancode_C'.$count=>'required'
                                    );
            $cylinderfields=array_merge($cylinderfields,$cylinderfield);
        }
        
 $kitfields=array_merge($kitfields,$cylinderfields);
$this->validate($cylinderRequest,$kitfields);

//dd($kitfields);
            $recordid= $cylinderRequest->record_id;
            $location = 1; //$request->input('location');
            $cylindernos= $cylinderRequest->input('cylindernos');
            $vregno= $cylinderRequest->input('vregno');
            $kitmnm = $cylinderRequest->input('kitmnm');
            $kitseriano=$cylinderRequest->input('kitseriano');
            $workstationid=$cylinderRequest->input('workstationid');

            $cylindervalve=$cylinderRequest->input('cylindervalve');
            $fillingvalve=$cylinderRequest->input('fillingvalve');
            $Reducer=$cylinderRequest->input('Reducer');
            $hpp=$cylinderRequest->input('hpp');
            $exhaustpipe=$cylinderRequest->input('exhaustpipe');


            $dt1=Carbon::today();
            
            $inspectiondate = date('Y-m-d', strtotime($dt1));

            //$dt1 = Carbon::today()->addMonths(12);
            $dt=Carbon::today();
            $expiryDate=date('Y-m-d', strtotime($dt->year.'-'.'12-31'));

             $makenmodel_1=$cylinderRequest->input('makenmodel_C1').'';
             $serialno_1=$cylinderRequest->input('serialno_C1').'';
             $dt1=$cylinderRequest->input('importdate_C1').'';
             $importdate_1=date('Y-m-d', strtotime($dt1));
             $scancode_1=$cylinderRequest->input('scancode_C1').'';
             $location_1 = $cylinderRequest->input('location_C1');

             $makenmodel_2=$cylinderRequest->input('makenmodel_C2').'';
             $serialno_2  =$cylinderRequest->input('serialno_C2').'';
             $importdate_2=$cylinderRequest->input('importdate_C2').'';
             $importdate_2=date('Y-m-d', strtotime($dt1));
             $scancode_2=$cylinderRequest->input('scancode_C2').'';
             $location_2 = $cylinderRequest->input('location_C2');

             $makenmodel_3=$cylinderRequest->input('makenmodel_C3').'';
             $serialno_3=$cylinderRequest->input('serialno_C3').'';
             $dt1=$cylinderRequest->input('importdate_C3').'';
             $importdate_3=date('Y-m-d', strtotime($dt1));
             $scancode_3=$cylinderRequest->input('scancode_C3').'';
             $location_3 = $cylinderRequest->input('location_C3');

             $makenmodel_4=$cylinderRequest->input('makenmodel_C4').'';
             $serialno_4 =$cylinderRequest->input('serialno_C4').'';
             $dt1=$cylinderRequest->input('importdate_C4').'';
             $importdate_4=date('Y-m-d', strtotime($dt1));             
             $scancode_4=$cylinderRequest->input('scancode_C4').'';
             $location_4 = $cylinderRequest->input('location_C4');


             $makenmodel_5=$cylinderRequest->input('makenmodel_C5').'';
             $serialno_5=$cylinderRequest->input('serialno_C5').'';
             $dt1=$cylinderRequest->input('importdate_C5').'';
             $importdate_5=date('Y-m-d', strtotime($dt1));
             $scancode_5=$cylinderRequest->input('scancode_C5').'';
             $location_5 = $cylinderRequest->input('location_C5');


             $makenmodel_6=$cylinderRequest->input('makenmodel_C6').'';
             $serialno_6=$cylinderRequest->input('serialno_C6').'';
             $dt1=$cylinderRequest->input('importdate_C6').'';
             $importdate_6=date('Y-m-d', strtotime($dt1));
             $scancode_6 =$cylinderRequest->input('scancode_C6').'';
             $location_6 = $cylinderRequest->input('location_C6');


             $registeredserialno = 1;

             
             

            $cylinderserialnocount=0;
            $formid=0;

            $results = DB::SELECT('select count(CngKitSerialNo) as kitcount from cng_kit where CngKitSerialNo=? and InspectionDate=?',[$kitseriano,$inspectiondate]);
            $countkits=$results[0]->kitcount;

            if ($countkits==0 &&
                !is_null($kitseriano) && !empty($kitseriano) && isset($kitseriano) &&
                !is_null($inspectiondate) && !empty($inspectiondate) && isset($inspectiondate)
            ) 
            {
 
                DB::insert('insert into cng_kit(Make_Model,CngKitSerialNo,Cylinder_valve,Filling_valve,Reducer,HighPressurePipe,ExhaustPipe,Workshop_identity,Total_Cylinders,Inspection_Status,VehiclerRegistrationNo,InspectionDate,Location_cylinder,InspectionExpiry,VehicleRecordNo)
                values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$kitmnm,$kitseriano,$cylindervalve,$fillingvalve,$Reducer,$hpp,$exhaustpipe,$workstationid,$cylindernos,'pending',$vregno,$inspectiondate,$location,$expiryDate,$recordid]);


                $results = DB::SELECT('select  formid from  cng_kit where  CngKitSerialNo =?  and  InspectionDate =?',[$kitseriano,$inspectiondate]);
                $formid =$results[0]->formid;



                    $imgRegPlate='filenotfound';
                    $extensionimgRegPlate;
                    $base64imageimgRegPlate;

                    if($cylinderRequest->hasfile('imgRegPlate')){

                        $imgRegPlate=$cylinderRequest->file('imgRegPlate');
                        $extensionimgRegPlate=$imgRegPlate->getClientOriginalExtension(); //image type

                         $imageStr = (string) Image::make( $imgRegPlate )->
                                                 resize( 300, null, function ( $constraint ) {
                                                     $constraint->aspectRatio();
                                                 })->encode( $extensionimgRegPlate );

                        $base64imageimgRegPlate = base64_encode( $imageStr );        

                    }

                    


                    $imgWndScreen='filenotfound';
                    $extensionimgWndScreen;
                    $base64imageextensionimgWndScreen;

                    if($cylinderRequest->hasfile('imgWndScreen')){

                        $imgWndScreen=$cylinderRequest->file('imgWndScreen');
                        $extensionimgWndScreen=$imgWndScreen->getClientOriginalExtension(); //image type

                         $imageStr = (string) Image::make( $imgWndScreen )->
                                                 resize( 300, null, function ( $constraint ) {
                                                     $constraint->aspectRatio();
                                                 })->encode( $extensionimgWndScreen );

                        $base64imageextensionimgWndScreen = base64_encode( $imageStr );        
                        
                    }



                if ($imgRegPlate!='filenotfound')
                {
                    /*field name: RegistrationPlate_Pic
                    field name: RegistrationPlate_Pic_imagetype

                    data to store: $extensionimgRegPlate;        
                    data to store: $base64imageimgRegPlate;*/
                    DB::table('cng_kit')
                        ->where(['VehiclerRegistrationNo'=> $vregno])
                        ->where(['formid'=> $formid])
                        ->where(['CngKitSerialNo'=> $kitseriano])
                        ->where(['InspectionDate'=>$inspectiondate])
                        ->update(['RegistrationPlate_Pic' => $base64imageimgRegPlate,
                                  'RegistrationPlate_Pic_imagetype' =>$extensionimgRegPlate
                                ]);                    
                }




                if ($imgWndScreen!='filenotfound')
                {
                    /*field name: WindScreen_Pic
                    field name: WindScreen_Pic_imagetype       

                    data to stroe: $extensionimgWndScreen;
                    data to stroe: $base64imageextensionimgWndScreen;*/
                    DB::table('cng_kit')
                        ->where(['VehiclerRegistrationNo'=> $vregno])
                        ->where(['formid'=> $formid])
                        ->where(['CngKitSerialNo'=> $kitseriano])
                        ->where(['InspectionDate'=>$inspectiondate])
                        ->update(['WindScreen_Pic' => $base64imageextensionimgWndScreen,
                                  'WindScreen_Pic_imagetype' =>$extensionimgWndScreen
                                ]);                                        
                }



                if (!is_null($formid) && !empty($formid) && isset($formid) && 
                    !is_null($kitseriano) && !empty($kitseriano) && isset($kitseriano) &&
                    !is_null($inspectiondate) && !empty($inspectiondate) && isset($inspectiondate)
                    )
                {
                    
                
                    if (!is_null($serialno_1) && !empty($serialno_1) && isset($serialno_1) )
                    {
                        

                        DB::insert('insert into kit_cylinders
                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderLocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$formid, 1 ,$serialno_1,$kitseriano,$inspectiondate,$importdate_1,$scancode_1,$makenmodel_1,$location_1]);

                            $cylinderserialnocount=$cylinderserialnocount+1;

                            

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_1,$inspectiondate,$makenmodel_1]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;

                        }



                    }               
                    
                    if (!is_null($serialno_2) && !empty($serialno_2) && isset($serialno_2) )
                    {
                        DB::insert('insert into kit_cylinders
                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderlocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$formid, 2 ,$serialno_2,$kitseriano,$inspectiondate,$importdate_2,$scancode_2,$makenmodel_2,$location_2]);
                        $cylinderserialnocount=$cylinderserialnocount+1;

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_2,$inspectiondate,$makenmodel_2]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;

                        }

                    }

                    if (!is_null($serialno_3) && !empty($serialno_3) && isset($serialno_3) )
                    {
                        DB::insert('insert into kit_cylinders
                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderlocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$formid, 3 ,$serialno_3,$kitseriano,$inspectiondate,$importdate_3,$scancode_3,$makenmodel_3,$location_3]);
                        $cylinderserialnocount=$cylinderserialnocount+1;


                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_3,$inspectiondate,$makenmodel_3]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;

                        }                        

                    }
                    if (!is_null($serialno_4) && !empty($serialno_4) && isset($serialno_4) )
                    {
                        DB::insert('insert into kit_cylinders
                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderlocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$formid, 4 ,$serialno_4,$kitseriano,$inspectiondate,$importdate_4,$scancode_4,$makenmodel_4,$location_4]);
                        $cylinderserialnocount=$cylinderserialnocount+1;


                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_4,$inspectiondate,$makenmodel_4]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;

                        }                        
                    }

                    if (!is_null($serialno_5) && !empty($serialno_5) && isset($serialno_5) )
                    {
                        DB::insert('insert into kit_cylinders
                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderlocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$formid, 5 ,$serialno_5,$kitseriano,$inspectiondate,$importdate_5,$scancode_5,$makenmodel_5,$location_5]);
                        $cylinderserialnocount=$cylinderserialnocount+1;

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_5,$inspectiondate,$makenmodel_5]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;

                        }

                    }
                    if (!is_null($serialno_6) && !empty($serialno_6) && isset($serialno_6) )
                    {
                        DB::insert('insert into kit_cylinders
                        (formid, Cylinder_no ,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,ImportDate,Standard,Make_Model,cylinderlocation) VALUES (?,?,?,?,?,?,?,?,?) ',[$formid, 6 ,$serialno_6,$kitseriano,$inspectiondate,$importdate_6,$scancode_6,$makenmodel_6,$location_6]);
                        $cylinderserialnocount=$cylinderserialnocount+1;

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_6,$inspectiondate,$makenmodel_6]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;

                        }                        
                    }
                } //end of kit_cylinders
                    
                    $inspectionStatus='pending';

                    if ($cylinderserialnocount == $cylindernos)
                    {   


                        $images=DB::table('cng_kit')    
                        ->select('WindScreen_Pic','RegistrationPlate_Pic')                    
                        ->where(['formid'=> $formid])
                        ->get();
       
                        if ($registeredserialno==1 && $images[0]->WindScreen_Pic && $images[0]->RegistrationPlate_Pic)
                            {
                                $inspectionStatus='completed';

                            }
                        
                    }





                    DB::table('vehicle_particulars')
                        //->where() rehan is working here.
                        ->where('Registration_no','=',$vregno)
                        ->where('Record_no','=',$recordid)
                        //->where('Record_no','=',$recordid)
                        ->update(['lastinspectionid'=>$formid,'Inspection_Status'=>$inspectionStatus]);                        



            } // end if ($countkits==0) 



        $usertype =Auth::user()->regtype;
        $sortby="Record_no";



        if ($usertype =='workshop')
        {
        $vehicles = DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');

                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate','cng_kit.InspectionExpiry')
                    ->where('vehicle_particulars.stationno','=',Auth::user()->stationno)
                    ->orderby($sortby,'desc')            
                    ->paginate(10);                        
        }
        else
        {
          $vehicles = DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');

                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate','cng_kit.InspectionExpiry')            
                    ->orderby($sortby,'desc')            
                    ->paginate(10);                        

        }



        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            

            return view ('vehicle.registrations',compact('vehicles','treeitems'));            
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
        $iform=DB::SELECT('select formid,CngKitSerialNo,InspectionDate,Make_Model,
                IF(isnull(Cylinder_valve),"off",Cylinder_valve) as Cylinder_valve,
                IF(isnull(Filling_valve),"off",Filling_valve) as Filling_valve,
                IF(isnull(Reducer),"off",Reducer) as Reducer,
                IF(isnull(HighPressurePipe),"off",HighPressurePipe) as HighPressurePipe,
                IF(isnull(ExhaustPipe),"off",ExhaustPipe) as ExhaustPipe,
                Workshop_identity,Total_Cylinders,Inspection_Status,VehiclerRegistrationNo,Location_cylinder,CL.Location_name,InspectionExpiry,kit.RegistrationPlate_Pic,kit.RegistrationPlate_Pic_imagetype,kit.WindScreen_Pic,kit.WindScreen_Pic_imagetype 
                from  cng_kit kit left join cylinder_locations CL
                on kit.Location_cylinder=CL.Location_id
                where kit.formid=?
                ',[$id]);
        //echo 'show editable form='.$id;


  
          $cylinders=DB::Table('kit_cylinders')
                    ->leftjoin('vehicle_particulars',function($join){
                        $join->on('vehicle_particulars.lastinspectionid','=','kit_cylinders.formid');
                    })
                    ->select('formid','Cylinder_SerialNo','CngKitSerialNo','InspectionDate','Cylinder_no','ImportDate','Standard','Make_Model','StickerSerialNo')
                    ->where('formid','=',$id)
                    ->get();


        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        return view ('vehicle.showcylinder',['InspectionForm'=>$iform,'Cylinders'=>$cylinders,'treeitems'=>$treeitems ]);
    }

    public function getAvailableBrands()
    {
        $brandsDB=array(
            "brand1"=>array("brandName"=>"Associate High Pressure Technologies Pvt
Ltd (India)",
                  "dimensions"=>array(                        
                        array("diameter"=>"267 mm","wlc"=>"20/30/40/41/50/55/60/75/80/90"),
                        array("diameter"=>"280 mm","wlc"=>"20/30/40/41/50/55/60/75/80/90"),
                        array("diameter"=>"317 mm","wlc"=>"20/30/40/41/50/55/60/75/80/90")
                            )
                ),
             "brand2"=>array("brandName"=>"Beijing Tianhai Industrial Co (BTIC)",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"20/30 to 85/45 to 130/50 to 140"),
                        array("diameter"=>"273 mm","wlc"=>"20/30 to 85/45 to 130/50 to 140"),
                        array("diameter"=>"280 mm","wlc"=>"20/30 to 85/45 to 130/50 to 140"),
                        array("diameter"=>"325 mm","wlc"=>"20/30 to 85/45 to 130/50 to 140")                      
                            )
                ),  
             "brand3"=>array("brandName"=>"BKC",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"30 to 85/45 to 130/50 to 140")
                            )
                ),               
             "brand4"=>array("brandName"=>"*Cidegas",
                  "dimensions"=>array(
                        array("diameter"=>"316 mm","wlc"=>"45 to 60"),
                        array("diameter"=>"267 mm","wlc"=>"20/30/50/55/60/55/90")
                            )
                ),  
             "brand5"=>array("brandName"=>"Cilbras",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"40/50/55/58/60"),
                        array("diameter"=>"324 mm","wlc"=>"62")
                            )
                ),                 
             "brand6"=>array("brandName"=>"Dalmine spa",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"30/40/50/55/58/60/62"),
                        array("diameter"=>"324 mm","wlc"=>"62"),
                        array("diameter"=>"340 mm","wlc"=>"50")
                            )
                ),
             "brand7"=>array("brandName"=>"EICC",
                  "dimensions"=>array(
                        array("diameter"=>"324 mm","wlc"=>"62")
                            )
                ),                              
             "brand8"=>array("brandName"=>"EKC",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"30/37/40/45/50/55/60/65/70/80/90/95/100"),
                    array("diameter"=>"316 mm","wlc"=>"40/45/50/55/60/65/70/75/80/85/90/95/100/110/120/130/140"),
                    array("diameter"=>"356 mm","wlc"=>"55/58/60/62/64/65/70/73/80/85/90/95/100/110/120/130/145/152")
                            )
                ),
             "brand9"=>array("brandName"=>"EKC-India",
                  "dimensions"=>array(
                        array("diameter"=>"324 mm","wlc"=>"62")
                            )
                ),                          
             "brand10"=>array("brandName"=>"EKC-UAE",
                  "dimensions"=>array(
                        array("diameter"=>"324 mm","wlc"=>"62")
                            )
                ),                                       
              "brand11"=>array("brandName"=>"Euro, India cylinders ltd",
                  "dimensions"=>array(
                        array("diameter"=>"232 mm","wlc"=>"20/22"),
                        array("diameter"=>"267 mm","wlc"=>"40/50/55/60/80"),
                        array("diameter"=>"316 mm","wlc"=>"50/55/60")
                            )
                ),                
            
              "brand12"=>array("brandName"=>"Everest Kanto Cylinder Ltd",
                  "dimensions"=>array(
                        array("diameter"=>"232 mm","wlc"=>"21.5/22/24/25/28/30/35/40/45/50/55/60/65/70/75/80"),
                        array("diameter"=>"267 mm","wlc"=>"30/34/40/48/49/50/55/60/65/70/75/80/85/90/95/100")
                       )
                ),  
                
                "brand13"=>array("brandName"=>"Faber Industries",
                  "dimensions"=>array(
                        array("diameter"=>"228 mm","wlc"=>"20/30"),
                        array("diameter"=>"267 mm","wlc"=>"40"),
                        array("diameter"=>"313.6 mm","wlc"=>"55/60"),
                        array("diameter"=>"316 mm","wlc"=>"65/70/75/80/85/90/95/100")
                            )
                ),  
                "brand14"=>array("brandName"=>"Faber",
                  "dimensions"=>array(
                        array("diameter"=>"228 mm","wlc"=>"20/30"),
                        array("diameter"=>"267 mm","wlc"=>"40"),
                        array("diameter"=>"313.6 mm","wlc"=>"55/60"),
                        array("diameter"=>"316 mm","wlc"=>"65/70/75/80/85/90/95/100")
                            )
                ),                
                "brand15"=>array("brandName"=>"Inflex",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"30 to 85/45 to 130/50 to 140")
                            )
                ),     
                "brand16"=>array("brandName"=>"*Inpencil",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"30/40/50/55/58/60/62/other"),
                        array("diameter"=>"273 mm","wlc"=>"30/40/50"),
                        array("diameter"=>"280 mm","wlc"=>"55"),
                        array("diameter"=>"340 mm","wlc"=>"50"),             
                            )
                ),                         
                "brand17"=>array("brandName"=>"*Inprocil S.A",
                  "dimensions"=>array(
                        array("diameter"=>"273 mm","wlc"=>"40"),
                        array("diameter"=>"280 mm","wlc"=>"55")             
                            )
                ), 
                "brand18"=>array("brandName"=>"Kioshi compression",
                  "dimensions"=>array(
                        array("diameter"=>"280 mm","wlc"=>"55")
                            )
                ) ,
             "brand19"=>array("brandName"=>"*Lizer Cylinders Limited",
                  "dimensions"=>array(
                        array("diameter"=>"317 mm","wlc"=>"30/50/55"),
                        array("diameter"=>"267 mm","wlc"=>"30/50/55")
                            )
                ),                              
             "brand20"=>array("brandName"=>"*M/s. International Gas Vessels Industries (IGVI)",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"40 to 80"),
                        array("diameter"=>"232 mm","wlc"=>"18 to 30"),
                        array("diameter"=>"273 mm","wlc"=>"40 to 80"),    
                            )
                ),                                                                  
            "brand21"=>array("brandName"=>"Marutti 5000/h",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"50")
                            )
                ),               
            "brand22"=>array("brandName"=>"*Maruti Koatsu Cylinder (Pvt) Ltd",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"50/55/60"),
                        array("diameter"=>"323 mm","wlc"=>"50"),
                        array("diameter"=>"325 mm","wlc"=>"50"),
                            )
                ),   
            "brand23"=>array("brandName"=>"M/s. Mat S/A",
                  "dimensions"=>array(
                        array("diameter"=>"324 mm","wlc"=>"62")
                            )
                ),          
            "brand24"=>array("brandName"=>"*Nitin Cylinders (Pvt) Ltd",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"41/50/55/60/62/70/90"),
                        array("diameter"=>"273 mm","wlc"=>"41/50/55/60/62/70/90"),
                        array("diameter"=>"280 mm","wlc"=>"41/50/55/60/62/70/90"),
                        array("diameter"=>"325 mm","wlc"=>"30/40/41/50/55/60/62/70/90"),
                            )
                ),                               
             "brand25"=>array("brandName"=>"*Rama Cylinders (Pvt) Ltd",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"40/50/55/58/60/70/90"),
                        array("diameter"=>"280 mm","wlc"=>"50/60/90"),                  
                        array("diameter"=>"317 mm","wlc"=>"50/90"),
                        array("diameter"=>"323 mm","wlc"=>"50 to 140"),
                        array("diameter"=>"340 mm","wlc"=>"20/40/41/50/55/60/75/80")
                            )
                ),
             "brand26"=>array("brandName"=>"RCL",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"50/60"),
                        array("diameter"=>"280 mm","wlc"=>"50/60"),                  
                        array("diameter"=>"317 mm","wlc"=>"50/60"),
                        array("diameter"=>"323 mm","wlc"=>"50/60"),
                        array("diameter"=>"340 mm","wlc"=>"50/60")

                            )
                ),             
             "brand27"=>array("brandName"=>"Washington Cylinder",
                  "dimensions"=>array(
                        array("diameter"=>"267 mm","wlc"=>"30 to 85/45 to 130/50 to 140")
                            )
                ),   
                  
        );         

        return $brandsDB;
    }
    public function testcylindersdataentryform()
    {
        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        $countries=DB::select(DB::raw('select distinct countries from worldcountries order by countries asc'));

        $email=Auth::user()->email;
        $brandStructures=$this->getAvailableBrands();

        return view ('vehicle.InspectedCylinders',['treeitems'=>$treeitems,'countries'=>$countries,'brandStructures'=>$brandStructures]);
    }


    public function transferStickers()
    {
        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        $batches=DB::select(DB::raw('select batchid,user,filename from CodeRollsPrimary where batchid in (SELECT distinct batchid FROM CodeRollsSecondary where allotedto is null) order by filename asc'));

                        
        $workshops = DB::select(DB::raw('select id,name,email,stationno,province,city,address,contactno from users where regtype ="workshop"  and deleted =0 and activated=1 and cellverified=1 order by name asc'));


        return view ('vehicle.allotedserials',['treeitems'=>$treeitems,'batches'=>$batches,'workshops'=>$workshops]);
    }

/*
            $msg="Cylinder Record no ".$id.' added.';
          return redirect()->back()->with('message', $msg)
                                    ->with ('registeredcylinders',$serialnos)  ;              
*/

    public function saveStickers(Request $request)
    {

        $this->validate($request,array(
            'batch'=>'required',
            'workshop'=>'required'
        ));


        $batchid = $request->batch;        
        $workshopemail= $request->workshop;    



        if (!is_null($batchid) && !empty($batchid) && isset($batchid) &&
            !is_null($workshopemail) && !empty($workshopemail) && isset($workshopemail))
            {

                DB::table('CodeRollsSecondary')
                ->where('batchid','=', $batchid)
                ->update (['allotedto'=>$workshopemail]);
            }

        
          $msg="Batchid [".$batchid."] alloted to workshop registered with email [".$workshopemail."]" ;
          //return redirect()->back()->with('message', $msg)
                                    //->with ('registeredcylinders',$serialnos)  ;              

          return redirect()->back()->with('message', $msg);              

    }


public function showUploadFile(Request $request) {
      $file = $request->file('uploadserials');
      $filename = $file->getClientOriginalName();
            $msg="No records entered" ;
      //Display File Name
      //echo 'File Name: '.$file->getClientOriginalName();
      //echo '<br>';
   
      //Display File Extension
      echo 'File Extension: '.$file->getClientOriginalExtension();
      echo '<br>';
   
      //Display File Real Path
      echo 'File Real Path: '.$file->getRealPath();
      echo '<br>';
   
      //Display File Size
      echo 'File Size: '.$file->getSize();
      echo '<br>';
   
      //Display File Mime Type
      echo 'File Mime Type: '.$file->getMimeType();
   
      //Move Uploaded File
      //$destinationPath = 'uploads';
      //$file->move($destinationPath,$file->getClientOriginalName());

      $content = File::get($file);


        $str_arr = explode ("\r\n", $content);  
        
        
        $dt=Carbon::today();
        $Date=date('Y-m-d', strtotime($dt));
        
//print_r($str_arr);
                      
             $batches=DB::SELECT('select count(batchid) as batchcount
                from CodeRollsPrimary where filename =?',[$filename]);                     
            //print_r($batches[0]->batchcount);

            if ($batches[0]->batchcount ==0 )
            {
                DB::insert('insert into CodeRollsPrimary
                (date,user,filename) VALUES (?,?,?) ',[$Date,'admin',$filename]);
                        $batchid = DB::getPdo()->lastInsertId();
                //$msg = $msg.$batchid;

                foreach ($str_arr as $i => $SerialNo) {
                    # code...
                    //echo $i."<br>";
                    //echo $SerialNo."<br>";
                    //echo "length of serial no ".strlen("$SerialNo");
                    if (strlen("$SerialNo") > 3)
                    {
                        $serialExistss=DB::SELECT('select count(serialno) as serialcount
                        from CodeRollsSecondary where serialno =?',[$SerialNo]); 
                        //echo "serial count=".$serialExistss[0]->serialcount."<br>";

                        if ($serialExistss[0]->serialcount ==0 )
                        {
                            DB::insert('insert into CodeRollsSecondary
                            (batchid,serialno) VALUES (?,?) ',[$batchid,$SerialNo]);
                            //echo "serial no inserted".$SerialNo."<br>";
                        }                                            

                    }



                }   
                $msg=$filename." saved" ;                      
            }
        
        //echo $str_arr[0];

          return redirect()->back()->with('message', $msg);              



   }



    public function savetestcylinders(Request $request)
    {
//https://regexr.com/

        $labUser =Auth::user()->email;
        $BrandName=$request->input('hiddenbrandname'); // $request->input('brand');
        $CountryOfOrigin=$request->input('CountryOfOrigin');        
        $this->validate($request,array(
            'CountryOfOrigin'=>'required',
            'brand'=>'required',
            'standard'=>'required',
            'SerialNo'=>['required',new engravedCylinderno($request->input('SerialNo'),$labUser,$BrandName,$CountryOfOrigin) ],
            'edate'=>'required',  //inspection date
            'expiry'=>'required',  //expiry date
            'method'=>'required',
             'ocnic'=>'nullable|regex:/(^([\d]{5}-[\d]{7}-[\d])$)/',
             'certificate'=>'nullable',
            'ddmanufacture'=>['required'],
            //'ddmanufacture'=>['required','regex:/(^(19|20)\d\d-0[1-9]|1[012]-(0[1-9]|[12][0-9]|3[01])$)/'],
            //'ocnic' =>['regex:/(^([\d]{5}-[\d]{7}-[\d])$)/'],
        ));


$ownername=$request->input('oname');
$vehicleRegNo=$request->input('oreg');
$ocnic=$request->input('ocnic');
$certificate=$request->input('certificate');

    

            $Standard=$request->input('standard');
            $SerialNumber=$request->input('SerialNo');            
            $dt1=$request->input('edate');   //inspection date
            $Date=date('Y-m-d', strtotime($dt1));
            
            $method=$request->input('method');



            $diameter=$request->input('diameter');
            //$length=$request->input('length');
            $length=0;
            $capacity=$request->input('capacity');
            $notes=$request->input('notes');
            //$inspector=$request->input('inspector');
            $inspector="not available"; 
            $manufacturedate=date('Y-m-d',strtotime($request->input('domyear').'/'.$request->input('dommonth').'/'.$request->input('domday')));

            //---------setting inspection expiry date ---------------------

            /*
            // following code when not using dtpicker but textbox.
            $eyear= $request->year;
            $emonth= $request->month;
            $eday= $request->day;
            $exdate=$eday."/".$emonth."/".$eyear;           

            // Parse a date using a user-defined format
            //$expirydate5years = DateTime::createFromFormat('d/m/Y', $exdate);            
            //$InspectionExpiryDate = $expirydate5years->format('Y-m-d'); */
            $expirydate5years=$request->input('expiry');   //inspection date
            $InspectionExpiryDate=date('Y-m-d', strtotime($expirydate5years));            
            //---------end setting inspection expiry date ---------------------            



            $LabUser=Auth::user()->email;
            $LabCTS=Auth::user()->labname;
            $id=0;

            if (
                !is_null($LabCTS) && !empty($LabCTS) && isset($LabCTS) &&
                !is_null($CountryOfOrigin) && !empty($CountryOfOrigin) && isset($CountryOfOrigin) &&
                !is_null($BrandName) && !empty($BrandName) && isset($BrandName) &&
                !is_null($Standard) && !empty($Standard) && isset($Standard) &&
                !is_null($method) && !empty($method) && isset($method) &&
                !is_null($SerialNumber) && !empty($SerialNumber) && isset($SerialNumber) &&
                !is_null($LabUser) && !empty($LabUser) && isset($LabUser) &&
                !is_null($Date) && !empty($Date) && isset($Date) &&
                !is_null($InspectionExpiryDate) && !empty($InspectionExpiryDate) && isset($InspectionExpiryDate) 

                )
            {

                    $duplicateSnos=DB::table('RegisteredCylinders')
                        ->select(DB::Raw('count(SerialNumber) as existssno'))
                        ->where('SerialNumber','=',$SerialNumber)
                        ->where('BrandName','=',$BrandName)
                        ->where ('CountryOfOrigin','=',$CountryOfOrigin)
                        ->get();
                    //dd($duplicateSnos);
                    if ($duplicateSnos[0]->existssno<=0)
                    {
                        DB::insert('insert into RegisteredCylinders
                        (LabCTS,CountryOfOrigin,BrandName,Standard,SerialNumber,LabUser,Date,InspectionExpiryDate,method,diameter,length,capacity,notes,inspector,DateOfManufacture,ownername,vehicleRegNo,ocnic,certificate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ',[$LabCTS,$CountryOfOrigin,$BrandName,$Standard,$SerialNumber,
                                        $LabUser,$Date,$InspectionExpiryDate,$method,$diameter,$length,$capacity,$notes,$inspector,$manufacturedate,$ownername,$vehicleRegNo,$ocnic,$certificate]);
                        $id = DB::getPdo()->lastInsertId();

                    }

            
                /*
                DB::table('CodeRollsSecondary')                
                ->where(['serialno'=>$SerialNumber])
                ->update(['RegisteredCylindersRefNo'=>$id]); */
                $serialnos='';
                //if (isset($request->session()->get('stored-cylinders'))){
                    $serialnos=$request->session()->get('stored-cylinders');                    
                //}

                $serialnos=$serialnos."<br>";

                $serialnos=$serialnos.$SerialNumber.' | '.$BrandName.' | '.$Standard.' | '.$InspectionExpiryDate;
                $request->session()->put('stored-cylinders',$serialnos);
            }
            $serialnos=$request->session()->get('stored-cylinders');

            $msg="Cylinder Record no ".$id.' added.';
          return redirect()->back()->with('message', $msg)
                                    ->with ('registeredcylinders',$serialnos)  ;              

            //DB::table('CodeRollsSecondary')                
              //  ->where(['serialno'=>$SerialNumber])
               // ->update(['RegisteredCylindersRefNo'=>$LabUser]);

/*------------------------------------------------------------*/
     


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
        $iform=DB::SELECT('select formid,CngKitSerialNo,InspectionDate,Make_Model,
                IF(isnull(Cylinder_valve),"off",Cylinder_valve) as Cylinder_valve,
                IF(isnull(Filling_valve),"off",Filling_valve) as Filling_valve,
                IF(isnull(Reducer),"off",Reducer) as Reducer,
                IF(isnull(HighPressurePipe),"off",HighPressurePipe) as HighPressurePipe,
                IF(isnull(ExhaustPipe),"off",ExhaustPipe) as ExhaustPipe,
                Workshop_identity,Total_Cylinders,Inspection_Status,VehiclerRegistrationNo,Location_cylinder,CL.Location_name,InspectionExpiry ,kit.RegistrationPlate_Pic,kit.RegistrationPlate_Pic_imagetype,kit.WindScreen_Pic,kit.WindScreen_Pic_imagetype,kit.InspectionExpiry
                from  cng_kit kit left join cylinder_locations CL
                on kit.Location_cylinder=CL.Location_id
                where kit.formid=?
                ',[$id]);
        //echo 'show editable form='.$id;

//---rehan here-----------------------------------------------
     
           

            $cylinders = DB::table('kit_cylinders')
                    ->leftjoin('RegisteredCylinders', function($join){
                      $join->on('kit_cylinders.Cylinder_SerialNo','=','RegisteredCylinders.SerialNumber');
                      $join->on('kit_cylinders.Make_Model','=','RegisteredCylinders.BrandName');
                    })
                    ->select('kit_cylinders.formid','kit_cylinders.Cylinder_SerialNo','kit_cylinders.CngKitSerialNo','kit_cylinders.CngKitSerialNo','kit_cylinders.InspectionDate','kit_cylinders.Cylinder_no','kit_cylinders.ImportDate','kit_cylinders.Standard','kit_cylinders.Make_Model','kit_cylinders.cylinderlocation',
                        DB::raw('IF(ISNULL(RegisteredCylinders.SerialNumber) OR ISNULL(RegisteredCylinders.BrandName), "(Unregistered)", "") as cylinderStatus'))
                    ->where('formid','=',$id)
                    ->orderby('Cylinder_no','asc')
                    ->get();                     


        $results = DB::SELECT('select Location_id,Location_name FROM cylinder_locations order by Location_id;');
                
        //$recordid=Request("recordid");


        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);


        $vehicles= DB::table('vehicle_particulars')
                ->select('Inspection_Status','vehicle_particulars.StickerSerialNo')
                ->where('lastinspectionid','=',$id)
                ->get();

        return view ('vehicle.editcylinder',['InspectionForm'=>$iform,'Cylinders'=>$cylinders,'cylinder_locations'=>$results,'treeitems'=>$treeitems,'vehicles'=>$vehicles ]);        


    }



/*->select('kit_cylinders.formid,
'kit_cylinders.Cylinder_SerialNo',



)*/

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


/*----------------------------------update records-------------------------------------------*/

        $kitfields =array('vregno' => 'required','kitmnm' => 'required','kitseriano' => 'required','workstationid' => 'required');
        $cylinderfields=array();
        $cylinderfield=array();
        $cylindernos= $request->input('cylindernos');

        for ($count=1 ;$count<= $cylindernos;++$count){
            $cylinderfield = array('makenmodel_C'.$count =>'required',
                                    'serialno_C'.$count=>'required',
                                    'importdate_C'.$count=>'required',
                                    'scancode_C'.$count=>'required'
                                    );
            $cylinderfields=array_merge($cylinderfields,$cylinderfield);
        }
        $kitfields=array_merge($kitfields,$cylinderfields);

        $this->validate($request,$kitfields);

            $recordid= $request->record_id;
            

            $location = $request->input('location');
            $cylindernos= $request->input('cylindernos');
            $vregno= $request->input('vregno');
            $kitmnm = $request->input('kitmnm');
            $kitseriano=$request->input('kitseriano');
            $workstationid=$request->input('workstationid');

            $cylindervalve=$request->input('cylindervalve');
            $fillingvalve=$request->input('fillingvalve');
            $Reducer=$request->input('Reducer');
            $hpp=$request->input('hpp');
            $exhaustpipe=$request->input('exhaustpipe');
            


            $dt1=$request->input('inspectiondate');            
            $inspectiondate = date('Y-m-d', strtotime($dt1));
/*            we donot change inspection date and expiry date in this system.
            $inspectiondate = date('Y-m-d', strtotime($dt1));
            $expiryDate=date('Y-m-d', strtotime($dt1));
*/      

                     $makenmodel_1='';
                     $serialno_1='';
                     $dt1=$request->input('importdate').'';
                     $importdate_1=date('Y-m-d', strtotime($dt1));
                     $scancode_1='';                    


                     $makenmodel_2='';
                     $serialno_2='';
                     $dt1=$request->input('importdate').'';
                     $importdate_2=date('Y-m-d', strtotime($dt1));
                     $scancode_2='';                    
                     
                     $makenmodel_3='';
                     $serialno_3='';
                     $dt1=$request->input('importdate').'';
                     $importdate_3=date('Y-m-d', strtotime($dt1));
                     $scancode_3='';                    
                     
                     $makenmodel_4='';
                     $serialno_4='';
                     $dt1=$request->input('importdate').'';
                     $importdate_4=date('Y-m-d', strtotime($dt1));
                     $scancode_4='';                    

                     $makenmodel_5='';
                     $serialno_5='';
                     $dt1=$request->input('importdate').'';
                     $importdate_5=date('Y-m-d', strtotime($dt1));
                     $scancode_5='';                    

                     $makenmodel_6='';
                     $serialno_6='';
                     $dt1=$request->input('importdate').'';
                     $importdate_6=date('Y-m-d', strtotime($dt1));
                     $scancode_6='';                    

            $initcount=1;
            $registeredserialno=1;
            //echo 'cylindernos='.$cylindernos;
            for ($initcount=1;$initcount <= $cylindernos;$initcount++)
            {
                $makenmodel='makenmodel_C'.$initcount;
                $serialno='serialno_C'.$initcount;
                $importdate='importdate_C'.$initcount;
                $scancode='scancode_C'.$initcount;
                $location ='location_C'.$initcount; //$request->input('location');



                if ($initcount==1)
                {
                     $makenmodel_1=$request->input($makenmodel).'';
                     $serialno_1=$request->input($serialno).'';
                     $dt1=$request->input($importdate).'';
                     $importdate_1=date('Y-m-d', strtotime($dt1));
                     $scancode_1=$request->input($scancode).'';                    
                     $location_1 = $request->input('location_C1');
             

                }
                if ($initcount==2)
                {
                     $makenmodel_2=$request->input($makenmodel).'';
                     $serialno_2  =$request->input($serialno).'';
                     $dt1=$request->input($importdate).'';
                     $importdate_2=date('Y-m-d', strtotime($dt1));
                     $scancode_2=$request->input($scancode).'';                    
                     $location_2 = $request->input('location_C2');


                }
                if ($initcount==3)
                {
                     $makenmodel_3=$request->input($makenmodel).'';
                     $serialno_3=$request->input($serialno).'';
                     $dt1=$request->input($importdate).'';
                     $importdate_3=date('Y-m-d', strtotime($dt1));
                     $scancode_3=$request->input($scancode).'';                     
                     $location_3 = $request->input('location_C3');

                }
                if ($initcount==4)
                {
                     $makenmodel_4=$request->input($makenmodel).'';
                     $serialno_4 =$request->input($serialno).'';
                     $dt1=$request->input($importdate).'';
                     $importdate_4=date('Y-m-d', strtotime($dt1));             
                     $scancode_4=$request->input($scancode).'';
                     $location_4 = $request->input('location_C4');                   

                }
                if ($initcount==5)
                {
                     $makenmodel_5=$request->input($makenmodel).'';
                     $serialno_5=$request->input($serialno).'';
                     $dt1=$request->input($importdate).'';
                     $importdate_5=date('Y-m-d', strtotime($dt1));
                     $scancode_5=$request->input($scancode).'';
                     $location_5 = $request->input('location_C5');                    

                }
                if ($initcount==6)
                {
                     $makenmodel_6=$request->input($makenmodel).'';
                     $serialno_6=$request->input($serialno).'';
                     $dt1=$request->input($importdate).'';
                     $importdate_6=date('Y-m-d', strtotime($dt1));
                     $scancode_6 =$request->input($scancode).'';                    
                     $location_6 = $request->input('location_C6');

                }                
            }




            $cylinderserialnocount=0;
            $formid=$id;



            if (!is_null($kitseriano) && !empty($kitseriano) && isset($kitseriano) &&
                !is_null($inspectiondate) && !empty($inspectiondate) && isset($inspectiondate)
            ) 
            {
                //DB::table('users')->delete($id);
                //DB::table('users')->where('id', $id)->delete();
                //DB::delete('delete from users');

                    DB::table('cng_kit')
                        ->where('VehiclerRegistrationNo', $vregno)
                        ->where('formid', $formid)
                        //->where(['CngKitSerialNo'=> $kitseriano])
                        ->where('InspectionDate',$inspectiondate)
                        ->update(['Make_Model'=>$kitmnm ,
                                    'CngKitSerialNo'=>$kitseriano,
                                    'Cylinder_valve'=>$cylindervalve,
                                    'Filling_valve'=>$fillingvalve,
                                    'Reducer'=>$Reducer,
                                    'HighPressurePipe'=>$hpp,
                                    'ExhaustPipe'=>$exhaustpipe,
                                    'Workshop_identity'=>$workstationid,
                                    //'Location_cylinder'=>$location                                 

                    ]);


                    $imgRegPlate='filenotfound';
                    $extensionimgRegPlate;
                    $base64imageimgRegPlate;

                    if($request->hasfile('imgRegPlate')){

                        $imgRegPlate=$request->file('imgRegPlate');
                        $extensionimgRegPlate=$imgRegPlate->getClientOriginalExtension(); //image type

                         $imageStr = (string) Image::make( $imgRegPlate )->
                                                 resize( 300, null, function ( $constraint ) {
                                                     $constraint->aspectRatio();
                                                 })->encode( $extensionimgRegPlate );

                        $base64imageimgRegPlate = base64_encode( $imageStr );        

                    }

                 
                    



                    $imgWndScreen='filenotfound';
                    $extensionimgWndScreen;
                    $base64imageextensionimgWndScreen;
                    $base64imageWndScreen;

                    if($request->hasfile('imgWndScreen')){

                        $imgWndScreen=$request->file('imgWndScreen');
                        $extensionimgWndScreen=$imgWndScreen->getClientOriginalExtension(); //image type

                         $imageStr = (string) Image::make( $imgWndScreen )->
                                                 resize( 300, null, function ( $constraint ) {
                                                     $constraint->aspectRatio();
                                                 })->encode( $extensionimgWndScreen );

                        $base64imageWndScreen = base64_encode( $imageStr );        
                 
                        
                    }
                 






                  if ($imgRegPlate!='filenotfound')
                {
  
                    echo 'rehan2';
                    DB::table('cng_kit')
                        ->where(['VehiclerRegistrationNo'=> $vregno])
                        ->where(['formid'=> $formid])
                        ->where(['CngKitSerialNo'=> $kitseriano])
                        ->where(['InspectionDate'=>$inspectiondate])
                        ->update(['RegistrationPlate_Pic' => $base64imageimgRegPlate,
                                  'RegistrationPlate_Pic_imagetype' =>$extensionimgRegPlate
                                ]);                    
                }




                if ($imgWndScreen!='filenotfound')
                {

                    DB::table('cng_kit')
                        ->where(['VehiclerRegistrationNo'=> $vregno])
                        ->where(['formid'=> $formid])
                        ->where(['CngKitSerialNo'=> $kitseriano])
                        ->where(['InspectionDate'=>$inspectiondate])
                        ->update(['WindScreen_Pic' => $base64imageWndScreen,
                                  'WindScreen_Pic_imagetype' =>$extensionimgWndScreen
                                ]);    
                }




                if (!is_null($formid) && !empty($formid) && isset($formid) && 
                    !is_null($kitseriano) && !empty($kitseriano) && isset($kitseriano) &&
                    !is_null($inspectiondate) && !empty($inspectiondate) && isset($inspectiondate)
                    )
                {
                
                    if (!is_null($serialno_1) && !empty($serialno_1) && isset($serialno_1) )
                    {
                        
                        DB::table('kit_cylinders')                        
                        ->where('formid', $formid)
                        ->where('Cylinder_no',1)
                        ->update([
                                'Cylinder_SerialNo' => $serialno_1,
                                'ImportDate' => $importdate_1,
                                'Standard' => $scancode_1,
                                'Make_Model' => $makenmodel_1,
                                'cylinderlocation' => (int) $location_1
                                ]);


                            $cylinderserialnocount=$cylinderserialnocount+1;

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_1,$inspectiondate,$makenmodel_1]) ;

                        
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;
                        

                        } 
                        

                        

                    }               
                    
                    if (!is_null($serialno_2) && !empty($serialno_2) && isset($serialno_2) )
                    {
                        DB::table('kit_cylinders')                        
                        ->where('formid', $formid)

                        ->where('Cylinder_no',2)
                        ->update([
                                'Cylinder_SerialNo' => $serialno_2,
                                'ImportDate' => $importdate_2,
                                'Standard' => $scancode_2,
                                'Make_Model' => $makenmodel_2,
                                'cylinderlocation' =>(int) $location_2
                                ]);

                        $cylinderserialnocount=$cylinderserialnocount+1;


                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_2,$inspectiondate,$makenmodel_2]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;
                            

                        }                        

                    }

                    if (!is_null($serialno_3) && !empty($serialno_3) && isset($serialno_3) )
                    {

                        DB::table('kit_cylinders')                        
                        ->where('formid', $formid)
                        ->where('Cylinder_no',3)
                        ->update([
                                'Cylinder_SerialNo' => $serialno_3,
                                'ImportDate' => $importdate_3,
                                'Standard' => $scancode_3,
                                'Make_Model' => $makenmodel_3,
                                'cylinderlocation' => (int)$location_3
                                ]);



                        $cylinderserialnocount=$cylinderserialnocount+1;

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_3,$inspectiondate,$makenmodel_3]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;                            

                        }                                                

                    }
                    if (!is_null($serialno_4) && !empty($serialno_4) && isset($serialno_4) )
                    {

                        DB::table('kit_cylinders')                        
                        ->where('formid', $formid)

                        ->where('Cylinder_no',4)
                        ->update([
                                'Cylinder_SerialNo' => $serialno_4,
                                'ImportDate' => $importdate_4,
                                'Standard' => $scancode_4,
                                'Make_Model' => $makenmodel_4,
                                'cylinderlocation' => (int) $location_4

                            ]);

                        $cylinderserialnocount=$cylinderserialnocount+1;
                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_4,$inspectiondate,$makenmodel_4]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;
                            

                        }                                                
                    }

                    if (!is_null($serialno_5) && !empty($serialno_5) && isset($serialno_5) )
                    {


                        DB::table('kit_cylinders')                        
                        ->where('formid',$formid)

                        ->where('Cylinder_no',5)
                        ->update([
                                'Cylinder_SerialNo' => $serialno_5,
                                'ImportDate' => $importdate_5,
                                'Standard' => $scancode_5,
                                'Make_Model' => $makenmodel_5,
                                'cylinderlocation' => (int) $location_5
                                ]);

                        $cylinderserialnocount=$cylinderserialnocount+1;

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_5,$inspectiondate,$makenmodel_5]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;                            

                        }                        


                    }
                    if (!is_null($serialno_6) && !empty($serialno_6) && isset($serialno_6) )
                    {


                        DB::table('kit_cylinders')                        
                        ->where('formid', $formid)
                        ->where(['Cylinder_no',6])
                        ->update([
                                'Cylinder_SerialNo' => $serialno_6,
                                'ImportDate' => $importdate_6,
                                'Standard' => $scancode_6,
                                'Make_Model' => $makenmodel_6,
                                'cylinderlocation' => (int)$location_6
                                ]);

                        $cylinderserialnocount=$cylinderserialnocount+1;

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ? and BrandName=?',[$serialno_6,$inspectiondate,$makenmodel_6]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;                            

                        }                                                
                    }
                } //end of kit_cylinders
                    $inspectionStatus='pending';
                    if ($cylinderserialnocount == $cylindernos)
                    {   
                        $images=DB::table('cng_kit')    
                        ->select('WindScreen_Pic','RegistrationPlate_Pic')                    
                        ->where(['formid'=> $formid])
                        ->get();
       
                        if ($registeredserialno==1 && $images[0]->WindScreen_Pic && $images[0]->RegistrationPlate_Pic)
                            {
                                $inspectionStatus='completed';

                            }                      
                    }
     

                    DB::table('cng_kit')
                        ->where('VehiclerRegistrationNo', $vregno)
                        ->where('formid', $formid)
                        //->where('CngKitSerialNo', $kitseriano)
                        //->where('InspectionDate',$inspectiondate)
                        ->update(['Inspection_Status' => $inspectionStatus]);

                    DB::table('vehicle_particulars')
                        //->where() rehan is working here.
                        ->where('Registration_no','=',$vregno)
                        ->where('lastinspectionid','=',$formid)
                        //->where('Record_no','=',$recordid)
                        ->update(['Inspection_Status'=>$inspectionStatus]);                        

            } // end if ($countkits==0) 


        $usertype =Auth::user()->regtype;


$sortby="Record_no";
    $recordperpage = 10;
    $pagesize=10;
    $pagesize=10;
        if  (Cookie::get('pagesize') !== null)
        {            
            $pagesize = Cookie::get('pagesize');
            $recordperpage=$pagesize;
        }
        else
        {$pagesize=10;$recordperpage;}


        if ($usertype =='workshop')
        {
        $vehicles = DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');
                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate','cng_kit.InspectionExpiry')
                    ->where('vehicle_particulars.stationno','=',Auth::user()->stationno)
                    ->orderby($sortby,'desc')            
                    ->paginate($pagesize);                        
        }
        else
        {
          $vehicles = DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');
                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate','cng_kit.InspectionExpiry')            
                    ->orderby($sortby,'desc')            
                    ->paginate($pagesize);                        

        }

       $querystringArray = ['sort' => $sortby];
        $vehicles->appends($querystringArray);


        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);


$targetroute=route('registrations');
return redirect()->to($targetroute)->with('vehicles',$vehicles)
                            ->with('treeitems',$treeitems)
                            ->with('page',1)
                            ->with('pagesize',$pagesize)
                            ->with('businessType','N/A')
                            ->with('inspectionType','N/A')
                            ->with('searchby','N/A');
                               

    }

    public function listlabtestedcylinders()
    {

        $pagesize=10;
        if  (Cookie::get('pagesize') !== null)
        {
            
            $pagesize = Cookie::get('pagesize');

        }
        else
        {$pagesize=10;}


            $sort=Request('sort');
            if (!isset($sort)){
                //$sort='id';
                $sort='row_number';

            }


        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            


        $labUser =Auth::user()->email;

                if (Auth::user()->regtype=='admin' || Auth::user()->regtype=='hdip' || Auth::user()->regtype=='apcng')
        {
                DB::statement(DB::raw('set @row:=0'));
                $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 
                        'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no',DB::Raw('@row:=@row+1 as row_number'))
                    ->orderby($sort,'desc')    
                    ->paginate($pagesize);            

                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where ('deleted','=',0)
                    ->orderby('Labname','desc')
                    ->get();
                   //all labs
        }
        
        else{
                DB::statement(DB::raw('set @row:=0'));
                $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 
                        'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no',DB::Raw('@row:=@row+1 as row_number'))

                    ->where ('LabUser','=',$labUser)
                    ->orderby($sort,'desc')                   
                    ->paginate($pagesize);  

                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where('email','=',$labUser) //only reistered lab user
                    ->where ('deleted','=',0)
                    ->orderby('Labname','desc')
                    ->get();
                                   
        }

 

  //return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1);
  //return view ('vehicle.listtestedcylinders',['testedcylinders'=>$testedcylinders->appends('sort'=>$sort),'treeitems'=>$treeitems])->with('page',1);
    //    return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with($data);

        //return view('vehicle.cylinders',['cylinder_locations'=>$results,'treeitems'=>$treeitems]);

//$querystringArray = ['sort' => $sort, 'anotherVar' => 'something_else'];
    $querystringArray = ['sort' => $sort];

$testedcylinders->appends($querystringArray);

    return view ('vehicle.listtestedcylinders',['testedcylinders'=>$testedcylinders,'treeitems'=>$treeitems,'labs'=>$labs])->with('page',1)->with('pagesize',$pagesize);
        /*$content = view ('vehicle.listtestedcylinders',['testedcylinders'=>$testedcylinders,'treeitems'=>$treeitems,'labs'=>$labs])->with('page',1);

        return response($content)->withHeaders(['Set-Cookie'=> "Secure;SameSite=None"]);*/
    }
 
/*private function sortProductsByRow(Product $a, Product $b)
{
   if ($a->getCreated() == $b->getCreated()) {
      return 0;
   }
   return ($a->getCreated() < $b->getCreated()) ? -1 : 1;
}*/
/*return response($content)
            ->withHeaders([
                'Content-Type' => $type,
                'X-Header-One' => 'Header Value',
                'X-Header-Two' => 'Header Value',
            ]);
response.AddHeader("Set-Cookie", "HttpOnly;Secure;SameSite=Strict");*/
    public function searchlabtestedcylinders(Request $request){

        $pagesize=$request->input('pagesize');
        $searchby=$request->input('searchby');
        $searchvalue=$request->input('searchvalue');
        $labName =$request->input('lab');

        $pagesize=10;
        if  (Cookie::get('pagesize') !== null)
        {
            
            $pagesize = Cookie::get('pagesize');

        }
        else
        {$pagesize=10;}


            $sort=Request('sort');
            if (!isset($sort)){
                //$sort='id';
                $sort='row_number';

            }

        
        if ($searchby=="Date" ) {
            if (!isset($searchvalue)){
                $searchvalue='01/01/1900'; //default value if provided date is empty
            }
            $searchvalue=date('Y-m-d', strtotime($searchvalue));
            $searchby='RegisteredCylinders.Date';
                        //converting date from mdy to YMD

        }


        if ($searchby=="InspectionExpiryDate" ) {
            if (!isset($searchvalue)){
                $searchvalue='01/01/1900'; //default value if provided date is empty
            }
            $searchvalue=date('Y-m-d', strtotime($searchvalue));
            $searchby='RegisteredCylinders.InspectionExpiryDate';
                        //converting date from mdy to YMD
        }


      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);



        $labUser =Auth::user()->email;


/*----------------------------------*/

            $sort=Request('sort');
            if (!isset($sort)){
                //$sort='id';
                $sort='row_number';
            }


        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            


        $labUser =Auth::user()->email;
        
            $labsWhereData = [           
            ['regtype', '=', 'laboratory'],
            ['deleted', '=', 0]
            ];        
/*$testedcylindersWhereData = [
    ['name', 'test'],
    ['id', '<>', '5']
];*/
        switch ($usertype) {
        case ($usertype=="admin" || $usertype=="hdip") && ($labName=="*") && ($searchby=="*"):
            # admin / all labs / all cylinder data
            # code...
            $testedcylindersWhereData = [           
            ['id', '>', 0]
            ];
            
           break;

        case ($usertype=="admin" || $usertype=="hdip") && ($labName=="*") && ($searchby!="*"):
            # admin / all labs / cylinder searchby field
            # code...
            $testedcylindersWhereData = [            
            [$searchby, '=', $searchvalue]
                ];        
           break;

  //-----------------------------------------------------------------
        case ($usertype=="admin" || $usertype=="hdip") && ($labName!="*") && ($searchby=="*"):
            # admin / single lab / all cylinder data
            # code...
            $testedcylindersWhereData = [            
            ['LabCTS', '=', $labName]
                ];   
           break;

        case ($usertype=="admin" || $usertype=="hdip") && ($labName!="*") && ($searchby!="*"):
            # admin / single lab / cylinder searchby field
            # code...
            $testedcylindersWhereData = [            
            ['LabCTS', '=', $labName],
            [$searchby, '=', $searchvalue]
                ];          
           break;



        case ($usertype=="laboratory" && $labName!="*" && $searchby=="*"):
            #non admin / single lab /  all cylinder data
            $testedcylindersWhereData = [            
            ['LabCTS', '=', $labName],
            ['LabUser','=',$labUser]
                ];   
            $labsWhereData = [           
            ['regtype', '=', 'laboratory'],
            ['deleted', '=', 0],
            ['email', '=', $labUser]
            ];                                 
            break;
        case ($usertype=="laboratory" && $labName!="*"  && $searchby!="*"):
            #non admin / single lab /  cylinder searchby field
            $testedcylindersWhereData = [            
            ['LabCTS', '=', $labName],
            ['LabUser','=',$labUser],
            [$searchby,'=',$searchvalue]
                ]; 
            $labsWhereData = [           
            ['regtype', '=', 'laboratory'],
            ['deleted', '=', 0],
            ['email', '=', $labUser]
            ];                                 

            break;            
        default:
            # code...
            #non admin / single lab /  all cylinder data
            $testedcylindersWhereData = [            
            ['LabCTS', '=', $labName],
            ['LabUser','=',$labUser]
                ];  

            $labsWhereData = [           
            ['regtype', '=', 'laboratory'],
            ['deleted', '=', 0]
            ];                         
            break;
        }
//print_r($testedcylindersWhereData);
//return;
        DB::statement(DB::raw('set @row:=0'));
        $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no',DB::Raw('@row:=@row+1 as row_number')) 
                    ->where ($testedcylindersWhereData)
                    ->orderby($sort,'desc')
                    ->paginate($pagesize);

        $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ($labsWhereData)
                    ->orderby('Labname','desc')
                    ->get();
                    //->paginate($pagesize); 


        $data =['page'=>'1','sort'=>$sort];
 
    $querystringArray = ['sort' => $sort];

$testedcylinders->appends($querystringArray);

session()->flashInput($request->input());

    return view ('vehicle.listtestedcylinders',['testedcylinders'=>$testedcylinders,'treeitems'=>$treeitems,'labs'=>$labs])->with('page',1)
                                                ->with('pagesize',$pagesize);
    

    }
    public function editformfortestedcylinders($cylinderid)
    {

        
        
        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        $countries=DB::select(DB::raw('select distinct countries from worldcountries order by countries asc'));
                        
       // $brands=DB::select(DB::raw('select distinct brandname  from  cylinderbrand order by brandname asc;'));
      $brandStructures=$this->getAvailableBrands();

        $email=Auth::user()->email;
        

            
        $CylinderDetails=DB::table('RegisteredCylinders')
                    ->select ('id','LabCTS','BrandName','Standard' ,'SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'stickerSerialNo','method','diameter','length','capacity','inspector','notes','DateOfManufacture','ownername','vehicleRegNo','ocnic','certificate')
                    ->where ('id','=',$cylinderid)
                    ->get();            


        return view ('vehicle.editformfortestedcylinders',['treeitems'=>$treeitems,'countries'=>$countries,'cylinderdetails'=>$CylinderDetails,'brandStructures'=>$brandStructures]);
        

    }

    public function updateformfortestedcylinders(Request $request, $id)
    {

        $labUser =Auth::user()->email;
        $BrandName= $BrandName=$request->input('hiddenbrandname');
         //$request->input('brand');
        $CountryOfOrigin=$request->input('CountryOfOrigin');            
//dd($CountryOfOrigin);
        $this->validate($request,array(
            'CountryOfOrigin'=>'required',
            'brand'=>'required',
            'standard'=>'required',
            'SerialNo'=>['required',new engravedCylindernoUpdate($request->input('SerialNo'),$labUser,$id,$BrandName,$CountryOfOrigin) ],
            'edate'=>'required',  //inspection date
            'expiry'=>'required',         
            'method' =>'required',
            'ocnic'=>'nullable|regex:/(^([\d]{5}-[\d]{7}-[\d])$)/',
            'certificate'=>'nullable',
            'ddmanufacture'=>'required',
            //'ddmanufacture'=>['required','regex:/(^(19|20)\d\d-0[1-9]|1[012]-(0[1-9]|[12][0-9]|3[01])$)/'],

        ));


$ownername=$request->input('oname');
$vehicleRegNo=$request->input('oreg');
$ocnic=$request->input('ocnic');
$certificate=$request->input('certificate');

            
            $Standard=$request->input('standard');
            $SerialNumber=$request->input('SerialNo');

            $diameter=$request->input('diameter');            
            $length=$request->input('length');            
            $capacity=$request->input('capacity');            
            $inspector=$request->input('inspector');            
            $notes =$request->input('notes');            
            $DateOfManufacture =date('Y-m-d',strtotime($request->input('domyear').'/'.$request->input('dommonth').'/'.$request->input('domday')));

            //$request->input('ddmanufacture');


            $dt1=$request->input('edate');      
            $Date=date('Y-m-d', strtotime($dt1));   //inspection date


            //---------setting inspection expiry date ---------------------

            $eyear= $request->year;
            $emonth= $request->month;
            $eday= $request->day;
            $exdate=$eday."/".$emonth."/".$eyear;           

            // Parse a date using a user-defined format
            $expirydate5years = DateTime::createFromFormat('d/m/Y', $exdate);            
            $InspectionExpiryDate = $expirydate5years->format('Y-m-d');
            //---------end setting inspection expiry date -----------------


            //$dt1=$request->input('expiry');
            //$InspectionExpiryDate=date('Y-m-d', strtotime($dt1));

            $method=$request->input('method');


            $LabUser=Auth::user()->email;
            $LabCTS=Auth::user()->labname;
            


            if (
                !is_null($LabCTS) && !empty($LabCTS) && isset($LabCTS) &&
                !is_null($CountryOfOrigin) && !empty($CountryOfOrigin) && isset($CountryOfOrigin) &&
                !is_null($BrandName) && !empty($BrandName) && isset($BrandName) &&
                !is_null($Standard) && !empty($Standard) && isset($Standard) &&
                !is_null($method) && !empty($method) && isset($method) &&
                !is_null($SerialNumber) && !empty($SerialNumber) && isset($SerialNumber) &&
                !is_null($LabUser) && !empty($LabUser) && isset($LabUser) &&
                !is_null($Date) && !empty($Date) && isset($Date) &&
                !is_null($InspectionExpiryDate) && !empty($InspectionExpiryDate) && isset($InspectionExpiryDate) 

                )
            {

                    $duplicateSnos=DB::table('RegisteredCylinders')
                        ->select(DB::Raw('count(SerialNumber) as existssno'))
                        ->where('SerialNumber','=',$SerialNumber)
                        ->where('BrandName','=',$BrandName)
                        ->where('CountryOfOrigin','=',$CountryOfOrigin)
                        ->get();
                    if ($duplicateSnos[0]->existssno<=1)
                    {


                        DB::table('RegisteredCylinders')
                        ->where(['id'=> $id])
                        ->update(['CountryOfOrigin' => $CountryOfOrigin,
                                  'BrandName' => $BrandName,
                                  'Standard' =>$Standard,
                                  'SerialNumber' =>$SerialNumber,
                                  'Date' =>$Date,
                                  'InspectionExpiryDate' =>$InspectionExpiryDate,
                                  'method'=>$method,
                                    'diameter'=>$diameter,
                                    'length'=>$length,
                                    'capacity'=>$capacity,
                                    'inspector'=>$inspector,
                                    'notes'=> $notes ,  
                                    'DateOfManufacture'=>$DateOfManufacture,
                                    'ownername'=>$ownername,
                                    'vehicleRegNo'=>$vehicleRegNo,
                                    'ocnic'=>$ocnic,
                                    'certificate'=>$certificate
                                ]);                                            

                    }


                $serialnos='';


                

            }

/*                
        return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1); */
        
        
        /*--------------------------------*/
        
            $sort=Request('sort');
            if (!isset($sort)){
                //$sort='id';
                $sort='row_number';                
            }


        $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            


        $labUser =Auth::user()->email;

                if (Auth::user()->regtype=='admin' || Auth::user()->regtype=='hdip')
        {
                DB::statement(DB::raw('set @row:=0'));
                $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no',DB::Raw('@row:=@row+1 as row_number'))

                    ->orderby($sort,'desc')
                    ->paginate(10);            

                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where ('deleted','=',0)
                    ->orderby('Labname','desc')
                    ->get();
                    //->paginate(10);  //all labs                    
        }
        
        else{
                DB::statement(DB::raw('set @row:=0'));
                $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no',DB::Raw('@row:=@row+1 as row_number'))
                    ->where ('LabUser','=',$labUser)
                    ->orderby($sort,'desc')
                    ->paginate(10);

                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where ('deleted','=',0)
                    ->where ('email','=',$labUser)
                    ->orderby('Labname','desc')
                    ->get();
                    //->paginate(10);                    
        }

        //return view ('vehicle.listestedcylinders',['testedcylinders'=>$testedcylinders]);            
        
        //return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1);
        //$sort=Request('sort');
        //$data =['page'=>'1','sort'=>$sort];
        /*$testedcylinders->setCollection(
    collect(
        collect($testedcylinders->items())->sortBy($sort,true)
    )->values());*/

  //return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1);
  //return view ('vehicle.listtestedcylinders',['testedcylinders'=>$testedcylinders->appends('sort'=>$sort),'treeitems'=>$treeitems])->with('page',1);
    //    return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with($data);

        //return view('vehicle.cylinders',['cylinder_locations'=>$results,'treeitems'=>$treeitems]);

//$querystringArray = ['sort' => $sort, 'anotherVar' => 'something_else'];
    $querystringArray = ['sort' => $sort];

$testedcylinders->appends($querystringArray);



    return view ('vehicle.listtestedcylinders',['testedcylinders'=>$testedcylinders,'treeitems'=>$treeitems,'labs'=>$labs])->with('page',1);
        

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
