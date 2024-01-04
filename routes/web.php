<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\App;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/detail-blog/{blog:slug}', [HomeController::class, 'detailBlog'])->name('detail-blog');
Route::put('/update-lihat/{id}', [HomeController::class, 'updateLihat'])->name('update-lihat');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');

Route::get('/profile/visi-misi', function () {
    return view('profile-sekolah.visi');
})->name('profile.visi');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Backend routes for admin
Route::prefix('admin')->name('admin.')->middleware('auth', 'makeSureRole:admin')->group(function () {

    // Dashboard routes
    Route::get('dashboard', [HomeController::class, 'dashboardAdmin'])->name('dashboard');

    //Admin Category Management Routes
    Route::resource('category', CategoryController::class);
    Route::delete('category/delete/{id}', [CategoryController::class, 'delete']);

    //Admin Blog Management Routes
    Route::resource('blog', BlogController::class);
    Route::put('blog/update/carousel/{id}', [BlogController::class, 'updateStatus'])->name('blog-update-carousel');
    Route::delete('blog/delete/{id}', [BlogController::class, 'delete']);

    // Admin Student Management Routes
    Route::resource('user', StudentController::class);

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
