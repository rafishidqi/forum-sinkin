<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware('web')
    ->group(base_path('routes/admin.php'));

Route::get('/', function () {
    return view('welcome');
});