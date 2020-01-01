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
        $stationno=DB::SELECT('select stationno FROM vehicle_particulars where Record_no=?',[$recordid]);
        
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
    public function store(Request $request)
    {



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
        





        //$this->validate($request,$kitfields);
        
                //$imageName = time().'.'.request()->imgRegPlate->getClientOriginalExtension();


        //$request->input('imgRegPlate')->image

            $recordid= $request->record_id;
            $location = 1; //$request->input('location');
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


            $dt1=Carbon::today();
            
            $inspectiondate = date('Y-m-d', strtotime($dt1));

            $dt1 = Carbon::today()->addMonths(12);

            $expiryDate=date('Y-m-d', strtotime($dt1));

             $makenmodel_1=$request->input('makenmodel_C1').'';
             $serialno_1=$request->input('serialno_C1').'';
             $dt1=$request->input('importdate_C1').'';
             $importdate_1=date('Y-m-d', strtotime($dt1));
             $scancode_1=$request->input('scancode_C1').'';
             $location_1 = $request->input('location_C1');

             $makenmodel_2=$request->input('makenmodel_C2').'';
             $serialno_2  =$request->input('serialno_C2').'';
             $importdate_2=$request->input('importdate_C2').'';
             $importdate_2=date('Y-m-d', strtotime($dt1));
             $scancode_2=$request->input('scancode_C2').'';
             $location_2 = $request->input('location_C2');

             $makenmodel_3=$request->input('makenmodel_C3').'';
             $serialno_3=$request->input('serialno_C3').'';
             $dt1=$request->input('importdate_C3').'';
             $importdate_3=date('Y-m-d', strtotime($dt1));
             $scancode_3=$request->input('scancode_C3').'';
             $location_3 = $request->input('location_C3');

             $makenmodel_4=$request->input('makenmodel_C4').'';
             $serialno_4 =$request->input('serialno_C4').'';
             $dt1=$request->input('importdate_C4').'';
             $importdate_4=date('Y-m-d', strtotime($dt1));             
             $scancode_4=$request->input('scancode_C4').'';
             $location_4 = $request->input('location_C4');


             $makenmodel_5=$request->input('makenmodel_C5').'';
             $serialno_5=$request->input('serialno_C5').'';
             $dt1=$request->input('importdate_C5').'';
             $importdate_5=date('Y-m-d', strtotime($dt1));
             $scancode_5=$request->input('scancode_C5').'';
             $location_5 = $request->input('location_C5');


             $makenmodel_6=$request->input('makenmodel_C6').'';
             $serialno_6=$request->input('serialno_C6').'';
             $dt1=$request->input('importdate_C6').'';
             $importdate_6=date('Y-m-d', strtotime($dt1));
             $scancode_6 =$request->input('scancode_C6').'';
             $location_6 = $request->input('location_C6');


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

                    if($request->hasfile('imgWndScreen')){

                        $imgWndScreen=$request->file('imgWndScreen');
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

                            

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_1,$inspectiondate]) ;
                        
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

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_2,$inspectiondate]) ;
                        
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


                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_3,$inspectiondate]) ;
                        
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


                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_4,$inspectiondate]) ;
                        
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

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_5,$inspectiondate]) ;
                        
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

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_6,$inspectiondate]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;

                        }                        
                    }
                } //end of kit_cylinders
                    
                    $inspectionStatus='pending';

                    if ($cylinderserialnocount == $cylindernos)
                    {   
                        if ($cylindervalve=="on" && $fillingvalve=="on" && $Reducer =="on" && $hpp=="on" && $exhaustpipe=="on")
                        {
                            if ($registeredserialno==1)
                            {
                                $inspectionStatus='completed';

                            }
                            
                        }
                        
                        
                    }



                    DB::table('cng_kit')
                        ->where(['VehiclerRegistrationNo'=> $vregno])
                        ->where(['formid'=> $formid])
                        //->where(['CngKitSerialNo'=> $kitseriano])
                        //->where(['InspectionDate'=>$inspectiondate])
                        ->update(['Inspection_Status' => $inspectionStatus]);


                    DB::table('vehicle_particulars')
                        //->where() rehan is working here.
                        ->where('Registration_no','=',$vregno)
                        ->where('Record_no','=',$recordid)
                        //->where('Record_no','=',$recordid)
                        ->update(['lastinspectionid'=>$formid,'Inspection_Status'=>$inspectionStatus]);                        



            } // end if ($countkits==0) 


        
