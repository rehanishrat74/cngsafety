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
use Session;
class UserViewController extends Controller
{
  public function __construct() {
      $this->middleware('auth');
   }
    //
   public function index() {
      

if (!empty($_GET['page']))
  {$page=$_GET['page'];}else{$page=1;}
if (empty($pagesize)){$pagesize=10;}

$CalculatedRow= $pagesize * ($page -1) ;
$rowSql='set @row:='.$CalculatedRow;

    if (Auth::user()->regtype =='admin')
    {
      DB::statement(DB::raw($rowSql));
      $users = DB::table('users')
        ->select('users.*',DB::Raw('@row:=@row+1 as row_number'))
        ->where('deleted','!=',1)
        ->orderby('id','desc')
        ->paginate(10);

    }else if (Auth::user()->regtype =='hdip' || Auth::user()->regtype =='apcng')
    {
        DB::statement(DB::raw($rowSql));
        $users = DB::table('users')
        ->select('users.*',DB::Raw('@row:=@row+1 as row_number'))
        ->where('deleted','!=',1)
        ->where('regtype','=','laboratory')
        ->orderby('id','desc')
        ->paginate(10);

    }
            
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      $provinces=DB::Select('SELECT DISTINCT province FROM `users` WHERE province is not null order by province');

      return view('user.user_view',['users'=>$users,'treeitems'=>$treeitems])->with('page',1)
            ->with('provinces',$provinces);
   }
    public function listUser()
    {
          if (Auth::user()->regtype =='admin')
          {
            $users = DB::table('users')
            ->select('users.*')
            ->where('deleted','!=',1)
            ->orderby('id','desc')
            ->paginate(10);

          }else if (Auth::user()->regtype =='hdip' || Auth::user()->regtype =='apcng')
            {
              $users = DB::table('users')
                ->select('users.*')
                ->where('deleted','!=',1)
                ->where('regtype','=','laboratory')
                ->orderby('id','desc')
                ->paginate(10);

            }

      return $users;
    }
    
    public function listtree()
    {
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      return $treeitems;
    }

    public function profile()
    {
      //$users = $this->listUser();
      $userid=Auth::user()->id;
      $treeitems=$this->listtree();
      $user=$this->getUserDetails($userid);
       return view ('user.user_profile',['treeitems'=>$treeitems,'userdetails'=>$user]);
    }

    public function getUserDetails($userid)
    {

      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);

