<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminPageController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->page_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->page_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');
    }
    
    public function index(){
        $pages = DB::table('pages')
            ->join('page_description', 'page_description.page_id', '=', 'pages.page_id')
            ->select('pages.page_id as id', 'page_description_name as name', 'page_description_content as content')
            ->where('language_id', '=', language())
            ->orderBy('pages.page_id', 'asc')
            ->get();
        return view('admin.page.index', compact('pages'));
    }

    public function edit($id){
        $pages = DB::table('pages')
            ->join('page_description', 'page_description.page_id', '=', 'pages.page_id')
            ->select('pages.page_id as id', 'page_description_name as name', 'page_description_content as content')
            ->where('pages.page_id', '=', $id)
            ->get();

        return view('admin.page.edit', compact('pages'));
    }

    public function update(Request $request, $id){
        $validator = validator()->make($request->all(), [
            'page_description_name' => 'required',
            'page_description_content' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->with('error', $error);
        }

        for ($i = 1; $i <= 2; $i++){
            $description = DB::table('page_description')
                ->where('page_id', '=', $id)
                ->where('language_id', '=', $i)
                ->update([
                    'page_description_name' => $request->page_description_name[$i],
                    'page_description_content' => $request->page_description_content[$i],
                ]);
        }

        $message = \App::isLocale('ar') ? 'تم التعديل بنجاح' : 'Updated Successfully';

        return Redirect::back()->with('message', $message);
    }

}
