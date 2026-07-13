<?php

use App\Livewire\Faculty\Index as Faculty_Index;

use App\Models\Faculty;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\AcadeYear\Index as Academ_Year_Index;
use App\Livewire\Department\Index as Department_Index;
use App\Livewire\Promotion\Index as Promotion_Index;
use App\Livewire\Enrollment\Index as Enrollment_Index;
use App\Livewire\Enrollment\Edit as Enrollement_Edit;
use App\Livewire\Enrollment\Create as Enrollment_Create;
use App\Livewire\Student\Index as Student_Index;
use App\Livewire\Student\Edit as Students_Edit;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// APPARITAIRE
Route::get('/Inscriptions/create', Enrollment_Create::class)->name('enrollment.create')->middleware('auth');
Route::get('/Inscriptions', Enrollment_Index::class)->name('enrollment.index')->middleware('auth');
Route::get('/Inscriptions/{enrollment}/edit', Enrollement_Edit::class)->name('enrollment.edit')->middleware('auth');

// Students
Route::get('/Etudiants/all', Student_Index::class)->name('student.index')->middleware('auth');
Route::get('/Etudiants/create', App\Livewire\Student\Create::class)->name('student.create')->middleware('auth');
Route::get('/Etudiants/{student:matricule}/edit', Students_Edit::class)->name('student.edit')->middleware('auth');
// Route::get('/Inscriptions', Enrollment_Index::class)->name('enrollment.index')->middleware('auth');


Route::prefix('admin')->group(function () {

    // Payment
    Route::get('/paiements', App\Livewire\Payment\Index::class)->name('admin.payments');
    Route::get('/paiements/{payment}/edit', App\Livewire\Payment\Edit::class)->name('payment.edit');

    Route::get('/payments', App\Livewire\Payment\Index::class)->name('payment.index');
    Route::get('/payments/create', App\Livewire\Payment\Create::class)->name('payment.create');
    Route::get('/payments/{payment}', App\Livewire\Payment\Show::class)->name('payment.show');
    Route::get('/payments/{payment}/receipt', App\Http\Controllers\Payment\Receipt::class)->name('payment.receipt');


})->middleware('auth');

Route::prefix('admin.setting')->group(function () {
    Route::get('/faculties', Faculty_Index::class)->name('admin.faculty');
    Route::get('/AcademiqueYears', Academ_Year_Index::class)->name('admin.academic_year');
    Route::get('/Departements', Department_Index::class)->name('admin.department');
    Route::get('/Promotions', Promotion_Index::class)->name('admin.promotion');
    Route::get('/fees', App\Livewire\Settings\Fees::class)->name('admin.fee');


})->middleware('auth');

Route::middleware(['auth'])->group(function () {

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
