<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;


class AdminSubscribeController extends Controller
{

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->subscribe_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->subscribe_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }

    public function index(){
        $subscribes = DB::table('subscribes')->select('subscribe_id as id', 'subscribe_email')->get();
        return view('admin.subscribe.index', compact('subscribes'));
    }

    public function destroy($id){
        DB::table('subscribes')->where('subscribe_id', '=', $id)->delete();
    }
}
