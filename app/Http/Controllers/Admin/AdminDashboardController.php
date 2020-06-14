<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(){
        $results = array();

        $users = DB::table('users')->where('type', '=', 1)->count();
        $guides = DB::table('users')->where('type', '=', 2)->count();
        $companies = DB::table('users')->where('type', '=', 3)->count();
        $total = DB::table('books')->selectRaw('sum(guide_price) + sum(trip_price) as total')->first();
        // ->select('guide_price', 'trip_price')->value(DB::raw('SUM(guide_price + trip_price)'));
        // dd($total);
        $broadcasts = DB::table('broadcasts')->count();
        $trips = DB::table('trips')->count();
        $orders = DB::table('books')->count();
        $rates = DB::table('rates')->count();
        $admins = DB::table('administration')->where('type', '!=', 1)->count();
        $services = DB::table('services')->count();
        $contacts = DB::table('contacts')->count();
        $notifications = DB::table('notifications')->where('type', '=', 1)->count();
        $subscribes = DB::table('subscribes')->count();
        $countries = DB::table('countries')->count();
        $cities = DB::table('cities')->count();
        $nationalities = DB::table('nationalities')->count();

        $results['users'] = $users;
        $results['guides'] = $guides;
        $results['companies'] = $companies;
        $results['total'] = $total->total;
        $results['broadcasts'] = $broadcasts;
        $results['trips'] = $trips;
        $results['orders'] = $orders;
        $results['rates'] = $rates;
        $results['admins'] = $admins;
        $results['services'] = $services;
        $results['contacts'] = $contacts;
        $results['notifications'] = $notifications;
        $results['subscribes'] = $subscribes;
        $results['countries'] = $countries;
        $results['cities'] = $cities;
        $results['nationalities'] = $nationalities;

        $role = false;
        if(auth()->guard('admin')->user()->type == 1){
            $role == true;
        } else {
            $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
        }

        return view('admin.dashboard.index', compact('role', 'results'));
    }
}
