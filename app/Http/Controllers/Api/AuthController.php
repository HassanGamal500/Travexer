<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;

class AuthController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function registration(Request $request) {
        // return response()->json($request->all());
        $validator = validator()->make($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }
        
        if($request->type == 1){
            $validator= validator()->make($request->all(),[
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email|max:200',
                'phone' => 'required|unique:users,phone|max:13',
                'password' => 'required|min:6',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'national_identity' => 'required|min:10',
            ]);
            
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
            && preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+[a-z]{1}$/", strtolower($request->email)) 
            && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)
            && preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->password)
            && $request->gender != null && preg_match("/[0-9]/u", $request->phone)) {
    
                $code = rand(1111, 9999);
            
                $verify = DB::table('verifications')->where('verification_phone', '=', $request->phone)->count();
                if($verify > 0) {
                    $verification = DB::table('verifications')->where('verification_phone', '=', $request->phone)->update(['verification_code' => '1234', 'is_used' => 0]);
                } else {
                    $verification = DB::table('verifications')->insert(['verification_code' => '1234', 'is_used' => 0, 'verification_phone' => $request->phone]);
                }
    
                $response = [
                    'status' => 1,
                    'message' => trans('admin.check verification code on your message'),
                    'data' => []
                ];
            
                return response()->json($response, 200);
    
            } else {
                if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || !preg_match("/[\p{Arabic}A-Za-z]/u", $request->name)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.name must contain only characters'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->password)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.Password must contain letters, numbers and symbols'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif($request->gender == null) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.select gender'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/[0-9]/u", $request->phone)) {
                    
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.number phone must contain only numbers'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                    
                } else {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.your email is not correct'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                }
            }
        } elseif($request->type == 2) {
            // return response()->json($request->all());
            $messages = [
                'service_other.required_if' => trans('admin.you must fill the field other'),     
            ];
            $validator= validator()->make($request->all(),[
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email|max:200',
                'phone' => 'required|unique:users,phone|max:13',
                'password' => 'required|min:6',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'nationality' => 'required',
                'national_identity' => 'required|min:10',
                'front_national_identity_image' => 'required',
                'back_national_identity_image' => 'required',
                'front_car_image' => 'required',
                'back_car_image' => 'required',
                'service_id' => 'required',
                'service_other' => 'required_if:service_id,0|max:32',
                'attach_field_image' => 'required',
                'price' => 'required|numeric',
            ], $messages);
            
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
            && preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+[a-z]{1}$/", strtolower($request->email)) 
            && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)
            && preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->password)
            && $request->gender != null && preg_match("/[0-9]/u", $request->phone)) {
    
                $code = rand(1111, 9999);
            
                $verify = DB::table('verifications')->where('verification_phone', '=', $request->phone)->count();
                if($verify > 0) {
                    $verification = DB::table('verifications')->where('verification_phone', '=', $request->phone)->update(['verification_code' => '1234', 'is_used' => 0]);
                } else {
                    $verification = DB::table('verifications')->insert(['verification_code' => '1234', 'is_used' => 0, 'verification_phone' => $request->phone]);
                }
    
                $response = [
                    'status' => 1,
                    'message' => trans('admin.check verification code on your message'),
                    'data' => []
                ];
            
                return response()->json($response, 200);
    
            } else {
                if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || !preg_match("/[\p{Arabic}A-Za-z]/u", $request->name)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.name must contain only characters'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->password)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.Password must contain letters, numbers and symbols'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif($request->gender == null) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.select gender'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/[0-9]/u", $request->phone)) {
                    
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.number phone must contain only numbers'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                    
                } else {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.your email is not correct'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                }
            }
        } else {
            $validator= validator()->make($request->all(),[
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email|max:200',
                'phone' => 'required|unique:users,phone|max:13',
                'password' => 'required|min:6',
                // 'date_of_birth' => 'required|date',
                // 'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'company_location' => 'required',
                'commercial_registration_no_image' => 'required',
                'contact_name' => 'required|max:100',
                'contact_email' => 'required|max:200',
                'contact_phone' => 'required|max:13',
            ]);
            
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
            && preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+[a-z]{1}$/", strtolower($request->email)) 
            && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)
            && preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->password)
            && preg_match("/[0-9]/u", $request->phone)) {
    
                $code = rand(1111, 9999);
            
                $verify = DB::table('verifications')->where('verification_phone', '=', $request->phone)->count();
                if($verify > 0) {
                    $verification = DB::table('verifications')->where('verification_phone', '=', $request->phone)->update(['verification_code' => '1234', 'is_used' => 0]);
                } else {
                    $verification = DB::table('verifications')->insert(['verification_code' => '1234', 'is_used' => 0, 'verification_phone' => $request->phone]);
                }
    
                $response = [
                    'status' => 1,
                    'message' => trans('admin.check verification code on your message'),
                    'data' => []
                ];
            
                return response()->json($response, 200);
    
            } else {
                if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || !preg_match("/[\p{Arabic}A-Za-z]/u", $request->name)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.name must contain only characters'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->password)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.Password must contain letters, numbers and symbols'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/[0-9]/u", $request->phone)) {
                    
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.number phone must contain only numbers'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                    
                } else {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.your email is not correct'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                }
            }
        }
            
    }

    public function verification(Request $request) {
        $validator = validator()->make($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }
        
        if($request->type == 1) {
            $validator= validator()->make($request->all(),[
                'verification_code' => 'required',
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email|max:200',
                'phone' => 'required|unique:users,phone|max:13',
                'password' => 'required|min:6',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'national_identity' => 'required|min:10',
            ]);
            
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            $user = DB::table('verifications')->where('verification_code', $request->verification_code)
                ->where('verification_phone', $request->phone)
                ->where('is_used', '=', 0)
                ->count();
    
            if ($user > 0){
                    $check = DB::table('users')->insertGetId([
                        'name'              => $request->name,
                        'email'             => $request->email,
                        'phone'             => $request->phone,
                        'password'          => Hash::make($request->password),
                        'birth_of_date'     => $request->date_of_birth,
                        'gender'            => $request->gender,
                        'image'             => 'images/user/avatar_user.png',
                        'country_id'        => $request->country,
                        'city_id'           => $request->city,
                        'type'              => 1,
                        'national_identity' => $request->national_identity,
                    ]);
                    
                    $update = DB::table('verifications')->where('verification_phone', '=', $request->phone)->update(['is_used' => 1]);
                    $user = DB::table('users')->where('type', '=', 1)->where('id', '=', $check)->first();
                    $loginToken = User::find($user->id);
                    $accessToken = $loginToken->createToken('authToken')->accessToken;
                    $response = [
                        'status' => 1,
                        'message' => trans('admin.Success'),
                        'data' => [
                            'user' => $user,
                            'token' => $accessToken
                        ]
                    ];
                    return response()->json($response, 200);
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.This verification code is invalid'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
        } elseif($request->type == 2) {
            $messages = [
                'service_other.required_if' => trans('admin.you must fill the field other'),     
            ];
            $validator= validator()->make($request->all(),[
                'verification_code' => 'required',
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email|max:200',
                'phone' => 'required|unique:users,phone|max:13',
                'password' => 'required|min:6',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'nationality' => 'required',
                'national_identity' => 'required|min:10',
                'front_national_identity_image' => 'required',
                'back_national_identity_image' => 'required',
                'front_car_image' => 'required',
                'back_car_image' => 'required',
                'service_id' => 'required',
                'service_other' => 'required_if:service_id,0|max:32',
                'attach_field_image' => 'required',
                'price' => 'required|numeric',
            ], $messages);
            
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            $user = DB::table('verifications')->where('verification_code', $request->verification_code)
                ->where('verification_phone', $request->phone)
                ->where('is_used', '=', 0)
                ->count();
    
            if ($user > 0){
    
                if(!empty($request->front_national_identity_image)){
                    $image = substr($request->front_national_identity_image, strpos($request->front_national_identity_image, ",") + 1);
                    $img = base64_decode($image);
                    $dir="images/user/guide/identity";
                    if (!file_exists($dir) and !is_dir($dir)) {
                        // mkdir($dir,0777,true);
                        File::makeDirectory(base_path().'/'.$dir);
                    }
                    $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                    file_put_contents(base_path().'/'.$uploadfile, $img);
                    $front_national_identity_image=$uploadfile;
                }
    
                if(!empty($request->back_national_identity_image)){
                    $image = substr($request->back_national_identity_image, strpos($request->back_national_identity_image, ",") + 1);
                    $img = base64_decode($image);
                    $dir="images/user/guide/identity";
                    if (!file_exists($dir) and !is_dir($dir)) {
                        mkdir($dir,0777,true);
                        File::makeDirectory(base_path().'/'.$dir);
                    }
                    $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                    file_put_contents(base_path().'/'.$uploadfile, $img);
                    $back_national_identity_image=$uploadfile;
                }
                
                if(!empty($request->front_car_image)){
                    $image = substr($request->front_car_image, strpos($request->front_car_image, ",") + 1);
                    $img = base64_decode($image);
                    $dir="images/user/guide/car";
                    if (!file_exists($dir) and !is_dir($dir)) {
                        // mkdir($dir,0777,true);
                        File::makeDirectory(base_path().'/'.$dir);
                    }
                    $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                    file_put_contents(base_path().'/'.$uploadfile, $img);
                    $front_car_image=$uploadfile;
                }
    
                if(!empty($request->back_car_image)){
                    $image = substr($request->back_car_image, strpos($request->back_car_image, ",") + 1);
                    $img = base64_decode($image);
                    $dir="images/user/guide/car";
                    if (!file_exists($dir) and !is_dir($dir)) {
                        mkdir($dir,0777,true);
                        File::makeDirectory(base_path().'/'.$dir);
                    }
                    $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                    file_put_contents(base_path().'/'.$uploadfile, $img);
                    $back_car_image=$uploadfile;
                }
    
                if(!empty($request->attach_field_image)){
                    $image = substr($request->attach_field_image, strpos($request->attach_field_image, ",") + 1);
                    $img = base64_decode($image);
                    $dir="images/user/guide/attach";
                    // if (!file_exists($dir) and !is_dir($dir)) {
                    //     // mkdir($dir,0777,true);
                    //     File::makeDirectory(base_path().'/'.$dir,0777,true);
                    // }
                    $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                    file_put_contents(base_path().'/'.$uploadfile, $img);
                    $attach_field_image=$uploadfile;
                }
    
                if($request->service_id == 0 && $request->service_other){
                    $services = DB::table('services')->insertGetId(['status' => 0]);
        
                    for ($i = 1; $i <= 2; $i++){
                        $description = DB::table('service_description')
                            ->insert([
                                'service_name' => $request->service_other,
                                'language_id' => $i,
                                'service_id' => $services
                            ]);
                    }
                } else {
                    $services = $request->service_id;
                }
    
                $check = DB::table('users')->insertGetId([
                    'name'                          => $request->name,
                    'email'                         => $request->email,
                    'phone'                         => $request->phone,
                    'password'                      => Hash::make($request->password),
                    'birth_of_date'                 => $request->date_of_birth,
                    'gender'                        => $request->gender,
                    'image'                         => 'images/user/avatar_user.png',
                    'country_id'                    => $request->country,
                    'city_id'                       => $request->city,
                    'type'                          => 2,
                    'nationality_id'                => $request->nationality,
                    'national_identity'             => $request->national_identity,
                    'front_national_identity_image' => $front_national_identity_image,
                    'back_national_identity_image'  => $back_national_identity_image,
                    'front_car_image'               => $front_car_image,
                    'back_car_image'                => $back_car_image,
                    'service_id'                    => $services,
                    'attach_field_image'            => $attach_field_image,
                    'price'                         => $request->price
                ]);
                
                $update = DB::table('verifications')->where('verification_phone', '=', $request->phone)->update(['is_used' => 1]);
                $user = DB::table('users')->where('type', '=', 2)->where('id', '=', $check)->first();
                $loginToken = User::find($user->id);
                $accessToken = $loginToken->createToken('authToken')->accessToken;
                $response = [
                    'status' => 1,
                    'message' => trans('admin.Success'),
                    'data' => [
                        'user' => $user,
                        'token' => $accessToken
                    ]
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.This verification code is invalid'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
        } else {
            $validator= validator()->make($request->all(),[
                'verification_code' => 'required',
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email|max:200',
                'phone' => 'required|unique:users,phone|max:13',
                'password' => 'required|min:6',
                // 'date_of_birth' => 'required|date',
                // 'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'company_location' => 'required',
                'commercial_registration_no_image' => 'required',
                'contact_name' => 'required|max:100',
                'contact_email' => 'required|max:200',
                'contact_phone' => 'required|max:13',
            ]);
            
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            $user = DB::table('verifications')->where('verification_code', $request->verification_code)
                ->where('verification_phone', $request->phone)
                ->where('is_used', '=', 0)
                ->count();
    
            if ($user > 0){
    
                if(!empty($request->commercial_registration_no_image)){
                    $image = substr($request->commercial_registration_no_image, strpos($request->commercial_registration_no_image, ",") + 1);
                    $img = base64_decode($image);
                    $dir="images/user/company/registration";
                    if (!file_exists($dir) and !is_dir($dir)) {
                        // mkdir($dir,0777,true);
                        File::makeDirectory(base_path().'/'.$dir,0777,true);
                    }
                    $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                    file_put_contents(base_path().'/'.$uploadfile, $img);
                    $commercial_registration_no_image=$uploadfile;
                }
    
                $check = DB::table('users')->insertGetId([
                    'name'                              => $request->name,
                    'email'                             => $request->email,
                    'phone'                             => $request->phone,
                    'password'                          => Hash::make($request->password),
                    // 'birth_of_date'                     => $request->date_of_birth,
                    // 'gender'                            => $request->gender,
                    'image'                             => 'images/user/avatar_user.png',
                    'country_id'                        => $request->country,
                    'city_id'                           => $request->city,
                    'type'                              => 3,
                    'company_location'                  => $request->company_location,
                    'commercial_registration_no_image'  => $commercial_registration_no_image,
                    'contact_name'                      => $request->contact_name,
                    'contact_email'                     => $request->contact_email,
                    'contact_phone'                     => $request->contact_phone,
                ]);
                
                $update = DB::table('verifications')->where('verification_phone', '=', $request->phone)->update(['is_used' => 1]);
                $user = DB::table('users')->where('type', '=', 3)->where('id', '=', $check)->first();
                $loginToken = User::find($user->id);
                $accessToken = $loginToken->createToken('authToken')->accessToken;
                $response = [
                    'status' => 1,
                    'message' => trans('admin.Success'),
                    'data' => [
                        'user' => $user,
                        'token' => $accessToken
                    ]
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.This verification code is invalid'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
        }
        
            
    }

    public function resend(Request $request) {
        $validator = validator()->make($request->all(),[
            'phone' => 'required|exists:users|max:13',
        ]);

        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }

        $user = DB::table('users')->where('phone', $request->phone)->first();

        if ($user) {
            $code = rand(1111, 9999);
            $verify = DB::table('verifications')->where('verification_phone', '=', $request->phone)->count();
            if($verify > 0) {
                $update = DB::table('verifications')->where('verification_phone', '=', $request->phone)->update(['verification_code' => '1234', 'is_used' => 0]);
            } else {
                $update = DB::table('verifications')->insert(['verification_code' => '1234', 'is_used' => 0, 'verification_phone' => $request->phone]);
                $update = true;
            }
            
            if ($update = true) {
                // $to_name = $user->name;
                // $to_email = $user->email;
                // $data = array('name'=> $user->name, "body" => "Your Reset Code Is :".$code);

                // Mail::send('email.mail', $data, function($message) use ($to_name, $to_email) {
                //     $message->to($to_email, $to_name)
                //         ->subject('Reset Password');
                //     $message->from('info@diva.com','Diva');
                // });

                $response = [
                    'status' => 1,
                    'message' => trans('admin.check verification code on your message'),
                    'data' => []
                ];
                return response()->json($response, 200);

            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.Activation code not sent. Try again'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }

        }

    }

    public function postlogin(Request $request) {
        $validator = validator()->make($request->all(), [
            'input' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }

        if (is_numeric($request->input)) {
            $validator = validator()->make($request->all(), [
                'input' => 'required|max:13|exists:users,phone',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()){
                $response = [
                    'status' => 0,
                    'message' => trans("admin.your phone or password is not correct"),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
            $user = DB::table('users')->where('phone', $request->input)->first();
        }elseif (filter_var(filter_var(strtolower($request->input), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
            $validator = validator()->make($request->all(), [
                'input' => 'required|email|exists:users,email|max:200',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()){
                $response = [
                    'status' => 0,
                    'message' => trans('admin.your email or password is not correct'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
            $user = DB::table('users')->where('email', strtolower($request->input))->first();
        }else{
            $user=false;
        }

        // $validator= validator()->make($request->all(),[
        //     'phone' => 'required|exists:users',
        //     'password' => 'required',
        // ]);

        // if ($validator->fails()){

        //     $response = [
        //         'status' => 0,
        //         'message' => trans('admin.invalid phone number or passowrd'),
        //         'data' => []
        //     ];
        //     return response()->json($response);

        // }

        // $user = DB::table('users')->where('phone', $request->phone)->count();
        // $user = DB::table('users')->where('phone', $request->phone)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $lang = DB::table('users')->where('phone', '=', $request->phone)->update(['default_language' => $request->language_id]);
                DB::table('users')->where('phone', '=', $request->phone)->update(['token'=>$request->token]);
                $loginToken = User::find($user->id);
                $accessToken = $loginToken->createToken('authToken')->accessToken;
                $response = [
                    'status' => 1,
                    'message' => trans('admin.Success'),
                    'data' => [
                        'user' => $user,
                        'token' => $accessToken
                    ]
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.invalid phone number or passowrd'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin.invalid phone number or passowrd'),
                'data' => []
            ];
            return response()->json($response, 422);
        }

    }

    public function reset_password(Request $request) {
        if (is_numeric($request->input)) {
            $validator = validator()->make($request->all(), [
                'input' => 'required|max:13|exists:users,phone'
            ]);

            if ($validator->fails()){
                $response = [
                    'status' => 0,
                    'message' => trans("admin.your phone is not correct"),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
            $user = DB::table('users')->where('phone', $request->input)->first();
        }elseif (filter_var(filter_var(strtolower($request->input), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
            $validator = validator()->make($request->all(), [
                'input' => 'required|email|exists:users,email|max:200'
            ]);

            if ($validator->fails()){
                $response = [
                    'status' => 0,
                    'message' => trans('admin.your email is not correct'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
            $user = DB::table('users')->where('email', strtolower($request->input))->first();
        }else{
            $user=false;
        }

        // $user = DB::table('users')->where('phone', $request->phone)->first();

        if ($user) {
            $code = rand(1111, 9999);
            $verify = DB::table('verifications')->where('verification_phone', '=', $user->phone)->count();
            if($verify > 0) {
                $update = DB::table('verifications')->where('verification_phone', '=', $user->phone)->update(['verification_code' => '1234', 'is_used' => 0]);
            } else {
                $update = DB::table('verifications')->insert(['verification_code' => '1234', 'is_used' => 0, 'verification_phone' => $user->phone]);
                $update = true;
            }
            
            if ($update = true) {
                // $to_name = $user->name;
                // $to_email = $user->email;
                // $data = array('name'=> $user->name, "body" => "Your Reset Code Is :".$code);

                // Mail::send('email.mail', $data, function($message) use ($to_name, $to_email) {
                //     $message->to($to_email, $to_name)
                //         ->subject('Reset Password');
                //     $message->from('info@diva.com','Diva');
                // });

                $response = [
                    'status' => 1,
                    'message' => trans('admin.Success'),
                    'data' => []
                ];
                return response()->json($response, 200);

            } else {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.something wrong, try again'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }

        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin.your account is not exist'),
                'data' => []
            ];
            return response()->json($response, 422);
        }

    }

    public function checkVerificationForPassword(Request $request) {
        $validator = validator()->make($request->all(),[
            'verification_phone' => 'required|max:13',
            'verification_code' => 'required'
        ]);

        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);

        }

        $user = DB::table('verifications')->where('verification_phone', '=', $request->verification_phone)
        ->where('verification_code', '=', $request->verification_code)->where('is_used', '=', 0)->first();

        if ($user){
            $update = DB::table('verifications')->where('verification_phone', '=', $request->verification_phone)
            ->where('verification_code', '=', $request->verification_code)->update(['is_used'=> 1]);
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $user
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin.This verification code is invalid'),
                'data' => []
            ];
            return response()->json($response, 422);
        }
    }

    public function changePassword(Request $request) {

        $validator = validator()->make($request->all(),[
            'phone' => 'required|max:13',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);

        }
        
        if(preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->password)) {
            $user = DB::table('users')->where('phone', $request->phone)->first();
    
            if ($user) {
                
                $update = DB::table('users')->where('phone', '=', $request->phone)->update(['password' =>  Hash::make($request->password)]);
                $response = [
                    'status' => 1,
                    'message' => trans('admin.password changed successfully'),
                    'data' => $user
                ];
                return response()->json($response, 200);
                
    
            } else {
    
                $response = [
                    'status' => 0,
                    'message' => trans('admin.This phone is invalid'),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
        } else {
            if(!preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->password)) {
                $response = [
                    'status' => 0,
                    'message' => trans('admin.Password must contain letters, numbers and symbols'),
                    'data' => []
                ];
                return response()->json($response, 422);
            // } elseif(!preg_match("/^(?=.*?[a-zA-Z])(?=.*?[0-9])/", $request->new_password)) {
            //     $response = [
            //         'status' => 0,
            //         'message' => trans('labels.New Password must contain letters, numbers and symbols'),
            //         'data' => []
            //     ];
            //     return response()->json($response, 422);
            }
        }
    }

    public function getProfile(Request $request) {
        $validator= validator()->make($request->all(),[
            'user_id' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }
        $id = $request->user_id;
        // $user=User::find($id);
        $user = DB::table('users')->where('id', '=', $id)->first();
        
        if($user){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $user
            ];
            $code = 200;
        } else {
            $response = [
                'status' => 0,
                'message' => trans('admin.failed'),
                'data' => []
            ];
            $code = 404;
        }
        return response()->json($response, $code);
    }

    public function updateProfile(Request $request) {
        $validator = validator()->make($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }
        
        if($request->type == 1) {
            $validator= validator()->make($request->all(),[
                'user_id' => 'required',
                'name' => 'required|max:100',
                'email' => 'required|email|max:200',
                'phone' => 'required|max:13',
                'password' => 'nullable|min:6',
                'new_password' => 'required_with:password|min:6',
                // 'national_identity' => 'required|max:10',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'image' => 'nullable',
            ]);
    
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
            && preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+[a-z]{1}$/", strtolower($request->email)) 
            && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name) 
            && $request->gender != null && preg_match("/[0-9]/u", $request->phone)) {
                $user = DB::table('users')->where('id', '=', $request->user_id)->select('image', 'password')->first();
                $allPhone = DB::table('users')->where('phone', $request->phone)->where('id', '!=', $request->user_id)->count();
                $allEmail = DB::table('users')->where('email', $request->email)->where('id', '!=', $request->user_id)->count();
                // dd($checkPassword);
                
                if ($allPhone > 0 || $allEmail > 0) {
                    if ($allPhone > 0){
                        $response = [
                            'status' => 0,
                            'message' => trans('admin.This phone has been taken before'),
                            'data' => []
                        ];
                        return response()->json($response, 422);
                    } elseif($allEmail > 0) {
                        $response = [
                            'status' => 0,
                            'message' => trans('admin.This email has been taken before'),
                            'data' => []
                        ];
                        return response()->json($response, 422);
                    }
                } else {
                    if($request->new_password != null){
                        if(!preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->new_password)){
                            $response = [
                                'status' => 0,
                                'message' => trans('admin.New Password must contain letters, numbers and symbols'),
                                'data' => []
                            ];
                            return response()->json($response, 422);
                        }
                    }
    
                    if(!empty($request->image)){
                        $image = substr($request->image, strpos($request->image, ",") + 1);
                        $img = base64_decode($image);
                        $dir="images/user";
                        if (!file_exists($dir) and !is_dir($dir)) {
                            File::makeDirectory(base_path().'/'.$dir);
                        }
                        $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $imageName=$uploadfile;
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update(['image'    =>  $imageName]);
                    }
                    
                    if($request->password != null ){
                        if (!Hash::check($request->password, $user->password)) {
                            $response = [
                                'status' => 0,
                                'message' => trans('admin.Current Password Is Not Correct'),
                                'data' => []
                            ];
                            return response()->json($response, 422);
                        } else {
                            $update = DB::table('users')->where('id', '=', $request->user_id)->update([
                                'name'              => $request->name,
                                'email'             => $request->email,
                                'phone'             => $request->phone,
                                'password'          => Hash::make($request->new_password),
                                'birth_of_date'     => $request->date_of_birth,
                                'gender'            => $request->gender,
                                'country_id'        => $request->country,
                                'city_id'           => $request->city,
                            ]);
                        }
                    } else {
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update([
                            'name'              => $request->name,
                            'email'             => $request->email,
                            'phone'             => $request->phone,
                            'birth_of_date'     => $request->date_of_birth,
                            'gender'            => $request->gender,
                            'country_id'        => $request->country,
                            'city_id'           => $request->city,
                        ]);
                    }
                    $userUpdated = DB::table('users')
                        ->where('id', '=', $request->user_id)
                        ->select('id', 'name', 'phone', 'email', 'image', 'gender', 
                        'birth_of_date', 'country_id', 'city_id', 'type')
                        ->first();
                    $response = [
                        'status' => 1,
                        'message' => trans('admin.update successfully'),
                        'data' => $userUpdated
                    ];
                    return response()->json($response, 200);
                }
            } else {
                if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || !preg_match("/[\p{Arabic}A-Za-z]/u", $request->name)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.name must contain only characters'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif($request->gender == null) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.select gender'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/[0-9]/u", $request->phone)) {
                    
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.number phone must contain only numbers'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                    
                } else {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.your email is not correct'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                }
            }
        } elseif($request->type == 2) {
            $validator= validator()->make($request->all(),[
                'user_id' => 'required',
                'name' => 'required|max:100',
                'email' => 'required|email|max:200',
                'phone' => 'required',
                'password' => 'nullable|min:6',
                'new_password' => 'required_with:password|min:6',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'nationality' => 'required',
                'image' => 'nullable',
                'national_identity' => 'nullable',
                'front_national_identity_image' => 'nullable',
                'back_national_identity_image' => 'nullable',
                'front_car_image' => 'nullable',
                'back_car_image' => 'nullable',
                'service_id' => 'nullable',
                'attach_field_image' => 'nullable',
                'price' => 'required|numeric',
                'description' => 'nullable'
            ]);
            // dd($request->option[0]['option_title']);
    
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
            && preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+[a-z]{1}$/", strtolower($request->email)) 
            && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name) 
            && $request->gender != null && preg_match("/[0-9]/u", $request->phone)) {
                $user = DB::table('users')->where('id', '=', $request->user_id)->select('image', 'password')->first();
                $allPhone = DB::table('users')->where('phone', $request->phone)->where('id', '!=', $request->user_id)->count();
                $allEmail = DB::table('users')->where('email', $request->email)->where('id', '!=', $request->user_id)->count();
                // dd($checkPassword);
                
                if ($allPhone > 0 || $allEmail > 0) {
                    if ($allPhone > 0){
                        $response = [
                            'status' => 0,
                            'message' => trans('admin.This phone has been taken before'),
                            'data' => []
                        ];
                        return response()->json($response, 422);
                    } elseif($allEmail > 0) {
                        $response = [
                            'status' => 0,
                            'message' => trans('admin.This email has been taken before'),
                            'data' => []
                        ];
                        return response()->json($response, 422);
                    }
                } else {
                    if($request->new_password != null){
                        if(!preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->new_password)){
                            $response = [
                                'status' => 0,
                                'message' => trans('admin.New Password must contain letters, numbers and symbols'),
                                'data' => []
                            ];
                            return response()->json($response, 422);
                        }
                    }
    
                    if(!empty($request->image)){
                        $image = substr($request->image, strpos($request->image, ",") + 1);
                        $img = base64_decode($image);
                        $dir="images/user/guide";
                        if (!file_exists($dir) and !is_dir($dir)) {
                            File::makeDirectory(base_path().'/'.$dir);
                        }
                        $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $imageName=$uploadfile;
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update(['image'    =>  $imageName]);
                    }
    
                    if(!empty($request->front_national_identity_image)){
                        $image = substr($request->front_national_identity_image, strpos($request->front_national_identity_image, ",") + 1);
                        $img = base64_decode($image);
                        $dir="images/user/guide/identity";
                        if (!file_exists($dir) and !is_dir($dir)) {
                            // mkdir($dir,0777,true);
                            File::makeDirectory(base_path().'/'.$dir);
                        }
                        $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $front_national_identity_image=$uploadfile;
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update(['front_national_identity_image'    =>  $front_national_identity_image]);
                    }
        
                    if(!empty($request->back_national_identity_image)){
                        $image = substr($request->back_national_identity_image, strpos($request->back_national_identity_image, ",") + 1);
                        $img = base64_decode($image);
                        $dir="images/user/guide/identity";
                        if (!file_exists($dir) and !is_dir($dir)) {
                            mkdir($dir,0777,true);
                            File::makeDirectory(base_path().'/'.$dir);
                        }
                        $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $back_national_identity_image=$uploadfile;
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update(['back_national_identity_image'    =>  $back_national_identity_image]);
                    }
                    
                    if(!empty($request->front_car_image)){
                        $image = substr($request->front_car_image, strpos($request->front_car_image, ",") + 1);
                        $img = base64_decode($image);
                        $dir="images/user/guide/identity";
                        if (!file_exists($dir) and !is_dir($dir)) {
                            // mkdir($dir,0777,true);
                            File::makeDirectory(base_path().'/'.$dir);
                        }
                        $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $front_car_image=$uploadfile;
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update(['front_car_image'    =>  $front_car_image]);
                    }
        
                    if(!empty($request->back_car_image)){
                        $image = substr($request->back_car_image, strpos($request->back_car_image, ",") + 1);
                        $img = base64_decode($image);
                        $dir="images/user/guide/identity";
                        if (!file_exists($dir) and !is_dir($dir)) {
                            mkdir($dir,0777,true);
                            File::makeDirectory(base_path().'/'.$dir);
                        }
                        $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $back_car_image=$uploadfile;
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update(['back_car_image'    =>  $back_car_image]);
                    }
        
                    if(!empty($request->attach_field_image)){
                        $image = substr($request->attach_field_image, strpos($request->attach_field_image, ",") + 1);
                        $img = base64_decode($image);
                        $dir="images/user/guide/attach";
                        if (!file_exists($dir) and !is_dir($dir)) {
                            // mkdir($dir,0777,true);
                            File::makeDirectory(base_path().'/'.$dir);
                        }
                        $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $attach_field_image=$uploadfile;
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update(['attach_field_image'    =>  $attach_field_image]);
                    }
                    
                    if($request->password != null ){
                        if (!Hash::check($request->password, $user->password)) {
                            $response = [
                                'status' => 0,
                                'message' => trans('admin.Current Password Is Not Correct'),
                                'data' => []
                            ];
                            return response()->json($response, 422);
                        } else {
                            $update = DB::table('users')->where('id', '=', $request->user_id)->update([
                                'name'                          => $request->name,
                                'email'                         => $request->email,
                                'phone'                         => $request->phone,
                                'password'                      => Hash::make($request->new_password),
                                'birth_of_date'                 => $request->date_of_birth,
                                'gender'                        => $request->gender,
                                'country_id'                    => $request->country,
                                'city_id'                       => $request->city,
                                'nationality_id'                => $request->nationality,
                                // 'national_identity'             => $request->national_identity,
                                // 'service_id'                    => $request->service_id,
                                'price'                         => $request->price,
                                'description'                   => $request->description
                            ]);
                        }
                    } else {
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update([
                            'name'                          => $request->name,
                            'email'                         => $request->email,
                            'phone'                         => $request->phone,
                            'birth_of_date'                 => $request->date_of_birth,
                            'gender'                        => $request->gender,
                            'country_id'                    => $request->country,
                            'city_id'                       => $request->city,
                            'nationality_id'                => $request->nationality,
                            // 'national_identity'             => $request->national_identity,
                            // 'service_id'                    => $request->service_id,
                            'price'                         => $request->price,
                            'description'                   => $request->description
                        ]);
                    }
    
                    if($request->option){
                        foreach($request->option as $opt){
                            $option = DB::table('options')->insertGetId(['user_id' => $request->user_id]);
                            for ($i = 0; $i <= 1; $i++){
                                $description = DB::table('option_description')->insert([
                                    'option_title' => $opt['option_title'],
                                    'option_value' => $opt['option_value'],
                                    'language_id' => $i+1,
                                    'option_id' => $option
                                ]);
                            }
                        }
                    }
    
                    $userUpdated = DB::table('users')
                        ->where('id', '=', $request->user_id)
                        ->select('id', 'name', 'phone', 'email', 'image', 'gender', 
                        'birth_of_date', 'country_id', 'city_id', 'nationality_id', 'national_identity',
                        'front_national_identity_image', 'back_national_identity_image', 'service_id',
                        'attach_field_image', 'price', 'description', 'type')
                        ->first();
    
                    $country_name = DB::table('country_description')
                        ->where('country_id', '=', $userUpdated->country_id)
                        ->where('language_id', '=', $request->language_id)
                        ->select('country_name')
                        ->first();
                        // dd($country_name->country_name);
                    $userUpdated->country_name = $country_name->country_name;
    
                    $city_name = DB::table('city_description')
                        ->where('city_id', '=', $userUpdated->city_id)
                        ->where('language_id', '=', $request->language_id)
                        ->select('city_name')
                        ->first();
                    $userUpdated->city_name = $city_name->city_name;
    
                    $nationality_name = DB::table('nationality_description')
                        ->where('nationality_id', '=', $userUpdated->nationality_id)
                        ->where('language_id', '=', $request->language_id)
                        ->select('nationality_name')
                        ->first();
                    $userUpdated->nationality_name = $nationality_name->nationality_name;
    
                    $options = DB::table('options')
                        ->join('option_description', 'option_description.option_id', '=', 'options.option_id')
                        ->where('language_id', '=', $request->language_id)
                        ->where('user_id', '=', $request->user_id)
                        ->select('options.option_id', 'option_title', 'option_value')
                        ->get();
                    $userUpdated->options = $options;
    
                    $response = [
                        'status' => 1,
                        'message' => trans('admin.update successfully'),
                        'data' => $userUpdated
                    ];
                    return response()->json($response, 200);
                }
            } else {
                if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || !preg_match("/[\p{Arabic}A-Za-z]/u", $request->name)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.name must contain only characters'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif($request->gender == null) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.select gender'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/[0-9]/u", $request->phone)) {
                    
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.number phone must contain only numbers'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                    
                } else {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.your email is not correct'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                }
            }
        } else {
            $validator= validator()->make($request->all(),[
                'user_id' => 'required',
                'name' => 'required|max:100',
                'email' => 'required|email|max:200',
                'phone' => 'required',
                'password' => 'nullable|min:6',
                'new_password' => 'required_with:password|min:6',
                // 'date_of_birth' => 'required|date',
                // 'gender' => 'required|in:male,female',
                'country' => 'required',
                'city' => 'required',
                'image' => 'nullable',
                'company_location' => 'required',
                // 'commercial_registration_no_image' => 'nullable',
                // 'contact_name' => 'required',
                // 'contact_email' => 'required',
                // 'contact_phone' => 'required',
            ]);
    
            if ($validator->fails()){
    
                $response = [
                    'status' => 0,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ];
                return response()->json($response, 422);
    
            }
    
            if (filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
            && preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+[a-z]{1}$/", strtolower($request->email)) 
            && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name) 
            && preg_match("/[0-9]/u", $request->phone)) {
                $user = DB::table('users')->where('id', '=', $request->user_id)->select('image', 'password')->first();
                $allPhone = DB::table('users')->where('phone', $request->phone)->where('id', '!=', $request->user_id)->count();
                $allEmail = DB::table('users')->where('email', $request->email)->where('id', '!=', $request->user_id)->count();
                // dd($checkPassword);
                
                if ($allPhone > 0 || $allEmail > 0) {
                    if ($allPhone > 0){
                        $response = [
                            'status' => 0,
                            'message' => trans('admin.This phone has been taken before'),
                            'data' => []
                        ];
                        return response()->json($response, 422);
                    } elseif($allEmail > 0) {
                        $response = [
                            'status' => 0,
                            'message' => trans('admin.This email has been taken before'),
                            'data' => []
                        ];
                        return response()->json($response, 422);
                    }
                } else {
                    if($request->new_password != null){
                        if(!preg_match("/^(?=.*?[a-zA-Z])(?=\S*[A-Z])(?=.*?[0-9])(?=.*[@$!%*#?&])/", $request->new_password)){
                            $response = [
                                'status' => 0,
                                'message' => trans('admin.New Password must contain letters, numbers and symbols'),
                                'data' => []
                            ];
                            return response()->json($response, 422);
                        }
                    }
    
                    if(!empty($request->image)){
                        $image = substr($request->image, strpos($request->image, ",") + 1);
                        $img = base64_decode($image);
                        $dir="images/user/company";
                        // if (!file_exists($dir) and !is_dir($dir)) {
                        //     File::makeDirectory(base_path().'/'.$dir);
                        // }
                        $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                        file_put_contents(base_path().'/'.$uploadfile, $img);
                        $imageName=$uploadfile;
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update(['image'    =>  $imageName]);
                    }
    
                    // if(!empty($request->commercial_registration_no_image)){
                    //     $image = substr($request->commercial_registration_no_image, strpos($request->commercial_registration_no_image, ",") + 1);
                    //     $img = base64_decode($image);
                    //     $dir="images/user/company/registration";
                    //     // if (!file_exists($dir) and !is_dir($dir)) {
                    //     //     // mkdir($dir,0777,true);
                    //     //     File::makeDirectory(base_path().'/'.$dir,0777,true);
                    //     // }
                    //     $uploadfile = $dir."/pic_".Str::random(60).".jpg";
                    //     file_put_contents(base_path().'/'.$uploadfile, $img);
                    //     $commercial_registration_no_image=$uploadfile;
                    //     $update = DB::table('users')->where('id', '=', $request->user_id)->update(['commercial_registration_no_image'    =>  $commercial_registration_no_image]);
                    // }
                    
                    if($request->password != null){
                        if (!Hash::check($request->password, $user->password)) {
                            $response = [
                                'status' => 0,
                                'message' => trans('admin.Current Password Is Not Correct'),
                                'data' => []
                            ];
                            return response()->json($response, 422);
                        } else {
                            $update = DB::table('users')->where('id', '=', $request->user_id)->update([
                                'name'                              => $request->name,
                                'email'                             => $request->email,
                                'phone'                             => $request->phone,
                                'password'                          => Hash::make($request->new_password),
                                // 'birth_of_date'                     => $request->date_of_birth,
                                // 'gender'                            => $request->gender,
                                'country_id'                        => $request->country,
                                'city_id'                           => $request->city,
                                'company_location'                  => $request->company_location,
                                // 'contact_name'                      => $request->contact_name,
                                // 'contact_email'                     => $request->contact_email,
                                // 'contact_phone'                     => $request->contact_phone,
                            ]);
                        }
                    } else {
                        $update = DB::table('users')->where('id', '=', $request->user_id)->update([
                            'name'                              => $request->name,
                            'email'                             => $request->email,
                            'phone'                             => $request->phone,
                            // 'birth_of_date'                     => $request->date_of_birth,
                            // 'gender'                            => $request->gender,
                            'country_id'                        => $request->country,
                            'city_id'                           => $request->city,
                            'company_location'                  => $request->company_location,
                            // 'contact_name'                      => $request->contact_name,
                            // 'contact_email'                     => $request->contact_email,
                            // 'contact_phone'                     => $request->contact_phone,
                        ]);
                    }
                    $userUpdated = DB::table('users')
                        ->where('id', '=', $request->user_id)
                        ->select('id', 'name', 'phone', 'email', 'image', 'gender', 
                        'birth_of_date', 'country_id', 'city_id', 'company_location', 'commercial_registration_no_image',
                        'contact_name', 'contact_email', 'contact_phone', 'type')
                        ->first();
                    $response = [
                        'status' => 1,
                        'message' => trans('admin.update successfully'),
                        'data' => $userUpdated
                    ];
                    return response()->json($response, 200);
                }
            } else {
                if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || !preg_match("/[\p{Arabic}A-Za-z]/u", $request->name)) {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.name must contain only characters'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                } elseif(!preg_match("/[0-9]/u", $request->phone)) {
                    
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.number phone must contain only numbers'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                    
                } else {
                    $response = [
                        'status' => 0,
                        'message' => trans('admin.your email is not correct'),
                        'data' => []
                    ];
                    return response()->json($response, 422);
                }
            }
        }
        
        
    }

    public function userLogOut(Request $request){
	    
        DB::table('users')->where('id', $request->user_id)->update(['token' => null]);
    	$responseData = array('status'=>1, 'data'=>array(), 'message'=>trans('admin.success'));
    		
    	return response()->json($responseData);
    }

    public function setLangUser(Request $request){
	    
        DB::table('users')->where('id', $request->user_id)->update(['default_language' => $request->language_id]);
    	$responseData = array('status'=>1, 'data'=>array(), 'message'=>trans('admin.success'));
    		
    	return response()->json($responseData);
    }

    public function deleteOption(Request $request) {
        $validator = validator()->make($request->all(),[
            'option_id' => 'required|exists:options,option_id',
        ]);

        if ($validator->fails()){

            $response = [
                'status' => 1,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }

        $deleteOption = DB::table('options')->where('option_id', '=', $request->option_id)->delete();
        $deleteDescription = DB::table('option_description')->where('option_id', '=', $request->option_id)->delete();

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => []
        ];
        return response()->json($response, 204);

    }

}
