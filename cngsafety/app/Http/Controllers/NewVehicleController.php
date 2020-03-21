<?php


namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;    //for date time
use App\Rules\workstationno;
use App\Rules\ValidStickerForWorkstation;
use App\Rules\Cnic;
use Cookie;
//use App\vehicleCategory; //donot need model




class NewVehicleController extends Controller
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

        return view('vehicle.newVehicle',['treeitems'=>$treeitems])->with('stationno',$usertype =Auth::user()->stationno);
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /*
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'scancode' => ['required', 'string', 'max:255'],
            'maketype' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'registrationNo' => ['required', 'string', 'min:8', 'confirmed'],
            'chasisno' => ['required','string','max:255'],

            'enginenNo' => ['required','string','max:255'],
            'vcat' => ['required','string','max:255'],
            'oname' => ['required','string','max:255'],
            'cnic' => ['required','string','max:255'],
            'cellno' => ['required','string','max:255'],
            'address' => ['required','string','max:255'],
        ]);
        need to find out how to call this function
    }


*/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //print_r($request);
        //validation will be put later
        $stationno=$request->input('stationno');
        $Stickerno=$request->input('Stickerno');
        $ocnic =$request->input('cnic');
        $vehicle =$request->input('registrationNo');

        $workstationParams = array('stationno' => $stationno,'Stickerno'=>$Stickerno);
        $vehicleParams= array('cnic' => $ocnic,'vehicle'=>$vehicle);

        $VehicleName=$request->input('VehicleName');

        $request->validate([

            //'scancode' => 'required',
        'maketype' => 'required',
        'Stickerno'=> ['required',new ValidStickerForWorkstation($workstationParams)],
        'registrationNo' => 'required', 
        'VehicleName' => 'required',
        'chasisno' => 'required',
        'engineNo' => 'required',
        'oname' => 'required',
        //'cnic' => array('required','regex:/(^([\d]{5}-[\d]{7}-[\d])$)/'),
        'cnic' => ['required','regex:/(^([\d]{5}-[\d]{7}-[\d])$)/',new Cnic($vehicleParams)],
        'cellno' => array('required','regex:/(^([\d]{4}-[\d]{3}-[\d]{4})$)/'),
        'address' => 'required|min:3',
        //'stationno' => ['required','regex:/(^([a-zA-Z]{3}-[\d]+)$)/',new workstationno($stationno)],
        'stationno' => ['required','regex:/(^([a-zA-Z]{3}-[\d]+)$)/',new workstationno($workstationParams)],
        //'stationno' => ['required',new workstationno($stationno)],

        ]);

        $case="init_insert";
        //dd('break');

        //'SerialNo'=>['required',new workstationno($request->input('stationno')) ],

        /*$this->validate(request(), [
            'projectName' => 
                array(
                        'required',
                        'regex:/(^([a-zA-Z]+)(\d+)?$)/u'
                )
        ];*/




        ///echo 'scancode='.$request->input('scancode').'<br>';
        /*echo 'maketype='.$request->input('maketype').'<br>';
        echo 'registrationNo='.$request->input('registrationNo').'<br>';
        echo 'chasisno='.$request->input('chasisno').'<br>';
        echo 'engineNo='.$request->input('engineNo').'<br>';
        echo 'vcat='.$request->input('vcat').'<br>';
        echo 'oname='.$request->input('oname').'<br>';
        echo 'cnic='.$request->input('cnic').'<br>';
        echo 'cellno='.$request->input('cellno').'<br>';
        echo 'address='.$request->input('address').'<br>';
        echo 'stationno='.$request->input('stationno').'<br>';*/


        $businesstype= $request->input('businesstype');
        $scancode= $request->input('scancode');
        $maketype= $request->input('maketype');
        $registrationNo= $request->input('registrationNo');
        $chasisno=$request->input('chasisno');
        $engineNo=$request->input('engineNo');
        $vcat=$request->input('vcat');
        $oname=$request->input('oname');
        $cnic=$request->input('cnic');
        $cellno=$request->input('cellno');
        $address=$request->input('address');
        $stationno=$request->input('stationno');
        $Stickerno=$request->input('Stickerno');

        $sortby="Record_no"; // to make compatible with vehiclelogiccontroller at the end of this function

        $currentdt = Carbon::now();
        // get the current time  - 2015-12-19 10:10:54
        $current = Carbon::now();
        $current = new Carbon();
        $insertedrecordno=0;

        //dd('break2');


        $dt1=Carbon::today();
        $created_at=date('Y-m-d', strtotime($dt1));

        //$Stickerno=$request->input('Stickerno');
        // $dt->format('Y-m-d H:i:s');
        if (!is_null($cnic) && !empty($cnic) && isset($cnic) && !is_null($registrationNo) && !empty($registrationNo) && isset($registrationNo)  && !is_null($Stickerno) && !empty($Stickerno) && isset($Stickerno)
            )
        {
                
                    $results = DB::select('select count(cnic) as owners from owner__particulars where cnic = ? and owner__particulars.VehicleReg_No=? and StickerSerialNo=?', [$cnic,$registrationNo,$Stickerno]);
                        //->orwhere('VehicleReg_No','=',$registrationNo)->get();
                    //print_r($results).'<br>';
                    $countowners=$results[0]->owners;


                    if (!$countowners >=1 )
                    {

                        DB::insert('insert into owner__particulars (Owner_name,CNIC,Cell_No,Address,VehicleReg_No,StickerSerialNo) values (?,?,?,?,?,?)', [$oname, $cnic,$cellno,$address,$registrationNo,$Stickerno]);
                                 
                                   DB::table('CodeRollsSecondary')
                                    ->where(['serialno'=> $Stickerno])
                                    ->update([
                                        'cnic' => $cnic,
                                        'vehicleRegNo' => $registrationNo
                                        ]);                           

                    }

                   // $vresults = DB::select('select count(Record_no) as vehiclecount from vehicle_particulars where Registration_no = ? and OwnerCnic=? and StickerSerialNo=?', [$registrationNo,$cnic,$Stickerno]);
                     $vresults = DB::select('select count(Record_no) as vehiclecount from vehicle_particulars where Registration_no = ? and OwnerCnic=? and StickerSerialNo=?', [$registrationNo,$cnic,$Stickerno]);
                    
                    $countvehicles=$vresults[0]->vehiclecount;
                    

                    if (!$countvehicles >=1) {
                        $insertedrecordno=DB::insert('insert into vehicle_particulars (Registration_no ,Chasis_no,Engine_no,Vehicle_catid,Make_type ,OwnerCnic,created_at,businesstype,stationno,StickerSerialNo,VehicleName ) values (?, ?, ?,?,?,?,?,?,?,?,?)',[$registrationNo,$chasisno,$engineNo,$vcat,$maketype,$cnic,$created_at,$businesstype,$stationno,$Stickerno,$VehicleName]);
                        $case="complete_insert";

                       $vehicle= DB::select('select * from vehicle_particulars where Registration_no=? and StickerSerialNo=?',[$registrationNo,$Stickerno]);
                            $insertedrecordno=$vehicle[0]->Record_no;        
                            $recordid =$vehicle[0]->Record_no;
                            $id=$registrationNo;
                    }
                

        }



        $usertype =Auth::user()->regtype;


        if ($usertype =='workshop')
        {
            $vehicles = $this->getVehiclesForListing($sortby,10);        
        }
        else
        {

            $vehicles = $this->getVehiclesForListing($sortby,10);


        }


        $treeitems =$this->getTree();

        
        $targetroute = route('newcylinderreg',$registrationNo.'?recordid='.$insertedrecordno.'&stationno='.$stationno);


        //http://cngsafety.test/newcylinderreg/KZ66%20ZYT?recordid=23&stationno=PFJ-1
        
        if ($case=="complete_insert" ){             


        $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);


        $results = DB::SELECT('select Location_id,Location_name FROM cylinder_locations order by Location_id;');        
        //$newvehicle=array([$id]);
        

        
        $stationno=DB::SELECT('select stationno,stickerSerialNo FROM vehicle_particulars where Record_no=?',[$recordid]);


            

      //echo '<br> recordid='.$recordid;
      //echo '<br> id'.$id;
      //print_r($stationno);

           // ----------------return view('vehicle.cylinders',['cylinder_locations'=>$results,'newvehicle'=>$id,'treeitems'=>$treeitems,'stationno'=>$stationno ]);        

        return redirect()->to($targetroute)->with('cylinder_locations',$results)
                                                    ->with('newvehicle',$id)
                                                   ->with('treeitems',$treeitems)
                                                    ->with('stationno',$stationno);
            

            } else {

            return view ('vehicle.registrations',compact('vehicles','treeitems'))->with('page',1);
        }
        



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
      

        //$usertype =Auth::user()->regtype;
        $treeitems =$this->getTree(); 
        // DB::select('select * from AccessRights where regtype =?',[$usertype]);    
  /*      
        $vehicles = DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');
                    })                    
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.StickerSerialNo' , 'vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno')
                    ->where ('vehicle_particulars.Record_no','=',$id)
                    ->get();   
*/

        $vehicles =  DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');
                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.VehicleName','vehicle_particulars.Make_type','vehicle_particulars.StickerSerialNo','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','cng_kit.InspectionDate','cng_kit.InspectionExpiry')            
                    ->where ('vehicle_particulars.Record_no','=',$id)
                    ->get(); 


        return view ('vehicle.editVehicle',compact('vehicles','treeitems'));         
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
        /*echo 'in update request id ='.$id."<br>";
         echo 'station no ='.$request->input('stationno').'<br>';
         echo 'make type ='.$request->input('maketype').'<br>';
         echo 'chasis no ='.$request->input('chasisno').'<br>';
         echo 'engine no ='.$request->input('engineNo').'<br>';
         echo 'vcat='.$request->input('vcat').'<br>';
         echo 'businesstype='.$request->input('businesstype').'<br>';
         echo 'owner name='.$request->input('oname').'<br>';
         echo 'cellno='.$request->input('cellno').'<br>';
         echo 'address='.$request->input('address').'<br>';
         echo 'sticker='.$request->input('hidden_StickerSerialNo').'<br>';
         echo 'vehicle='.$request->input('hidden_Registration_no').'<br>';
         echo 'cnic'.$request->input('hidden_cnic').'<br>';*/

         $Record_no=$id;
         $stationno=$request->input('stationno');
         $maketype=$request->input('maketype');
         $chasisno=$request->input('chasisno');
         $engineNo=$request->input('engineNo');
         $vcat=$request->input('vcat');
         $businesstype=$request->input('businesstype');
         $oname=$request->input('oname');
         $cellno=$request->input('cellno');
         $address=$request->input('address');
         $sticker=$request->input('hidden_StickerSerialNo');
         $vehicle=$request->input('hidden_Registration_no');
         $cnic=$request->input('hidden_cnic');
 $VehicleName=$request->input('VehicleName');