      $userdetails =DB::select('select id,name,email,address,regtype,labname,contactno,hdip_lic_no,cellnoforinspection,technician,ownercellno,ownername,mobileno,landlineno,engineername,companyname,cellverified,imei,device_id,latitude,longitude,stationno,city,province from users where id =?',[$userid]);      
      return $userdetails;
    }

  public function showuser($userid)
    {
      //echo 'user='.$userid;
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);



      $userdetails =DB::select('select id,name,email,address,regtype,labname,contactno,hdip_lic_no,cellnoforinspection,technician,ownercellno,ownername,mobileno,landlineno,engineername,companyname,cellverified,imei,device_id,latitude,longitude,stationno,city,province from users where id =?',[$userid]);

      

      return view ('user.showuser',['treeitems'=>$treeitems,'userdetails'=>$userdetails]);
    }
    public function dodisplaypswd($user)
    {
          $credentials=DB::table('users')
          ->select(['email','encpwd','regtype','name','cellnoforinspection','mobileno'])
          ->where(['id'=> $user])
          ->get();                

        $pwd= Crypt::decryptString($credentials[0]->encpwd);
             //return response()->json("password is ", 200);
        return response()->json($pwd, 200);
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
         $workshopfields =array('username' => 'required', 'useraddress' => 'required', 'usercontact' => 'required', 'userownercellno' => 'required' , 'userownername'=> 'required' , 'usertechnician'=>'required','usercellnoforinspection'=>'required_without:usercellnoforinspection|regex:/^\+?[92](\d+)$/' );

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

public function searchforhdippaged(){

if (!empty($_GET['page']))
  {
    $page=$_GET['page'];
  }else
  {
    $page=1;
  }

if (!empty($_GET['user_regtype'])) 
  {
    $regtype= $_GET['user_regtype'];
  } else 
  {
    $regtype='laboratory';
  }

if (!empty($_GET['province'])) 
  {
    $province= $_GET['province'];
  } else 
  {
    $province='All';
  }

if (!empty($_GET['cities']))
  {
    $city= $_GET['cities'];
  } else 
  {
    $city='All';
  }

//$pagesize=$_GET['pagesize'];


if (empty($_GET['pagesize']))
  {
    $pagesize=10;
  }
else
{
  $pagesize=$_GET['pagesize'];
}
$keys_array=[];
$values_array=[];

$emailkey_array=[];
$emailname_array=[];

$namekey_array=[];
$namevalue_array=[];


$whereArray=[];
    
if ($regtype!="All")
{
    array_push($keys_array, "regtype");
    array_push($values_array, $regtype);  
} 

if ($province!="All")
{
    array_push($keys_array, "province");
    array_push($values_array, $province);   
}

if ($city!="All"){

    array_push($keys_array, "city");
    array_push($values_array, $city);     
}


$whereArray=array_combine($keys_array,$values_array);
$CalculatedRow= $pagesize * ($page -1) ;
$rowSql='set @row:='.$CalculatedRow;

  DB::statement(DB::raw($rowSql));
      $users = DB::table('users')
        ->select('users.*',DB::Raw('@row:=@row+1 as row_number'))
        ->where('deleted','!=',1)
        ->where($whereArray)
        ->orderby('id','desc')
        ->paginate($pagesize);
    
            
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      $provinces=DB::Select('SELECT DISTINCT province FROM `users` WHERE province is not null order by province');

      $users->appends(['user_regtype' => $regtype,'province'=>$province,'cities'=>$city,'pagesize'=>$pagesize])->links();


      return view('user.hdip_labs',['users'=>$users,'treeitems'=>$treeitems])->with('page',$page)
            ->with('provinces',$provinces)
            ->with('selectedRegType',$regtype)
            ->with('selectedProvince',$province)
            ->with('selectedCity',$city)
            ;


}
    public function searchforhdip (Request $request) {

    $regtype= $request->input("user_regtype");
    $province=$request->input("province");
    $city=$request->input("cities"); 
    $search=$request->input("searchvalue");
    $pagesize= $request->input("pagesize");


if (!empty($_GET['page']))
  {$page=$_GET['page'];}else{$page=1;}


if (empty($pagesize)){$pagesize=10;}
$keys_array=[];
$values_array=[];

$emailkey_array=[];
$emailname_array=[];

$namekey_array=[];
$namevalue_array=[];


$whereArray=[];
    
if ($regtype!="All")
{
    array_push($keys_array, "regtype");
    array_push($values_array, $regtype);  
} 

if ($province!="All")
{
    array_push($keys_array, "province");
    array_push($values_array, $province);   
}

if ($city!="All"){

    array_push($keys_array, "city");
    array_push($values_array, $city);     
}


if (!empty($search)){

    array_push($emailkey_array, "email");
    array_push($emailname_array, $search);     


    array_push($namekey_array, "name");
    array_push($namevalue_array, $search);    
}

$whereArray=array_combine($keys_array,$values_array);
$whereEmailArray=array_combine($emailkey_array,$emailname_array);
$whereNameArray=array_combine($namekey_array,$namevalue_array);




    if (!empty($_GET['page']))
        {$page=$_GET['page'];}else{$page=1;}
    if (empty($pagesize)){$pagesize=10;}

$CalculatedRow= $pagesize * ($page -1) ;
$rowSql='set @row:='.$CalculatedRow;
 DB::statement(DB::raw($rowSql));
    $users = DB::table('users')
        ->select('users.*',DB::Raw('@row:=@row+1 as row_number'))
        ->where('regtype','=',$regtype)
        ->where($whereArray)
        ->orWhere($whereEmailArray)
        ->orWhere($whereNameArray)
        ->paginate($pagesize);


$users->appends(['user_regtype' => $regtype,'province'=>$province,'cities'=>$city,'pagesize'=>$pagesize])->links();



      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      $provinces=DB::Select('SELECT DISTINCT province FROM `users` WHERE province is not null order by province');

      return view('user.hdip_labs',['users'=>$users,'treeitems'=>$treeitems])->with('page',1)
            ->with('provinces',$provinces)
            ->with('selectedRegType',$regtype)
            ->with('selectedProvince',$province)
            ->with('selectedCity',$city)
            ;

    }

   public function HDIPusers()
   {



$regtype='laboratory';
$province='All'; 
$city='All'; 
$search=''; 
$pagesize=10; 


if (!empty($_GET['page']))
  {$page=$_GET['page'];}else{$page=1;}


if (empty($pagesize)){$pagesize=10;}
$keys_array=[];
$values_array=[];

$emailkey_array=[];
$emailname_array=[];

$namekey_array=[];
$namevalue_array=[];


$whereArray=[];
    
if ($regtype!="All")
{
    array_push($keys_array, "regtype");
    array_push($values_array, $regtype);  
} 

if ($province!="All")
{
    array_push($keys_array, "province");
    array_push($values_array, $province);   
}

if ($city!="All"){

    array_push($keys_array, "city");
    array_push($values_array, $city);     
}


if (!empty($search)){

    array_push($emailkey_array, "email");
    array_push($emailname_array, $search);     


    array_push($namekey_array, "name");
    array_push($namevalue_array, $search);    
}

$whereArray=array_combine($keys_array,$values_array);
$whereEmailArray=array_combine($emailkey_array,$emailname_array);
$whereNameArray=array_combine($namekey_array,$namevalue_array);




    if (!empty($_GET['page']))
        {$page=$_GET['page'];}else{$page=1;}
    if (empty($pagesize)){$pagesize=10;}

$CalculatedRow= $pagesize * ($page -1) ;
$rowSql='set @row:='.$CalculatedRow;
 DB::statement(DB::raw($rowSql));
    $users = DB::table('users')
        ->select('users.*',DB::Raw('@row:=@row+1 as row_number'))
        ->where('regtype','=','laboratory')
        ->where($whereArray)
        ->orWhere($whereEmailArray)
        ->orWhere($whereNameArray)
        ->paginate(10);

      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      $provinces=DB::Select('SELECT DISTINCT province FROM `users` WHERE province is not null order by province');

      return view('user.hdip_labs',['users'=>$users,'treeitems'=>$treeitems])->with('page',1)
            ->with('provinces',$provinces)
            ->with('selectedRegType',$regtype)
            ->with('selectedProvince',$province)
            ->with('selectedCity',$city)
            ;

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
          ->select(['email','encpwd','regtype','name','cellnoforinspection','mobileno'])
          ->where(['id'=> $id])
          ->get();                

        $pwd= Crypt::decryptString($credentials[0]->encpwd);
        $msg ="Please login at cngsafetypakistan.com. Your login credentials are: login id = ".$credentials[0]->email. " and password=".$pwd ;                 

        if ($credentials[0]->regtype=="workshop")
        {
        $msg ="Please login at cngsafetypakistan.com. Your login credentials are: login id = ".$credentials[0]->email. " and password=".$pwd.". You can download the app from ".env('App_Link') ;
        $mobile =$credentials[0]->cellnoforinspection;
        } 
        else {
          $mobile =$credentials[0]->mobileno;
        }

    }
    
    $status="id=".$id." data->name=".$data->name;
    
    $myuser=array("name"=>$credentials[0]->name,"email"=>$credentials[0]->email);
          
    Mail::to($credentials[0]->email)->send(new WelcomeMail($myuser,$msg));

     $sender = "iBex";
     
                $message = "Congratulation. Your Login has been activated. Kindly check your email ".$credentials[0]->email." for login credentials. For further querries dial 051-4901444 or email us at cng.safety.taskforce@gmail.com";
     
                //sending sms
                $post = "sender=".urlencode($sender)."&mobile=".urlencode($mobile)."&message=".urlencode($message)."";
                $url = "https://sendpk.com/api/sms.php?username=923065353533&password=4619";

$url = "https://sendpk.com/api/sms.php?username=".env('SMS_User')."&password=".env('SMS_Pwd');                
                $ch = curl_init();
                $timeout = 30; // set to zero for no timeout
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $result = curl_exec($ch); 
    
    return response()->json("login credentials sent at ".$credentials[0]->email, 200);
}

   public function delete(Request $request)
   {

    $id =str_replace("del_","",$request->id);

      
      DB::table('users')
          ->where(['id'=> $id])
          ->update(['deleted' => 1 ]);


      return response()->json("deleted", 200);
      

   }

