<?php

declare(strict_types=1);

use App\Http\Controllers\Backend\ActionLogController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ModulesController;
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\ProfilesController;
use App\Http\Controllers\Backend\TranslationController;
use App\Http\Controllers\Backend\UserLoginAsController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes.
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('roles', RolesController::class);

    // Hotel Routes.
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
    Route::get('/hotels/create', [HotelController::class, 'create'])->name('hotels.create');
    Route::post('/hotels', [HotelController::class, 'store'])->name('hotels.store');
    Route::get('/hotels/{hotel}/edit', [HotelController::class, 'edit'])->name('hotels.edit');
    Route::put('/hotels/{hotel}', [HotelController::class, 'update'])->name('hotels.update');
    Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy'])->name('hotels.destroy');

     // Room-Type Routes.
    Route::resource('room-types', RoomTypeController::class)->except(['show']);
    Route::resource('rooms', RoomController::class)->except(['show']);

    // Permissions Routes.
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{id}', [PermissionsController::class, 'show'])->name('permissions.show');

    // Modules Routes.
    Route::get('/modules', [ModulesController::class, 'index'])->name('modules.index');
    Route::post('/modules/toggle-status/{module}', [ModulesController::class, 'toggleStatus'])->name('modules.toggle-status');
    Route::post('/modules/upload', [ModulesController::class, 'upload'])->name('modules.upload');
    Route::delete('/modules/{module}', [ModulesController::class, 'destroy'])->name('modules.delete');

    // Settings Routes.
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

    // Translation Routes
    Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::post('/translations', [TranslationController::class, 'update'])->name('translations.update');
    Route::post('/translations/create', [TranslationController::class, 'create'])->name('translations.create');

    // Login as & Switch back
    Route::resource('users', UsersController::class);
    Route::get('users/{id}/login-as', [UserLoginAsController::class, 'loginAs'])->name('users.login-as');
    Route::post('users/switch-back', [UserLoginAsController::class, 'switchBack'])->name('users.switch-back');

    // Action Log Routes.
    Route::get('/action-log', [ActionLogController::class, 'index'])->name('actionlog.index');
});

/**
 * Profile routes.
 */
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    Route::get('/edit', [ProfilesController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfilesController::class, 'update'])->name('update');
});

Route::get('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');
