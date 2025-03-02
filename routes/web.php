<?php

use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class ,'index'])->name('home');

Route::get('/dashboard', function () {

    if (Auth::user()->hasAnyRole(['admin'])) {

        return view('admin.dashboard');
    } else if (Auth::user()->hasAnyRole(['writer'])) {

        return redirect()->route('admin.news.index');
    }

    return redirect()->route('home');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/description', [ProfileController::class, 'add_description'])->name('profile.add.description')->middleware(['role:admin|writer']);
});


//// post page
Route::get('/news/{id}' ,[HomeController::class ,'getPost'])->name('post');

Route::get('/video/{id}' ,[HomeController::class ,'getVideo'])->name('video');

//// news related to the categories
Route::get('news/category/{cat}' ,[HomeController::class ,'getPostCategory'])->name('post.category');

//// search options

//// get search results
Route::get('/search/result/{key}' ,[HomeController::class ,'getSearchResult'])->name('request.search.result');

//// get search view
Route::get('/search/{key}' ,[HomeController::class ,'search'])->name('request.search');


Route::get('/test' ,function () {



});

require __DIR__.'/auth.php';