$request->validate([

//'scancode' => 'required',
    //station code, cnic and reg no are commented because in edit mode the fields are disabled
'maketype' => 'required',
'VehicleName' => 'required',
//'Stickerno'=> ['required',new ValidStickerForWorkstation($workstationParams)],
//'registrationNo' => 'required', 
'chasisno' => 'required',
'engineNo' => 'required',
'oname' => 'required',
//'cnic' => array('required','regex:/(^([\d]{5}-[\d]{7}-[\d])$)/'),
//'cnic' => ['required','regex:/(^([\d]{5}-[\d]{7}-[\d])$)/',new Cnic($vehicleParams)],
'cellno' => array('required','regex:/(^([\d]{4}-[\d]{3}-[\d]{4})$)/'),
'address' => 'required|min:3',
//'stationno' => ['required','regex:/(^([a-zA-Z]{3}-[\d]+)$)/',new workstationno($stationno)],
//'stationno' => ['required','regex:/(^([a-zA-Z]{3}-[\d]+)$)/',new workstationno($workstationParams)],
//'stationno' => ['required',new workstationno($stationno)],

]);
        $sort="Recordno";
         $sortby="Record_no";

        $pagesize=10;
        if  (Cookie::get('pagesize') !== null)
        {            
            $pagesize = Cookie::get('pagesize');
            $recordperpage=$pagesize;
        }
        else
        {$pagesize=10;$recordperpage;}


        DB::table('owner__particulars')                       
                        ->where(['CNIC'=> $cnic])
                        ->where(['VehicleReg_No'=> $vehicle])                        
                        ->update(['Owner_name' => $oname,
                                  'Cell_No' => $cellno,
                                  'Address' =>$address
                                ]);     

        DB::table('vehicle_particulars')
                        ->where(['Record_no'=> $Record_no])                                               
                        ->update(['Chasis_no' => $chasisno,
                                  'Engine_no' => $engineNo,
                                  'Vehicle_catid' =>$vcat,
                                  'Make_type' => $maketype,
                                  'businesstype' =>$businesstype,
                                  'VehicleName'=>$VehicleName
                                ]); 
        $treeitems = $this->getTree();
        $vehicles = $this->getVehiclesForListing("Record_no",10);
       //echo 'here';

        $querystringArray = ['sort' => $sort];
        $vehicles->appends($querystringArray);


        $querystringArray = ['sort' => $sort];
        $vehicles->appends($querystringArray);


      //  return view ('vehicle.registrations',compact('vehicles','treeitems'))->with('page',1);   
        return view ('vehicle.registrations',['vehicles'=>$vehicles,'treeitems'=>$treeitems])->with('page',1)
          ->with('pagesize',$pagesize)
          ->with('businessType','N/A')
          ->with('inspectionType','N/A')
          ->with('searchby','N/A')
          ;                             

    }
    protected function getVehiclesForListing($sortby,$pagesize)
    {
        $usertype =Auth::user()->regtype;
        $selectStatement="";

        if ($usertype =='workshop')
        {
                return DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');

                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.StickerSerialNo','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','cng_kit.InspectionDate','cng_kit.InspectionExpiry')
                    ->where('vehicle_particulars.stationno','=',Auth::user()->stationno) //this is the only diff
                    ->orderby($sortby,'desc')            
                    ->paginate($pagesize); 
        } else {

            return DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');
                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.StickerSerialNo','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','cng_kit.InspectionDate','cng_kit.InspectionExpiry')            
                    ->orderby($sortby,'desc')            
                    ->paginate($pagesize); 
        }
          

    }
    protected function getTree()
    {
        $usertype =Auth::user()->regtype;
        return DB::select('select * from AccessRights where regtype =?',[$usertype]);            
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
