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

class UserFlowTripController extends Controller
{
    public function __construct(Request $request){
        languageApi($request->language_id);
    }

    public function categories(Request $request) {

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

        $categories = DB::table('categories')
            ->join('category_description', 'category_description.category_id', '=', 'categories.category_id')
            ->where('language_id', '=', $request->language_id)
            ->select('categories.category_id', 'category_image', 'category_name', 'category_description')
            ->get();
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $categories
        ];
        return response()->json($response, 200);
    }

    public function addTrip(Request $request) {

        $validator = validator()->make($request->all(),[
            'trip_images' => 'required|array',
            'trip_title' => 'required',
            'trip_description' => 'required',
            'category_id' => 'required',
            'trip_price' => 'required',
            'trip_discount' => 'nullable',
            'trip_date' => 'required',
            'trip_time_from' => 'required',
            'trip_time_to' => 'required',
            'trip_child_percent' => 'nullable',
            'information' => 'required',
            // 'information_value' => 'required|array',
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
        // // dd($request->information[0]['information_title'][0]);
        // foreach($request->information as $information){
        //     // dd($information['information_title'][0]);
        //     for ($i = 0; $i <= 1; $i++){
        //         dd($information['information_value'][$i]);
        //     }
        // }

        $trip = DB::table('trips')->insertGetId([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'trip_price' => $request->trip_price,
            'trip_discount' => $request->trip_discount,
            'trip_date' => $request->trip_date,
            'trip_time_from' => $request->trip_time_from,
            'trip_time_to' => $request->trip_time_to,
            'trip_child_percent' => $request->trip_child_percent,
        ]);
        for ($i = 0; $i <= 1; $i++){
            $trip_description = DB::table('trip_description')->insert([
                'trip_title' => $request->trip_title,
                'trip_description' => $request->trip_description,
                'trip_id' => $trip,
                'language_id' => $i+1
            ]);
        }

        if ($request->trip_images) {
            $images = $request->trip_images;
            if(!array_filter($images) == []){
                $x = 1;
                foreach ($images as  $key => $value) {
                    $image = substr($value['image'], strpos($value['image'], ",") + 1);
                    $img = base64_decode($image);
                    $dir="images/trips";
                    // if (!file_exists($dir) and !is_dir($dir)) {
                    //     File::makeDirectory(base_path().'/'.$dir,0777,true);
                    // }
                    $uploadfile = $dir."/trip_".Str::random(60).".jpg";
                    file_put_contents(base_path().'/'.$uploadfile, $img);
                    $trip_images = $uploadfile;
                    $insertImage = DB::table('trip_image')
                        ->insert([
                            'trip_image' => $trip_images,
                            'trip_id' => $trip
                        ]);
                    $x++;
                }
            }
        }

        foreach($request->information as $information){
            $insertInformation = DB::table('trip_information')
                ->insertGetId([
                    'trip_id' => $trip
                ]);
            // $index = 0;
            for ($i = 0; $i <= 1; $i++){
                $description = DB::table('trip_information_description')
                ->insert([
                    'trip_information_title' => $information['information_title'],
                    'trip_information_value' => $information['information_value'],
                    'language_id' => $i+1,
                    'trip_information_id' => $insertInformation
                ]);
            }
            // $index++;
        }
        

        // for ($i = 0; $i <= 1; $i++){
            
        // }
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => []
        ];
        return response()->json($response, 201);
    }

    public function myBooks(Request $request) {

        $validator = validator()->make($request->all(),[
            'user_id' => 'required',
            'type' => 'required',
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

        if($request->type == 1){
            $books = DB::table('books')
                ->where('guide_id', '=', $request->user_id)
                ->where('book_type', '=', 1)
                ->where('book_status', '=', 1)
                ->select('book_id', 'user_id', 'user_name', 'book_date', 'book_type')
                ->get();
        } elseif($request->type == 2) {
            $books = DB::table('books')
                ->join('trips', 'trips.trip_id', '=', 'books.trip_id')
                ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
                ->where('trips.user_id', '=', $request->user_id)
                ->where('book_type', '=', 2)
                ->where('book_status', '=', 1)
                ->where('language_id', '=', $request->language_id)
                ->groupBy('books.trip_id', 'book_id', 'trip_description.trip_title')
                ->select('book_id', 'books.trip_id', 'trip_description.trip_title')
                ->get();
            foreach($books as $book){
                $people = DB::table('books')->where('trip_id', '=', $book->trip_id)->count();
                $book->people = $people;
            }
        }
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $books
        ];
        return response()->json($response, 200);
    }

    public function bookDetails(Request $request) {

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

        if($request->book_type == 1){
            $detail = DB::table('books')
                ->where('book_id', '=', $request->book_id)
                ->where('guide_id', '=', $request->user_id)
                ->where('book_type', '=', 1)
                ->select('book_id', 'user_id', 'user_name', 'user_phone', 'user_gender', 'user_country_id',
                 'user_city_id', 'book_date', 'book_time', 'book_note')
                ->first();
            $country_name = DB::table('country_description')
                ->where('country_id', '=', $detail->user_country_id)
                ->where('language_id', '=', $request->language_id)
                ->select('country_name')
                ->first();
            $detail->country_name = $country_name->country_name;
            $city_name = DB::table('city_description')
                ->where('city_id', '=', $detail->user_city_id)
                ->where('language_id', '=', $request->language_id)
                ->select('city_name')
                ->first();
            $detail->city_name = $city_name->city_name;
        } elseif($request->book_type == 2) {
            $detail = DB::table('books')
                ->where('book_id', '=', $request->book_id)
                ->join('trips', 'trips.trip_id', '=', 'books.trip_id')
                ->where('trips.user_id', '=', $request->user_id)
                ->where('book_type', '=', 2)
                ->select('book_id', 'books.user_id', 'user_name', 'user_phone', 'user_gender', 'user_country_id',
                 'user_city_id', 'book_date', 'book_time', 'book_note', 'no_of_adult', 'no_of_child')
                ->first();
            $country_name = DB::table('country_description')
                ->where('country_id', '=', $detail->user_country_id)
                ->where('language_id', '=', $request->language_id)
                ->select('country_name')
                ->first();
            $detail->country_name = $country_name->country_name;
            $city_name = DB::table('city_description')
                ->where('city_id', '=', $detail->user_city_id)
                ->where('language_id', '=', $request->language_id)
                ->select('city_name')
                ->first();
            $detail->city_name = $city_name->city_name;
        } 
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $detail
        ];
        return response()->json($response, 200);
    }

    public function userBookedTrip(Request $request) {

        $validator = validator()->make($request->all(),[
            'user_id' => 'required',
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

        $trips = DB::table('books')
            ->join('trips', 'trips.trip_id', '=', 'books.trip_id')
            ->where('trips.user_id', '=', $request->user_id)
            ->where('trips.trip_id', '=', $request->trip_id)
            ->where('book_type', '=', 2)
            ->where('book_status', '=', 1)
            ->select('book_id', 'books.user_id', 'user_name', 'book_date', 'book_type')
            ->get();
        
        $response = [
            'status' => 1,
            'message' => trans('admin.Success'),
            'data' => $trips
        ];
        return response()->json($response, 200);
    }

    public function AcceptRejectBook(Request $request) {
        $validator = validator()->make($request->all(), [
            'book_id' => 'required',
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
        
        
        $findOrder = DB::table('books')
            ->where('book_id', '=', $request->book_id)
            ->where('book_status', 1)
            ->count();
        if($findOrder > 0){
            $cancel = DB::table('books')
                ->where('book_id', '=', $request->book_id)
                ->update(['book_status' => $request->status]);
            
            $history = DB::table('history_status')
                ->insert([
                    'book_id' => $request->book_id,
                    'status_id' => $request->status,
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
    
    public function startEndTrip(Request $request) {
        $validator = validator()->make($request->all(), [
            'trip_id' => 'required',
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
        
        
        $trips = DB::table('trips')
            ->where('trip_id', '=', $request->trip_id)
            ->count();
        if($trips > 0){
            $status = DB::table('book_trip_status')
                ->insert([
                    'trip_id' => $request->trip_id,
                    'status' => $request->status,
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
