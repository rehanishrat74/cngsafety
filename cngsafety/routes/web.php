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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function(){
     //return back();
     return redirect('/');
    //return redirect()->route('');
});

Route::get('/testmethods/getcodes', 'Test@doGetCodes');
Route::get('/testmethods/GetInspectionDetails', 'Test@doGetInspectionDetails');
Route::get('/testmethods/UpdateParticulars', 'Test@doUpdateParticulars');
Route::get('/testmethods/TestKit', 'Test@doUpdateCngKit');
Route::get('/testmethods/TestCylinders', 'Test@doUpdateCylinders');


Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/view-records','UserViewController@index')->name('view-records');

/*Route::get('ajax',function() {
   return view('message');
});*/

/* signup routes */
Route::get('/signup_workshop','multiregistrationController@registerWorkshop')->name('workshoplogin');
Route::get('/signup_laboratory','multiregistrationController@registerLaboratory')->name('laboratorylogin');
Route::get('/signup_ogra','multiregistrationController@registerOgra')->name('ogralogin');
//Route::get('/signup_laboratory','dashboardController@index')->name('laboratorylogin');

/* login routes */
Route::get('/login_workshop','multiregistrationController@preworkshoplogin')->name('preworkshoplogin');
Route::get('/login_lab','multiregistrationController@prelablogin')->name('prelablogin');

Route::post('/getcities','PublicController@getcities')->name('getcities');

Route::get('/searchSticker/{stickerNo}','PublicController@searchSticker')->name('searchSticker');

//Route::get('/dologinaccess/{id}','PublicController@EnableLoginAccess')->name('enableuserget');

Route::post('/dologindenied','PublicController@DisableLoginAccess')->name('disableuser');

Auth::routes();



Route::group(['middleware' => ['auth', 'admin']], function() {
    // your routes
    Route::post('/getmsg','UserViewController@search')->name('search');
    Route::get('/view-records','UserViewController@index')->name('view-records');
    Route::post('/getajax','UserViewController@AjaxSearch')->name('searchajax');
    Route::get('/showlabs','UserViewController@HDIPusers')->name('showlabs');
    Route::post('/deleteuser','UserViewController@delete')->name('deleteuser');
    Route::post('/dologinaccess','UserViewController@dologinaccess')->name('dologinaccess');
  //Route::get('/ajax','UserViewController@AjaxSearch')->name('view-records');
    Route::get('/showuser/{id}','UserViewController@showuser')->name('showuser');
    Route::post('/edituser','UserViewController@edituser')->name('edituser');


    Route::get('/categories','vehicleCategoryController@index')->name('view-categories');
    Route::get('/locations','CylinderLocationsController@index')->name('view-locations');
    //Route::post('/categories','vehicleCategoryController@index')->name('view-categoires');
    Route::get('/registrations','VehicleLogicController@index')->name('registrations');    
    Route::post('/registrations','VehicleLogicController@search')->name('registrations-search');

    Route::post('/newvehicle','NewVehicleController@store')->name('reg-vehicle');    
    Route::get('/newvehicle','NewVehicleController@index')->name('new-vehicle');

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



    //Route::get('sendbasicemail','MailController@basic_email');
    //Route::get('/sendhtmlemail','MailController@html_email');
    //Route::get('sendattachmentemail','MailController@attachment_email');
});
