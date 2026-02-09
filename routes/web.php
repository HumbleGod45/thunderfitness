<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminTrainerController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminAnnouncementController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainerDashboardController;
use App\Http\Controllers\TrainerProfileController;
use App\Http\Controllers\TrainerWorkoutController;
use App\Http\Controllers\TrainerWorkoutSidebarController;
use App\Http\Controllers\TrainerWorkoutHistoryController;
use App\Http\Controllers\WorkoutLogController;
use App\Http\Controllers\MemberWorkoutController;
use App\Http\Controllers\MemberWorkoutHistoryController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('home', [
    'title' => 'Thunder Fitness'
]));

Route::get('/pricelist', fn () => view('pricelist', [
    'title' => 'Pricelist | Thunder Fitness'
]));

Route::get('/trainer', [TrainerController::class, 'index'])
    ->name('trainer.public');

Route::get('/about', fn () => view('about', [
    'title' => 'Tentang Kami | Thunder Fitness'
]));


/*
|--------------------------------------------------------------------------
| HALAMAN AUTENTIKASI
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // HOME / DASHBOARD
        Route::get('/home', [AdminMemberController::class, 'index'])
            ->name('home');

        // MEMBERS
        Route::get('/members', [AdminMemberController::class, 'index'])
            ->name('members');

        Route::put('/members/{member}', [AdminMemberController::class, 'update'])
            ->name('members.update');

        Route::delete('/members/{member}', [AdminMemberController::class, 'destroy'])
            ->name('members.destroy');

        // TRAINER
        Route::get('/trainer', [AdminTrainerController::class, 'index'])
            ->name('trainer');

        Route::post('/trainer', [AdminTrainerController::class, 'store'])
            ->name('trainer.store');

        Route::put('/trainer/{trainer}', [AdminTrainerController::class, 'update'])
            ->name('trainer.update');

        Route::delete('/trainer/{id}', [AdminTrainerController::class, 'destroy'])
            ->name('trainer.destroy');
            
        // LAPORAN
        Route::get('/laporan', [AdminLaporanController::class, 'index'])
            ->name('laporan.index');

        // ANNOUNCEMENTS (RESOURCE)
        Route::resource('announcements', AdminAnnouncementController::class)
            ->except(['show']);
    });


/*
|-------------------------------------------------------------------------
| TRAINER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:trainer'])
    ->prefix('trainer')
    ->group(function () {

        Route::get('/home', [TrainerDashboardController::class, 'home'])
            ->name('trainer.home');
        
        Route::get('/members/{member}', [TrainerDashboardController::class, 'detail'])
            ->name('trainer.members.detail');

        Route::get('/profile', [TrainerProfileController::class, 'index'])
            ->name('trainer.profile');

        Route::put('/profile', [TrainerProfileController::class, 'update'])
            ->name('trainer.profile.update');

        Route::put('/profile/reset-password', [TrainerProfileController::class, 'resetPassword'])
            ->name('trainer.profile.reset-password');
        
        Route::get('/members/{member}/workouts/create', [TrainerWorkoutController::class, 'create'])
            ->name('trainer.workouts.create');

        Route::post('/members/{member}/workouts', [TrainerWorkoutController::class, 'store'])
            ->name('trainer.workouts.store');
        
        Route::get('/latihan', [TrainerWorkoutSidebarController::class, 'create'])
            ->name('trainer.workouts.sidebar.create');

        Route::post('/latihan', [TrainerWorkoutSidebarController::class, 'store'])
            ->name('trainer.sidebar.workouts.store');

        Route::get('/history', [TrainerWorkoutHistoryController::class, 'index'])
            ->name('trainer.history.index');

        Route::get('/history/{member}', [TrainerWorkoutHistoryController::class, 'show'])
            ->name('trainer.history.show');

    });

/*
|--------------------------------------------------------------------------
| MEMBER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->group(function () {

        Route::get('/home', [MemberDashboardController::class, 'home'])
            ->name('member.home');

        Route::get('/profile', [MemberProfileController::class, 'show'])
            ->name('member.profile');

        Route::put('/profile/update', [MemberProfileController::class, 'update'])
            ->name('member.profile.update');

        Route::put('/password', [MemberProfileController::class, 'changePassword'])
            ->name('member.password.update');
        
        Route::get('/workouts/create', [MemberWorkoutController::class, 'create'])
            ->name('member.workouts.create');

        Route::post('/workouts', [MemberWorkoutController::class, 'store'])
            ->name('member.workouts.store');

        Route::get('/workouts/history', [MemberWorkoutHistoryController::class, 'index'])
            ->name('member.workouts.history');
    });
