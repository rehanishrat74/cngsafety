<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Hashing\BcryptHasher;
use DB;

class ValidateHDIP implements Rule
{
    protected $hdip_loginid,$hdip_password,$useremail,$userpassword;
    protected $passwordmatched,$loginmatched;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        
    }*/
    public function __construct($loginid,$password)
    {
        //
        $this->hdip_loginid=$loginid;  //login id is email
        $this->hdip_password =$password;
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
        //We fill in the methods. passes() should return true/false depending on $value condition,
        /*Games started in 1896
        Year can’t be bigger than current year
        Number should be divided by 4
        return $value >= 1896 && $value <= date('Y') && $value % 4 == 0;*/
        
        
        $this->passwordmatched=false;

        $hdip=DB::TABLE('users')
            ->select('email','password')
            ->where('labname','=','HDIP')
            ->get();
       


       $this->useremail = $hdip[0]->email;
       
        $this->userpassword =$hdip[0]->password;

        $hasher = app('hash');

       
        if ($this->hdip_loginid == $hdip[0]->email) 
        {
                    $this->loginmatched=true;
                    if ($hasher->check($this->hdip_password, $hdip[0]->password))
                    {
                        $this->passwordmatched=true;
                        
                    }

        }




        /*if ($hasher->check($this->hdip_password, $hdip[0]->password)) {
            
        }*/

        return $this->passwordmatched;
    
}

      //  return $validHDIPcredentials;
        //echo 'loginid='.$hdip_loginid;
        //echo 'pwd='.$hdip_password;
    //}

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {

        //,,$useremail,$userpassword;
        if($this->passwordmatched==false)
        {
                $msg = 'HDIP credentials fails.';
        }
        else
        {
                $msg="Error.";
        }
        
        /*$msg=$msg.'loginid passed='.$this->hdip_loginid;
        $msg=$msg.'<br> password passed ='.$this->hdip_password;
        $msg=$msg.'<br> in database loginid ='.$this->useremail;
        $msg=$msg.'<br> in database pwd is ='.$this->userpassword;
        $msg=$msg.'<br> password status='.$this->passwordmatched;
        $msg=$msg.'<br>login matched='.$this->loginmatched;*/

        return $msg;
        
    }
}
