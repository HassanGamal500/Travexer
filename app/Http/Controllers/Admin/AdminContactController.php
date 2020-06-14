<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminContactController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->contact_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('indexWeb', 'indexPhone');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->contact_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }
    
    public function indexWeb(){
        $contacts = DB::table('contacts')
            ->select('contact_id as id', 'contact_name', 'contact_email', 'contact_phone', 'contact_subject', 'contact_message')
            ->where('contact_from', '=', 1)
            ->orderBy('contact_id', 'desc')
            ->get();
        $readAll = DB::table('contacts')->update(['contact_read' => 1]);
        return view('admin.contact.indexWeb', compact('contacts'));
    }

    public function indexPhone(){
        $contacts = DB::table('contacts')
            ->select('contact_id as id', 'contact_name', 'contact_email', 'contact_phone', 'contact_subject', 'contact_message')
            ->where('contact_from', '=', 0)
            ->orderBy('contact_id', 'desc')
            ->get();
        $readAll = DB::table('contacts')->update(['contact_read' => 1]);
        return view('admin.contact.indexPhone', compact('contacts'));
    }

    // public function getContacts(){
    //     $type = auth()->guard('admin')->user()->id;
    //     $contacts = DB::table('contacts')->where('admin_id', '=', $type)->where('contact_read', '=', 0)->orderBy('contact_id', 'desc')->count();
    //     return response()->json($contacts);
    // }

    // public function contact_notify(){
    //     $type = auth()->guard('admin')->user()->id;
    //     $contacts = DB::table('contacts')->where('admin_id', '=', $type)->where('notify_read', '=', 0)->count();
    //     $update = DB::table('contacts')->where('admin_id', '=', $type)->where('notify_read', '=', 0)->update(['notify_read' => 1]);
    //     return response()->json($contacts);
    // }

    public function destroy(Request $request, $id){
        $contacts = DB::table('contacts')
            ->where('contact_id', '=', $id)
            ->delete();
    }
}