public function searchuserregistration(Request $request) {

    
$regtype= $request->input("user_regtype");
$province= $request->input("province");
$city= $request->input("cities");
$search= $request->input("searchvalue");
$pagesize= $request->input("pagesize");
//$page=$_GET['page'];

if (!empty($_GET['page']))
  {$page=$_GET['page'];}else{$page=1;}


if (empty($pagesize)){$pagesize=10;}
$keys_array=[];
$values_array=[];

$emailkey_array=[];
$emailname_array=[];

$namekey_array=[];
$namevalue_array=[];


$whereArray=[];
    
if ($regtype!="All")
{
  //$whereArray=['regtype','=',$regtype];
    array_push($keys_array, "regtype");
    array_push($values_array, $regtype);  
} 

if ($province!="All")
{
    //array_push($whereArray, array('province','=',$province));
    array_push($keys_array, "province");
    array_push($values_array, $province);   
}

if ($city!="All"){

    array_push($keys_array, "city");
    array_push($values_array, $city);     
}


if (!empty($search)){

    array_push($emailkey_array, "email");
    array_push($emailname_array, $search);     


    array_push($namekey_array, "name");
    array_push($namevalue_array, $search);    
}

$whereEmailArray=array_combine($emailkey_array,$emailname_array);
$whereNameArray=array_combine($namekey_array,$namevalue_array);



$whereArray=array_combine($keys_array,$values_array);
$CalculatedRow= $pagesize * ($page -1) ;
$rowSql='set @row:='.$CalculatedRow;


    if (Auth::user()->regtype =='admin')
    {
        DB::statement(DB::raw($rowSql));
      $users = DB::table('users')
        ->select('users.*',DB::Raw('@row:=@row+1 as row_number'))
        ->where('deleted','!=',1)
        ->where($whereArray)
        ->orWhere($whereEmailArray)
        ->orWhere($whereNameArray)
        ->orderby('id','desc')
        ->paginate($pagesize);

    }else if (Auth::user()->regtype =='hdip' || Auth::user()->regtype =='apcng')
    {
        DB::statement(DB::raw($rowSql));
      $users = DB::table('users')
        ->select('users.*',DB::Raw('@row:=@row+1 as row_number'))
        ->where('deleted','!=',1)
        ->where($whereArray)
        ->orWhere($whereEmailArray)
        ->orWhere($whereNameArray)
        ->orderby('id','desc')
        ->paginate($pagesize);
    }
            
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      $provinces=DB::Select('SELECT DISTINCT province FROM `users` WHERE province is not null order by province');

//$users->appends(['user_regtype' => $regtype])->links();
      $users->appends(['user_regtype' => $regtype,'province'=>$province,'cities'=>$city,'pagesize'=>$pagesize])->links();



      return view('user.user_view',['users'=>$users,'treeitems'=>$treeitems])->with('page',1)
            ->with('provinces',$provinces)
            ->with('selectedRegType',$regtype)
            ->with('selectedProvince',$province)
            ->with('selectedCity',$city)
            ;
   }

