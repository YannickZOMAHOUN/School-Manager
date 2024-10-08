<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

// Routes d'authentification
Auth::routes();
use App\Http\Controllers\LocationController;
Route::resource('locations', LocationController::class);
Route::get('locations/departments/{countryId}', [LocationController::class, 'getDepartments']);
Route::get('locations/cities/{departmentId}', [LocationController::class, 'getCities']);

use App\Http\Controllers\SchoolController;
Route::get('/departments/{countryId}', [SchoolController::class, 'getDepartments']);
Route::get('/cities/{departmentId}', [SchoolController::class, 'getCities']);


// Redirection vers la page de connexion
Route::get('/', function () { return redirect('login');});

// Routes accessibles sans authentification
Route::resource('school', \App\Http\Controllers\SchoolController::class);
Route::get('/get-roles', [\App\Http\Controllers\Auth\RegisterController::class, 'getRoles'])->name('getRoles');
// Groupe de routes protégées par le middleware `auth` (utilisateur doit être connecté)
Route::group(['middleware' => ['auth']], function () {

    // Routes nécessitant la vérification 2FA après la connexion
    Route::group(['middleware' => ['two_fa']], function () {
        Route::resource('dashboard', \App\Http\Controllers\HomeController::class);
        Route::resource('classroom', \App\Http\Controllers\ClassroomController::class);
        Route::resource('student', \App\Http\Controllers\StudentController::class);
        Route::resource('note', \App\Http\Controllers\NoteController::class);
        Route::resource('year', \App\Http\Controllers\YearController::class);
        Route::resource('subject', \App\Http\Controllers\SubjectController::class);
        Route::resource('ratio', \App\Http\Controllers\RatioController::class);
        Route::resource('staff', \App\Http\Controllers\StaffController::class);
        Route::resource('user', \App\Http\Controllers\UserController::class);

        Route::get('/file-import', [\App\Http\Controllers\StudentController::class, 'importView'])->name('import_view');
        Route::post('/import', [\App\Http\Controllers\StudentController::class, 'import'])->name('import');

        Route::get('/get-students', [\App\Http\Controllers\NoteController::class, 'getStudents'])->name('get.students');
        Route::get('/get-ratio', [\App\Http\Controllers\NoteController::class, 'getRatio'])->name('get.ratio');
        Route::get('/get-student-notes', [\App\Http\Controllers\NoteController::class, 'getStudentNotes'])->name('get.student.notes');
        Route::get('/get-class-students', [\App\Http\Controllers\NoteController::class, 'getClassStudents'])->name('get.class.students');

        Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'show'])->name('notes.show');
        Route::get('/students/lists', [\App\Http\Controllers\StudentController::class, 'getStudentLists'])->name('get.student.lists');
        Route::get('/notes/load', [\App\Http\Controllers\NoteController::class, 'loadNotes'])->name('notes.load');
        Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'getNotes'])->name('get.notes');
        // Génération de PDF (classement et bulletins)
        Route::post('/classement/generer', [\App\Http\Controllers\NoteController::class, 'generateRankingPDF'])->name('ranking.generate');
        Route::post('/generation-bulletins', [\App\Http\Controllers\NoteController::class, 'generateBulletinsPDF'])->name('bulletins.generate');
        Route::get('/bulletins', [\App\Http\Controllers\NoteController::class, 'getcards'])->name('get.cards');

        // Suppression massive de ratios
        Route::delete('/ratios/destroy-all', [\App\Http\Controllers\RatioController::class, 'destroyAll'])->name('ratios.destroy.all');

        Route::get('disable/{year}',[\App\Http\Controllers\YearController::class,'disableyear'])->name('disable_year');
        Route::get('activate/{year}',[\App\Http\Controllers\YearController::class,'activateyear'])->name('activate_year');
    });

    // Routes protégées nécessitant uniquement l'authentification, pas de 2FA
    // Ajoutez ici d'autres routes si nécessaire
});

// Routes pour la vérification du 2FA
Route::get('/two_fa/verify', [\App\Http\Controllers\Auth\TwoFactorController::class, 'showVerifyForm'])->name('two_fa.verify');
Route::post('/two_fa/verify', [\App\Http\Controllers\Auth\TwoFactorController::class, 'verify'])->name('two_fa.verify.post');
