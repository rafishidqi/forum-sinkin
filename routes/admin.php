<?php

// routes/admin.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Report;

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
});

Route::middleware('auth:admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'userCount' => User::count(),
            'postCount' => Post::count(),
            'categoryCount' => Category::count(),
            'commentCount' => Comment::count(),
            'reportCount' => Report::count(),
        ]);
    })->name('admin.dashboard');

    // Menambahkan rute resource untuk kategori
    Route::resource('categories', AdminCategoryController::class);

    // Menambahkan rute untuk postingan
    Route::get('/posts', [AdminPostController::class, 'index'])->name('admin.posts.index'); // Menampilkan daftar postingan
    Route::get('/posts/{id}', [AdminPostController::class, 'show'])->name('admin.posts.show'); // Menampilkan detail postingan
    Route::post('/posts/{id}/ban', [AdminPostController::class, 'ban'])->name('admin.posts.ban'); // Membanned postingan
    Route::delete('/posts/{id}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy'); // Menghapus postingan
    Route::post('/posts/{post}/restore', [AdminPostController::class, 'restore'])->name('admin.posts.restore');
    Route::delete('/comments/{comment}', [AdminPostController::class, 'destroyComment'])->name('admin.comments.destroy');

    // Rute untuk melihat komentar terkait postingan
    Route::get('/posts/{id}/comments', [AdminPostController::class, 'showComments'])->name('admin.posts.comments');

    // Rute untuk melihat daftar pengguna
    Route::get('/users', [AdminUserController::class, 'index'])->name('user.index');

    // Rute untuk melihat detail pengguna
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('user.show');

    // Rute untuk laporan
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index'); // Diperbaiki: name menjadi admin.reports.index
    Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('admin.reports.show'); // Ditambahkan: Rute untuk menampilkan detail laporan
    Route::put('/reports/{report}/status/{status}', [AdminReportController::class, 'updateStatus'])->name('admin.reports.update_status');
    Route::delete('/reports/{report}', [AdminReportController::class, 'destroy'])->name('admin.reports.destroy');

    // Logout Route
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});
