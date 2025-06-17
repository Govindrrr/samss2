<?php

namespace App\Livewire;

use App\Models\Mark;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class StudentResult extends Component

{
    public $stds;

    public function mount()
    {
        $records = session('selected_records');
        // dd($records);
        $this->stds = Student::whereIn('id', $records)->get();
        // dd($this->stds);
         $pdfs = [];
        $totals = [];
        foreach ($this->stds as $student) {
            $Marks = Mark::where('student_id', $student->id)->where('exam_id',session('exam'))->get();
            $total = 0;
            $totalmark = 0;

            foreach ($Marks as $mark) {
                $total = $total + $mark->marks;
                $totalmark = $totalmark + $mark->full_mark;
                if ($mark->marks < $mark->pass_mark) {
                    $result = 0;
                }
            }
            $data = [
                'stds' => $this->stds,
                // 'total' => $total,
                // 'Marks' => $Marks,
                // 'gpa' => 3.4,
                'result' => 1,
            ];
        }

    }
    public function Pdf()
    {

        // dd($this->stds);
        $pdfs = [];
        $totals = [];
        foreach ($this->stds as $student) {
            $Marks = Mark::where('student_id', $student->id)->where('exam_id',session('exam'))->get();
            $total = 0;
            $totalmark = 0;

            foreach ($Marks as $mark) {
                $total = $total + $mark->marks;
                $totalmark = $totalmark + $mark->full_mark;
                if ($mark->marks < $mark->pass_mark) {
                    $result = 0;
                }
            }
            $data = [
                'stds' => $this->stds,
                // 'total' => $total,
                // 'Marks' => $Marks,
                // 'gpa' => 3.4,
                'result' => 1,
            ];

            $pdf = Pdf::loadView('studentsresult', $data);
            $pdfs = Pdf::loadView('studentsresult', $data);
            
        }
        return response()->streamDownload(function() use($pdfs){
            echo $pdfs->stream();
        },'results.pdf');
    }
    public function render()
    {
        return view('livewire.student-result')->layout('layouts.app');
    }
}
