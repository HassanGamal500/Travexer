<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;


class AdminOrderController extends Controller
{

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->faq_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('indexGuide', 'indexTrip', 'orderDetail', 'get_order_guide_user', 'get_order_trip_user');
    }

    public function indexGuide(){
        $orders = DB::table('books')
            ->join('country_description', 'country_description.country_id', '=', 'books.user_country_id')
            ->join('city_description', 'city_description.city_id', '=', 'books.user_city_id')
            ->select('book_id as id', 'book_date as date', 'book_time as time', 'guide_name',
            'book_note as note', 'user_name', 'country_name', 'city_name', 'book_type')
            ->where('country_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->where('book_type', '=', 1)
            ->get();
        // dd($broadcasts);
        return view('admin.order.index', compact('orders'));
    }

    public function indexTrip(){
        $orders = DB::table('books')
            ->join('country_description', 'country_description.country_id', '=', 'books.user_country_id')
            ->join('city_description', 'city_description.city_id', '=', 'books.user_city_id')
            ->select('book_id as id', 'book_date as date', 'book_time as time', 'trip_title',
            'book_note as note', 'user_name', 'country_name', 'city_name', 'book_type')
            ->where('country_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->where('book_type', '=', 2)
            ->get();
        // dd($broadcasts);
        return view('admin.order.index', compact('orders'));
    }

    public function orderDetail($id){
        $type = DB::table('books')->where('book_id', '=', $id)->select('book_type')->first();
        if($type->book_type == 1) {
            $orders = DB::table('books')
                ->join('country_description', 'country_description.country_id', '=', 'books.user_country_id')
                ->join('city_description', 'city_description.city_id', '=', 'books.user_city_id')
                ->select('book_id as id', 'book_date as date', 'book_time as time', 'guide_name', 'guide_email',
                'guide_phone', 'guide_price', 'book_note as note', 'user_name', 'user_email', 'user_phone', 'user_gender',
                'country_name', 'city_name', 'books.created_at', 'book_type')
                ->where('country_description.language_id', '=', language())
                ->where('city_description.language_id', '=', language())
                ->where('book_id', '=', $id)
                ->where('book_type', '=', 1)
                ->first();
        } else {
            $orders = DB::table('books')
                ->join('country_description', 'country_description.country_id', '=', 'books.user_country_id')
                ->join('city_description', 'city_description.city_id', '=', 'books.user_city_id')
                ->select('book_id as id', 'book_date as date', 'book_time as time', 'trip_title', 'trip_description',
                'trip_price', 'trip_discount', 'trip_date', 'trip_time_from', 'trip_time_to', 'trip_child_percent', 
                'no_of_adult', 'no_of_child', 'book_note as note', 'user_name', 'user_email', 'user_phone',
                'country_name', 'city_name', 'books.created_at', 'book_type')
                ->where('country_description.language_id', '=', language())
                ->where('city_description.language_id', '=', language())
                ->where('book_type', '=', 2)
                ->where('book_id', '=', $id)
                ->first();
        }

        // dd($orders);
        
        return view('admin.order.orderDetail', compact('orders'));
    }

    public function get_order_guide_user($id){
        $orders = DB::table('books')
            ->join('country_description', 'country_description.country_id', '=', 'books.user_country_id')
            ->join('city_description', 'city_description.city_id', '=', 'books.user_city_id')
            ->select('book_id as id', 'book_date as date', 'book_time as time', 'guide_name',
            'book_note as note', 'user_name', 'country_name', 'city_name', 'book_type')
            ->where('country_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->where('books.user_id', '=', $id)
            ->where('book_type', '=', 1)
            ->get();
        return view('admin.order.index', compact('orders'));
    }

    public function get_order_trip_user($id){
        $orders = DB::table('books')
            ->join('country_description', 'country_description.country_id', '=', 'books.user_country_id')
            ->join('city_description', 'city_description.city_id', '=', 'books.user_city_id')
            ->select('book_id as id', 'book_date as date', 'book_time as time', 'trip_title',
            'book_note as note', 'user_name', 'country_name', 'city_name', 'book_type')
            ->where('country_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->where('books.user_id', '=', $id)
            ->where('book_type', '=', 2)
            ->get();
        return view('admin.order.index', compact('orders'));
    }
}
