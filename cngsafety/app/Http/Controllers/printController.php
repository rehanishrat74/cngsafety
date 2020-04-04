<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use PDF;
use DB;

class printController extends Controller
{

    public function cylindersPrintIndex($row){

     // ini_set('max_execution_time', 300);
      //ini_set("memory_limit","512M");
       $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

      $cylinders=$this->cylindersDB($row);

    //http://phillihp.com/toolz/php-array-beautifier/php-beautifier-v2/
     /*$pdf=PDF::loadView('Print.cylindersReport',['cylinders'=>$cylinders])->setPaper('a4', 'landscape');
      return $pdf->download('cylinders.pdf');*/
      if ($usertype=="admin" || $usertype=="hdip"){
          return view ('Print.cylindersReport',['cylinders'=>$cylinders,'treeitems'=>$treeitems]);
      } else {
         return 'Not authorized';
      }
    }
    //
    public function cylinders(){

      //$cylinders=$this->cylindersDB();
      //print_r($cylinders);
      //http://phillihp.com/toolz/php-array-beautifier/php-beautifier-v2/
    	/*$pdf=PDF::loadView('Print.cylindersReport',['cylinders'=>$cylinders])->setPaper('a4', 'landscape');
    	return $pdf->download('cylinders.pdf');*/
       $usertype =Auth::user()->regtype;
        $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

   $cylinders=DB::table('registeredcylinders')
            ->leftjoin('users',function($join){
              $join->on('registeredcylinders.LabUser','=','users.email');
            })
            ->select(DB::Raw('count(registeredcylinders.id) as recs') )
            
            ->whereIn('users.regtype', ['laboratory', 'hdip', 'apcng'])
            ->get();
            

      return view ('Print.cylindersReportpaged',['cylinders'=>$cylinders,'treeitems'=>$treeitems]);
    }

    public function printCylinderIndex()
    {

    }
    public function cylindersDB($row){
     $rowSql='set @row:='.$row;
    
      DB::statement(DB::raw($rowSql));      
        $cylinders=DB::table('registeredcylinders')
            ->leftjoin('users',function($join){
              $join->on('registeredcylinders.LabUser','=','users.email');
            })
            ->select('registeredcylinders.id','registeredcylinders.LabCTS','registeredcylinders.CountryOfOrigin','registeredcylinders.BrandName','registeredcylinders.Standard','registeredcylinders.SerialNumber','registeredcylinders.LabUser','registeredcylinders.Date','registeredcylinders.InspectionExpiryDate','registeredcylinders.method','registeredcylinders.diameter','registeredcylinders.length','registeredcylinders.capacity','registeredcylinders.DateOfManufacture','registeredcylinders.ownername','registeredcylinders.vehicleRegNo','registeredcylinders.ocnic','registeredcylinders.certificate' , 'users.email','users.province','users.city','users.regtype','users.address','users.labname','users.contactno','users.hdip_lic_no','users.ownercellno','users.ownername','users.mobileno','users.landlineno','users.companyname')            
            ->whereIn('users.regtype', ['laboratory', 'hdip', 'apcng'])
            ->orderBy('users.Province','desc')
            ->orderBy('users.city','desc')
            ->orderBy('users.labname','desc')
            ->orderBy('registeredcylinders.CountryOfOrigin','desc')
            ->orderBy('registeredcylinders.BrandName','desc')
             ->orderBy('registeredcylinders.Standard','desc')
             ->orderBy('registeredcylinders.diameter','desc')
             ->orderBy('registeredcylinders.capacity','desc')
             ->orderBy('registeredcylinders.SerialNumber','desc')
            ->paginate(500);
            //->where('registeredcylinders.LabUser','=','Friends.engineeringmultan@yahoo.com')
            //->whereIn('registeredcylinders.LabUser',['Friends.engineeringmultan@yahoo.com','saye.cngtesting@gmail.com'])
            //->where('registeredcylinders.BrandName','=','Beijing Tianhai Industrial Co (BTIC)')            
            return $cylinders;
    }

    public function vehicleDB($sortby)
    {
      //$stationno=Auth::user()->stationno;
      $usertype =Auth::user()->regtype;
      $printWhere="";
      $printOrderBy="";
      $printPaginate="";

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
            ->get();                        
            
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
            ->get();                        
            
      }

      return $vehicles;

    }

    public function vehicles() {
    	$paginate=$_GET['printPaginate'];
    	$printOrderBy=$_GET['printOrderBy'];
    	$printWhere=$_GET['printWhere'];
    	$functionName=$_GET['function'];
    	$vehicles=[];

    	if ($functionName=='vehicleIndex') {

    		$vehicles=$this->vehicleDB($printOrderBy,$paginate);
    	}

ini_set('max_execution_time', 300);
ini_set("memory_limit","512M");

      //$pdf=PDF::loadView('Print.vehiclesReport',compact('vehicles'))->setPaper('a4', 'landscape');
      
$pdf=PDF::loadView('Print.vehiclesReport',['vehicles'=>$vehicles])->setPaper('a4', 'landscape');
      return $pdf->download('vechiles.pdf');
    }
}
