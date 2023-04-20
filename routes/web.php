<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['IsAdmin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        Route::prefix('/criteria')->name('criteria.')->group(function () {
            Route::get('', [App\Http\Controllers\CriteriaController::class, 'index'])->name('index');
            Route::get('/activate/{id}', [App\Http\Controllers\CriteriaController::class, 'activate'])->name('activate');
            Route::get('/create', [App\Http\Controllers\CriteriaController::class, 'create'])->name('create');
            Route::post('/create', [App\Http\Controllers\CriteriaController::class, 'store'])->name('store');
            Route::post('/test', [App\Http\Controllers\CriteriaController::class, 'test'])->name('test');
            Route::get('/detail/{id}', [App\Http\Controllers\CriteriaController::class, 'show'])->name('detail');

            Route::post('/form/additional', [App\Http\Controllers\CriteriaController::class, 'formAdditional'])->name('form.additional');
            Route::post('/form/preview', [App\Http\Controllers\CriteriaController::class, 'formPreview'])->name('form.preview');
            Route::post('/form/preview/upload', [App\Http\Controllers\UserDocumentController::class, 'upload'])->name('form.preview.upload');
            // Route::get('/delete/{id}', [App\Http\Controllers\CriteriaController::class, 'deleteUser'])->name('delete');
            Route::get('/update/{id}', [App\Http\Controllers\CriteriaController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [App\Http\Controllers\CriteriaController::class, 'update'])->name('update');
        });
    });
});
