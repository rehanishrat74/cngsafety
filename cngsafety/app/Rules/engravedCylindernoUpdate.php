<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;
class engravedCylindernoUpdate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
       protected $serialno,$alloteduser,$msg,$validRule,$id;
    public function __construct($serialnotovalidate,$useremail,$serialid)
    {
        //
        $this->serialno = $serialnotovalidate;
        $this->alloteduser=$useremail;
        $this->id=$serialid;
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
                $registeredCylinders=Db::select('select count(SerialNumber) as serialregistered from RegisteredCylinders where SerialNumber=? ',[$this->serialno]);
                        

        if ($registeredCylinders[0]->serialregistered > 0 ){

                    $registeredCylinderid=DB::Select('select id,serialnumber from RegisteredCylinders where SerialNumber=?',[$this->serialno]);

                        if ($registeredCylinderid[0]->id != $this->id)
                        {
                        $this->msg="Serial Number [".$this->serialno."] already registered.";
                        $this->validRule=false;
                        }

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
