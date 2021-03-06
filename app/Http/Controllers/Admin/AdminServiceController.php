<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminServiceController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->service_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->service_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->service_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->service_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }
    
    public function index(){
        $services = DB::table('services')
            ->join('service_description', 'service_description.service_id', '=', 'services.service_id')
            ->select('services.service_id as id', 'service_name as name', 'status')
            ->where('language_id', '=', language())
            ->orderBy('services.service_id', 'desc')
            ->get();

        return view('admin.service.index', compact('services'));
    }

    public function create(){
        return view('admin.service.create');
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'service_name' => 'required|max:100',
            // 'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->service_name[1]) 
        &&!preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->service_name[2])) {

            $services = DB::table('services')->insertGetId(['status' => 1]);
    
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('service_description')
                    ->insert([
                        'service_name' => $request->service_name[$i],
                        'language_id' => $i,
                        'service_id' => $services
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->service_name[1])) {
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
        $services = DB::table('services')
            ->join('service_description', 'service_description.service_id', '=', 'services.service_id')
            ->select('services.service_id as id', 'service_name as name', 'status')
            ->where('services.service_id', '=', $id)
            ->get();
        return view('admin.service.edit', compact('services'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'service_name' => 'required|max:100',
            // 'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->service_name[1]) 
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->service_name[2])) {
            // $country = DB::table('countries')->where('country_id', '=', $id)->update(['is_active' => $request->is_active]);
            
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('service_description')
                    ->where('service_id', '=', $id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'service_name' => $request->service_name[$i],
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->service_name[1])) {
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
        $services = DB::table('services')->where('service_id', '=', $id)->delete();
        $description = DB::table('service_description')->where('service_id', '=', $id)->delete();
    }
}
