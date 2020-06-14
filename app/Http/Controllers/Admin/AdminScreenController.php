<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;


class AdminScreenController extends Controller
{

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->screen_shot_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->screen_shot_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->screen_shot_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->screen_shot_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }

    public function index(){
        $screens = DB::table('screen_shots')
            ->select('screen_shot_id as id', 'screen_image as image', 'status')
            ->get();
        return view('admin.screen.index', compact('screens'));
    }

    public function create(){
        return view('admin.screen.create');
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'screen_image' => 'required|array',
            'screen_image.*' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if ($request->hasFile('screen_image')) {
            foreach($request->screen_image as $image) {
                $imageName = Storage::disk('edit_path')->putFile('images/screen', $image);
                $img = DB::table('screen_shots')->insert(['screen_image' => $imageName]);
            }
        }

        $screen_image = DB::table('screen_shots')
            ->select('screen_shot_id as id', 'screen_image as image')
            ->get();

        $message = App::isLocale('ar') ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function edit(Request $request, $id) {
        $screens = DB::table('screen_shots')
            ->select('screen_shot_id as id', 'screen_image as image')
            ->where('screen_shot_id', '=', $id)
            ->first();

        return view('admin.screen.edit', compact('screens'));
    }

    public function update(Request $request, $id) {
        $validator = validator()->make($request->all(), [
            'screen_image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if ($request->hasFile('screen_image')) {
        	$getImage = DB::table('screen_shots')->where('screen_shot_id', '=', $id)->select('screen_image')->first();
            $myFile = base_path($getImage->screen_image);
            File::delete($myFile);
            $screen_image = Storage::disk('edit_path')->putFile('images/screen', $request->file('screen_image'));
        } else {
            $screen_image = $request->old_screen_image;
        }

        $screen_image = DB::table('screen_shots')->where('screen_shot_id', '=', $id)->update(['screen_image' => $screen_image]);

        $message = App::isLocale('ar') ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroy(Request $request, $id){
        $getImage = DB::table('screen_shots')->select('screen_image')->where('screen_shot_id', '=', $id)->first();
        $myFile = base_path($getImage->screen_image);
        File::delete($myFile);
        $screen_image = DB::table('screen_shots')->where('screen_shot_id', '=', $id)->delete();
    }
}
