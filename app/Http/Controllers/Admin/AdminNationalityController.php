<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminNationalityController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->nationality_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->nationality_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->nationality_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->nationality_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }
    
    public function index(){
        $nationalities = DB::table('nationalities')
            ->join('nationality_description', 'nationality_description.nationality_id', '=', 'nationalities.nationality_id')
            ->select('nationalities.nationality_id as id', 'nationality_name as name', 'status')
            ->where('language_id', '=', language())
            ->orderBy('nationalities.nationality_id', 'desc')
            ->get();

        return view('admin.nationality.index', compact('nationalities'));
    }

    public function create(){
        return view('admin.nationality.create');
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'nationality_name' => 'required|max:100',
            // 'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->nationality_name[1]) 
        &&!preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->nationality_name[2])) {

            $nationalities = DB::table('nationalities')->insertGetId(['status' => 1]);
    
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('nationality_description')
                    ->insert([
                        'nationality_name' => $request->nationality_name[$i],
                        'language_id' => $i,
                        'nationality_id' => $nationalities
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->nationality_name[1])) {
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
        $nationalities = DB::table('nationalities')
            ->join('nationality_description', 'nationality_description.nationality_id', '=', 'nationalities.nationality_id')
            ->select('nationalities.nationality_id as id', 'nationality_name as name', 'status')
            ->where('nationalities.nationality_id', '=', $id)
            ->get();
        return view('admin.nationality.edit', compact('nationalities'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'nationality_name' => 'required|max:100',
            // 'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->nationality_name[1]) 
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->nationality_name[2])) {
            // $country = DB::table('countries')->where('country_id', '=', $id)->update(['is_active' => $request->is_active]);
            
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('nationality_description')
                    ->where('nationality_id', '=', $id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'nationality_name' => $request->nationality_name[$i],
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->nationality_name[1])) {
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
        $country = DB::table('nationalities')
            ->where('nationality_id', '=', $id)
            ->delete();
    }
}
