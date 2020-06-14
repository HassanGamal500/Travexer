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

class AppController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function banners(Request $request){
        $validator= validator()->make($request->all(),[
            'language_id' => 'required',
        ]);
        
        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }

        $banners = DB::table('banners')->where('status', '=', 1)->select('banner_id', 'banner_image')->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $banners
        ];
    
        return response()->json($response, 200);
    }

    public function listOfCountries(Request $request){
        $validator= validator()->make($request->all(),[
            'language_id' => 'required',
        ]);
        
        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);

        }

        $countries = DB::table('countries')
            ->join('country_description', 'country_description.country_id', '=', 'countries.country_id')
            ->where('status', '=', 1)
            ->where('language_id', '=', $request->language_id)
            ->select('countries.country_id', 'country_name')
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $countries
        ];
    
        return response()->json($response, 200);
    }

    public function listOfCities(Request $request){
        $validator= validator()->make($request->all(),[
            'country_id' => 'required',
            'language_id' => 'required',
        ]);
        
        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);

        }

        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('status', '=', 1)
            ->where('country_id', '=', $request->country_id)
            ->where('language_id', '=', $request->language_id)
            ->select('cities.city_id', 'city_name')
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $cities
        ];
    
        return response()->json($response, 200);
    }

    public function listOfServices(Request $request){
        $validator= validator()->make($request->all(),[
            'language_id' => 'required',
        ]);
        
        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);

        }

        $services = DB::table('services')
            ->join('service_description', 'service_description.service_id', '=', 'services.service_id')
            ->where('status', '=', 1)
            ->where('language_id', '=', $request->language_id)
            ->select('services.service_id', 'service_name')
            ->get();
            
        if($request->language_id == 1){
            $otherLang = 'Other';
        } else {
            $otherLang = 'اخرى';
        }
        
//         $index = 0;
//         $result = array();
// 		foreach($services as $service){
// 			array_push($result, $service);
// 			$index++;
// 		}
        $other = array('service_id' => 0, 'service_name' => $otherLang);
        $services[] = $other;

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $services
        ];
    
        return response()->json($response, 200);
    }

    public function page(Request $request) {
        $validator = validator()->make($request->all(), [
            'page_id' => 'required',
            'language_id' => 'required'
        ]);
        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);

        }
        $page = DB::table('pages')
            ->join('page_description', 'page_description.page_id', '=', 'pages.page_id')
            ->select('pages.page_id', 'page_description_name', 'page_description_content', 'language_id')
            ->where('pages.page_id', '=', $request->page_id)
            ->where('language_id', '=', $request->language_id)
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $page
        ];

        return response()->json($response, 200);
    }

    public function contactUs(Request $request){
        $validator= validator()->make($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'subject' => 'required|max:80',
            'message' => 'required'

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
        && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email)) 
        && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) 
        && !preg_match("/[0-9]/u", $request->name)
        && preg_match("/[0-9]/u", $request->phone)) {

            $name           =   $request->name;
            $phone          =   $request->phone;
            $email          =   $request->email;
            $message        =   $request->message;
            $subject        =   $request->subject;

            $id = DB::table('contacts')->insertGetId([
                'contact_name' => $name,
                'contact_email' => $email,
                'contact_phone' => $phone,
                'contact_message' => $message,
                'contact_subject'=>$subject,
                'contact_from' => 0
            ]);

            $response = [
                'status' => 1,
                'message' => trans('admin.Success'),
                'data' => []
            ];

            return response()->json($response, 201);
            
        } else {
            if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || preg_match("/[0-9]/u", $request->name)) {
                // $error = trans('admin.this name must contain only characters');
                $response = [
                    'status' => 0,
                    'message' => trans('labels.this name must contain only characters'),
                    'data' => []
                ];
                return response()->json($response, 422);
            } elseif(!preg_match("/[0-9]/u", $request->phone)) {
                
                $response = [
                    'status' => 0,
                    'message' => trans('labels.number phone must contain only numbers'),
                    'data' => []
                ];
                return response()->json($response, 422);
                
            }else {
                // $error = trans('admin.your email is not correct');
                $response = [
                    'status' => 0,
                    'message' => trans('labels.your email is not correct'),
                    'data' => []
                ];
                return response()->json($response, 422);
            }
        }
    }

    public function notifications(Request $request){
        $validator = validator()->make($request->all(), [
            'user_id' => 'required',
            'language_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }

        $array = array();
        $notifications = DB::table('notifications')
            ->join('notification_description', 'notification_description.notification_id', '=', 'notifications.notification_id')
            ->where('user_id', '=', $request->user_id)
            ->where('language_id', '=', $request->language_id)
            ->orwhere('user_id', '=', 0)
            ->select('notification_description.notification_name','notification_description.notification_content', 'notification_image', 'is_seen', 'notifications.created_at')
            ->orderBy('notifications.notification_id', 'desc')
            ->get();
            
        $seen = DB::table('notifications')
            ->where('user_id', '=', $request->user_id)
            ->update(['is_seen' => 1]);

        if (!empty($notifications)){
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $notifications
            ];
        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
        }

        return response()->json($response, 200);
    }
    
    public function listOfNationalities(Request $request){
        $validator= validator()->make($request->all(),[
            'language_id' => 'required',
        ]);
        
        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);

        }

        $nationalities = DB::table('nationalities')
            ->join('nationality_description', 'nationality_description.nationality_id', '=', 'nationalities.nationality_id')
            ->where('status', '=', 1)
            ->where('language_id', '=', $request->language_id)
            ->select('nationalities.nationality_id', 'nationality_name')
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $nationalities
        ];
    
        return response()->json($response, 200);
    }

    public function aboutUs(Request $request) {
        $validator = validator()->make($request->all(), [
            'language_id' => 'required'
        ]);
        if ($validator->fails()){

            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);

        }
        $about = DB::table('about_us')
            ->join('about_us_description', 'about_us_description.about_us_id', '=', 'about_us.about_us_id')
            ->select('about_us.about_us_id', 'about_description as description', 'about_mission as mission',
            'about_vission as vission', 'about_values as values', 'language_id')
            ->where('about_us.about_us_id', '=', 1)
            ->where('language_id', '=', $request->language_id)
            ->get();

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $about
        ];

        return response()->json($response, 200);
    }

    public function subscribe(Request $request){
        $validator= validator()->make($request->all(),[
            'email' => 'required|email'
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
        && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email))) {

            $email = $request->email;

            $subscribes = DB::table('subscribes')->insertGetId([
                'subscribe_email' => $email,
            ]);

            $response = [
                'status' => 1,
                'message' => trans('admin.Success'),
                'data' => []
            ];

            return response()->json($response, 200);
            
        } else {
            $response = [
                'status' => 0,
                'message' => trans('labels.your email is not correct'),
                'data' => []
            ];
            return response()->json($response, 422);
        }
    }

    public function homeWeb(Request $request){
        $validator= validator()->make($request->all(),[
            'language_id' => 'required',
        ]);
        
        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => []
            ];
            return response()->json($response, 422);
        }

        $result = array();

        $banners = DB::table('banners')->where('status', '=', 1)->select('banner_id', 'banner_image')->get();

        $screens = DB::table('screen_shots')->where('status', '=', 1)->select('screen_shot_id', 'screen_image')->get();

        $result['banners'] = $banners;
        $result['screen_shot'] = $screens;

        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $result
        ];
    
        return response()->json($response, 200);
    }

}
