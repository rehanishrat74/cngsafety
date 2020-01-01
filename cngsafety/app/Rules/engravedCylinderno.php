<?php




namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class engravedCylinderno implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $serialno,$alloteduser,$msg,$validRule;
    public function __construct($serialnotovalidate,$useremail)
    {
        //
        $this->serialno = $serialnotovalidate;
        $this->alloteduser=$useremail;
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
        $this->validRule=true;
//DB::table('CodeRollsSecondary')
        /*$validcylinder=DB::select('select count(serialno) as serialexists from CodeRollsSecondary where serialno =? and allotedto =?',[$this->serialno,$this->alloteduser] );

        if (($validcylinder[0]->serialexists) !=1)
        {
            $this->msg="Invalid Serial Number";
            $this->validRule=false;
        }*/



        $registeredCylinders=Db::select('select count(SerialNumber) as serialregistered from RegisteredCylinders where SerialNumber=? ',[$this->serialno]);
                        

        if ($registeredCylinders[0]->serialregistered > 0 ){
                        $this->msg="Serial Number already registered.";
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
