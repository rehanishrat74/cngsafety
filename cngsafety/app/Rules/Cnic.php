<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
 use Illuminate\Support\Arr;
use DB;

class Cnic implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $msg,$validRule,$cnic,$vehicle;
    public function __construct($vechilceParams)
    {
        //
         $this->cnic=Arr::get($vechilceParams,'cnic');
        $this->vehicle=Arr::get($vechilceParams,'vehicle');           
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
        $countvehicle=0;
        $vresults = DB::select('select count(Record_no) as vehiclecount from vehicle_particulars where Registration_no = ? and OwnerCnic=?', [$this->vehicle,$this->cnic]);
                    
        $countvehicles=$vresults[0]->vehiclecount;   
        if ($countvehicles >=1) {
            $this->msg="Vehicle ".$this->vehicle." exists with this cnic" ;
            $this->validRule=false;              
        } else {$this->msg="vehicle deos not exists";$this->validRule=true;}   
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
