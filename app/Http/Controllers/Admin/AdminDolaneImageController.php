<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;


class AdminDolaneImageController extends Controller
{

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->dolane_img_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->dolane_img_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->dolane_img_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->dolane_img_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }

    public function index(){
        $dolanes = DB::table('dolane_image')
            ->select('dolane_image_id as id', 'dolane_image as image', 'status')
            ->get();
        return view('admin.dolane.images.index', compact('dolanes'));
    }

    public function create(){
        return view('admin.dolane.images.create');
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'dolane_image' => 'required|array',
            'dolane_image.*' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if ($request->hasFile('dolane_image')) {
            foreach($request->dolane_image as $image) {
                $imageName = Storage::disk('edit_path')->putFile('images/dolane', $image);
                $img = DB::table('dolane_image')->insert(['dolane_image' => $imageName, 'dolane_id' => 1]);
            }
        } 
        // else {
        //     foreach ($request->image as $image) {
        //         $imageName = 'images/banner/avatar_banner.png';
        //         $img = DB::table('banners')->insert(['banner_image' => $imageName, 'admin_id' => auth()->guard('admin')->user()->id]);
        //     }
        // }

        $type_id = auth()->guard('admin')->user()->id;
        $dolane_image = DB::table('dolane_image')
            ->select('dolane_image_id as id', 'dolane_image as image')
            ->get();

        $message = App::isLocale('ar') ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function edit(Request $request, $id) {
        $dolane = DB::table('dolane_image')
            ->select('dolane_image_id as id', 'dolane_image as image')
            ->where('dolane_image_id', '=', $id)
            ->first();

        return view('admin.dolane.images.edit', compact('dolane'));
    }

    public function update(Request $request, $id) {
        $validator = validator()->make($request->all(), [
            'dolane_image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if ($request->hasFile('dolane_image')) {
        	$getImage = DB::table('dolane_image')->where('dolane_image_id', '=', $id)->select('dolane_image')->first();
            $myFile = base_path($getImage->dolane_image);
            File::delete($myFile);
            $dolane_image = Storage::disk('edit_path')->putFile('images/dolane', $request->file('dolane_image'));
        } else {
            $dolane_image = $request->old_dolane_image;
        }

        $dolane_image = DB::table('dolane_image')->where('dolane_image_id', '=', $id)->update(['dolane_image' => $dolane_image]);

        $message = App::isLocale('ar') ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroy(Request $request, $id){
        $getImage = DB::table('dolane_image')->select('dolane_image')->where('dolane_image_id', '=', $id)->first();
        $myFile = base_path($getImage->dolane_image);
        File::delete($myFile);
        $dolane_image = DB::table('dolane_image')->where('dolane_image_id', '=', $id)->delete();
    }
}
