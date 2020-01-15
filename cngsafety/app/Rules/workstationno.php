<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
 use Illuminate\Support\Arr;
use DB;

class workstationno implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    //php artisan make:rule workstationno
    protected $workstationno,$msg,$validRule,$Stickerno;
    public function __construct($workstation)
    {
        //
       // $this->workstationno=array_get($workstation,'stationno');
        //$this->Stickerno=array_get($workstation,'Stickerno');

 $this->workstationno=Arr::get($workstation,'stationno');
        $this->Stickerno=Arr::get($workstation,'Stickerno');        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $this->validRule=true;

        $registeredWs=DB::select('select count(id) as registered from users where stationno=?',[$this->workstationno]);


                
        


/*$registeredWs= DB::table('users')
                ->leftjoin('coderollssecondary',function($join){
                    $join->on('users.email','=','coderollssecondary.allotedto');
                })
                ->select(
                    DB::Raw('count(users.id) as registered'),
                    DB::Raw('IF(ISNULL(coderollssecondary.serialno),"0",coderollssecondary.serialno) as serialno'),
                    DB::Raw('IF(ISNULL(coderollssecondary.cnic),"0",coderollssecondary.cnic) as cnic'),
                    DB::Raw('IF(ISNULL(coderollssecondary.vehicleRegNo),"0",coderollssecondary.vehicleRegNo) as vehicleRegNo'),
                )
                ->where('users.stationno','=',$this->workstationno)
                ->where('coderollssecondary.serialno','=',$this->Stickerno)
                ->groupby ('coderollssecondary.vehicleRegNo','cnic','serialno')
                ->get();*/



//dd($registeredWs);
if (!is_null($registeredWs) || !empty($registeredWs)){ //data =true
    if(count($registeredWs) >0 ){  //data = true

        if ($registeredWs[0]->registered <= 0 )
        {
            $this->msg="Invalid workstaion id" ; $this->validRule=false;

        } else {$this->validRule=true;} //record found       
    } else {$this->msg="Invalid workstaion id." ;$this->validRule=false;}  // data does not exists.
}else {$this->msg="Invalid workstaion id.." ;$this->validRule=false;}  // data does not exists.

      
//dd($this->validRule);


        return $this->validRule;
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg;
    }
}
