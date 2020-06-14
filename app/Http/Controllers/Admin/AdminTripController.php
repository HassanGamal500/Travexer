<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminTripController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->trip_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->trip_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');
    }
    
    public function index(){
        $trips = DB::table('trips')
            ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
            ->select('trips.trip_id as id', 'trip_title', 'trip_price', 'trip_date', 'trip_time_from', 'trip_time_to')
            ->where('language_id', '=', language())
            ->orderBy('trips.trip_id', 'desc')
            ->get();
        return view('admin.trip.index', compact('trips'));
    }

    public function edit($id){
        $trips = DB::table('trips')
            ->join('trip_description', 'trip_description.trip_id', '=', 'trips.trip_id')
            ->select('trips.trip_id as id', 'trip_title', 'trip_description', 'trip_price', 'trip_discount', 
            'trip_date', 'trip_time_from', 'trip_time_to', 'trip_child_percent')
            ->where('trips.trip_id', '=', $id)
            ->get();

        return view('admin.trip.edit', compact('trips'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'trip_title' => 'required',
            'trip_description' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        for ($i = 1; $i <= 2; $i++){
            $description = DB::table('trip_description')
                ->where('trip_id', '=', $id)
                ->where('language_id', '=', $i)
                ->update([
                    'trip_title' => $request->trip_title[$i],
                    'trip_description' => $request->trip_description[$i],
                ]);
        }

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

}
