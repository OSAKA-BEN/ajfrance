<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Calendar;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\Rtl;
use App\Http\Livewire\CalendarManagement;
use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\UserManagement;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/login');
});

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/calendar', Calendar::class)->name('calendar');
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/user-profile', UserProfile::class)->name('user-profile');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users-management', UserManagement::class)->name('users-management');
    Route::get('/calendar-management', CalendarManagement::class)->name('calendar-management');
    // Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    // Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
});

Route::middleware(['auth', 'role:teacher,admin'])->group(function () {
    // Routes accessibles aux profs et admins
});

