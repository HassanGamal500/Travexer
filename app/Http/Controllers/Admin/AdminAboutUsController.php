<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminAboutUsController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->about_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');
    }
    
    public function edit(){
        $about = DB::table('about_us')
            ->join('about_us_description', 'about_us_description.about_us_id', '=', 'about_us.about_us_id')
            ->select('about_us.about_us_id as id', 'about_description as description', 'about_mission as mission',
            'about_vission as vission', 'about_values as values')
            ->where('about_us.about_us_id', '=', 1)
            ->get();

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request){
        $validator = validator()->make($request->all(), [
            'description' => 'required',
            'mission' => 'required',
            'vission' => 'required',
            'values' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        for ($i = 1; $i <= 2; $i++){
            $description = DB::table('about_us_description')
                ->where('about_us_id', '=', 1)
                ->where('language_id', '=', $i)
                ->update([
                    'about_description' => $request->description[$i],
                    'about_mission' => $request->mission[$i],
                    'about_vission' => $request->vission[$i],
                    'about_values' => $request->values[$i]
                ]);
        }

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

}
