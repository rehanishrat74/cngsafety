<?php

namespace App\Http\Controllers\Auth;
use App\Rules\ValidateHDIP;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;
use Illuminate\Support\Str;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {





        if ($data['regtype']=="workshop")
        {
        return Validator::make($data, [
            'nickname' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'province' => ['required','string','max:191'],
            'city' => ['required','string','max:191'],
            'address' => ['required','string','max:191'],
            'regtype'=> ['required','string','max:45'],
            'contactno' => ['required','string','max:191'],
            'cellnoforinspection' => ['required','string','max:191'],
            'technician' => ['required','string','max:191'],
            'ownercellno' => ['required','string','max:45'],
            'ownername' => ['required','string','max:191'],

            ]);
        }
        else if ($data['regtype']=="admin" )
        {
        return Validator::make($data, [
            'nickname' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'province' => ['required','string','max:191'],
            'city' => ['required','string','max:191'],
            'address' => ['required','string','max:191'],
            'regtype'=> ['required','string','max:45'],
            'contactno' => ['required','string','max:45'],
            ]);
        } else if ($data['regtype']=="laboratory")
        {

        return Validator::make($data, [
            //'nickname' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'province' => ['required','string','max:191'],
            'city' => ['required','string','max:191'],
            'address' => ['required','string','max:191'],
            'regtype'=> ['required','string','max:191'],
            'contactno' => ['required','string','max:181'],
            'labname' =>['required','string','max:191'],
            //'hdip_loginid' => ['required', 'string', 'email', 'max:191'],
            //'hdip_password' => ['required','string','max:191'],
//            'hdip_lic_no'=> ['required','string','max:191', new ValidateHDIP($data['hdip_loginid'],$data['hdip_password'])],    

            'hdip_lic_no'=> ['required','string','max:191'],                                
            'mobileno' =>['required','string','max:45'],
            'landlineno' =>['required','string','max:45'],
            'engineername' =>['required','string','max:191'],
            'companyname' =>['required','string','max:191'],
            'ownername' =>['required','string','max:191'],
            ]);
        }





  
  
    }
//,'labid','labname',
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {


        $fields;        
        $stationno=0;
        $labid=0;
        $workshopstationid=0;
        $encryptedpwd= Crypt::encryptString($data['password']);
//$encrypted = Crypt::encryptString('Hello world.');
        if ($data['regtype']=="admin")
        {


  
            $user= User::create([
                'name' => $data['nickname'],
                'email' => $data['email'],
                'nickname' => $data['nickname'],
                'password' => Hash::make($data['password']),
                'regtype' =>  $data['regtype'],
                'province' => $data['province'],
                'city' => $data['city'],
                'address' => $data['address'],
                'contactno'=>$data['contactno'],
                'encpwd' => $encryptedpwd,
                'activated'=> 0, //false           
                ]);            


        }
        else if ($data['regtype']=="workshop")
        {

                        
     
            $getwshopid = DB::TABLE('users')
                        ->select(DB::raw('count(workshopstationid) as workshopid')) 
                        ->where ('regtype','=','workshop')
                        ->where ('province','=',$data['province'])
                        ->where('city','=',$data['city'])
                        ->get();
            $workshopstationid =$getwshopid[0]->workshopid +1 ;
            


/*
PLR   for punjab -> lahore.
PRP   for punjab -> Rawalpindi.
SKI   for Sindh  -> karachi
PRP   for Punjab -> rawalpindi
SHD   for Sindh  -> hyderabad
KP    for kyber pakhtoon khua
AK    for azad kashmir
B     for balochistan.
*/

//todo: frontend per parent child province and city needed.---------------here--->


            $getstationcode = DB::TABLE('cities')
                        ->select('stationcode') 
                        ->where ('province','=',$data['province'])
                        ->where('city','=',$data['city'])
                        ->get();
            $stationcode =$getstationcode[0]->stationcode; //e.g SKI



             $stationno=$stationcode.'-'.$workshopstationid;   //SKI-3




            $user= User::create([
                'name' => $data['nickname'],
                'email' => $data['email'],
                'nickname' => $data['nickname'],
                'password' => Hash::make($data['password']),
                'regtype' =>  $data['regtype'],
                'province' => $data['province'],
                'city' => $data['city'],
                'address' => $data['address'],
                'contactno'=>$data['contactno'],
                'stationno'=> $stationno,                //PLR-1
                'workshopstationid'=> (int) $workshopstationid,  //1   
                'cellnoforinspection' =>$data['cellnoforinspection'],
                'technician'=>$data['technician'],
                'ownercellno'=>$data['ownercellno'],
                'ownername'=>$data['ownername'],
                'encpwd' => $encryptedpwd,
                'activated'=> 0, //false                           
                ]);            

        }
        else if ($data['regtype']=="laboratory")
        {
            

            $getlabid = DB::TABLE('users')
                        ->select(DB::raw('count(labid) as newlabid')) 
                        ->where ('regtype','=','laboratory')
                        ->where ('province','=',$data['province'])
                        ->where('city','=',$data['city'])                        
                        ->get();
            $labid =$getlabid[0]->newlabid +1 ;

            



//php artisan key:generate
//$encrypted = Crypt::encryptString('Hello world.');
//$decrypted = Crypt::decryptString($encrypted);

//$encrypted = 223;//Crypt::encryptString($data['password']);

            $user= User::create([
                'name' =>$data['labname'],// $data['nickname'],
                'email' => $data['email'],
                'nickname' =>$data['labname'],// $data['nickname'],
                'password' => Hash::make($data['password']),
                'regtype' =>  $data['regtype'],
                'province' => $data['province'],
                'city' => $data['city'],
                'address' => $data['address'],
                'contactno'=>$data['contactno'],
                'labname'=> $data['labname'],
                'labid'=> (int) $labid,
                'hdip_lic_no'=> $data['hdip_lic_no'],                
                'mobileno'=> $data['mobileno'],
                'landlineno'=> $data['landlineno'],
                'engineername'=> $data['engineername'],
                'companyname' => $data['companyname'],             
                'ownername' => $data['ownername'], 
                'encpwd' => $encryptedpwd,
                'activated'=> 0, //false                           
                ]);            

        }


/*
        $user= User::create([
            'name' => $data['nickname'],
            'email' => $data['email'],
            'nickname' => $data['nickname'],
            'password' => Hash::make($data['password']),
            'regtype' =>  $data['regtype'],
            'province' => $data['province'],
            'city' => $data['city'],
            'address' => $data['address']
        ]);
*/
        $msg ="Your login credentials are: login id = ".$data['email']. " and password=".$data['password'] ;                 

        if ($data['regtype']=="workshop")
        {
        $msg ="Your login credentials are: login id = ".$data['email']. " and password=".$data['password'].". You can download the app from ".env('App_Link') ;
        } 


            
        //$user= User::create([$fields]); //temporary blocking creating table.
        // Mail::to($data['email'])->send(new WelcomeMail($user,$msg));
         //Mail::to('rehanishrat74@gmail.com')->send(new WelcomeMail($user,$msg)); 
         

        // Mail::to($data['email'])->send(new WelcomeMail($user,$msg)); //and temporary blocking

        return $user;
    }
}
