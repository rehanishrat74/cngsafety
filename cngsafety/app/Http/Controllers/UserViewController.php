<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\user;
//use  App\Http\Controllers\Auth;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;

class UserViewController extends Controller
{
  public function __construct() {
      $this->middleware('auth');
   }
    //
   public function index() {
        //oreach($myModal->getFillable() as $property)
    //echo $this->user->regtype;
    //echo $user->getFillable();
     //echo  Auth::user()->regtype ;

/*$vehicles = DB::table('vehicle_particulars')
            ->leftjoin('owner__particulars','owner__particulars.CNIC','=','vehicle_particulars.OwnerCnic')
              ->joinSub($cng_kit,'cng_kit',function($leftjoin){
                $leftjoin->on('vehicle_particulars.Registration_no','=','cng_kit.VehiclerRegistrationNo');
            })
            ->select('owner__particulars.CNIC','owner__particulars.Owner_name','owner__particulars.CNIC','owner__particulars.Cell_No','owner__particulars.Address', 'vehicle_particulars.Record_no','vehicle_particulars.Registration_no','vehicle_particulars.Chasis_no','vehicle_particulars.Engine_no',
'vehicle_particulars.Vehicle_catid','vehicle_particulars.Make_type','vehicle_particulars.Scan_code','vehicle_particulars.OwnerCnic','vehicle_particulars.businesstype','vehicle_particulars.stationno','cng_kit.VehiclerRegistrationNo','cng_kit.Inspection_Status','cng_kit.formid')
            ->orderby($sortby,'desc')            
            ->paginate(2);*/



if (Auth::user()->regtype =='admin')
{
  $users = DB::table('users')
        ->select('users.*')
        ->where('deleted','!=',1)
        ->paginate(10);

}else if (Auth::user()->regtype =='hdip' || Auth::user()->regtype =='apcng')
{
    $users = DB::table('users')
        ->select('users.*')
        ->where('deleted','!=',1)
        ->where('regtype','=','laboratory')
        ->paginate(10);

}


        //->orderby



      /*$users = DB::select('select * from users');*/
      
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      //print_r($treeitems);
      return view('user.user_view',['users'=>$users,'treeitems'=>$treeitems])->with('page',1);
   }

  public function showuser($userid)
    {
      //echo 'user='.$userid;
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);



      $userdetails =DB::select('select id,name,email,address,regtype,labname,contactno,hdip_lic_no,cellnoforinspection,technician,ownercellno,ownername,mobileno,landlineno,engineername,companyname,cellverified,imei,latitude,longitude,stationno,city,province from users where id =?',[$userid]);

      

      return view ('user.showuser',['treeitems'=>$treeitems,'userdetails'=>$userdetails]);
    }

    public function edituser(Request $data)
    {
      


      if ($data->userregtypehidden=="admin")
      {

        //'userid' => 'required','useremail' => 'required'
         $adminfields =array('username' => 'required','useraddress' => 'required','usercontact' =>'required','usermobileno'=> 'required');

             $this->validate($data,$adminfields);

              DB::table('users')
                ->where('id','=', $data->useridhidden)                
                ->update(['name' => $data->username,
                          'address' => $data->useraddress,
                          'contactno' => $data->usercontact,
                          'mobileno' => $data->usermobileno
                ]);   
                
      } 
      elseif ($data->userregtypehidden=="workshop")
      {
         $workshopfields =array('username' => 'required', 'useraddress' => 'required', 'usercontact' => 'required', 'userownercellno' => 'required' , 'userownername'=> 'required' , 'usertechnician'=>'required' );

             $this->validate($data,$workshopfields);        
              
              DB::table('users')
                ->where('id','=', $data->useridhidden)                
                ->update(['name' => $data->username,
                          'address' => $data->useraddress,
                          'contactno' => $data->usercontact,
                          'ownercellno' =>$data->userownercellno,
                          'ownername' => $data->userownername,
                          'technician' => $data->usertechnician
                          
                ]);                          

          $cellverified =0;
          //dd($data->isverified);
          if (is_null($data->isverified) )
          {
            $cellverified =0;
          } elseif ($data->isverified==0){
            $cellverified =0;
          }elseif ($data->isverified==1){
            $cellverified =1;
          }

          
          $inspectionquery =DB::select('select cellnoforinspection,cellverified,imei from users where id =?',[$data->useridhidden]);
          
          if ($inspectionquery[0]->cellverified!=$cellverified ||   
              $inspectionquery[0]->cellnoforinspection!=$data->usercellnoforinspection ||
              $inspectionquery[0]->imei !=$data->userimei ) 
          {
            //if any values changes reinstall of app is needed.            
              if ($cellverified==0){
                //dd($cellverified);
                  DB::table('users')
                ->where('id','=', $data->useridhidden)                
                ->update(['cellnoforinspection' => $data->usercellnoforinspection,
                          'cellverified' => 0,
                          'imei' => '',
                          'pin_code' => null
                ]);                            

              } else {
                DB::table('users')
                ->where('id','=', $data->useridhidden)                
                ->update([ 'cellverified' =>$cellverified,
                  'cellnoforinspection' => $data->usercellnoforinspection
                 ]);                          

                }

          } 

            

          

      }
      elseif ($data->userregtypehidden=="laboratory")
      {

         $labfields =array('username' => 'required','useraddress' => 'required','usercontact' =>'required','userlabname'=>'required' , 'userownername'=>'required','usercompanyname'=>'required', 'userengineername'=>'required','userlandlineno'=>'required' , 'usermobileno'=> 'required','userhdip_lic_no'=>'required');

             $this->validate($data,$labfields);

              DB::table('users')
                ->where('id','=', $data->useridhidden)                
                ->update(['name' => $data->username,
                          'address' => $data->useraddress,
                          'contactno' => $data->usercontact,
                          'ownername' => $data->userownername,
                          'labname' => $data->userlabname,
                          'companyname' => $data->usercompanyname,
                          'engineername' => $data->userengineername,
                          'landlineno' => $data->userlandlineno,
                          'mobileno' => $data->usermobileno,
                          'hdip_lic_no' => $data->userhdip_lic_no
                          
                ]);   



      }


        return redirect()->back()->with('message', 'Record Updated');




    }

   public function HDIPusers()
   {
    $users = DB::table('users')
        ->select('users.*')
        ->where('regtype','=','laboratory')
        ->paginate(10);

      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

      return view('user.hdip_labs',['users'=>$users,'treeitems'=>$treeitems])->with('page',1);

   }

  public function AjaxSearch(Request $data) {
 /*$msg = "This is a simple message.";
    $msg = $data->user ;
      return response()->json(array('msg'=> $msg), 200);*/
      $users=DB::table('users')->where('name', 'like', '%'.$data->name.'%')->get();
      //return response()->json(array('msg'=> $msg), 200);
    return response()->json($users, 200);
  }



   public function search(Request $data) {

    $users=DB::table('users')->where('name', 'like', '%'.$data->name.'%')->get();


      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

      return view('user.user_view',['users'=>$users,'treeitems'=>$treeitems]);

   }

