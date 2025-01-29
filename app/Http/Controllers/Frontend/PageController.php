<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\bar;
use App\Models\Notice;
use App\Models\Result;
use App\Models\School;
use App\Models\slidder;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function __construct()
    {
        $school = School::first();
        $bars = bar::all();
        View::share([
            "school"=>$school,
            "bars"=>$bars,
        ]);
    }
    public function home(){
        $slidders = slidder::all();
        $staff = Staff::first();
        
        // return $staff;
        return view('frontend.home',compact('slidders','staff'));
    }
    public function notice(){
        $notices = Notice::orderBy('id','desc')->limit('5')->get();
        // return $notices;
        return view('frontend.notice',compact('notices'));
    }
    public function notices($id){
        $user = $id;
        $notices = Notice::orderBy('id','desc')->limit('5')->get();
        $noti = Notice::find($id);
        // return $user;
        return view('frontend.notices',compact('notices','noti'));

    }
    public function result(){
        $results = Result::orderBy('level_id','asc')->get();
        return view('frontend.result',compact('results'));
    }
    public function results($id){
        $results = Result::orderBy('level_id','asc')->get();
        $resu = Result::find($id);
        return view('frontend.results',compact('results','resu'));
    }

   
    public function faculty(){
        return "faculties dead";
    }
    public function addmission(){
        return "faculties dead";
    }
    public function gallery(){
        return "faculties dead";
    }
    public function aboutus(){
        return "faculties dead";
    }
}
