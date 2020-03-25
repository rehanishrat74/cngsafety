<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/testArray','Test@testArray');
Route::get('/testimage','Test@testImage');
Route::get('/testwhere','Test@testWhere');
Route::get('/testsql','Test@testSql');
Route::get('/testCookie','Test@testCookie');
Route::get('/getCookie','Test@getCookie');
Route::get('/do-update-particulars_test', 'Test@doUpdateParticulars');

Route::get('/testcylinders','Test@doUpdateCylinders');
/*-----------------------------*/
Route::post('/do-login', 'apiController@doLogin');
Route::post('/do-generate-pin', 'apiController@doGeneratePin');
Route::post('/do-verify-pin', 'apiController@doVerifyPin');
Route::post('/do-verify-code', 'apiController@doVerifyCode');
Route::post('/do-update-particulars', 'apiController@doUpdateParticulars');
Route::post('/do-update-cylinders', 'apiController@doUpdateCylinders');
Route::post('/do-update-cng-kit', 'apiController@doUpdateCngKit');
Route::post('/do-get-codes', 'apiController@doGetCodes');
Route::post('/do-upload-image', 'apiController@uploadFiles');
Route::post('/do-get-details','apiController@doGetInspectionDetails');
/*-----------------------------*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function(){
     //return back();
     return redirect('/');
    //return redirect()->route('');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/testmail', 'UserViewController@testmail')->name('testmail');
//Route::get('/view-records','UserViewController@index')->name('view-records');

/*Route::get('ajax',function() {
   return view('message');
});*/

/* signup routes */
Route::get('/signup_workshop','multiregistrationController@registerWorkshop')->name('workshoplogin');
Route::get('/signup_laboratory','multiregistrationController@registerLaboratory')->name('laboratorylogin');
Route::get('/signup_ogra','multiregistrationController@registerOgra')->name('ogralogin');
//Route::get('/signup_laboratory','dashboardController@index')->name('laboratorylogin');

    Route::get('/showuser/{id}','UserViewController@showuser')->name('showuser');
    Route::post('/edituser','UserViewController@edituser')->name('edituser');
    
/* login routes */
Route::get('/login_workshop','multiregistrationController@preworkshoplogin')->name('preworkshoplogin');
Route::get('/login_lab','multiregistrationController@prelablogin')->name('prelablogin');

Route::post('/getcities','PublicController@getcities')->name('getcities');

Route::get('/searchSticker/{stickerNo}','PublicController@searchSticker')->name('searchSticker');

//Route::get('/dologinaccess/{id}','PublicController@EnableLoginAccess')->name('enableuserget');

Route::post('/dologindenied','PublicController@DisableLoginAccess')->name('disableuser');
Route::get('/searchkccode','PublicController@searchKCcode')->name('searchkccode');
Route::post('/setCookie','PublicController@setCookie')->name('setCookie');


Auth::routes();



Route::group(['middleware' => ['auth', 'admin']], function() {
    // your routes



    Route::post('/getmsg','UserViewController@search')->name('search');
    Route::post('/searchuserregistration','UserViewController@searchuserregistration')->name('searchuserregistration');
    Route::get('/searchuserregistration','UserViewController@searchuserregistrationpaged')->name('searchuserregistration');

   Route::post('/searchforhdip','UserViewController@searchforhdip')->name('searchforhdip');
   Route::get('/searchforhdip','UserViewController@searchforhdippaged')->name('searchforhdip');


    Route::get('/view-records','UserViewController@index')->name('view-records');
    Route::post('/getajax','UserViewController@AjaxSearch')->name('searchajax');
    Route::get('/showlabs','UserViewController@HDIPusers')->name('showlabs');
    Route::post('/deleteuser','UserViewController@delete')->name('deleteuser');
    Route::post('/dologinaccess','UserViewController@dologinaccess')->name('dologinaccess');
    Route::post('/dochangepswd','UserViewController@dochangepswd')->name('dochangepswd');
     Route::get('/dodisplaypswd/{id}','UserViewController@dodisplaypswd')->name('dodisplaypswd');
      Route::get('/displayProfile','UserViewController@profile')->name('displayProfile');
  //Route::get('/ajax','UserViewController@AjaxSearch')->name('view-records');


    Route::get('/categories','vehicleCategoryController@index')->name('view-categories');
    Route::get('/locations','CylinderLocationsController@index')->name('view-locations');
    //Route::post('/categories','vehicleCategoryController@index')->name('view-categoires');
    Route::get('/registrations','VehicleLogicController@index')->name('registrations');    
    Route::post('/registrations','VehicleLogicController@search')->name('registrations-search');

    Route::get('/Workshops','VehicleLogicController@Workshops')->name('Workshops'); 
    Route::post('/WorkshopSearch','VehicleLogicController@WorkshopSearch')->name('workshop-search'); 
    Route::get('/WorkshopSearch','VehicleLogicController@WorkshopSearchpaginated')->name('workshop-search'); 

    Route::post('/getProvinceCities','VehicleLogicController@getProvinceCities')->name('province-search'); 
    Route::post('/getCityStations','VehicleLogicController@getCityStations')->name('city-search'); 


    Route::post('/newvehicle','NewVehicleController@store')->name('reg-vehicle');    
    Route::get('/newvehicle','NewVehicleController@index')->name('new-vehicle');
    Route::get('/editvehicle/{id}','NewVehicleController@edit')->name('edit-vehicle');
    Route::post('/editvehicle/{id}','NewVehicleController@update')->name('update-vehicle');      

    //Route::get('/newcylinderreg/{id}','CylindersController@createcylinder')->name('newcylinderreg');  
    Route::get('/newcylinderreg/{id}','CylindersController@createcylinder')->name('newcylinderreg');  
    Route::post('/cylinders','CylindersController@store')->name('cylinders');    
    
    Route::get('/cylinders/{id}','CylindersController@show')->name('showcylinder');   
    Route::get('/editcylinder/{id}','CylindersController@edit')->name('editcylinder');
    Route::post('/editcylinder/{id}','CylindersController@update')->name('editcylinder');

    Route::get('/dashboard','dashboardController@index')->name('dashboard');    

    Route::get('/labtestedcylinders','CylindersController@testcylindersdataentryform')->name('testcylindersdataentryform');
    Route::post('/labtestedcylinders','CylindersController@savetestcylinders')->name('savetestcylinders');    
    
    Route::get('/listlabtestedcylinders','CylindersController@listlabtestedcylinders')->name('listlabtestedcylinders');    
    Route::post('/listlabtestedcylinders','CylindersController@searchlabtestedcylinders')->name('testedcylinders-search');    

    Route::get('/editformfortestedcylinders/{id}','CylindersController@editformfortestedcylinders')->name('editformfortestedcylinders');    
    Route::post('/editformfortestedcylinders/{id}','CylindersController@updateformfortestedcylinders')->name('updateformfortestedcylinders');        


    Route::get('/transferStickers','CylindersController@transferStickers')->name('transferStickers');
    Route::post('/transferStickers','CylindersController@saveStickers')->name('saveStickers');

    Route::post('/showUploadFile','CylindersController@showUploadFile')->name('showUploadFile');    

    Route::get('/printCylinders','printController@cylinders');

    //Route::get('sendbasicemail','MailController@basic_email');
    //Route::get('/sendhtmlemail','MailController@html_email');
    //Route::get('sendattachmentemail','MailController@attachment_email');
});
