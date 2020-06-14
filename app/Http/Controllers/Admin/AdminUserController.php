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

class AdminUserController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->user_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->user_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->user_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->user_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }
    
    public function index(){
        $users = DB::table('users')
            ->select('id', 'name', 'phone', 'email', 'active')
            ->where('type', '=', 1)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.users.index', compact('users'));
    }
    
    public function changeStatus(Request $request){
        if($request->type == 'user') {
            $user = DB::table('users')->where('id', '=', $request->id)->update(['active' => $request->status]);
        }

        if($request->type == 'country') {
            $country = DB::table('countries')->where('country_id', '=', $request->id)->update(['status' => $request->status]);
        }

        if($request->type == 'city') {
            $country = DB::table('cities')->where('city_id', '=', $request->id)->update(['status' => $request->status]);
        }

        if($request->type == 'service') {
            $country = DB::table('services')->where('service_id', '=', $request->id)->update(['status' => $request->status]);
        }

        if($request->type == 'banner') {
            $country = DB::table('banners')->where('banner_id', '=', $request->id)->update(['status' => $request->status]);
        }

        if($request->type == 'dolane') {
            $country = DB::table('dolane_image')->where('dolane_image_id', '=', $request->id)->update(['status' => $request->status]);
        }

        if($request->type == 'faq') {
            $country = DB::table('faqs')->where('faq_id', '=', $request->id)->update(['status' => $request->status]);
        }

        if($request->type == 'nationality') {
            $country = DB::table('nationalities')->where('nationality_id', '=', $request->id)->update(['status' => $request->status]);
        }

        if($request->type == 'screen') {
            $country = DB::table('screen_shots')->where('screen_shot_id', '=', $request->id)->update(['status' => $request->status]);
        }

        if($request->type == 'admin') {
            $user = DB::table('administration')->where('id', '=', $request->id)->update(['active' => $request->status]);
        }

        if($request->type == 'is_join') {
            $user = DB::table('users')->where('id', '=', $request->id)->update(['is_join' => $request->status]);
        }
    }

    public function create(){
        $countries = DB::table('countries')
            ->join('country_description', 'country_description.country_id', '=', 'countries.country_id')
            ->where('language_id', '=', language())
            ->select('countries.country_id as id', 'country_name as name')
            ->get();
        return view('admin.users.create', compact('countries'));
    }

    public function store(Request $request){

        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|regex:/^(?=.*?[a-zA-Z])(?=.*?[0-9])/',
            'gender' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            'birthofdate' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
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
        
        if(filter_var(filter_var(strtolower($request->email), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email)) && preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)){
            $users = DB::table('users')
            ->insertGetId([
                'name' => $request->name,
                'phone' => convert($request->phone),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'image' => $imageName,
                'gender' => $request->gender,
                'birth_of_date' => $request->birthofdate,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'type' => 1
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
        $users = DB::table('users')
            ->select('id', 'name', 'phone', 'email', 'image', 'gender', 'active', 'birth_of_date', 'country_id', 'city_id')
            ->where('id', '=', $id)
            ->first();
        
        $countries = DB::table('countries')
            ->join('country_description', 'country_description.country_id', '=', 'countries.country_id')
            ->where('language_id', '=', language())
            ->select('countries.country_id as id', 'country_name as name')
            ->get();

        $cities = DB::table('cities')
            ->join('city_description', 'city_description.city_id', '=', 'cities.city_id')
            ->where('language_id', '=', language())
            ->where('country_id', '=', $users->country_id)
            ->select('cities.city_id as id', 'city_name as name')
            ->get();
            
        return view('admin.users.edit', compact('users', 'countries', 'cities'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8|regex:/^(?=.*?[a-zA-Z])(?=.*?[0-9])/',
            'gender' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
            // 'active' => 'nullable',
            'birthofdate' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        $getUser = User::find($id);
        $allPhone = User::where('phone', convert($request->phone))->where('id', '!=', $id)->first();
        $email = strtolower($request->email);

        if(preg_match("/[\p{Arabic}A-Za-z]/u", $request->name) && !preg_match("/[0-9]/u", $request->name)) {
            $users = DB::table('users')
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
            $getUser->phone = convert($request->phone);
            $getUser->save();
        }
        
        if(filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) 
        && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", strtolower($request->email))){
            $allEmail = User::where('email', $email)->where('id', '!=', $id)->first();
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
            }
        } else {
            $error = trans('admin.your email is not correct');
            return Redirect::back()->with('error', $error);
        }

        if ($request->password) {
            $users = DB::table('users')
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

        // if ($request->gender) {
        //     $users = DB::table('users')
        //         ->where('id', '=', $id)
        //         ->update(['gender' => $request->gender]);
        // }
        
        // $CustomersPush = new CustomersPush();
        // if ($request->active == 1) {
        //     $users = DB::table('users')
        //         ->where('id', '=', $id)
        //         ->update(['active' => $request->active]);
            
        //     $customersToken = DB::table('users')->select('token')->where('id', '=', $id)->get();
        //     foreach($customersToken as $customer){
        //         $customersTokenArr[]=$customer->token;
        //     }
        //     $CustomersPush->send('User Active','This User Is Active',$customersTokenArr,'','1');
        // } else {
        //     $users = DB::table('users')
        //         ->where('id', '=', $id)
        //         ->update(['active' => $request->active]);
                
        //     $customersToken = DB::table('users')->select('token')->where('id', '=', $id)->get();
        //     foreach($customersToken as $customer){
        //         $customersTokenArr[]=$customer->token;
        //     }
        //     $CustomersPush->send('User InActive','This User Is InActive',$customersTokenArr,'','1');
        // }

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroy(Request $request, $id){
        // $CustomersPush = new CustomersPush();
        // $customersToken = DB::table('users')->select('token', 'default_language')->where('id', '=', $id)->get();
        // foreach($customersToken as $customer){
        //     $customersTokenArr[]=$customer->token;
        // }
        // if($customersToken[0]->default_language == 1) {
        //     $CustomersPush->send('Reservation','The user has been deleted',$customersTokenArr,'','1', '2');
        // } else {
        //     $CustomersPush->send('الحجوزات','تم حذف المستخدم',$customersTokenArr,'','1', '2');
        // }
        $getUser = User::find($id);
        if($getUser->image != 'images/user/avatar_user.png'){
            $myFile = base_path($getUser->image);
            File::delete($myFile);
        }
        $users = DB::table('users')
            ->where('id', '=', $id)
            ->delete();
    }

}
