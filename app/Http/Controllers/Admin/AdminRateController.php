<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminRateController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->rate_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('guideRate', 'tripRate');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->rate_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }
    
    public function guideRate(){
        $rates = DB::table('rates')
            ->join('users', 'users.id', '=', 'rates.user_id')
            ->where('rates.type', '=', 1)
            // ->where('type_id', '=', $type_id)
            ->select('rate_id as id', 'name', 'rate_content as content', 'rate_star as star')
            ->orderBy('rate_id', 'desc')
            ->get();
            // dd($rates);
        return view('admin.rate.index', compact('rates'));
    }

    public function TripRate(){
        $rates = DB::table('rates')
            ->join('users', 'users.id', '=', 'rates.user_id')
            ->select('rate_id as id', 'name', 'rate_content as content', 'rate_star as star')
            ->where('rates.type', '=', 2)
            // ->where('type_id', '=', $type_id)
            ->orderBy('rate_id', 'desc')
            ->get();
        return view('admin.rate.index', compact('rates'));
    }

    public function destroy(Request $request, $id){
        $rate = DB::table('rates')->where('rate_id', '=', $id)->delete();
    }

}
