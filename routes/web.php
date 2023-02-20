<?php

use Illuminate\Support\Facades\Route;


// Site Controller
use App\Http\Controllers\Site\HomeController as SiteHomeController;
use App\Http\Controllers\Site\UserController as SiteUserController;
use App\Http\Controllers\Site\PostController as SitePostController;
use App\Http\Controllers\HelpcenterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikecommentController;
use App\Http\Controllers\SavepostController;
use App\Http\Controllers\FollowuserController;

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
Route::get('forget/password', [SiteUserController::class, 'forgetPasswordView'])->name('forget-password-view');
Route::post('forget-password', [SiteUserController::class, 'forgetPassword'])->name('forget-password');

Route::get('get/session/data', [SiteUserController::class, 'callMailFunc']);

// password/reset

// User Routes
Route::group(['middleware' => ['auth:sanctum','verified']], function () {
    Route::get('/', [SiteHomeController::class, 'index'])->name('home');
    Route::get('/friends', [SiteHomeController::class, 'profileSearch'])->name('friends');
    
    // User Sections
    Route::get('/profile', [SiteUserController::class, 'viewProfile'])->name('view-user-profile');
    Route::get('/edit/profile', [SiteUserController::class, 'editProfile'])->name('user-profile');
    Route::post('/update/profile', [SiteUserController::class, 'updateProfile'])->name('edit-profile');
    Route::post('update-password', [UserController::class, 'updatePassword'])->name('update-password');
    Route::post('help-center', [HelpcenterController::class, 'store'])->name('help-center');
    Route::post('user/delete/request', [SiteUserController::class, 'deleteRequest'])->name('user-delete-request');

    // Post Sections
    Route::get('/write-page', [SitePostController::class, 'CreatePost'])->name('create-post');
    Route::post('/store-post', [SitePostController::class, 'StorePost'])->name('store-post');
    Route::post('auto/draft/store-post', [SitePostController::class, 'autoDraftPostRequest'])->name('auto-draft-store-post');
    Route::get('/edit/{type}/{slug}', [SitePostController::class, 'editPostView'])->name('edit-post-view');
    Route::post('/update/post/{type}/{id}', [SitePostController::class, 'updatePost'])->name('update-post-view');
    Route::get('/day/{type}/{slug}', [SitePostController::class, 'PublicPostDetailView'])->name('detail-post-view');
    Route::get('/detail/{type}/{slug}', [SitePostController::class, 'PrivatePostDetailView'])->name('detail-post-view-private');
    Route::get('/day/detail/{type}/{slug}', [SitePostController::class, 'draftPostDetailView'])->name('detail-post-view-draft');
    Route::post('/delete/public/post/', [SitePostController::class, 'deletePublicPost'])->name('delete-public-post');
    Route::post('/delete/private/post/', [SitePostController::class, 'deletePrivatePost'])->name('delete-private-post');
    Route::post('/delete/draft/post/', [SitePostController::class, 'deleteDraftPost'])->name('delete-draft-post');
    Route::post('/report/post/', [SitePostController::class, 'reportPost'])->name('report-post');
    Route::post('/hide/post/', [SitePostController::class, 'hidePost'])->name('hide-post');
    Route::get('/load/posts/', [SiteHomeController::class, 'LoadPostWithAjax'])->name('load-more-post');

    // Post Like,Share,Comment,View, Follow
    Route::get('/add-post-view', [SitePostController::class, 'addPostView'])->name('add-post-view');
    Route::post('/post-share', [SitePostController::class, 'PostShare'])->name('share-post');
    Route::post('/comment', [CommentController::class, 'store'])->name('add-comment');
    Route::post('/like/comment', [LikecommentController::class, 'store'])->name('like-comment');
    Route::get('/load/comments', [CommentController::class, 'loadComments'])->name('load-comment');
    Route::post('/like/post', [SitePostController::class, 'publicPostLike'])->name('add-remove-like');
    Route::post('/like/private/post', [SitePostController::class, 'privatePostLike'])->name('add-remove-like-private');
    Route::post('/like/draft/post', [SitePostController::class, 'draftPostLike'])->name('add-remove-like-draft');
    Route::post('/update/profile/image', [SiteUserController::class, 'updateProfileImage'])->name('update-profile-image');
    Route::post('/save/post', [SavepostController::class, 'store'])->name('save-post');
    Route::post('/follow/unfollow/user', [FollowuserController::class, 'store'])->name('follow-unfollow-user');
    Route::post('/remove/follower/user/{id}', [FollowuserController::class, 'destroy'])->name('remove-follower-user');

    // Search Post and Friends
    Route::get('/search', [SitePostController::class, 'searchPostFriends'])->name('search-post-friends');
    Route::get('/search/profile/{username}', [SiteUserController::class, 'SearchUserProfile'])->name('search-user-profile');
});

Route::group(['middleware' => ['auth:sanctum',  'verified', 'role']], function () {
    // Admin Panel
    Route::group(['prefix' => 'admin'], function(){
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');        

        // Messages
        Route::resource('message', MessageController::class);
        Route::resource('helpcenter', HelpcenterController::class);

        // Users
        Route::resource('user', UserController::class);
        Route::resource('user', UserController::class);
        Route::resource('staff', StaffController::class);
        
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
            // Load Table
            Route::get('load-help-request-table', [HelpcenterController::class, 'loadTable'])->name('load-help-request-table');

            // Multi Delete
            Route::get('delete-help-requests', [HelpcenterController::class, 'multiDelete'])->name('delete-help-requests'); 

            // Change Staff
            Route::put('change-user-status/{id}', [UserController::class, 'UserChangeStatus'])->name('change-user-status');
        });
        Route::get('change-password', [UserController::class, 'changePassword'])->name('change-password');
    });
});
