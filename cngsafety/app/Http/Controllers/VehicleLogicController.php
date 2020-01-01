<?php



namespace App\Http\Controllers;
use Auth;
//use Sortable; 
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\user;
use App\Owner_Particulars;
use App\VehicleParticulars;
use App\vehicleCategory;
//use Illuminate\Support\Facades\Paginator;
//use Illuminate\Pagination\Paginator;
class VehicleLogicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$owners=Owner_Particulars::all();
        //$vehicles = VehicleParticulars::all();
        //$categories = vehicleCategory::all();
        //return view ('vehicle.registrations',compact('owners','vehicles','categories'));
      
      
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

      $sort= Request('sort');
      $sortby="Record_no";

      if ($sort=="Recordno")
      { 
        $sortby="Record_no";

      }else if ($sort=="Registrationno")
      {
        $sortby="Registration_no";

      }else if ($sort=="Make"){
        $sortby="Make_type";

      }else if ($sort=="Type"){
        $sortby="businesstype";

      }else if ($sort=="Owner"){
        $sortby="Owner_name";

      }else if ($sort=="Station"){
        $sortby="stationno";

      }else if ($sort=="Engine"){
        $sortby="Engine_no";

      }else if ($sort=="Inspection"){
        $sortby="Inspection_Status";
      }



//$stationno=Auth::user()->stationno;
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




        $querystringArray = ['sort' => $sort];
        $vehicles->appends($querystringArray);
        return view ('vehicle.registrations',['vehicles'=>$vehicles,'treeitems'=>$treeitems])->with('page',1);
      
    }


    /*
    sample
    $querystringArray = ['sort' => $sort];

    $testedcylinders->appends($querystringArray);
    return view ('vehicle.listtestedcylinders',['testedcylinders'=>$testedcylinders,'treeitems'=>$treeitems])->with('page',1);
    */

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


    public function search(Request $request){

        /*echo 'in request<br>';
        echo '<br>pagesize='.$request->input('pagesize');
        echo '<br>searchby'.$request->input('searchby');
        echo '<br>searchvalue'.$request->input('searchvalue');*/



        $pagesize=$request->input('pagesize');
        $searchby=$request->input('searchby');
        $searchvalue=$request->input('searchvalue');
        
        if ($searchby=="created_at" ) {
            if (!isset($searchvalue)){
                $searchvalue='01/01/1900'; //default value if provided date is empty
            }
            $searchvalue=date('Y-m-d', strtotime($searchvalue));
            $searchby='vehicle_particulars.created_at';
            //converting date from mdy to YMD

        }



        if ($searchby=="serialno" && isset($searchvalue)){
            //if cylinder serial no is entered, we find corresponding vehicle.
            $formid = DB::select('select formid FROM kit_cylinders where Cylinder_SerialNo=? order by formid desc limit 1',[$searchvalue]);
            //print_r($formid);

            $Registration_no=DB::select('select VehiclerRegistrationNo from homestead.cng_kit 
               where formid =? order by formid desc limit 1',[$formid[0]->formid]);

            $searchby="Registration_no"; 
            $searchvalue=$Registration_no[0]->VehiclerRegistrationNo; //vechicle found

        }


      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);


    
/*      $cng_kit =DB::table('cng_kit')
        ->select(DB::raw('IF(ISNULL(Inspection_Status), "pending", Inspection_Status) as Inspection_Status'),
            'VehiclerRegistrationNo', DB::raw('IF(ISNULL(formid), 0,formid) as formid'))
        ->orderby('formid','desc');


$vehicles = DB::table('vehicle_particulars')
            ->leftjoin('owner__particulars','owner__particulars.CNIC','=','vehicle_particulars.OwnerCnic')
              ->joinSub($cng_kit,'cng_kit',function($leftjoin){
                $leftjoin->on('vehicle_particulars.Registration_no','=','cng_kit.VehiclerRegistrationNo');
            })
            ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno','cng_kit.VehiclerRegistrationNo','cng_kit.Inspection_Status','cng_kit.formid','vehicle_particulars.created_at')
            ->where($searchby,'=',$searchvalue)
            ->orderby('Record_no','desc')  
            ->paginate($pagesize);*/

/*$vehicles = DB::table('vehicle_particulars')
            ->leftjoin('owner__particulars','owner__particulars.CNIC','=','vehicle_particulars.OwnerCnic')

            ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at')
            ->where($searchby,'=',$searchvalue)
            ->orderby('Record_no','desc')  
            ->paginate($pagesize);            
*/
            $sortby="Record_no";

if ($usertype=="workshop")
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
            ->where($searchby,'=',$searchvalue)
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
'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate')            
            ->where($searchby,'=',$searchvalue)
            ->orderby($sortby,'desc')            
            ->paginate($pagesize);                   
}


        return view ('vehicle.registrations',compact('vehicles','treeitems'))->with('page',1);




/*  Registration no</option> Registration_no
    CNIC</option>            CNIC
    Owner</option>           Owner_name
    Station no</option>  stationno
    type</option>            businesstype

    date</option>            =>?created_at
    Serial no</option>  ?serialno


            $dt1=Carbon::today();            
            $inspectiondate = date('Y-m-d', strtotime($dt1));
            $dt1 = Carbon::today()->addMonths(12);
            $expiryDate=date('Y-m-d', strtotime($dt1));

    $location = $request->input('location');*/


    }
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
