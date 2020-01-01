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
$request->validate([

//'scancode' => 'required',
'maketype' => 'required',
'registrationNo' => 'required', 
'chasisno' => 'required',
'engineNo' => 'required',
'oname' => 'required',
'cnic' => array('required','regex:/(^([\d]{5}-[\d]{7}-[\d])$)/'),
'cellno' => array('required','regex:/(^([\d]{4}-[\d]{3}-[\d]{4})$)/'),
'address' => 'required|min:3',
'stationno' => ['required','regex:/(^([a-zA-Z]{3}-[\d]+)$)/',new workstationno($stationno)],
//'stationno' => ['required',new workstationno($stationno)],

]);




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

$sortby="Record_no"; // to make compatible with vehiclelogiccontroller at the end of this function

        $currentdt = Carbon::now();
        // get the current time  - 2015-12-19 10:10:54
        $current = Carbon::now();
        $current = new Carbon();





        $dt1=Carbon::today();
        $created_at=date('Y-m-d', strtotime($dt1));


        // $dt->format('Y-m-d H:i:s');
        if (!is_null($cnic) && !empty($cnic) && isset($cnic) && !is_null($registrationNo) && !empty($registrationNo) && isset($registrationNo) )
        {
                
                    $results = DB::select('select count(cnic) as owners from owner__particulars where cnic = ? and owner__particulars.VehicleReg_No=?', [$cnic,$registrationNo]);
                        //->orwhere('VehicleReg_No','=',$registrationNo)->get();
                    //print_r($results).'<br>';
                    $countowners=$results[0]->owners;


                    if (!$countowners >=1 )
                    {

                        DB::insert('insert into owner__particulars (Owner_name,CNIC,Cell_No,Address,VehicleReg_No) values (?,?,?,?,?)', [$oname, $cnic,$cellno,$address,$registrationNo]);
                    }

                    $vresults = DB::select('select count(Record_no) as vehiclecount from vehicle_particulars where Registration_no = ? and OwnerCnic=?', [$registrationNo,$cnic]);
                    
                    $countvehicles=$vresults[0]->vehiclecount;
                    

                    if (!$countvehicles >=1) {
                        DB::insert('insert into vehicle_particulars (Registration_no ,Chasis_no,Engine_no,Vehicle_catid,Make_type ,OwnerCnic,created_at,businesstype,stationno ) values (?, ?, ?,?,?,?,?,?,?)',[$registrationNo,$chasisno,$engineNo,$vcat,$maketype,$cnic,$created_at,$businesstype,$stationno]);
                    }
                

        }



        $usertype =Auth::user()->regtype;


        if ($usertype =='workshop')
        {
        $vehicles = DB::table('vehicle_particulars')
                    ->leftjoin('owner__particulars', function($join){
                      $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
                      $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');

                    })
                    ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
                    ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','cng_kit.InspectionDate')
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
        'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','cng_kit.InspectionDate')            
                    ->orderby($sortby,'desc')            
                    ->paginate(10);                        

        }





      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);            




            
        return view ('vehicle.registrations',compact('vehicles','treeitems'))->with('page',1);




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
