<?php

use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProfileController;
use App\Livewire\MarkPage;
use App\Livewire\StudentResult;
use App\Models\Mark;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function(){
    Route::get('/','home')->name('home');
    Route::get('/notice','notice')->name('notice');
    Route::get('/notices/{id}','notices')->name('notices');
    Route::get('/result','result')->name('result');
    Route::get('/results/{id}','results')->name('results');
    Route::get('/faculty','faculty')->name('faculty');
    Route::get('/gallery','gallery')->name('gallery');
    Route::get('/addmission','addmission')->name('addmission');
    Route::get('/aboutus','aboutus')->name('aboutus');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/users', [MarkPage::class]);
Route::get('/admin/result/{student}', function ($std) {
    $students = $std;

    $Marks = Mark::where('student_id', $students)->get();
    $total = 0;
    $totalmark = 0;
    $result = 1;

    foreach ($Marks as $mark) {
        $total = $total + $mark->marks;
        $totalmark = $totalmark + $mark->full_mark;
        if ($mark->marks < $mark->pass_mark) {
            $result = 0;
        }
    }
    $percentage = ($total / $totalmark) * 100;
    $gpa = $percentage / 25;

    return view('studentresult', compact('Marks', 'total', 'gpa', 'result'));
})->name('student.show');

Route::get('admin/results/student', StudentResult::class)->name('students-result');
// Route::get('admin/results/student/',function(){
//     $students = session()->get('selected_records');
//     $Marks = [];

//     foreach ($students as $key => $student) {
//         $Marks = Mark::where('student_id', $student)->get();
//     }



//     return view('studentsresult',compact('students','Marks'));
// })->name('students-result');