public function testmail(){


  try {
      $myuser=array("name"=>"rehan","email"=>"rehanishrat74@gmail.com");
      Mail::to("rehanishrat74@gmail.com")->send(new WelcomeMail($myuser,"i m test"));
      echo "mail sent";
      } catch (Exception $e) {

        //return $e;
        echo $e;
      }


 
}
public function dologinaccess(Request $data){
    
     $id =str_replace("act_","",$data->id);

    if ($data->name=="1")
    {
                    DB::table('users')
                        ->where(['id'=> $id])
                        ->update(['activated' => 1
                                ]);   

        $credentials=DB::table('users')
          ->select(['email','encpwd','regtype','name'])
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
    
    $myuser=array("name"=>$credentials[0]->name,"email"=>$credentials[0]->email);
          
    //Mail::to($credentials[0]->email)->send(new WelcomeMail($myuser,$msg));
    
    return response()->json("login credentials sent at ".$credentials[0]->email, 200);
}

   public function delete(Request $request)
   {

    $id =str_replace("del_","",$request->id);

      /*$user=DB::select('select email from users where id=?',[$id]) ;
      $email='blocked';
      $email=$email.$user[0]->email;*/
                              
      
      DB::table('users')
          ->where(['id'=> $id])
          ->update(['deleted' => 1 ]);






 /*if (Auth::user()->regtype =='admin')
{
  $users = DB::table('users')
        ->select('users.*')
        ->where('deleted','!=',1)
        ->paginate(10);

}else if (Auth::user()->regtype =='hdip')
{
    $users = DB::table('users')
        ->select('users.*')
        ->where('deleted','!=',1)
        ->where('regtype','=','laboratory')
        ->paginate(10);

}*/
            
      
      //$usertype =Auth::user()->regtype;
      //$treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      //print_r($treeitems);
      //return view('user.user_view',['users'=>$users,'treeitems'=>$treeitems])->with('page',1);
      return response()->json("deleted", 200);
      

   }
}

            //print_r($users);


            /*$users=DB::table('users')->where('name', 'like', '%'.$data->name.'%')
                                  ->where('category_id', 1)
                                  ->where('city_id', 1)
                                  ->get();*/
                //$users = User::where('name','LIKE',"%{$$data->name}%")->get();
                //echo' data'.$data->name;
                  //$msg = "This is a simple message.";
                 //$querry ='select * from users where name like ';

                 //echo $querry;
                  //$users = DB::select();
                //DB::table('users')->where('name', 'LIKE','%', $data->name,'%')->get();

            /*$term = $data->name;
            $query = User::where('name', 'LIKE', '%' . $term . '%');
            $username=$query->getBindings();
            $querryWithLikeSyntax ='select * from users where name like '.$username[0].'';
            echo $querryWithLikeSyntax;*/
            //$users=dd($query->toSql(), $query->getBindings());
            //$users=$query->toSql();

            //echo 'users:'.$users;
            //print_r($users);
            //echo $users[0];
                  //return view('user.user_view',['users'=>$users]);

                  //return response()->json(array('msg'=> $msg), 200);
                  //return response()->json(array('msg'=> $data), 200);



/*$search = 'hdtopi';

$user = User::where('name','LIKE',"%{$search}%")->get();

print_r($user);


DB::table('job_details')->where('job_title', 'like', '%officer%')
                      ->where('category_id', 1)
                      ->where('city_id', 1)
                      ->get();



$term = '23 test';

$query = User::where('name', 'LIKE', '%' . $term . '%');

*/




