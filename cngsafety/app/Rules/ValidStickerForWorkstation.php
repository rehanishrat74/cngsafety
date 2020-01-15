<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
 use Illuminate\Support\Arr;
 use DB;

class ValidStickerForWorkstation implements Rule
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

        //$registeredWs=DB::select('select count(id) as registered from users where stationno=?',[$this->workstationno]);


                
        


$registeredWs= DB::table('users')
                ->leftjoin('coderollssecondary',function($join){
                    $join->on('users.email','=','coderollssecondary.allotedto');
                })
                ->select(
                    DB::Raw('count(users.id) as registered'),
                    DB::Raw('IF(ISNULL(coderollssecondary.serialno),"0",coderollssecondary.serialno) as serialno'),
                    DB::Raw('IF(ISNULL(coderollssecondary.cnic),"0",coderollssecondary.cnic) as cnic'),
                    DB::Raw('IF(ISNULL(coderollssecondary.vehicleRegNo),"0",coderollssecondary.vehicleRegNo) as vehicleRegNo')
                )
                ->where('users.stationno','=',$this->workstationno)
                ->where('coderollssecondary.serialno','=',$this->Stickerno)
                ->groupby ('coderollssecondary.vehicleRegNo','cnic','serialno')
                ->get();



//dd($registeredWs);
 //valid workstation
if (!is_null($registeredWs) || !empty($registeredWs)){
    if(count($registeredWs) >0 )
    { //dd('here');
           if ( $registeredWs[0]->serialno =="0" )
            {

            $this->msg="Invalid Sticker No." ;
            $this->validRule=false;                

            }
           else if ( $registeredWs[0]->cnic !="0" )
            {
                //if cnic is null then valid on insert
                //if cnic does not match with old cnic. WE WONT APPLY THIS RULE HERE.
            $this->msg="Sticker allocated to a different vehicle" ;
            $this->validRule=false;                   

            }  else {$this->validRule=true;}       
    } else {$this->msg="Sticker does not exists." ;$this->validRule=false;}  // data does not exists.


} 

    else { 
//dd('inempty');
        $this->msg="Sticker does not exists.." ;
            $this->validRule=false;  }


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
        //return 'The validation error message.';
    }
}
