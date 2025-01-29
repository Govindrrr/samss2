<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacultyResource;
use App\Http\Resources\LevelRecource;
use App\Models\Classroom;
use App\Models\Esetup;
use App\Models\Exam;
use App\Models\Faculty;
use App\Models\Level;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function students(){
        $students = Student::all();
        return response()->json($students);
    }
    public function studendsByLC($level,$classroom){
        $students = Student::where('level_id',$level)->where('classroom_id',$classroom)->get();
        return response()->json($students);
    }
    public function Faculty(){
        $students = Faculty::all();
        return FacultyResource::collection($students);
    }
    public function LevelsByFaculty($faculty){
        $levels = Level::where('faculty_id',$faculty)->get();
        return LevelRecource::collection($levels);
    }
    public function ClassroomByLevel($level){
        $students = Classroom::where('level_id',$level)->get();
        return response()->json($students);
    }
    public function Exams(){
        $students = Exam::first();
        // dd($students);
        return response()->json($students);
    }
    public function SubjectsByLevel($id){
        $subjects = Subject::with('levels')->findOrFail($id);
        return response()->json($subjects);
    }
    public function CreateMarks(Request $req){
        $validate = $req->validate([
            'level_id'=>'required',
            'student_id'=>'required',
            'roll_no'=>'required',
            'subject_id'=>'required',
            'faculty_id'=>'required',
            'exam_id'=>'required',
            'marks'=>'required',
            'classroom_id'=>'required',
        ]);
        $esetup = Esetup::where('level_id',$req->level_id)
        ->where('faculty_id', $req->faculty_id)
        ->where('exam_id', $req->exam_id)
        ->whereHas('subjects', function ($query) use ($req) {
            $query->where('subject_id', $req->subject_id);})->first();

            $mark = new Mark();
            $mark->student_id = $req->student_id;
            $mark->roll_no = $req->roll_no;
            $mark->level_id = $req->level_id;
            $mark->subject_id = $req->subject_id;
            // $mark->faculty_id = $req->faculty_id;
            $mark->exam_id = $req->exam_id;
            $mark->classroom_id = $req->classroom_id;
            // $mark->classroom_id = $req->classroom_id;
            
            $mark->full_mark = $esetup->Tr_full_mark;
            $mark->pass_mark = $esetup->Tr_pass_mark;
            $mark->marks = $req->marks;
            $mark->save();
            return response()->json($esetup);
    }
}