/*
            $vehicles = DB::select('select Owner_name,CNIC,Cell_No,Address,Record_no,Registration_no,Chasis_no,Engine_no,Vehicle_catid,Make_type,Scan_code,OwnerCnic,businesstype,stationno,IF(ISNULL(Inspection.Inspection_Status), "pending", Inspection.Inspection_Status) as Inspection_Status,IF(ISNULL(Inspection.formid), 0, Inspection.Inspection.formid) as formid
            from owner__particulars owners 
            left join vehicle_particulars vehicles on  owners.CNIC=vehicles.OwnerCnic
            left join (select Inspection_Status,VehiclerRegistrationNo,formid from cng_kit  order by formid desc limit 1) Inspection
            on Inspection.VehiclerRegistrationNo=Registration_no order by Record_no desc;');*/
        

/*$vehicles = DB::table('vehicle_particulars')
            ->leftjoin('owner__particulars','owner__particulars.CNIC','=','vehicle_particulars.OwnerCnic')

            ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at')            
            ->orderby('Record_no','desc')  
            ->paginate(10);*/            


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
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate')
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
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate')            
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


          $cylinders=DB::SELECT('select formid,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,Cylinder_no,ImportDate,Standard,Make_Model
                from kit_cylinders where formid =?',[$id]);



        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        return view ('vehicle.showcylinder',['InspectionForm'=>$iform,'Cylinders'=>$cylinders,'treeitems'=>$treeitems ]);
    }

    public function testcylindersdataentryform()
    {
        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        $countries=DB::select(DB::raw('select distinct countries from worldcountries order by countries asc'));
                        
        $brands=DB::select(DB::raw('select distinct brandname  from  cylinderbrand order by brandname asc;'));

        $email=Auth::user()->email;
        
        //$serialnos=DB::select('select distinct serialno  from  CodeRollsSecondary  where RegisteredCylindersRefNo is null and allotedto=? limit 100',[$email])   ;         
            
        

        return view ('vehicle.InspectedCylinders',['treeitems'=>$treeitems,'countries'=>$countries,'brands'=>$brands]);
    }


    public function transferStickers()
    {
        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        $batches=DB::select(DB::raw('select batchid,user,filename from CodeRollsPrimary where batchid in (SELECT distinct batchid FROM CodeRollsSecondary where allotedto is null) order by filename asc'));

                        
        $workshops = DB::select(DB::raw('select id,name,email,stationno,province,city,address,contactno from users where regtype ="workshop" order by name asc'));


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


/*
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
*/

    public function savetestcylinders(Request $request)
    {


        $labUser =Auth::user()->email;
        $this->validate($request,array(
            'CountryOfOrigin'=>'required',
            'brand'=>'required',
            'standard'=>'required',
            'SerialNo'=>['required',new engravedCylinderno($request->input('SerialNo'),$labUser) ],
            'edate'=>'required',  //inspection date
            'expiry'=>'required',  //expiry date
            'method'=>'required',
        ));


            $CountryOfOrigin=$request->input('CountryOfOrigin');            
            $BrandName=$request->input('brand');
            $Standard=$request->input('standard');
            $SerialNumber=$request->input('SerialNo');            
            $dt1=$request->input('edate');   //inspection date
            $Date=date('Y-m-d', strtotime($dt1));
            
            $method=$request->input('method');



            $diameter=$request->input('diameter');
            $length=$request->input('length');
            $capacity=$request->input('capacity');
            $notes=$request->input('notes');
            $inspector=$request->input('inspector');


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
                        ->get();
                    if ($duplicateSnos[0]->existssno<=0)
                    {
                        DB::insert('insert into RegisteredCylinders
                        (LabCTS,CountryOfOrigin,BrandName,Standard,SerialNumber,LabUser,Date,InspectionExpiryDate,method,diameter,length,capacity,notes,inspector) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ',[$LabCTS,$CountryOfOrigin,$BrandName,$Standard,$SerialNumber,
                                        $LabUser,$Date,$InspectionExpiryDate,$method,$diameter,$length,$capacity,$notes,$inspector]);
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
     
        /*$usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        $countries=DB::select(DB::raw('select distinct countries from worldcountries order by countries asc'));
                        
        $brands=DB::select(DB::raw('select distinct brandname  from  cylinderbrand order by brandname asc;'));

        $email=Auth::user()->email;
        $serialnos=DB::select('select distinct serialno  from  CodeRollsSecondary  where RegisteredCylindersRefNo is null and allotedto=? limit 100',[$email])   ;         
            
        

        return view ('vehicle.InspectedCylinders',['treeitems'=>$treeitems,'countries'=>$countries,'brands'=>$brands,'serialnos'=>$serialnos ]); */


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
                Workshop_identity,Total_Cylinders,Inspection_Status,VehiclerRegistrationNo,Location_cylinder,CL.Location_name,InspectionExpiry ,kit.RegistrationPlate_Pic,kit.RegistrationPlate_Pic_imagetype,kit.WindScreen_Pic,kit.WindScreen_Pic_imagetype
                from  cng_kit kit left join cylinder_locations CL
                on kit.Location_cylinder=CL.Location_id
                where kit.formid=?
                ',[$id]);
        //echo 'show editable form='.$id;

//---rehan here-----------------------------------------------
          /*$cylinders=DB::SELECT('select formid,Cylinder_SerialNo,CngKitSerialNo,InspectionDate,Cylinder_no,ImportDate,Standard,Make_Model,cylinderlocation
                from kit_cylinders where formid =? order by Cylinder_no',[$id]);*/

            $cylinders = DB::table('kit_cylinders')
                    ->leftjoin('RegisteredCylinders', function($join){
                      $join->on('kit_cylinders.Cylinder_SerialNo','=','RegisteredCylinders.SerialNumber');
                    })
                    ->select('kit_cylinders.formid','kit_cylinders.Cylinder_SerialNo','kit_cylinders.CngKitSerialNo','kit_cylinders.CngKitSerialNo','kit_cylinders.InspectionDate','kit_cylinders.Cylinder_no','kit_cylinders.ImportDate','kit_cylinders.Standard','kit_cylinders.Make_Model','kit_cylinders.cylinderlocation',DB::raw('IF(ISNULL(RegisteredCylinders.SerialNumber), "(Unregistered)", "") as cylinderStatus'))
                    ->where('formid','=',$id)
                    ->orderby('Cylinder_no','asc')
                    ->get();                        

        $results = DB::SELECT('select Location_id,Location_name FROM cylinder_locations order by Location_id;');
                
        //$recordid=Request("recordid");


        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);


        $vehicles= DB::table('vehicle_particulars')
                ->select('Inspection_Status')
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

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_1,$inspectiondate]) ;

                        
                        
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


                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_2,$inspectiondate]) ;
                        
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

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_3,$inspectiondate]) ;
                        
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
                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_4,$inspectiondate]) ;
                        
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

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_5,$inspectiondate]) ;
                        
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

                        $validSerialNo=DB::select('select count(id) as totalcylinders from RegisteredCylinders where SerialNumber=? and InspectionExpiryDate > ?',[$serialno_6,$inspectiondate]) ;
                        
                        if ($validSerialNo[0]->totalcylinders<=0)
                        {
                            $registeredserialno = 0;                            

                        }                                                
                    }
                } //end of kit_cylinders
                    $inspectionStatus='pending';
                    if ($cylinderserialnocount == $cylindernos)
                    {   
                        if ($cylindervalve=="on" && $fillingvalve=="on" && $Reducer =="on" && $hpp=="on" && $exhaustpipe=="on")
                        {
                            if ($registeredserialno==1)
                            {
                                $inspectionStatus='completed';    
                            }
                            
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



        if ($usertype =='workshop')
        {
        $vehicles = DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');
                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate')
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
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate')            
                    ->orderby($sortby,'desc')            
                    ->paginate(10);                        

        }




        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        return view ('vehicle.registrations',compact('vehicles','treeitems'));            

    }

    public function listlabtestedcylinders()
    {



            $sort=Request('sort');
            if (!isset($sort)){
                $sort='id';
            }


        $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            


        $labUser =Auth::user()->email;

                if (Auth::user()->regtype=='admin' || Auth::user()->regtype=='hdip' || Auth::user()->regtype=='apcng')
        {
                $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no')

                    ->orderby($sort,'desc')
                    ->paginate(10);            

                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where ('deleted','=',0)
                    ->orderby($sort,'desc')
                    ->paginate(10);                    //all labs
        }
        
        else{
                $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no')

                    ->where ('LabUser','=',$labUser)
                    ->orderby($sort,'desc')
                    ->paginate(10);

                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where('email','=',$labUser) //only reistered lab user
                    ->where ('deleted','=',0)
                    ->orderby($sort,'desc')
                    ->paginate(10);                    
        }

        //return view ('vehicle.listestedcylinders',['testedcylinders'=>$testedcylinders]);            
        
        //return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1);
        //$sort=Request('sort');
        $data =['page'=>'1','sort'=>$sort];
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


    public function searchlabtestedcylinders(Request $request){

        $pagesize=$request->input('pagesize');
        $searchby=$request->input('searchby');
        $searchvalue=$request->input('searchvalue');
        $labName =$request->input('lab');




        
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

/*

                if (Auth::user()->regtype=='admin' || Auth::user()->regtype=='hdip')
        {
            
        $testedcylinders=DB::table('RegisteredCylinders')
                    ->select ('id','LabCTS','BrandName','Standard' ,'SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'stickerSerialNo','method')
                    ->where ($searchby,'=',$searchvalue)
                    ->paginate($pagesize);            
        }
        else
        {
            $testedcylinders=DB::table('RegisteredCylinders')
                    ->select ('id','LabCTS','BrandName','Standard' ,'SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'stickerSerialNo','method')
                    ->where ('LabUser','=',$labUser)
                    ->where ($searchby,'=',$searchvalue)
                    ->paginate($pagesize);            
        }
        
        //return view ('vehicle.listestedcylinders',['testedcylinders'=>$testedcylinders]);            
        return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1);
*/

/*----------------------------------*/

            $sort=Request('sort');
            if (!isset($sort)){
                $sort='id';
            }


        $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            


        $labUser =Auth::user()->email;


                if (Auth::user()->regtype=='admin' || Auth::user()->regtype=='hdip')
        {
                    if ($searchby=="*"){
                        $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no')                    
                    ->where ('LabCTS','=',$labName)                    
                    ->orderby($sort,'desc')
                    ->paginate($pagesize);         

                    } else {
                        $testedcylinders=DB::table('RegisteredCylinders')
                        ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                        ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no')
                        ->where ($searchby,'=',$searchvalue)                    
                        ->where ('LabCTS','=',$labName)                    
                        ->orderby($sort,'desc')
                        ->paginate($pagesize);                                 
                    }



                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')                    
                    ->where ('deleted','=',0)
                    ->orderby($sort,'desc')
                    ->paginate($pagesize);                     //all labs                    
        }
        
        else{
                if ($searchby=="*"){
                    $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no')
                    //->where ($searchby,'=',$searchvalue)
                    ->where ('LabUser','=',$labUser)                    
                    ->where ('LabCTS','=',$labName)                    
                    ->orderby($sort,'desc')
                    ->paginate(10);                    

                } else 
                {
                    $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no')
                    ->where ($searchby,'=',$searchvalue)
                    ->where ('LabUser','=',$labUser)                    
                    ->where ('LabCTS','=',$labName)                    
                    ->orderby($sort,'desc')
                    ->paginate(10);
                }


                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where('email','=',$labUser) //only reistered lab user
                    ->where ('deleted','=',0)
                    ->orderby($sort,'desc')
                    ->paginate($pagesize);                                        
        }

        //return view ('vehicle.listestedcylinders',['testedcylinders'=>$testedcylinders]);            
        
        //return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1);
        //$sort=Request('sort');
        $data =['page'=>'1','sort'=>$sort];
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

session()->flashInput($request->input());

    return view ('vehicle.listtestedcylinders',['testedcylinders'=>$testedcylinders,'treeitems'=>$treeitems,'labs'=>$labs])->with('page',1);
    








    }
    public function editformfortestedcylinders($cylinderid)
    {

        
        
        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

        $countries=DB::select(DB::raw('select distinct countries from worldcountries order by countries asc'));
                        
        $brands=DB::select(DB::raw('select distinct brandname  from  cylinderbrand order by brandname asc;'));

        $email=Auth::user()->email;
        

            
        $CylinderDetails=DB::table('RegisteredCylinders')
                    ->select ('id','LabCTS','BrandName','Standard' ,'SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'stickerSerialNo','method','diameter','length','capacity','inspector','notes')
                    ->where ('id','=',$cylinderid)
                    ->get();            


        return view ('vehicle.editformfortestedcylinders',['treeitems'=>$treeitems,'countries'=>$countries,'brands'=>$brands,'cylinderdetails'=>$CylinderDetails]);
        

    }

    public function updateformfortestedcylinders(Request $request, $id)
    {

        $labUser =Auth::user()->email;
        $this->validate($request,array(
            'CountryOfOrigin'=>'required',
            'brand'=>'required',
            'standard'=>'required',
            'SerialNo'=>['required',new engravedCylindernoUpdate($request->input('SerialNo'),$labUser,$id) ],
            'edate'=>'required',  //inspection date
            'expiry'=>'required',         
            'method' =>'required',
        ));


            $CountryOfOrigin=$request->input('CountryOfOrigin');            
            $BrandName=$request->input('brand');
            $Standard=$request->input('standard');
            $SerialNumber=$request->input('SerialNo');

            $diameter=$request->input('diameter');            
            $length=$request->input('length');            
            $capacity=$request->input('capacity');            
            $inspector=$request->input('inspector');            
            $notes =$request->input('notes');            


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
                                ]);                                            

                    }


                $serialnos='';


                

            }

