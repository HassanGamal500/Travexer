<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminCountryController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->country_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->country_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->country_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->country_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }
    
    public function index(){
        $countries = DB::table('countries')
            ->join('country_description', 'country_description.country_id', '=', 'countries.country_id')
            ->select('countries.country_id as id', 'country_name as name', 'status')
            ->where('language_id', '=', language())
            ->orderBy('countries.country_id', 'desc')
            ->get();

        return view('admin.country.index', compact('countries'));
    }

    public function create(){
        return view('admin.country.create');
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'country_name' => 'required|max:100',
            // 'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->country_name[1]) 
        &&!preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->country_name[2])) {

            $countries = DB::table('countries')->insertGetId(['status' => 1]);
    
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('country_description')
                    ->insert([
                        'country_name' => $request->country_name[$i],
                        'language_id' => $i,
                        'country_id' => $countries
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->country_name[1])) {
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
        $countries = DB::table('countries')
            ->join('country_description', 'country_description.country_id', '=', 'countries.country_id')
            ->select('countries.country_id as id', 'country_name as name', 'status')
            ->where('countries.country_id', '=', $id)
            ->get();
        return view('admin.country.edit', compact('countries'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'country_name' => 'required|max:100',
            // 'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->country_name[1]) 
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->country_name[2])) {
            // $country = DB::table('countries')->where('country_id', '=', $id)->update(['is_active' => $request->is_active]);
            
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('country_description')
                    ->where('country_id', '=', $id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'country_name' => $request->country_name[$i],
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->country_name[1])) {
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
        $country = DB::table('countries')
            ->where('country_id', '=', $id)
            ->delete();
    }
}