function searchuserregistrationpaged() {


if (!empty($_GET['page']))
  {$page=$_GET['page'];}else{$page=1;}

$regtype= $_GET['user_regtype'];
$province= $_GET['province'];
$city= $_GET['cities'];
$pagesize=$_GET['pagesize'];


if (empty($pagesize)){$pagesize=10;}
$keys_array=[];
$values_array=[];

$emailkey_array=[];
$emailname_array=[];

$namekey_array=[];
$namevalue_array=[];


$whereArray=[];
    
if ($regtype!="All")
{
    array_push($keys_array, "regtype");
    array_push($values_array, $regtype);  
} 

if ($province!="All")
{
    array_push($keys_array, "province");
    array_push($values_array, $province);   
}

if ($city!="All"){

    array_push($keys_array, "city");
    array_push($values_array, $city);     
}


$whereArray=array_combine($keys_array,$values_array);
$CalculatedRow= $pagesize * ($page -1) ;
$rowSql='set @row:='.$CalculatedRow;

  DB::statement(DB::raw($rowSql));
      $users = DB::table('users')
        ->select('users.*',DB::Raw('@row:=@row+1 as row_number'))
        ->where('deleted','!=',1)
        ->where($whereArray)
        ->orderby('id','desc')
        ->paginate($pagesize);
    
            
      $usertype =Auth::user()->regtype;
      $treeitems =DB::select('select * from AccessRights where regtype =?',[$usertype]);
      $provinces=DB::Select('SELECT DISTINCT province FROM `users` WHERE province is not null order by province');

      $users->appends(['user_regtype' => $regtype,'province'=>$province,'cities'=>$city,'pagesize'=>$pagesize])->links();


      return view('user.user_view',['users'=>$users,'treeitems'=>$treeitems])->with('page',$page)
            ->with('provinces',$provinces)
            ->with('selectedRegType',$regtype)
            ->with('selectedProvince',$province)
            ->with('selectedCity',$city)
            ;



    }
}

