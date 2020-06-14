<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;


class AdminBannerController extends Controller
{
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->advertisement_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->advertisement_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->advertisement_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->advertisement_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }

    public function index(){
        $banners = DB::table('banners')
            ->select('banner_id as id', 'banner_image as image', 'status')
            ->get();
        return view('admin.banner.index', compact('banners'));
    }

    public function create(){
        return view('admin.banner.create');
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'banner_image' => 'required|max:2048|array',
            'banner_image.*' => 'required',
        ]);
        // dd($request->all());
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        
        if ($request->hasFile('banner_image')) {
            foreach($request->banner_image as $image) {
                $imageName = Storage::disk('edit_path')->putFile('images/banner', $image);
                $img = DB::table('banners')->insert(['banner_image' => $imageName]);
            }
        } 
        // else {
        //     foreach ($request->image as $image) {
        //         $imageName = 'images/banner/avatar_banner.png';
        //         $img = DB::table('banners')->insert(['banner_image' => $imageName, 'admin_id' => auth()->guard('admin')->user()->id]);
        //     }
        // }

        $type_id = auth()->guard('admin')->user()->id;
        $banners = DB::table('banners')
            ->select('banner_id as id', 'banner_image as image')
            ->get();

        $message = App::isLocale('ar') ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function edit(Request $request, $id) {
        $banners = DB::table('banners')
            ->select('banner_id as id', 'banner_image as image')
            ->where('banner_id', '=', $id)
            ->first();

        return view('admin.banner.edit', compact('banners'));
    }

    public function update(Request $request, $id) {
        $validator = validator()->make($request->all(), [
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if ($request->hasFile('banner_image')) {
        	$getImage = DB::table('banners')->where('banner_id', '=', $id)->select('banner_image')->first();
            $myFile = base_path($getImage->banner_image);
            File::delete($myFile);
            $banner_image = Storage::disk('edit_path')->putFile('images/banner', $request->file('banner_image'));
        } else {
            $banner_image = $request->old_banner_image;
        }

        $banner = DB::table('banners')->where('banner_id', '=', $id)->update(['banner_image' => $banner_image]);

        $message = App::isLocale('ar') ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroy(Request $request, $id){
        $getImage = DB::table('banners')->select('banner_image')->where('banner_id', '=', $id)->first();
        $myFile = base_path($getImage->banner_image);
        File::delete($myFile);
        $banners = DB::table('banners')->where('banner_id', '=', $id)->delete();
    }
}
