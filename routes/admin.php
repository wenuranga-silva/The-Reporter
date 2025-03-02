<?php

use App\DataTables\NewsAllDataTable;
use App\DataTables\VideoAllDataTable;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryHome;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GeneralSettings;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\VideoController;
use Illuminate\Support\Facades\Route;


/////////// Admin only routes
Route::middleware(['role:admin'])->group(function () {

    // Category
    Route::resource('category' ,CategoryController::class);

    // Category Home
    Route::resource('category-home' ,CategoryHome::class);

    // Tags
    Route::resource('tag', TagController::class);


    // Permission
    Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('permission/get-users', [PermissionController::class, 'getUserData'])->name('permission.get.users');
    Route::put('permission/change-status', [PermissionController::class, 'changeStatus'])->name('permission.change.status');
    Route::put('permission/change-role', [PermissionController::class, 'changeRole'])->name('permission.change.role');


    // settings
    Route::get('settings/nav/index' ,[GeneralSettings::class ,'nav_index'])->name('settings.nav.index');
    Route::post('settings/nav/index' ,[GeneralSettings::class ,'nav_store'])->name('settings.nav.store');
    Route::delete('settings/nav/index/{id}' ,[GeneralSettings::class ,'nav_delete'])->name('settings.nav.delete');

    Route::get('settings/webInfo/index' ,[GeneralSettings::class ,'web_index'])->name('settings.webInfo.index');
    Route::post('settings/webInfo/index' ,[GeneralSettings::class ,'web_store'])->name('settings.webInfo.store');
    Route::put('settings/webInfo/index/{id}' ,[GeneralSettings::class ,'web_update'])->name('settings.webInfo.update');


    //// dashboard

    Route::get('/dashboard/getData' ,[DashboardController::class ,'getData'])->name('dashboard.get.data');

});


///////////// route for writer and admin
// News
// all news
Route::get('news/all', function (NewsAllDataTable $dataTable) {

    return $dataTable->render('admin.news.all_news');
})->middleware('role:admin')->name('new.all');

Route::put('news/change-status', [NewsController::class, 'change_status'])->name('news.change.status');
Route::put('news/change-comment', [NewsController::class, 'change_comment'])->name('news.change.comment');
Route::post('news/image-store', [NewsController::class, 'image_store'])->name('news.image.store');
Route::post('news/image-update', [NewsController::class, 'image_update'])->name('news.image.update');
Route::get('news/image-details/{post_id}/{image_id}', [NewsController::class, 'image_details'])->name('news.image.details');
Route::delete('news/image-delete/{post_id}/{image_id}', [NewsController::class, 'image_delete'])->name('news.image.delete');
Route::put('news/image-status', [NewsController::class, 'image_status'])->name('news.image.status');
Route::resource('news', NewsController::class);

// News Videos
Route::get('video/all', function (VideoAllDataTable $dataTable) {

    return $dataTable->render('admin.news.video.all_video');
})->middleware('role:admin')->name('video_news.all');

Route::get('video/news-add/{id}', [VideoController::class, 'add_forNews'])->name('video.news.add');
Route::post('video/news-store', [VideoController::class, 'store_forNews'])->name('video.news.store');
Route::put('video/news-update', [VideoController::class, 'update_forNews'])->name('video.news.update');
Route::put('video/change-status', [VideoController::class, 'change_status'])->name('video.change.status');
Route::resource('video', VideoController::class);