/*                $testedcylinders=DB::table('RegisteredCylinders')
                    ->select ('id','LabCTS','BrandName','Standard' ,'SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'stickerSerialNo','method')
                    ->orderby('id','desc')
                    ->paginate(10);            
  
            $usertype =Auth::user()->regtype;
            $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            


        return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1); */
        
        
        /*--------------------------------*/
        
                    $sort=Request('sort');
            if (!isset($sort)){
                $sort='id';
            }


        $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            


        $labUser =Auth::user()->email;

                if (Auth::user()->regtype=='admin' || Auth::user()->regtype=='hdip')
        {
                $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no')

                    ->orderby($sort,'desc')
                    ->paginate(10);            

                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where ('deleted','=',0)
                    ->orderby($sort,'desc')
                    ->paginate(10);  //all labs                    
        }
        
        else{
                $testedcylinders=DB::table('RegisteredCylinders')
                    ->leftjoin('vehicle_particulars','RegisteredCylinders.stickerSerialNo','=','vehicle_particulars.StickerSerialNo')                
                    ->select ('id','LabCTS','BrandName','Standard' ,'RegisteredCylinders.SerialNumber','CountryOfOrigin' , 'LabUser' , 'Date', 'InspectionExpiryDate' ,   'RegisteredCylinders.stickerSerialNo','method',
                        'vehicle_particulars.Registration_no')

                    ->where ('LabUser','=',$labUser)
                    ->orderby($sort,'desc')
                    ->paginate(10);

                $labs=DB::table('users')                    
                    ->select ('id','Labname')
                    ->where ('regtype','=','laboratory')
                    ->where ('deleted','=',0)
                    ->where ('email','=',$labUser)
                    ->orderby($sort,'desc')
                    ->paginate(10);                    
        }

        //return view ('vehicle.listestedcylinders',['testedcylinders'=>$testedcylinders]);            
        
        //return view ('vehicle.listtestedcylinders',compact('testedcylinders','treeitems'))->with('page',1);
        //$sort=Request('sort');
        $data =['page'=>'1','sort'=>$sort];
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
