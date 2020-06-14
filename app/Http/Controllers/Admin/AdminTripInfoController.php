<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminTripInfoController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->trip_info_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->trip_info_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');
    }
    
    public function index($id){
        $trips = DB::table('trip_information')
            ->join('trip_information_description', 'trip_information_description.trip_information_id', '=', 'trip_information.trip_information_id')
            ->select('trip_information.trip_information_id as id', 'trip_information_title', 'trip_information_value')
            ->where('language_id', '=', language())
            ->where('trip_id', '=', $id)
            ->orderBy('trip_information.trip_information_id', 'desc')
            ->get();
        return view('admin.trip.info.index', compact('trips'));
    }

    public function edit($id){
        $trips = DB::table('trip_information')
            ->join('trip_information_description', 'trip_information_description.trip_information_id', '=', 'trip_information.trip_information_id')
            ->select('trip_information.trip_information_id as id', 'trip_information_title', 'trip_information_value')
            ->where('trip_information.trip_information_id', '=', $id)
            ->get();

        return view('admin.trip.info.edit', compact('trips'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'trip_information_title' => 'required',
            'trip_information_value' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        for ($i = 1; $i <= 2; $i++){
            $description = DB::table('trip_information_description')
                ->where('trip_information_id', '=', $id)
                ->where('language_id', '=', $i)
                ->update([
                    'trip_information_title' => $request->trip_information_title[$i],
                    'trip_information_value' => $request->trip_information_value[$i],
                ]);
        }

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

}
