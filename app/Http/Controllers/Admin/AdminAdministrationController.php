<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminAdministrationController extends Controller
{
    // protected $user;
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->admin_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->admin_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->admin_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->admin_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }
    
    public function index(){
        $users = DB::table('administration')
            ->select('id', 'name', 'phone', 'email', 'active')
            ->where('type', '=', 2)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.administration.index', compact('users'));
    }

    public function create(){
        // $manages = DB::table('manage_role')->get();
        return view('admin.administration.create');
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:administration',
            'email' => 'required|unique:administration|email',
            'password' => 'required|min:8|regex:/^(?=.*?[a-zA-Z])(?=.*?[0-9])/',
            'image' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        // dd($request->all());

        if ($request->hasFile('image')) {
            $imageName = Storage::disk('edit_path')->putFile('images/user', $request->file('image'));
        } else {
            $imageName = 'images/user/avatar_user.png';
        }
        
        if(filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
        && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email)) 
        && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) 
        && !preg_match("/[0-9]/u", $request->name)){
            $admin = DB::table('administration')
            ->insertGetId([
                'name' => $request->name,
                'phone' => convert($request->phone),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'image' => $imageName,
                'type' => 2
            ]);

            $permission = DB::table('manage_role')
                ->insert([
                    'admin_id' => $admin,
                    'user_view' => $request->user_view == 'on' ? 1 : 0,
                    'user_create' => $request->user_create == 'on' ? 1 : 0,
                    'user_update' => $request->user_update == 'on' ? 1 : 0,
                    'user_delete' => $request->user_delete == 'on' ? 1 : 0,
                    'guide_view' => $request->guide_view == 'on' ? 1 : 0,
                    'guide_create' => $request->guide_create == 'on' ? 1 : 0,
                    'guide_update' => $request->guide_update == 'on' ? 1 : 0,
                    'guide_delete' => $request->guide_delete == 'on' ? 1 : 0,
                    'company_view' => $request->company_view == 'on' ? 1 : 0,
                    'company_create' => $request->company_create == 'on' ? 1 : 0,
                    'company_update' => $request->company_update == 'on' ? 1 : 0,
                    'company_delete' => $request->company_delete == 'on' ? 1 : 0,
                    'advertisement_view' => $request->advertisement_view == 'on' ? 1 : 0,
                    'advertisement_create' => $request->advertisement_create == 'on' ? 1 : 0,
                    'advertisement_update' => $request->advertisement_update == 'on' ? 1 : 0,
                    'advertisement_delete' => $request->advertisement_delete == 'on' ? 1 : 0,
                    'page_view' => $request->page_view == 'on' ? 1 : 0,
                    'page_update' => $request->page_update == 'on' ? 1 : 0,
                    'notification_view' => $request->notification_view == 'on' ? 1 : 0,
                    'notification_create' => $request->notification_create == 'on' ? 1 : 0,
                    'notification_delete' => $request->notification_delete == 'on' ? 1 : 0,
                    'contact_view' => $request->contact_view == 'on' ? 1 : 0,
                    'contact_delete' => $request->contact_delete == 'on' ? 1 : 0,
                    'rate_view' => $request->rate_view == 'on' ? 1 : 0,
                    'rate_delete' => $request->rate_delete == 'on' ? 1 : 0,
                    'country_view' => $request->country_view == 'on' ? 1 : 0,
                    'country_create' => $request->country_create == 'on' ? 1 : 0,
                    'country_update' => $request->country_update == 'on' ? 1 : 0,
                    'country_delete' => $request->country_delete == 'on' ? 1 : 0,
                    'city_view' => $request->city_view == 'on' ? 1 : 0,
                    'city_create' => $request->city_create == 'on' ? 1 : 0,
                    'city_update' => $request->city_update == 'on' ? 1 : 0,
                    'city_delete' => $request->city_delete == 'on' ? 1 : 0,
                    'nationality_view' => $request->nationality_view == 'on' ? 1 : 0,
                    'nationality_create' => $request->nationality_create == 'on' ? 1 : 0,
                    'nationality_update' => $request->nationality_update == 'on' ? 1 : 0,
                    'nationality_delete' => $request->nationality_delete == 'on' ? 1 : 0,
                    'service_view' => $request->service_view == 'on' ? 1 : 0,
                    'service_create' => $request->service_create == 'on' ? 1 : 0,
                    'service_update' => $request->service_update == 'on' ? 1 : 0,
                    'service_delete' => $request->service_delete == 'on' ? 1 : 0,
                    'dolane_update' => $request->dolane_update == 'on' ? 1 : 0,
                    'dolane_img_view' => $request->dolane_img_view == 'on' ? 1 : 0,
                    'dolane_img_create' => $request->dolane_img_create == 'on' ? 1 : 0,
                    'dolane_img_update' => $request->dolane_img_update == 'on' ? 1 : 0,
                    'dolane_img_delete' => $request->dolane_img_delete == 'on' ? 1 : 0,
                    'faq_view' => $request->faq_view == 'on' ? 1 : 0,
                    'faq_create' => $request->faq_create == 'on' ? 1 : 0,
                    'faq_update' => $request->faq_update == 'on' ? 1 : 0,
                    'faq_delete' => $request->faq_delete == 'on' ? 1 : 0,
                    'about_update' => $request->about_update == 'on' ? 1 : 0,
                    'screen_shot_view' => $request->screen_shot_view == 'on' ? 1 : 0,
                    'screen_shot_create' => $request->screen_shot_create == 'on' ? 1 : 0,
                    'screen_shot_update' => $request->screen_shot_update == 'on' ? 1 : 0,
                    'screen_shot_delete' => $request->screen_shot_delete == 'on' ? 1 : 0,
                    'broadcast_view' => $request->broadcast_view == 'on' ? 1 : 0,
                    'trip_view' => $request->trip_view == 'on' ? 1 : 0,
                    'trip_update' => $request->trip_update == 'on' ? 1 : 0,
                    'trip_info_view' => $request->trip_info_view == 'on' ? 1 : 0,
                    'trip_info_update' => $request->trip_info_update == 'on' ? 1 : 0,
                    'order_view' => $request->order_view == 'on' ? 1 : 0,
                    'admin_view' => $request->admin_view == 'on' ? 1 : 0,
                    'admin_create' => $request->admin_create == 'on' ? 1 : 0,
                    'admin_update' => $request->admin_update == 'on' ? 1 : 0,
                    'admin_delete' => $request->admin_delete == 'on' ? 1 : 0,
                    'subscribe_view' => $request->subscribe_view == 'on' ? 1 : 0,
                    'subscribe_delete' => $request->subscribe_delete == 'on' ? 1 : 0,
                ]);
        } else {
            if(!preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) || preg_match("/[0-9]/u", $request->name)) {
                $error = trans('admin.this name must contain only characters');
                return Redirect::back()->withInput($request->all())->with('error', $error);
            } else {
                $error = trans('admin.your email is not correct');
                return Redirect::back()->withInput($request->all())->with('error', $error);
            }
        }

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);

    }

    public function edit($id){
        $users = DB::table('administration')
            ->select('id', 'name', 'phone', 'email', 'image', 'active')
            ->where('id', '=', $id)
            ->first();
        
        $manages = DB::table('manage_role')->where('admin_id', '=', $id)->first();

        // dd($manages);
            
        return view('admin.administration.edit', compact('users', 'manages'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8|regex:/^(?=.*?[a-zA-Z])(?=.*?[0-9])/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        $getUser = DB::table('administration')->where('id', '=', $id);
        $allPhone = DB::table('administration')->where('phone', convert($request->phone))->where('id', '!=', $id)->first();
        $email = strtolower($request->email);

        if(preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)) {
            $users = DB::table('administration')
                ->where('id', '=', $id)
                ->update(['name' => $request->name]);
        } else {
            $error = trans('admin.this name must contain only characters');
            return Redirect::back()->with('error', $error);
        }
        
        if ($allPhone) {
            $error = trans('admin.This phone has been taken before');
            return Redirect::back()->with('error', $error);
        } else {
            // $getUser->phone = convert($request->phone);
            // $getUser->save();
            $users = DB::table('administration')
                ->where('id', '=', $id)
                ->update(['phone' => convert($request->phone)]);
        }
        
        if(filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
        && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email))){
            $allEmail = DB::table('administration')->where('email', $email)->where('id', '!=', $id)->first();
            if ($allEmail) {
                $error = trans('admin.This Email has been taken before');
                return Redirect::back()->with('error', $error);
            } else {
                $users = DB::table('users')
                    ->where('id', '=', $id)
                    ->update([
                        'email' => $email,
                        'gender' => $request->gender,
                        'birth_of_date' => $request->birthofdate,
                        'country_id' => $request->country_id,
                        'city_id' => $request->city_id
                    ]);
                
                $permission = DB::table('manage_role')
                ->where('admin_id', '=', $id)
                ->update([
                    'user_view' => $request->user_view == 'on' ? 1 : 0,
                    'user_create' => $request->user_create == 'on' ? 1 : 0,
                    'user_update' => $request->user_update == 'on' ? 1 : 0,
                    'user_delete' => $request->user_delete == 'on' ? 1 : 0,
                    'guide_view' => $request->guide_view == 'on' ? 1 : 0,
                    'guide_create' => $request->guide_create == 'on' ? 1 : 0,
                    'guide_update' => $request->guide_update == 'on' ? 1 : 0,
                    'guide_delete' => $request->guide_delete == 'on' ? 1 : 0,
                    'company_view' => $request->company_view == 'on' ? 1 : 0,
                    'company_create' => $request->company_create == 'on' ? 1 : 0,
                    'company_update' => $request->company_update == 'on' ? 1 : 0,
                    'company_delete' => $request->company_delete == 'on' ? 1 : 0,
                    'advertisement_view' => $request->advertisement_view == 'on' ? 1 : 0,
                    'advertisement_create' => $request->advertisement_create == 'on' ? 1 : 0,
                    'advertisement_update' => $request->advertisement_update == 'on' ? 1 : 0,
                    'advertisement_delete' => $request->advertisement_delete == 'on' ? 1 : 0,
                    'page_view' => $request->page_view == 'on' ? 1 : 0,
                    'page_update' => $request->page_update == 'on' ? 1 : 0,
                    'notification_view' => $request->notification_view == 'on' ? 1 : 0,
                    'notification_create' => $request->notification_create == 'on' ? 1 : 0,
                    'notification_delete' => $request->notification_delete == 'on' ? 1 : 0,
                    'contact_view' => $request->contact_view == 'on' ? 1 : 0,
                    'contact_delete' => $request->contact_delete == 'on' ? 1 : 0,
                    'rate_view' => $request->rate_view == 'on' ? 1 : 0,
                    'rate_delete' => $request->rate_delete == 'on' ? 1 : 0,
                    'country_view' => $request->country_view == 'on' ? 1 : 0,
                    'country_create' => $request->country_create == 'on' ? 1 : 0,
                    'country_update' => $request->country_update == 'on' ? 1 : 0,
                    'country_delete' => $request->country_delete == 'on' ? 1 : 0,
                    'city_view' => $request->city_view == 'on' ? 1 : 0,
                    'city_create' => $request->city_create == 'on' ? 1 : 0,
                    'city_update' => $request->city_update == 'on' ? 1 : 0,
                    'city_delete' => $request->city_delete == 'on' ? 1 : 0,
                    'nationality_view' => $request->nationality_view == 'on' ? 1 : 0,
                    'nationality_create' => $request->nationality_create == 'on' ? 1 : 0,
                    'nationality_update' => $request->nationality_update == 'on' ? 1 : 0,
                    'nationality_delete' => $request->nationality_delete == 'on' ? 1 : 0,
                    'service_view' => $request->service_view == 'on' ? 1 : 0,
                    'service_create' => $request->service_create == 'on' ? 1 : 0,
                    'service_update' => $request->service_update == 'on' ? 1 : 0,
                    'service_delete' => $request->service_delete == 'on' ? 1 : 0,
                    'dolane_update' => $request->dolane_update == 'on' ? 1 : 0,
                    'dolane_img_view' => $request->dolane_img_view == 'on' ? 1 : 0,
                    'dolane_img_create' => $request->dolane_img_create == 'on' ? 1 : 0,
                    'dolane_img_update' => $request->dolane_img_update == 'on' ? 1 : 0,
                    'dolane_img_delete' => $request->dolane_img_delete == 'on' ? 1 : 0,
                    'faq_view' => $request->faq_view == 'on' ? 1 : 0,
                    'faq_create' => $request->faq_create == 'on' ? 1 : 0,
                    'faq_update' => $request->faq_update == 'on' ? 1 : 0,
                    'faq_delete' => $request->faq_delete == 'on' ? 1 : 0,
                    'about_update' => $request->about_update == 'on' ? 1 : 0,
                    'screen_shot_view' => $request->screen_shot_view == 'on' ? 1 : 0,
                    'screen_shot_create' => $request->screen_shot_create == 'on' ? 1 : 0,
                    'screen_shot_update' => $request->screen_shot_update == 'on' ? 1 : 0,
                    'screen_shot_delete' => $request->screen_shot_delete == 'on' ? 1 : 0,
                    'broadcast_view' => $request->broadcast_view == 'on' ? 1 : 0,
                    'trip_view' => $request->trip_view == 'on' ? 1 : 0,
                    'trip_update' => $request->trip_update == 'on' ? 1 : 0,
                    'trip_info_view' => $request->trip_info_view == 'on' ? 1 : 0,
                    'trip_info_update' => $request->trip_info_update == 'on' ? 1 : 0,
                    'order_view' => $request->order_view == 'on' ? 1 : 0,
                    'admin_view' => $request->admin_view == 'on' ? 1 : 0,
                    'admin_create' => $request->admin_create == 'on' ? 1 : 0,
                    'admin_update' => $request->admin_update == 'on' ? 1 : 0,
                    'admin_delete' => $request->admin_delete == 'on' ? 1 : 0,
                    'subscribe_view' => $request->subscribe_view == 'on' ? 1 : 0,
                    'subscribe_delete' => $request->subscribe_delete == 'on' ? 1 : 0,
                ]);
            }
        } else {
            $error = trans('admin.your email is not correct');
            return Redirect::back()->with('error', $error);
        }

        if ($request->password) {
            $users = DB::table('administration')
                ->where('id', '=', $id)
                ->update(['password' => Hash::make($request->password)]);
        }

        if ($request->hasFile('image')) {
            if($getUser->image != 'images/user/avatar_user.png'){
                $myFile = base_path($getUser->image);
                File::delete($myFile);
            }
            
            $imageName = Storage::disk('edit_path')->putFile('images/user', $request->file('image'));

            $users = DB::table('users')
                ->where('id', '=', $id)
                ->update(['image' => $imageName]);
        } else {
            $imageName = $request->old_image;
            $users = DB::table('users')
                ->where('id', '=', $id)
                ->update(['image' => $imageName]);
        }
        
        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroy(Request $request, $id){
        $getUser = DB::table('administration')->where('id', '=', $id)->first();
        if($getUser->image != 'images/user/avatar_user.png'){
            $myFile = base_path($getUser->image);
            File::delete($myFile);
        }
        $users = DB::table('administration')->where('id', '=', $id)->delete();
        $permission = DB::table('manage_role')->where('admin_id', '=', $id)->delete();
    }

}
