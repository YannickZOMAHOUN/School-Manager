<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('dashboard', \App\Http\Controllers\HomeController::class);
Route::resource('classroom', \App\Http\Controllers\ClassroomController::class);
Route::resource('student', \App\Http\Controllers\StudentController::class);
Route::resource('note', \App\Http\Controllers\NoteController::class);
Route::resource('year', \App\Http\Controllers\YearController::class);
Route::resource('subject', \App\Http\Controllers\SubjectController::class);
Route::resource('ratio', \App\Http\Controllers\RatioController::class);
Route::get('/file-import',[\App\Http\Controllers\StudentController::class,'importView'])->name('import_view');
Route::post('/import',[\App\Http\Controllers\StudentController::class,'import'])->name('import');
// web.php
Route::get('/get-students', [\App\Http\Controllers\NoteController::class, 'getStudents'])->name('get.students');
Route::get('/get-ratio', [\App\Http\Controllers\NoteController::class, 'getRatio'])->name('get.ratio');
Route::get('/get-student-notes', [\App\Http\Controllers\NoteController::class, 'getStudentNotes'])->name('get.student.notes');
Route::get('/get-class-students', [\App\Http\Controllers\NoteController::class, 'getClassStudents'])->name('get.class.students');
Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'show'])->name('notes.show');
Route::get('/students/lists', [\App\Http\Controllers\StudentController::class, 'getStudentLists'])->name('get.student.lists');
