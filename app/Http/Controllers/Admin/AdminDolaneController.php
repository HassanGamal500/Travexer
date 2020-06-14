<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminDolaneController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->dolane_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');
    }

    public function edit(){
        $dolanes = DB::table('dolanes')
            ->join('dolane_description', 'dolane_description.dolane_id', '=', 'dolanes.dolane_id')
            ->select('dolanes.dolane_id as id', 'dolane_phone', 'dolane_latitude', 'dolane_longitude', 'dolane_name', 'dolane_description')
            ->where('dolanes.dolane_id', '=', 1)
            ->get();
        return view('admin.dolane.edit', compact('dolanes'));
    }

    public function update(Request $request){
        $validator = validator()->make($request->all(), [
            'dolane_name' => 'required|max:70',
            'dolane_description' => 'required',
            'dolane_phone' => 'required',
            'dolane_latitude' => 'required',
            'dolane_longitude' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }
        
        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->dolane_name[1]) 
        && preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%()-<>\s]+$/", $request->dolane_description[1]) 
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->dolane_name[2])
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->dolane_description[2])) {
            $country = DB::table('dolanes')->where('dolane_id', '=', 1)
                ->update([
                    'dolane_phone' => $request->dolane_phone,
                    'dolane_latitude' => $request->dolane_latitude,
                    'dolane_longitude' => $request->dolane_longitude
                ]);
            
            for ($i = 1; $i <= 2; $i++){
                $description = DB::table('dolane_description')
                    ->where('dolane_id', '=', 1)
                    ->where('language_id', '=', $i)
                    ->update([
                        'dolane_name' => $request->dolane_name[$i],
                        'dolane_description' => $request->dolane_description[$i]
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->dolane_name[1]) 
            && !preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->dolane_description[1])) {
                $error = trans('admin.name or description content must be contain only english characters');
            } else {
                $error = trans('admin.name or description content must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

}
