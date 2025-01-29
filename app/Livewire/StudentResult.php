<?php

namespace App\Livewire;

use App\Models\Mark;
use App\Models\Student;
use Niklasravnsborg\LaravelPdfMerger\Facades\PdfMerger;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use LynX39\LaraPdfMerger\PdfMergerServiceProvider;

class StudentResult extends Component

{
    public $stds;

    public function mount()
    {
        $records = session('selected_records');
        $this->stds = Student::whereIn('id', $records)->get(['id', 'first_name']);
        // dd($this->stds);

    }
    public function Pdf()
    {

        dd($this->stds);
        $pdfs = [];
        foreach ($this->stds as $student) {
            $Marks = Mark::where('student_id', $student->id)->where('exam_id', session('exam'))->get();
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
                'total' => $total,
            ];

            $pdf = Pdf::loadView('studentsresult', $data);
            $pdfs += $pdf;
        }
        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'results.pdf');
    }
    public function render()
    {
        return view('livewire.student-result')->layout('layouts.app');
    }
}
