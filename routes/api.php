<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/students', [ApiController::class,'students']);
Route::get('/school', [ApiController::class,'School']);
Route::get('/slidder',[ApiController::class,'Slidder']);
Route::get('/exam', [ApiController::class,'Exams']);
Route::get('/faculties', [ApiController::class,'Faculty']);
Route::get('/level/{id}', [ApiController::class,'LevelsByFaculty']);
Route::get('/section/{id}', [ApiController::class,'ClassroomByLevel']);
Route::get('/subjects/{id}', [ApiController::class,'SubjectsByLevel']);
Route::post('/create-marks', [ApiController::class,'CreateMarks']);
Route::get('/students/level/{id}/section/{sectionid}', [ApiController::class,'studendsByLC']);