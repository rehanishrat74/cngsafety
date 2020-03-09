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
use Cookie;
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

    $recordperpage = 10;
    $pagesize=10;
   /*if(request()->cookie('pagesize'))
      { $pagesize =request()->cookie('pagesize');
        $recordperpage =$pagesize;
      }*/


        $pagesize=10;
        if  (Cookie::get('pagesize') !== null)
        {            
            $pagesize = Cookie::get('pagesize');
            $recordperpage=$pagesize;
        }
        else
        {$pagesize=10;$recordperpage;}



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
'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.StickerSerialNo','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate','cng_kit.InspectionExpiry')
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
'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.StickerSerialNo','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate','cng_kit.InspectionExpiry')
            ->orderby($sortby,'desc')            
            ->paginate($pagesize);                        

}

        $querystringArray = ['sort' => $sort];
        $vehicles->appends($querystringArray);
    
        return view ('vehicle.registrations',['vehicles'=>$vehicles,'treeitems'=>$treeitems])->with('page',1)
          ->with('pagesize',$pagesize)
          ->with('businessType','N/A')
          ->with('inspectionType','N/A')
          ->with('searchby','N/A')
          ;


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


    public function search(Request $request){

        /*echo 'in request<br>';
        echo '<br>pagesize='.$request->input('pagesize');
        echo '<br>searchby'.$request->input('searchby');
        echo '<br>searchvalue'.$request->input('searchvalue');*/

        //$pagesize=$request->input('pagesize');
        $searchby=$request->input('searchby');
        $searchvalue=$request->input('searchvalue');        
$whereArray=[];
$values_array=[];
//$whereArray=array($searchby,'=',$searchvalue);

//1-----------

$keys_array=[];
$values_array=[];

        if ($searchby=="created_at" ) {
            if (!isset($searchvalue)){
                $searchvalue='01/01/1900'; //default value if provided date is empty
            }
            $searchvalue=date('Y-m-d', strtotime($searchvalue));
            $searchby='vehicle_particulars.created_at';
            //converting date from mdy to YMD

        }



        if ($searchby=="serialno" && isset($searchvalue)){
      
            $searchby="vehicle_particulars.StickerSerialNo"; 

        }



if ($searchby!="All")
{

$keys_array=array($searchby);
$values_array=array($searchvalue);

} 

        $pagesize=10;
        if  (Cookie::get('pagesize') != null)
        {            
            $pagesize = Cookie::get('pagesize');
            Cookie::queue('pagesize', $pagesize, 120);
            $request->session()->put('pagesize',$pagesize);
        }
        else
        {$pagesize=10;
            Cookie::queue('pagesize', $pagesize, 120);
            $request->session()->put('pagesize',$pagesize);

        }

        
      
        if  (Cookie::get('registrations_businessType') != null)
        {
            $registrations_businessType = Cookie::get('registrations_businessType');
            if ($registrations_businessType !='All')
            {
             
              if (count($keys_array)>0 && $registrations_businessType!="All") {
                array_push($keys_array, "businesstype");
                array_push($values_array, $registrations_businessType);
              } else
              {
                if ($registrations_businessType!="All") {
                $keys_array=array("businesstype");
                $values_array=array($registrations_businessType);                  
                }

              }


            }
        }else {$registrations_businessType="All";}

        if  (Cookie::get('registrations_inspectionType') != null)
        {
            $registrations_inspectionType = Cookie::get('registrations_inspectionType');
  
            //pending / completed
            if (count($keys_array)>0 && $registrations_inspectionType !="All" ) {
            array_push($keys_array, "vehicle_particulars.Inspection_Status");
            array_push($values_array, $registrations_inspectionType);
            }else
              {
                if ($registrations_inspectionType !="All"){
                $keys_array=array("vehicle_particulars.Inspection_Status");
                $values_array=array($registrations_inspectionType);                  
                }

              }

        } else {  $registrations_inspectionType="All";}


      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

            $sortby="Record_no";

if ($usertype=="workshop"){

  if (count($keys_array)>0) {
    array_push($keys_array, "vehicle_particulars.stationno");
    array_push($values_array, Auth::user()->stationno);
  } else
  {
      $keys_array=array("vehicle_particulars.stationno");
      $values_array=array(Auth::user()->stationno);
  }


}            
$whereArray=array_combine( $keys_array, $values_array );



$vehicles = DB::table('vehicle_particulars')
            ->leftjoin('owner__particulars', function($join){
              $join->on('vehicle_particulars.OwnerCnic','=','owner__particulars.CNIC');
              $join->on('vehicle_particulars.Registration_no','=','owner__particulars.VehicleReg_No');

            })
            ->leftjoin('cng_kit','cng_kit.formid','=','vehicle_particulars.lastinspectionid')
            ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.StickerSerialNo','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno',DB::raw('IF(ISNULL(vehicle_particulars.Inspection_Status), "pending", vehicle_particulars.Inspection_Status) as Inspection_Status'),DB::raw('IF(ISNULL(vehicle_particulars.lastinspectionid), 0,vehicle_particulars.lastinspectionid) as formid'),'vehicle_particulars.created_at','vehicle_particulars.StickerSerialNo','cng_kit.InspectionDate','cng_kit.InspectionExpiry')
            ->where($whereArray)
            ->orderby($sortby,'desc')              
            ->paginate($pagesize);

 


        return view ('vehicle.registrations',compact('vehicles','treeitems'))->with('page',1)
                                                                              ->with('pagesize',$pagesize)
                                                                              ->with('businessType',$registrations_businessType)
                                                                              ->with('inspectionType',$registrations_inspectionType)
                                                                              ->with('searchby',$searchvalue)
                                                                              ;


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
