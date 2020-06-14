<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminNotificationController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->notification_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->notification_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->notification_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->notification_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }

    public function index(){
        $type = auth()->guard('admin')->user()->id;
        $notifications = DB::table('notifications')
            ->join('notification_description', 'notification_description.notification_id', '=', 'notifications.notification_id')
            ->select('notifications.notification_id as id', 'notification_name as name', 
            'notification_content as content', 'notification_image as image')
            ->where('type', '=', 1)
            ->where('type_id', '=', $type)
            ->where('language_id', '=', language())
            ->orderBy('notifications.notification_id', 'desc')
            ->get();

        return view('admin.notification.index', compact('notifications'));
    }

    public function create(){
        $type = auth()->guard('admin')->user()->id;
        $users = DB::table('users')->select('id', 'email')->where('type', '=', 1)->get();
        $guides = DB::table('users')->select('id', 'email')->where('type', '=', 2)->get();
        $companies = DB::table('users')->select('id', 'email')->where('type', '=', 3)->get();
        return view('admin.notification.create', compact('users', 'guides', 'companies'));
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'send' => 'required',
            'email' => 'nullable',
            'notification_name' => 'required',
            'notification_content' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }
        // dd($request->all());

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%?()-<>\s]+$/", $request->notification_name[1])
        && preg_match("/^[A-Za-z0-9_.,{}@#!~%()-<>\s].*[A-Za-z0-9_.,{}@#!~%?()-<>\s]+$/", $request->notification_content[1])
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->notification_name[2])
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->notification_content[2])) {
            $CustomersPush = new AdminCustomersPush();

            $type = auth()->guard('admin')->user()->id;

            if($request->send == 1){
                $users = DB::table('users')->where('active','1')->get();
                foreach($users as $user){
                    $notification = DB::table('notifications')
                        ->insertGetId([
                            'notification_image' => 'images/admin/admin_avatar.png',
                            'user_id' => $user->id,
                            'type'  => 1,
                            'type_id' => $type,
                            'is_seen' => 0
                        ]);
                    for ($i = 1; $i <= 2; $i++){
                        $description = DB::table('notification_description')
                            ->insert([
                                'notification_name' => $request->notification_name[$i],
                                'notification_content' => $request->notification_content[$i],
                                'language_id' => $i,
                                'notification_id' => $notification
                            ]);
                    }
                }
                    
                // English
                $customersTokenEN = DB::table('users')
                    ->select('token')
                    ->where('default_language', '=', 1)
                    ->where('active','1')
                    ->get();
                if($customersTokenEN->count() > 0) {
                    foreach($customersTokenEN as $customer){
                        $customersTokenArrEN[]=$customer->token;
                    }
                    $notEN = DB::table('notification_description')
                        ->select('notification_name', 'notification_content')
                        ->where('language_id', '=', 1)
                        ->where('notification_id', '=', $notification)
                        ->first();
                    $CustomersPush->send($notEN->notification_name,$notEN->notification_content,$customersTokenArrEN,'','1');
                }
                    
                // Arabic
                $customersTokenAR = DB::table('users')
                    ->select('token')
                    ->where('default_language', '=', 2)
                    ->where('active','1')
                    ->get();
                if($customersTokenAR->count() > 0) {
                    foreach($customersTokenAR as $customer){
                        $customersTokenArrAR[]=$customer->token;
                    }
                    $notAR = DB::table('notification_description')
                        ->select('notification_name', 'notification_content')
                        ->where('language_id', '=', 2)
                        ->where('notification_id', '=', $notification)
                        ->first();
                    $CustomersPush->send($notAR->notification_name,$notAR->notification_content,$customersTokenArrAR,'','1');
                }
            } elseif($request->send == 2) {
                $users = DB::table('users')->where('type', 1)->where('active','1')->get();
                foreach($users as $user){
                    $notification = DB::table('notifications')
                        ->insertGetId([
                            'notification_image' => 'images/admin/admin_avatar.png',
                            'user_id' => $user->id,
                            'type'  => 1,
                            'type_id' => $type,
                            'is_seen' => 0
                        ]);
                    for ($i = 1; $i <= 2; $i++){
                        $description = DB::table('notification_description')
                            ->insert([
                                'notification_name' => $request->notification_name[$i],
                                'notification_content' => $request->notification_content[$i],
                                'language_id' => $i,
                                'notification_id' => $notification
                            ]);
                    }
                }
                    
                // English
                $customersTokenEN = DB::table('users')
                    ->select('token')
                    ->where('default_language', '=', 1)
                    ->where('active','1')
                    ->where('type', 1)
                    ->get();
                if($customersTokenEN->count() > 0) {
                    foreach($customersTokenEN as $customer){
                        $customersTokenArrEN[]=$customer->token;
                    }
                    $notEN = DB::table('notification_description')
                        ->select('notification_name', 'notification_content')
                        ->where('language_id', '=', 1)
                        ->where('notification_id', '=', $notification)
                        ->first();
                    $CustomersPush->send($notEN->notification_name,$notEN->notification_content,$customersTokenArrEN,'','1');
                }
                    
                // Arabic
                $customersTokenAR = DB::table('users')
                    ->select('token')
                    ->where('default_language', '=', 2)
                    ->where('active','1')
                    ->where('type', 1)
                    ->get();
                if($customersTokenAR->count() > 0) {
                    foreach($customersTokenAR as $customer){
                        $customersTokenArrAR[]=$customer->token;
                    }
                    $notAR = DB::table('notification_description')
                        ->select('notification_name', 'notification_content')
                        ->where('language_id', '=', 2)
                        ->where('notification_id', '=', $notification)
                        ->first();
                    $CustomersPush->send($notAR->notification_name,$notAR->notification_content,$customersTokenArrAR,'','1');
                }
            } elseif($request->send == 3) {
                $users = DB::table('users')->where('type', 2)->where('active','1')->get();
                foreach($users as $user){
                    $notification = DB::table('notifications')
                        ->insertGetId([
                            'notification_image' => 'images/admin/admin_avatar.png',
                            'user_id' => $user->id,
                            'type'  => 1,
                            'type_id' => $type,
                            'is_seen' => 0
                        ]);
                    for ($i = 1; $i <= 2; $i++){
                        $description = DB::table('notification_description')
                            ->insert([
                                'notification_name' => $request->notification_name[$i],
                                'notification_content' => $request->notification_content[$i],
                                'language_id' => $i,
                                'notification_id' => $notification
                            ]);
                    }
                }
                    
                // English
                $customersTokenEN = DB::table('users')
                    ->select('token')
                    ->where('default_language', '=', 1)
                    ->where('active','1')
                    ->where('type', 2)
                    ->get();
                if($customersTokenEN->count() > 0) {
                    foreach($customersTokenEN as $customer){
                        $customersTokenArrEN[]=$customer->token;
                    }
                    $notEN = DB::table('notification_description')
                        ->select('notification_name', 'notification_content')
                        ->where('language_id', '=', 1)
                        ->where('notification_id', '=', $notification)
                        ->first();
                    $CustomersPush->send($notEN->notification_name,$notEN->notification_content,$customersTokenArrEN,'','1');
                }
                    
                // Arabic
                $customersTokenAR = DB::table('users')
                    ->select('token')
                    ->where('default_language', '=', 2)
                    ->where('active','1')
                    ->where('type', 2)
                    ->get();
                if($customersTokenAR->count() > 0) {
                    foreach($customersTokenAR as $customer){
                        $customersTokenArrAR[]=$customer->token;
                    }
                    $notAR = DB::table('notification_description')
                        ->select('notification_name', 'notification_content')
                        ->where('language_id', '=', 2)
                        ->where('notification_id', '=', $notification)
                        ->first();
                    $CustomersPush->send($notAR->notification_name,$notAR->notification_content,$customersTokenArrAR,'','1');
                }
            } elseif($request->send == 4) {
                $users = DB::table('users')->where('type', 3)->where('active','1')->get();
                foreach($users as $user){
                    $notification = DB::table('notifications')
                        ->insertGetId([
                            'notification_image' => 'images/admin/admin_avatar.png',
                            'user_id' => $user->id,
                            'type'  => 1,
                            'type_id' => $type,
                            'is_seen' => 0
                        ]);
                    for ($i = 1; $i <= 2; $i++){
                        $description = DB::table('notification_description')
                            ->insert([
                                'notification_name' => $request->notification_name[$i],
                                'notification_content' => $request->notification_content[$i],
                                'language_id' => $i,
                                'notification_id' => $notification
                            ]);
                    }
                }
                    
                // English
                $customersTokenEN = DB::table('users')
                    ->select('token')
                    ->where('default_language', '=', 1)
                    ->where('active','1')
                    ->where('type', 3)
                    ->get();
                if($customersTokenEN->count() > 0) {
                    foreach($customersTokenEN as $customer){
                        $customersTokenArrEN[]=$customer->token;
                    }
                    $notEN = DB::table('notification_description')
                        ->select('notification_name', 'notification_content')
                        ->where('language_id', '=', 1)
                        ->where('notification_id', '=', $notification)
                        ->first();
                    $CustomersPush->send($notEN->notification_name,$notEN->notification_content,$customersTokenArrEN,'','1');
                }
                    
                // Arabic
                $customersTokenAR = DB::table('users')
                    ->select('token')
                    ->where('default_language', '=', 2)
                    ->where('active','1')
                    ->where('type', 3)
                    ->get();
                if($customersTokenAR->count() > 0) {
                    foreach($customersTokenAR as $customer){
                        $customersTokenArrAR[]=$customer->token;
                    }
                    $notAR = DB::table('notification_description')
                        ->select('notification_name', 'notification_content')
                        ->where('language_id', '=', 2)
                        ->where('notification_id', '=', $notification)
                        ->first();
                    $CustomersPush->send($notAR->notification_name,$notAR->notification_content,$customersTokenArrAR,'','1');
                }
            } else {
                $notification = DB::table('notifications')
                    ->insertGetId([
                        'notification_image' => 'images/admin/admin_avatar.png',
                        'user_id' => $request->email,
                        'type'  => 1,
                        'type_id' => $type,
                        'is_seen' => 0
                    ]);
                for ($i = 1; $i <= 2; $i++){
                    $description = DB::table('notification_description')
                        ->insert([
                            'notification_name' => $request->notification_name[$i],
                            'notification_content' => $request->notification_content[$i],
                            'language_id' => $i,
                            'notification_id' => $notification
                        ]);
                }
                $customersToken = DB::table('users')->select('token')->where('active','1')->where('id',$request->email)->get();
                foreach($customersToken as $customer){
                    $customersTokenArr[]=$customer->token;
                }
                $getUserLanguage = DB::table('users')->select('default_language')->where('id', '=', $request->email)->first();
                $not = DB::table('notification_description')
                    ->select('notification_name', 'notification_content')
                    ->where('language_id', '=', $getUserLanguage->default_language)
                    ->where('notification_id', '=', $notification)
                    ->first();
                $CustomersPush->send($not->notification_name,$not->notification_content,$customersTokenArr,'','1');
            }

        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->notification_name[1]) 
            && !preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->notification_content[1])) {
                $error = trans('admin.name or description content must be contain only english characters');
            } else {
                $error = trans('admin.name or description content must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $message = session()->get('locale') == 'ar' ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroy($id){
        $notifications = DB::table('notifications')->where('notification_id', '=', $id)->delete();
        $description = DB::table('notification_description')->where('notification_id', '=', $id)->delete();
    }
}
