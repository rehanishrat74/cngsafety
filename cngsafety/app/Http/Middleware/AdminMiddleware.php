<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use DB;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

 /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
 /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {

        $route=Request::route()->getName();
        $regtype = $this->auth->getUser()->regtype;



        if (!$this->allowedOperation($regtype,$route))
        {
            $errmsg="Unauthorized action.";

            /*if (Auth::user()->activated==1) {
                $errmsg="Your application is in process.We will email your credentials to login after approval.";
            }*/
            //$errmsg=$errmsg."<br>type=.".$regtype;
            //$errmsg=$errmsg."<br>routename=".$route;
           abort(403, $errmsg); 
           //https://laravel.com/docs/5.6/authentication#logging-out
        }


        return $next($request);
    }

    public function allowedOperation($regtype,$route)
    {
        
       
        if ($regtype=='admin')
        {
            return true;
        }

  
        $isauthorise=false;

        if ($regtype=='workshop')
        {
            if ( $route=='registrations' || $route=='registrations-search'  ||  $route=='new-vehicle' || $route== 'reg-vehicle' || $route== 'cylinders' || $route== 'showcylinder' || $route== 'editcylinder' || $route=='newcylinderreg'  || $route=='logout' || $route=='displayProfile' ) {
                    $isauthorise=true;
            }
            if ($route=='new-vehicle' || $route=='edit-vehicle' || $route='update-vehicle'  || $route=='displayProfile'){
             $isauthorise=true;   
            }

        } 
        else if ($regtype=='laboratory')
        {

            if ( $route=='testcylindersdataentryform' || $route=='savetestcylinders' || $route=='listlabtestedcylinders' || $route=='testedcylinders-search' || $route=='showlabs'  || $route=='logout'  || $route=='displayProfile'){
                $isauthorise=true;
            }

            

        } else if ($regtype=='hdip' || $regtype=='apcng')
        {

           if ($route=='showlabs' || $route=='listlabtestedcylinders' || $route=='testedcylinders-search' || $route=='editformfortestedcylinders' || $route =='updateformfortestedcylinders' || $route=='deleteuser' || $route=='view-records'  
                || $route=='logout'  || $route=='displayProfile' || $route=='setCookie' || $route=='province-search' || $route=='searchuserregistration' || $route=='searchuserregistrationpaged' || $route=='Workshops'  || $route=='workshop-search' || $route=='city-search' || $route='searchforhdip' ||
                     $route=='printCylinders' || $route=='printCylinderIndex'){
                $isauthorise=true;
                if (Auth::user()->readonly ==1 && ($route=='deleteuser' || $route=='editformfortestedcylinders' || $route =='updateformfortestedcylinders' || $route=='searchuserregistrationpaged' ))
                {
                    $isauthorise=false;

                }
                
            }            
        }
        
        if ($regtype=='hdip' &&($route=='registrations' || $route=='registrations-search'
            || $route=='editcylinder' || $route=='cylinders' || $route=='newcylinderreg'
            || $route=='showcylinder'
        ))
         {  // giving access to hdip to vechilcles.

            $isauthorise=true;} 
        if ($route=='getcities'){
            $isauthorise=true; //public

        }

        if (Auth::user()->activated==0) {
            $isauthorise=false;
        }

        return $isauthorise;
        //return true;

    }
}


            /*if ($route=='registrations' || $route=='newcylinderreg'  || $route=='registrations-search' || $route=='testcylindersdataentryform' || $route=='savetestcylinders' || $route=='listlabtestedcylinders' || $route=='testedcylinders-search'){
                $isauthorise=true;
            }*/


           /*if ($route=='showlabs'|| $route=='registrations' || $route=='newcylinderreg'  || $route=='registrations-search' || $route=='showcylinder' || $route=='editcylinder' ){
                $isauthorise=true;
            }*/
//|| $route=='testcylindersdataentryform'