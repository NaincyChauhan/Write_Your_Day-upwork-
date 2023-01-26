<?php

use Illuminate\Support\Facades\Route;


// Site Controller
use App\Http\Controllers\Site\HomeController as SiteHomeController;
use App\Http\Controllers\Site\UserController as SiteUserController;

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

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});

//Website Routes
Auth::routes();
Route::post('login-user', [SiteUserController::class, 'loginuser'])->name('loginuser');
Route::post('registeruser', [SiteUserController::class, 'registeruser'])->name('registeruser');
Route::get('forgotmypassword', [SiteUserController::class, 'forgetPasswordView'])->name('forget-password-view');
Route::post('forget-password', [SiteUserController::class, 'forgetPassword'])->name('forget-password');

// password/reset

// User Routes
Route::group(['middleware' => ['auth:sanctum',  'verified']], function () {
    Route::get('/', [SiteHomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth:sanctum',  'verified', 'role']], function () {

    // Admin Panel
    Route::group(['prefix' => 'admin'], function(){
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');        

        // Messages
        Route::resource('message', MessageController::class);
        
        // Policies
        Route::group(["prefix" => "policy"], function(){
            Route::get('terms-and-conditions',[SettingController::class, 'terms'])->name('policy.update.term');
            Route::post('terms-and-conditions', [SettingController::class, 'termsUpdate'])->name('policy.update.term-update');
            
            //Privacy Policy
            Route::get('privacy-policy', [SettingController::class, 'policy'])->name('policy.update.policy');
            Route::post('privacy-policy', [SettingController::class, 'policyUpdate'])->name('policy.update.policy-update');
            
            //Privacy Policy
            Route::get('refund-policy', [SettingController::class, 'refund'])->name('refund.update.policy');
            Route::post('refund-policy', [SettingController::class, 'refundUpdate'])->name('refund.update.refund-update');
        });

        // about
        Route::group(["prefix" => "about"], function(){
            Route::get('about-us',[AboutController::class, 'about'])->name('about.index');
            Route::post('about-us', [AboutController::class, 'aboutUpdate'])->name('about.update');
            
            // Director Message
            Route::get('director-message',[AboutController::class, 'directorMessage'])->name('directorMessage.index');
            Route::post('director-message', [AboutController::class, 'directorMessageUpdate'])->name('directorMessage.update');
        });
        
        Route::group(["prefix" => "setting"], function(){
            //Setting
            Route::get('update-setting', [SettingController::class, 'setting'])->name('update-setting');
            Route::post('update-setting', [SettingController::class, 'settingUpdate'])->name('setting-update');
        });

        //Ajax
        Route::group(["prefix" => "ajax"], function(){
            
        });
        Route::get('change-password', [UserController::class, 'changePassword'])->name('change-password');
    });
});
