<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('years', [\App\Http\Controllers\YearController::class, 'index']);
Route::get('classrooms', [\App\Http\Controllers\ClassroomController::class, 'index']);
Route::get('students', [\App\Http\Controllers\StudentController::class, 'index']);
Route::get('subjects', [\App\Http\Controllers\SubjectController::class, 'index']);
Route::get('ratio', [\App\Http\Controllers\RatioController::class, 'show']);
Route::post('notes', [\App\Http\Controllers\NoteController::class, 'store']);
