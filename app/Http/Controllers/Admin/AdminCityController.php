<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminCityController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->city_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->city_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->city_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->city_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }
    
    public function index(){
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->select('cities.city_id as id', 'city_name as name', 'status')
            ->where('language_id', '=', language())
            ->orderBy('cities.city_id', 'desc')
            ->get();

        return view('admin.city.index', compact('cities'));
    }

    public function create(){
        $countries = DB::table('countries')
            ->join('country_description', 'country_description.country_id', '=', 'countries.country_id')
            ->select('countries.country_id as id', 'country_name as name')
            ->where('language_id', '=', language())
            ->get();
        return view('admin.city.create', compact('countries'));
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'city_name' => 'required|max:100',
            'country_id' => 'required',
            // 'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->city_name[1]) 
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->city_name[2])) {
            $cities = DB::table('cities')->insertGetId(['country_id' => $request->country_id]);

            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('city_description')
                    ->insert([
                        'city_name' => $request->city_name[$i],
                        'language_id' => $i,
                        'city_id' => $cities
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->city_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function edit($id){
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->select('cities.city_id as id', 'city_name as name', 'status', 'country_id')
            ->where('cities.city_id', '=', $id)
            ->get();
        $countries = DB::table('countries')
            ->join('country_description', 'country_description.country_id', '=', 'countries.country_id')
            ->select('countries.country_id as id', 'country_name as name')
            ->where('language_id', '=', language())
            ->get();
        return view('admin.city.edit', compact('cities', 'countries'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'city_name' => 'required|max:100',
            'country_id' => 'required',
            // 'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->city_name[1]) 
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->city_name[2])) {
            $country = DB::table('cities')->where('city_id', '=', $id)->update(['country_id' => $request->country_id]);
            
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('city_description')
                    ->where('city_id', '=', $id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'city_name' => $request->city_name[$i],
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->city_name[1])) {
                $error = trans('admin.name must be contain only english characters');
            } else {
                $error = trans('admin.name must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
            

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroy($id){
        $country = DB::table('cities')
            ->where('city_id', '=', $id)
            ->delete();
    }
    
    public function getCity(Request $request) {
        $country = $request->country_id;
        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('language_id', '=', language())
            ->where('status', '=', 1)
            ->where('country_id', '=', $country)
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
        return response()->json($cities);
    }
}
