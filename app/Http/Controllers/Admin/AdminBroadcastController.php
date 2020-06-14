<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;


class AdminBroadcastController extends Controller
{

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->broadcast_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');
    }

    public function index(){
        $broadcasts = DB::table('broadcasts')
            ->join('users', 'users.id', '=', 'broadcasts.user_id')
            ->join('service_description', 'service_description.service_id', '=', 'broadcasts.service_id')
            ->join('country_description', 'country_description.country_id', '=', 'broadcasts.country_id')
            ->join('city_description', 'city_description.city_id', '=', 'broadcasts.city_id')
            ->select('broadcast_id as id', 'broadcast_date as date', 'broadcast_stat_time as start',
            'broadcast_end_time as end', 'broadcast_note as note', 'name as user_name', 'service_name', 'country_name', 'city_name')
            ->where('service_description.language_id', '=', language())
            ->where('country_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->get();
        // dd($broadcasts);
        return view('admin.broadcast.index', compact('broadcasts'));
    }

    public function get_broadcast(Request $request){
        $broadcasts = DB::table('broadcasts')
            ->join('users', 'users.id', '=', 'broadcasts.user_id')
            ->join('service_description', 'service_description.service_id', '=', 'broadcasts.service_id')
            ->join('country_description', 'country_description.country_id', '=', 'broadcasts.country_id')
            ->join('city_description', 'city_description.city_id', '=', 'broadcasts.city_id',)
            ->select('broadcast_id as id', 'broadcast_date as date', 'broadcast_stat_time as start', 'email','phone',
            'broadcast_end_time as end', 'broadcast_note as note', 'name as user_name', 'service_name', 'country_name', 'city_name')
            ->where('service_description.language_id', '=', language())
            ->where('country_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->where('broadcast_id', '=', $request->id)
            ->first();
        // dd($broadcasts);
        return response()->json($broadcasts);
    }

    public function get_broadcast_user($id){
        $broadcasts = DB::table('broadcasts')
            ->join('users', 'users.id', '=', 'broadcasts.user_id')
            ->join('service_description', 'service_description.service_id', '=', 'broadcasts.service_id')
            ->join('country_description', 'country_description.country_id', '=', 'broadcasts.country_id')
            ->join('city_description', 'city_description.city_id', '=', 'broadcasts.city_id',)
            ->select('broadcast_id as id', 'broadcast_date as date', 'broadcast_stat_time as start', 'email','phone',
            'broadcast_end_time as end', 'broadcast_note as note', 'name as user_name', 'service_name', 'country_name', 'city_name')
            ->where('service_description.language_id', '=', language())
            ->where('country_description.language_id', '=', language())
            ->where('city_description.language_id', '=', language())
            ->where('broadcasts.user_id', '=', $id)
            ->get();
        // dd($broadcasts);
        return view('admin.broadcast.index', compact('broadcasts'));
    }
}
