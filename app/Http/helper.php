<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

function language(){
    if (session()->get('back-locale') == 'ar') {
        return 2;
    } else {
        return 1;
    }
}

// function languageSite(){
//     if(session()->get('front-locale') == 'ar') {
//         return 2;
//     } else {
//         return 1;
//     }
// }

function languageApi($lang){
    if($lang == 2){
        App::setLocale('ar');
    } else {
        App::setLocale('en');
    }
}

// function nameAdmin(){
//     $id = auth()->guard('admin')->user()->id;
//     $admin = DB::table('administration')
//         ->where('id', '=', $id)
//         ->first();
//     return $admin;
// }

function messageContact(){
    $contacts = DB::table('contacts')
        ->where('contact_read', '=', 0)
        ->where('contact_from', '=', 1)
        ->orderBy('contact_id', 'desc')
        ->get();
    return $contacts;
}

function messageCount(){
   $count = DB::table('contacts')->where('contact_read', '=', 0)->where('contact_from', '=', 1)->count();
   return $count;
}
/*
function getName(){
    $type_id = Auth::guard('admin')->user()->type_id;
    if (Auth::guard('admin')->user()->type == 1){
        $user = DB::table('hospital_description')
            ->where('hospital_id', '=', $type_id)
            ->where('language_id', '=', language())
            ->select('hospital_name')
            ->first();
        return $user->hospital_name;
    } elseif (Auth::guard('admin')->user()->type == 2) {
        $user = DB::table('clinic_description')
            ->where('clinic_id', '=', $type_id)
            ->where('language_id', '=', language())
            ->select('clinic_name')
            ->first();
        return $user->clinic_name;
    } elseif (Auth::guard('admin')->user()->type == 3) {
        $user = DB::table('restaurant_description')
            ->where('restaurant_id', '=', $type_id)
            ->where('language_id', '=', language())
            ->select('restaurant_name')
            ->first();
        return $user->restaurant_name;
    } elseif(Auth::guard('admin')->user()->type == 4) {
        $user = DB::table('catering_description')
            ->where('catering_id', '=', $type_id)
            ->where('language_id', '=', language())
            ->select('catering_name')
            ->first();
        return $user->catering_name;
    } else {
        $type = Auth::guard('admin')->user()->type;
        $user = DB::table('administration')
            ->where('type', '=', $type)
            ->select('name')
            ->first();
        return $user->name;
    }
}
*/
function setting(){
    $currency = DB::table('setting_description')->where('language_id', '=', languageSite())->first();
    return $currency;
}

function allSetting(){
    $settings = DB::table('settings')->get();
    return $settings;
}

function aboutUs(){
    $about_us=DB::table('about_us')
        ->leftJoin('about_us_description', 'about_us_description.about_us_id', '=', 'about_us.about_us_id')
        ->where('about_us_description.language_id', languageSite())
        ->get();
    return $about_us;
}

function convert($string) {
    $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩',','];
    $num = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
    $englishNumbersOnly = str_replace($arabic, $num, $string);

    return $englishNumbersOnly;
}

function get_local_time(){

//   $ip = $request->getClientIp();

   // $url = 'http://ip-api.com/json/'.$ip;

   // $tz = file_get_contents($url);

   // $tz = json_decode($tz,true)['timezone'];

   date_default_timezone_set('Asia/Riyadh');
   
   return date('Y/m/d H:i:s');

}

function setOpen($path)
{
    return Request::is($path . '*') ? ' open' :  '';
}

function setActive($path)
{
    return Request::is($path . '*') ? ' active' :  '';
}

function role($name){
    if(auth()->guard('admin')->user()->type != 1) {
        $user_role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
        $user_role->$name;
        if($user_role->$name == 1){
            $user = true;
        } else {
            $user = false;
        }
    } else {
        $user = true;
    }
    
    return $user;
}

function user_type(){
    return auth()->guard('admin')->user()->type;
}


