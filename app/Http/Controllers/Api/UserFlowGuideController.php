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

class UserFlowGuideController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function allGuides(Request $request) {

        $validator = validator()->make($request->all(),[
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

        $guides = DB::table('users')->where('type', '=', 2)->select('id', 'image', 'name')->get();
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $guides
        ];
        return response()->json($response, 200);
    }

    public function guideDetails(Request $request) {

        $validator = validator()->make($request->all(),[
            'guide_id' => 'required',
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

        $guides = DB::table('users')->where('type', '=', 2)->where('id', '=', $request->guide_id)
            ->select('id', 'image', 'name', 'price', 'description', 'attach_field_image')
            ->first();

        // foreach($guides as $guide){
            $numOfTrips = DB::table('trips')->where('user_id', '=', $guides->id)->count();
            $guides->numOfTrips = $numOfTrips;
            $avgRates = DB::table('rates')->where('type', '=', 1)->where('type_id', '=', $guides->id)->avg('rate_star');
            $guides->avgRates = $avgRates;
            $numOfComments = DB::table('rates')->where('type', '=', 1)->where('type_id', '=', $guides->id)->count();
            $guides->numOfComments = $numOfComments;
            $images = DB::table('trips')
                ->where('user_id', '=', $guides->id)
                ->join('trip_image', 'trip_image.trip_id', '=', 'trips.trip_id')
                ->select('trip_image')
                ->get();
            $guides->images = $images;
        // };
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $guides
        ];
        return response()->json($response, 200);
    }

    public function filterGuides(Request $request) {

        $validator = validator()->make($request->all(),[
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
        // dd(isset($request->service_id));

        if($request->date 
        && isset($request->service_id) == false
        && isset($request->nationality_id) == false 
        && isset($request->country_id) == false 
        && isset($request->city_id) == false){
            $guides = DB::table('users')->where('type', '=', 2)
                ->whereDate('created_at', $request->date)
                ->select('id', 'image', 'name')
                ->get();
        } elseif($request->service_id 
        && isset($request->date) == false
        && isset($request->nationality_id) == false
        && isset($request->country_id) == false
        && isset($request->city_id) == false){
            $guides = DB::table('users')->where('type', '=', 2)
                ->where('service_id', '=', $request->service_id)
                ->select('id', 'image', 'name')
                ->get();
        } elseif($request->nationality_id 
        && isset($request->service_id) == false
        && isset($request->date) == false
        && isset($request->country_id) == false
        && isset($request->city_id) == false){
            $guides = DB::table('users')->where('type', '=', 2)
                ->where('nationality_id', '=', $request->nationality_id)
                ->select('id', 'image', 'name')
                ->get();
        } elseif($request->nationality_id 
        && $request->service_id 
        && isset($request->date) == false
        && isset($request->country_id) == false
        && isset($request->city_id) == false){
            $guides = DB::table('users')->where('type', '=', 2)
                ->where('nationality_id', '=', $request->nationality_id)
                ->where('service_id', '=', $request->service_id)
                ->select('id', 'image', 'name')
                ->get();
        } elseif($request->date && $request->service_id 
        && isset($request->country_id) == false
        && isset($request->city_id) == false
        && isset($request->nationality_id) == false){
            $guides = DB::table('users')->where('type', '=', 2)
                ->whereDate('created_at', $request->date)
                ->where('service_id', '=', $request->service_id)
                ->select('id', 'image', 'name')
                ->get();
        // } elseif($request->country_id){
        //     $guides = DB::table('users')->where('type', '=', 2)
        //         ->where('country_id', '=', $request->country_id)
        //         ->select('id', 'image', 'name')
        //         ->get();
        } elseif($request->country_id && $request->city_id 
        && isset($request->date) == false
        && isset($request->service_id) == false
        && isset($request->nationality_id) == false){
            $guides = DB::table('users')->where('type', '=', 2)
                ->where('country_id', '=', $request->country_id)
                ->where('city_id', '=', $request->city_id)
                ->select('id', 'image', 'name')
                ->get();
        // } elseif($request->date && $request->service_id && $request->country_id){
        //     $guides = DB::table('users')->where('type', '=', 2)
        //         ->whereDate('created_at', $request->date)
        //         ->where('service_id', '=', $request->service_id)
        //         ->where('country_id', '=', $request->country_id)
        //         ->select('id', 'image', 'name')
        //         ->get();
        } elseif($request->date && $request->service_id && $request->country_id && $request->city_id 
        && isset($request->nationality_id) == false){
            $guides = DB::table('users')->where('type', '=', 2)
                ->whereDate('created_at', $request->date)
                ->where('service_id', '=', $request->service_id)
                ->where('country_id', '=', $request->country_id)
                ->where('city_id', '=', $request->city_id)
                ->select('id', 'image', 'name')
                ->get();
        } elseif($request->date && $request->service_id && $request->country_id && $request->city_id && $request->nationality_id){
            $guides = DB::table('users')->where('type', '=', 2)
                ->whereDate('created_at', $request->date)
                ->where('service_id', '=', $request->service_id)
                ->where('country_id', '=', $request->country_id)
                ->where('city_id', '=', $request->city_id)
                ->where('nationality_id', '=', $request->nationality_id)
                ->select('id', 'image', 'name')
                ->get();
        } else {
            $guides = DB::table('users')->where('type', '=', 2)->select('id', 'image', 'name')->get();
        }

        // $guides = DB::table('users')->where('type', '=', 2)->select('id', 'image', 'name')->get();
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $guides
        ];
        return response()->json($response, 200);
    }

    public function bookGuideNow(Request $request) {

        $validator = validator()->make($request->all(),[
            'user_id' => 'required',
            'guide_id' => 'required',
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

        $date = date('Y-m-d');
        $time = date('H:i:s');

        $user = DB::table('users')
            ->where('id', '=', $request->user_id)
            ->where('type', '=', 1)
            ->select('id', 'name', 'email', 'phone', 'country_id', 'city_id')
            ->first();

        $guide = DB::table('users')
            ->where('id', '=', $request->guide_id)
            ->where('type', '=', 2)
            ->select('id', 'name', 'email', 'phone', 'price')
            ->first();

        $book = DB::table('books')->insertGetId([
            'user_id' => $request->user_id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'user_country_id' => $user->country_id,
            'user_city_id' => $user->city_id,
            'guide_id' => $request->guide_id,
            'guide_name' => $guide->name,
            'guide_email' => $guide->email,
            'guide_phone' => $guide->phone,
            'guide_price' => $guide->price,
            'book_type' => 1,
            'book_date' => $date,
            'book_time' => $time,
            'book_note' => $request->book_note,
            'book_status' => 1
        ]);

        $history = DB::table('history_status')
            ->insert([
                'book_id' => $book,
                'status_id' => 1,
                'created_at' => get_local_time($request->getClientIp())
            ]);
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $book
        ];
        return response()->json($response, 201);
    }

    public function bookGuideLater(Request $request) {

        $validator = validator()->make($request->all(),[
            'user_id' => 'required',
            'guide_id' => 'required',
            'book_date' => 'required',
            'book_time' => 'required',
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

        $user = DB::table('users')
            ->where('id', '=', $request->user_id)
            ->where('type', '=', 1)
            ->select('id', 'name', 'email', 'phone', 'country_id', 'city_id')
            ->first();

        $guide = DB::table('users')
            ->where('id', '=', $request->guide_id)
            ->where('type', '=', 2)
            ->select('id', 'name', 'email', 'phone', 'price')
            ->first();

        $book = DB::table('books')->insert([
            'user_id' => $request->user_id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'user_country_id' => $user->country_id,
            'user_city_id' => $user->city_id,
            'guide_id' => $request->guide_id,
            'guide_name' => $guide->name,
            'guide_email' => $guide->email,
            'guide_phone' => $guide->phone,
            'guide_price' => $guide->price,
            'book_type' => 1,
            'book_date' => $request->book_date,
            'book_time' => $request->book_time,
            'book_note' => $request->book_note,
            'book_status' => 1
        ]);

        
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $book
        ];
        return response()->json($response, 201);
    }

    public function bookTripNow(Request $request) {

        $validator = validator()->make($request->all(),[
            'user_id' => 'required',
            'trip_id' => 'required',
            'no_of_adult' => 'required',
            'no_of_child' => 'required',
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

        $date = date('Y-m-d');
        $time = date('H:i:s');

        $user = DB::table('users')
            ->where('id', '=', $request->user_id)
            ->where('type', '=', 1)
            ->select('id', 'name', 'email', 'phone', 'country_id', 'city_id')
            ->first();

        $trip = DB::table('trips')
            ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
            ->where('trips.trip_id', '=', $request->trip_id)
            ->where('language_id', '=', $request->language_id)
            ->select('trips.trip_id', 'category_id', 'trip_price', 'trip_discount', 'trip_date',
             'trip_time_from', 'trip_time_to', 'trip_child_percent', 'trip_title', 'trip_description')
            ->first();

        $book = DB::table('books')->insertGetId([
            'user_id' => $request->user_id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'user_country_id' => $user->country_id,
            'user_city_id' => $user->city_id,
            'trip_id' => $request->trip_id,
            'trip_category_id' => $trip->category_id,
            'trip_title' => $trip->trip_title,
            'trip_description' => $trip->trip_description,
            'trip_price' => $trip->trip_price,
            'trip_discount' => $trip->trip_discount,
            'trip_date' => $trip->trip_date,
            'trip_time_from' => $trip->trip_time_from,
            'trip_time_to' => $trip->trip_time_to,
            'trip_child_percent' => $trip->trip_child_percent,
            'no_of_adult' => $request->no_of_adult,
            'no_of_child' => $request->no_of_child,
            'book_type' => 2,
            'book_date' => $request->date,
            'book_time' => $request->time,
            // 'book_note' => $request->book_note,
            'book_status' => 1
        ]);

        $history = DB::table('history_status')
            ->insert([
                'book_id' => $book,
                'status_id' => 1,
                'created_at' => get_local_time($request->getClientIp())
            ]);
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => []
        ];
        return response()->json($response, 201);
    }

    public function myOrderStatus(Request $request) {

        $validator = validator()->make($request->all(),[
            'user_id' => 'required',
            'date_status' => 'required',
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

        $date = date('Y-m-d');

        if($request->date_status == 1){
            $ordersGuides = DB::table('books')
                ->where('user_id', '=', $request->user_id)
                ->where('book_type', '=', 1)
                ->whereDate('book_date', $date)
                ->select('book_id', 'user_id', 'book_status', 'guide_name', 'book_date', 'book_type')
                ->get();
        } elseif($request->date_status == 2) {
            $ordersGuides = DB::table('books')
                ->where('user_id', '=', $request->user_id)
                ->where('book_type', '=', 1)
                ->whereDate('book_date', '>', $date)
                ->select('book_id', 'user_id', 'book_status', 'guide_name', 'book_date', 'book_type')
                ->get();
        } elseif($request->date_status == 3) {
            $ordersGuides = DB::table('books')
                ->where('user_id', '=', $request->user_id)
                ->where('book_type', '=', 1)
                ->whereDate('book_date', '<', $date)
                ->select('book_id', 'user_id', 'book_status', 'guide_name', 'book_date', 'book_type')
                ->get();
        }
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $ordersGuides
        ];
        return response()->json($response, 200);
    }

    public function orderDetails(Request $request) {

        $validator = validator()->make($request->all(),[
            'user_id' => 'required',
            'book_id' => 'required',
            'book_type' => 'required',
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

        $date = date('Y-m-d');

        if($request->book_type == 1){
            $detail = DB::table('books')
                ->where('book_id', '=', $request->book_id)
                ->where('user_id', '=', $request->user_id)
                ->where('book_type', '=', 1)
                ->select('book_id', 'user_id', 'book_status', 'guide_name', 'book_date', 'book_time', 'book_note', 'guide_price')
                ->get();
        } elseif($request->book_type == 2) {
            $detail = DB::table('books')
                ->where('book_id', '=', $request->book_id)
                ->where('user_id', '=', $request->user_id)
                ->where('book_type', '=', 2)
                ->select('book_id', 'user_id', 'book_status', 'trip_title', 'book_date', 'book_time', 'book_note', 'trip_price', 'no_of_adult', 'no_of_child')
                ->get();
        }
        
        
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $detail
        ];
        return response()->json($response, 200);
    }

    public function cancelOrder(Request $request) {
        $validator = validator()->make($request->all(), [
            'book_id' => 'required',
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
        
        
        $findOrder = DB::table('books')
            ->where('book_id', '=', $request->book_id)
            ->whereIn('book_status', [1, 2])
            ->count();
        if($findOrder > 0){
            $cancel = DB::table('books')
                ->where('book_id', '=', $request->book_id)
                ->where('user_id', '=', $request->user_id)
                ->update(['book_status' => 3]);
            
            $history = DB::table('history_status')
                ->insert([
                    'book_id' => $request->book_id,
                    'status_id' => 3,
                    'created_at' => get_local_time($request->getClientIp())
                ]);
            // $getId = DB::table('reserve_restaurant')->where('reserve_restaurant_id', '=', $request->reserve_id)->where('user_id', '=', $request->user_id)->select('restaurant_id')->first();
            // $sendNotification = new AdminsPush();
            // $getTokens = DB::table('administration')->where('type', '=', 1)->where('type_id', '=', $getId->restaurant_id)->select('token')->get();
            // foreach($getTokens as $token){
            //     $tokens[] = $token->token;
            // }
            // $sendNotification->send($tokens, trans('admin.reservation canceled'), trans('admin.the reservation is  canceled'), 'images/user/avatar_user.png', 'images/user/avatar_user.png', '/show_reserve/' . $request->reserve_id, '3');
        } else {
            $cancel = 0;
        }
            
        if($cancel){
            $response = [
                'status' => 1,
                'message' => trans('admin.Success'),
                'data' => $cancel
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

    public function giveReview(Request $request) {
        $validator = validator()->make($request->all(), [
            'star' => 'required',
            'content' => 'nullable',
            'user_id' => 'required',
            'type' => 'required',
            'type_id' => 'required',
            'book_id' => 'required'
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => (object)[]
            ];
            return response()->json($response, 422);
        }

        $rate = DB::table('rates')
            ->insert([
                'rate_star' => $request->star,
                'rate_content' => $request->content,
                'user_id' => $request->user_id,
                'type' => $request->type,
                'type_id' => $request->type_id,
                'book_id' => $request->book_id,
                'created_at' => get_local_time($request->getClientIp())
            ]);

        if($rate) {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $rate
            ];
            $code = 201;
        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
            $code = 201;
        }

        return response()->json($response, $code);
    }

    public function allReview(Request $request) {
        $validator = validator()->make($request->all(), [
            'type' => 'required',
            'type_id' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'status' => 0,
                'message' => $validator->errors()->first(),
                'data' => (object)[]
            ];
            return response()->json($response, 422);
        }

        $rates = DB::table('rates')
            ->join('users', 'users.id', '=', 'rates.user_id')
            ->where('rates.type', '=', $request->type)
            ->where('type_id', '=', $request->type_id)
            ->select('name', 'rate_star', 'rate_content')
            ->get();

        if($rates) {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => $rates
            ];
            $code = 200;
        } else {
            $response = [
                'status' => 1,
                'message' => trans('admin.success'),
                'data' => []
            ];
            $code = 200;
        }

        return response()->json($response, $code);
    }

    public function trips(Request $request) {

        $validator = validator()->make($request->all(),[
            'category_id' => 'required',
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

        $trips = DB::table('trips')
            ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
            ->where('category_id', '=', $request->category_id)
            ->where('language_id', '=', $request->language_id)
            ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
            ->get();
        foreach($trips as $trip){
            $avgRates = DB::table('rates')->where('type', '=', 2)->where('type_id', '=', $trip->trip_id)->avg('rate_star');
            $trip->avgRates = $avgRates;
            $numOfRates = DB::table('rates')->where('type', '=', 2)->where('type_id', '=', $trip->trip_id)->count();
            $trip->numOfRates = $numOfRates;
        }
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $trips
        ];
        return response()->json($response, 200);
    }

    public function tripDetails(Request $request) {

        $validator = validator()->make($request->all(),[
            'category_id' => 'required',
            'trip_id' => 'required',
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

        $trips = DB::table('trips')
            ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
            ->where('category_id', '=', $request->category_id)
            ->where('language_id', '=', $request->language_id)
            ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price', 'trip_discount', 'trip_date',
             'trip_time_from', 'trip_time_to', 'trip_child_percent', 'user_id')
            ->first();
        $avgRates = DB::table('rates')->where('type', '=', 2)->where('type_id', '=', $trips->trip_id)->avg('rate_star');
        $trips->avgRates = $avgRates;
        $numOfRates = DB::table('rates')->where('type', '=', 2)->where('type_id', '=', $trips->trip_id)->count();
        $trips->numOfRates = $numOfRates;
        $images = DB::table('trip_image')->where('trip_id', '=', $trips->trip_id)->select('trip_image')->get();
        $trips->images = $images;
        $informations = DB::table('trip_information')
            ->join('trip_information_description', 'trip_information_description.trip_information_id', '=', 'trip_information.trip_information_id')
            ->where('trip_id', '=', $trips->trip_id)
            ->where('language_id', '=', $request->language_id)
            ->select('trip_information_title', 'trip_information_value')
            ->get();
        $trips->informations = $informations;
        $organizedBy = DB::table('users')->where('id', '=', $trips->user_id)->first();
        $trips->organizedBy = $organizedBy->name;
        $countryName = DB::table('country_description')
            ->where('country_id', '=', $organizedBy->country_id)
            ->select('country_name')
            ->where('language_id', '=', $request->language_id)
            ->first();
        $trips->countryName = $countryName->country_name;
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $trips
        ];
        return response()->json($response, 200);
    }

    public function filterTrips(Request $request) {

        $validator = validator()->make($request->all(),[
            'category_id' => 'required',
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

        if($request->price_from && $request->price_to) {
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->whereBetween('trip_price', [$request->price_from, $request->price_to])
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->date){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->whereDate('trip_date', $request->date)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->service_id){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->join('users', 'users.id', '=', 'trips.user_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->where('service_id', '=', $request->service_id)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->date && $request->service_id){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->join('users', 'users.id', '=', 'trips.user_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->where('service_id', '=', $request->service_id)
                ->whereDate('trip_date', $request->date)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->country_id && $request->city_id){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->join('users', 'users.id', '=', 'trips.user_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->where('country_id', '=', $request->country_id)
                ->where('city_id', '=', $request->city_id)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->date && $request->price_from && $request->price_to){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->join('users', 'users.id', '=', 'trips.user_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->whereDate('trip_date', $request->date)
                ->whereBetween('trip_price', [$request->price_from, $request->price_to])
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->date && $request->service_id){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->join('users', 'users.id', '=', 'trips.user_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->whereDate('trip_date', $request->date)
                ->where('service_id', '=', $request->service_id)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->date && $request->service_id && $request->country_id && $request->city_id){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->join('users', 'users.id', '=', 'trips.user_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->whereDate('trip_date', $request->date)
                ->where('service_id', '=', $request->service_id)
                ->where('country_id', '=', $request->country_id)
                ->where('city_id', '=', $request->city_id)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->price_from && $request->price_to && $request->country_id && $request->city_id){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->join('users', 'users.id', '=', 'trips.user_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->whereBetween('trip_price', [$request->price_from, $request->price_to])
                ->where('country_id', '=', $request->country_id)
                ->where('city_id', '=', $request->city_id)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } elseif($request->date && $request->price_from && $request->price_to && $request->service_id && $request->country_id && $request->city_id){
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->join('users', 'users.id', '=', 'trips.user_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->whereDate('trip_date', $request->date)
                ->whereBetween('trip_price', [$request->price_from, $request->price_to])
                ->where('service_id', '=', $request->service_id)
                ->where('country_id', '=', $request->country_id)
                ->where('city_id', '=', $request->city_id)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        } else {
            $trips = DB::table('trips')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->where('category_id', '=', $request->category_id)
                ->where('language_id', '=', $request->language_id)
                ->select('trips.trip_id', 'trip_title', 'trip_description', 'trip_price')
                ->get();
        }

        foreach($trips as $trip){
            $avgRates = DB::table('rates')->where('type', '=', 2)->where('type_id', '=', $trip->trip_id)->avg('rate_star');
            $trip->avgRates = $avgRates;
            $numOfRates = DB::table('rates')->where('type', '=', 2)->where('type_id', '=', $trip->trip_id)->count();
            $trip->numOfRates = $numOfRates;
        }

        // $guides = DB::table('users')->where('type', '=', 2)->select('id', 'image', 'name')->get();
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $trips
        ];
        return response()->json($response, 200);
    }

    public function dolaneDetails(Request $request) {

        $validator = validator()->make($request->all(),[
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

        $dolane = DB::table('dolanes')->where('dolanes.dolane_id', '=', 1)
            ->join('dolane_description', 'dolane_description.dolane_id', '=', 'dolanes.dolane_id')
            ->select('dolane_phone', 'dolane_latitude', 'dolane_longitude', 'dolane_name', 'dolane_description')
            ->where('language_id', '=', $request->language_id)
            ->first();

        $images = DB::table('dolane_image')
            ->where('dolane_id', '=', 1)
            ->select('dolane_image')
            ->get();
        $dolane->images = $images;
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $dolane
        ];
        return response()->json($response, 200);
    }

    public function broadcasts(Request $request) {

        $validator = validator()->make($request->all(),[
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

        $broadcasts = DB::table('broadcasts')
            ->where('user_id', '=', $request->user_id)
            ->select('broadcast_id')
            ->get();
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $broadcasts
        ];
        return response()->json($response, 200);
    }

    public function addBroadcast(Request $request) {

        $validator = validator()->make($request->all(),[
            'user_id' => 'required',
            'broadcast_date' => 'required',
            'service_id' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'nationality_id' => 'required',
            'broadcast_stat_time' => 'required',
            'broadcast_end_time' => 'required',
            'broadcast_note' => 'required',
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

        $broadcast = DB::table('broadcasts')->insert([
            'user_id' => $request->user_id,
            'broadcast_date' => $request->broadcast_date,
            'service_id' => $request->service_id,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'nationality_id' => $request->nationality_id,
            'broadcast_stat_time' => $request->broadcast_stat_time,
            'broadcast_end_time' => $request->broadcast_end_time,
            'broadcast_note' => $request->broadcast_note,
        ]);
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $broadcast
        ];
        return response()->json($response, 201);
    }

    public function listOfRequestBroadcasts(Request $request) {

        $validator = validator()->make($request->all(),[
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

        $broadcasts = DB::table('broadcast_guides')
            ->join('broadcasts', 'broadcasts.broadcast_id', '=', 'broadcast_guides.broadcast_id')
            ->join('users', 'users.id', '=', 'broadcast_guides.guide_id')
            ->where('broadcasts.user_id', '=', $request->user_id)
            ->where('status', '=', 1)
            ->where('type', '=', 2)
            ->select('broadcast_guides.broadcast_id', 'name', 'price')
            ->get();
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $broadcasts
        ];
        return response()->json($response, 200);
    }

    public function requestBroadcast(Request $request) {
        $validator = validator()->make($request->all(), [
            'broadcast_guides_id' => 'required',
            'status' => 'required',
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
        
        
        $findOrder = DB::table('broadcast_guides')
            ->where('broadcast_guides_id', '=', $request->broadcast_guides_id)
            ->whereIn('status', [1, 2])
            ->count();

        if($findOrder > 0){
            $status = DB::table('broadcast_guides')
                ->where('broadcast_guides_id', '=', $request->broadcast_guides_id)
                ->update(['status' => $request->status]);
            
            // $history = DB::table('history_status')
            //     ->insert([
            //         'broadcast_guides_id' => $request->broadcast_guides_id,
            //         'status_id' => $request->status,
            //         'created_at' => get_local_time($request->getClientIp())
            //     ]);
            // $getId = DB::table('reserve_restaurant')->where('reserve_restaurant_id', '=', $request->reserve_id)->where('user_id', '=', $request->user_id)->select('restaurant_id')->first();
            // $sendNotification = new AdminsPush();
            // $getTokens = DB::table('administration')->where('type', '=', 1)->where('type_id', '=', $getId->restaurant_id)->select('token')->get();
            // foreach($getTokens as $token){
            //     $tokens[] = $token->token;
            // }
            // $sendNotification->send($tokens, trans('admin.reservation canceled'), trans('admin.the reservation is  canceled'), 'images/user/avatar_user.png', 'images/user/avatar_user.png', '/show_reserve/' . $request->reserve_id, '3');
        } else {
            $status = 0;
        }
            
        if($status){
            $response = [
                'status' => 1,
                'message' => trans('admin.Success'),
                'data' => $status
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

}
