<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

php artisan cache:clear
php artisan route:clear
php artisan config:clear 
php artisan view:clear
1
2
3
4
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
##-----------to update images-----------
https://stackoverflow.com/questions/27374613/laravel-intervention-image-class-class-not-found
Add "intervention/image": "dev-master" to the “require” section of your composer.json file.
"require": {
    "laravel/framework": "4.1.*",
    "intervention/image": "dev-master"
},
Run CMD;
$ composer install
do $ composer update and then $ composer install
open the config/app.php file. Add this to the $providers array.
Intervention\Image\ImageServiceProvider::class
Next add this to the $aliases array.
'Image' => Intervention\Image\Facades\Image::class
$ composer update

##--------------regular expressions-------------------
https://regexr.com/
example: ^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$
year = (19|20)\d\d-
month = 0[1-9]|1[012]-
date = (0[1-9]|[12][0-9]|3[01])

laravel converstion
example: 'regex:/(^([a-zA-Z]{3}-[\d]+)$)/'
'regex:/(^$)/'
'regex:/(^(19|20)\d\d-0[1-9]|1[012]-(0[1-9]|[12][0-9]|3[01])$)/'
##-------------------------
jquery=editormtestedcylinders.blade.php
views/jquerysample
user/showuser.blade.php
##=========================
header("Set-Cookie: key=value; path=/; domain=www.tutorialshore.com; HttpOnly; Secure; SameSite=Strict");
##==========================
/*$testedcylindersWhereData = [
    ['name', 'test'],
    ['id', '<>', '5']
];*/

->where ($testedcylindersWhereData)
##==========================
to debug sql in laravel
 $cylinders=DB::Table('kit_cylinders')
                    ->leftjoin('RegisteredCylinders',function($join){
                        $join->on('kit_cylinders.Cylinder_SerialNo','=','RegisteredCylinders.SerialNumber');
                        $join->on('kit_cylinders.Make_Model','=','RegisteredCylinders.BrandName');
                    })
                    ->select(DB::Raw('count(formid) as UnregisteredCylinders'))
                    ->where('formid','=',$lastinspectionid)
                    ->where('RegisteredCylinders.Date','=',null)
                    ->where($cylindersWhereData)
                    ->toSql();

                    dd($cylinders);
##======================================
 'ocnic'=>'nullable|regex:/(^([\d]{5}-[\d]{7}-[\d])$)/',
              'ocnic'=>'nullable|regex:/(^([\d]{5}-[\d]{7}-[\d])$)/',
            'ddmanufacture'=>['required'],
            //'ddmanufacture'=>['required','regex:/(^(19|20)\d\d-0[1-9]|1[012]-(0[1-9]|[12][0-9]|3[01])$)/'],
            //'ocnic' =>['regex:/(^([\d]{5}-[\d]{7}-[\d])$)/'],

##============================================
   if(request()->cookie('pagesize'))
      { $pagesize =request()->cookie('pagesize');
        $recordperpage =$pagesize;
      }

##=================================================
            return redirect()->to($targetroute)->with('cylinder_locations',$results)
                                                    ->with('newvehicle',$id)
                                                    ->with('treeitems',$treeitems)
                                                    ->with('stationno',$stationno);
E:\xampp\htdocs\laravel\cngsafety\app\Http\Controllers\NewVehicleController.php:
##==================================================
views->jqeurysample.php

HTTP->controllers-Test.php =>cookie example
reading querystring: $page=$_GET['page'];

##=================================================      

composer require barryvdh/laravel-dompdf

