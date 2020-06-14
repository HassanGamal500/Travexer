<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;


class AdminFaqController extends Controller
{

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->faq_view == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('index');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->faq_create == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('create', 'store');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->faq_update == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('edit', 'update');

        $this->middleware(function ($request, $next) {
            if(auth()->guard('admin')->user()->type != 1) {
                $role = DB::table('manage_role')->where('admin_id', '=', auth()->guard('admin')->user()->id)->first();
                if($role->faq_delete == 0){
                    return abort(404);
                }
            }
            return $next($request);
        })->only('destroy');
    }

    public function index(){
        $faqs = DB::table('faqs')
            ->join('faq_description', 'faq_description.faq_id', 'faqs.faq_id')
            ->select('faqs.faq_id as id', 'faq_question', 'status')
            ->where('language_id', '=', language())
            ->orderBy('faqs.faq_id','desc')
            ->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create(){
        return view('admin.faq.create');
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'faq_question' => 'required',
            'faq_answer' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%?()-<>\s].*[A-Za-z0-9_.,{}@#!~%?()-<>\s]+$/", $request->faq_question[1])
        && preg_match("/^[A-Za-z0-9_.,{}@#!~%?()-<>\s].*[A-Za-z0-9_.,{}@#!~%?()-<>\s]+$/", $request->faq_answer[1])
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->faq_question[2])
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->faq_answer[2])) {
            $faq = DB::table('faqs')->insertGetId([
                'status'	  =>   1,
            ]);

            for ($i = 1; $i <= 2; $i++){
                DB::table('faq_description')->insert([
                    'faq_question'  =>  $request->faq_question[$i],
                    'faq_answer'    =>  $request->faq_answer[$i],
                    'faq_id'        =>  $faq,
                    'language_id'   =>  $i,
                ]);
            }

        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->faq_question[1]) 
            && !preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->faq_answer[1])) {
                $error = trans('admin.the question or answer must be contain only english characters');
            } else {
                $error = trans('admin.the question or answer must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $message = App::isLocale('ar') ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function edit($id) {
        $faqs = DB::table('faqs')
            ->leftjoin('faq_description', 'faq_description.faq_id', 'faqs.faq_id')
            ->where('faqs.faq_id', $id)
            ->select('faqs.faq_id as id', 'faq_question', 'faq_answer')
            ->get();

        return view('admin.faq.edit', compact('faqs'));
    }

    public function update(Request $request, $id) {
        $validator = validator()->make($request->all(), [
            'faq_question' => 'required',
            'faq_answer' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        if(preg_match("/^[A-Za-z0-9_.,{}@#!~%?()-<>\s].*[A-Za-z0-9_.,{}@#!~%?()-<>\s]+$/", $request->faq_question[1])
        && preg_match("/^[A-Za-z0-9_.,{}@#!~%?()-<>\s].*[A-Za-z0-9_.,{}@#!~%?()-<>\s]+$/", $request->faq_answer[1])
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->faq_question[2])
        && !preg_match("/^[A-Za-z].*[A-Za-z]+$/", $request->faq_answer[2])) {
            for ($i = 1; $i <= 2; $i++){
                DB::table('faq_description')
                    ->where('faq_id', '=', $id)
                    ->where('language_id', '=', $i)
                    ->update([
                        'faq_question'  =>   $request->faq_question[$i],
                        'faq_answer'    =>   $request->faq_answer[$i],
                    ]);
            }
        } else {
            if(!preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->faq_question[1]) 
            && !preg_match("/^[A-Za-z0-9].*[A-Za-z0-9]+$/", $request->faq_answer[1])) {
                $error = trans('admin.the question or answer must be contain only english characters');
            } else {
                $error = trans('admin.the question or answer must be contain only arabic characters');
            }
            return Redirect::back()->withInput($request->all())->with('error', $error);
        }

        $message = App::isLocale('ar') ? 'تم التسجيل بنجاح' : 'Inserted Successfully';

        return Redirect::back()->with('message', $message);
    }

    public function destroy($id){
        DB::table('faqs')->where('faq_id', $id)->delete();
        DB::table('faq_description')->where('faq_id', '=', $id)->delete();
    }
}
