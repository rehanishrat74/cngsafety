<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class workstationno implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $workstationno,$msg,$validRule;
    public function __construct($workstationid)
    {
        //
        $this->workstationno=$workstationid;
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
                        

        if ($registeredWs[0]->registered <= 0 )
        {

            $this->msg="Invalid workstaion id." ;
            $this->validRule=false;
        }
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
