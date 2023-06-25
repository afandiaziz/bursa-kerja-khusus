<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\InformationController;

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

Auth::routes();

Route::get('/raw-cv', [LandingController::class, 'raw'])->name('raw-cv');
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/tentang', function () {
    return view('about');
})->name('about');
Route::prefix('/informasi')->name('informasi.')->group(function () {
    Route::get('/', [LandingController::class, 'information'])->name('index');
    Route::get('/{slug}', [LandingController::class, 'detailInfo'])->name('detail');
});
Route::prefix('/loker')->name('loker.')->group(function () {
    Route::get('/', [LokerController::class, 'index'])->name('index');
    Route::get('/detail', [LokerController::class, 'detail'])->name('detail');
    Route::get('/detail/{id}', [LokerController::class, 'show'])->name('show');

    Route::middleware(['auth'])->group(function () {
        Route::post('/daftar/{id}', [LokerController::class, 'apply'])->name('daftar');
    });
});
Route::middleware(['auth'])->prefix('/lamaran')->name('lamaran.')->group(function () {
    Route::get('/', [ProfilController::class, 'applications'])->name('index');
    Route::get('/detail/{id}', [LokerController::class, 'show'])->name('show');
    Route::get('/bukti-pendaftaran/{registrationNumber}', [ProfilController::class, 'evidence'])->name('evidence');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/bukti-pendaftaran/{registrationNumber}', [ProfilController::class, 'evidence'])->name('bukti.show');
    Route::prefix('/profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('edit');
        Route::post('/edit', [ProfilController::class, 'update'])->name('update');
        Route::post('/store/custom', [ProfilController::class, 'storeValueCustom'])->name('store.custom');
        Route::post('/update/custom', [ProfilController::class, 'updateValueCustom'])->name('update.custom');
        Route::delete('/delete/custom', [ProfilController::class, 'deleteValueCustom'])->name('delete.custom');

        Route::post('/load/modal/custom', [ProfilController::class, 'loadModalCustom'])->name('load.modal.custom');
    });
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['IsAdmin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        Route::prefix('/criteria')->name('criteria.')->group(function () {
            Route::get('', [CriteriaController::class, 'index'])->name('index');
            Route::get('/activate/{id}', [CriteriaController::class, 'activate'])->name('activate');
            Route::get('/create', [CriteriaController::class, 'create'])->name('create');
            Route::post('/create', [CriteriaController::class, 'store'])->name('store');
            Route::post('/test', [CriteriaController::class, 'test'])->name('test');
            Route::get('/detail/{id}', [CriteriaController::class, 'show'])->name('detail');

            Route::post('/form/additional', [CriteriaController::class, 'formAdditional'])->name('form.additional');
            Route::post('/form/preview', [CriteriaController::class, 'formPreview'])->name('form.preview');
            Route::post('/form/preview/upload', [App\Http\Controllers\UserDocumentController::class, 'upload'])->name('form.preview.upload');
            // Route::get('/delete/{id}', [CriteriaController::class, 'deleteUser'])->name('delete');
            Route::get('/update/{id}', [CriteriaController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CriteriaController::class, 'update'])->name('update');
        });
        Route::prefix('/company')->name('company.')->group(function () {
            Route::get('', [CompanyController::class, 'index'])->name('index');
            Route::get('/create', [CompanyController::class, 'create'])->name('create');
            Route::post('/create', [CompanyController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [CompanyController::class, 'show'])->name('detail');
            Route::get('/activate/{id}', [CompanyController::class, 'activate'])->name('activate');
            Route::get('/update/{id}', [CompanyController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CompanyController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CompanyController::class, 'destroy'])->name('delete');
            Route::delete('/delete/logo/{id}', [CompanyController::class, 'deleteLogo'])->name('delete-logo');
        });
        Route::prefix('/vacancy')->name('vacancy.')->group(function () {
            Route::get('', [VacancyController::class, 'index'])->name('index');
            Route::get('/create', [VacancyController::class, 'create'])->name('create');
            Route::post('/create', [VacancyController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [VacancyController::class, 'show'])->name('detail');
            // Route::get('/activate/{id}', [VacancyController::class, 'activate'])->name('activate');
            Route::get('/update/{id}', [VacancyController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [VacancyController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [VacancyController::class, 'destroy'])->name('delete');
        });
        Route::prefix('/applicant')->name('applicant.')->group(function () {
            Route::get('', [ApplicantController::class, 'index'])->name('index');
            Route::get('/verify/{id}', [ApplicantController::class, 'verify'])->name('verify');
            Route::get('/detail/{id}', [ApplicantController::class, 'show'])->name('detail');
            Route::post('/detail/info', [ApplicantController::class, 'info'])->name('detail.info');
            Route::get('/delete/{id}', [VacancyController::class, 'destroy'])->name('delete');
        });
        Route::prefix('/verify')->name('verify.')->group(function () {
            Route::get('', [VerifyController::class, 'index'])->name('index');
            Route::post('/check', [VerifyController::class, 'check'])->name('check');
        });
        Route::prefix('/information')->name('information.')->group(function () {
            Route::get('', [InformationController::class, 'index'])->name('index');
            Route::get('/create', [InformationController::class, 'create'])->name('create');
            Route::post('/create', [InformationController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [InformationController::class, 'show'])->name('detail');
            Route::get('/activate/{id}', [InformationController::class, 'activate'])->name('activate');
            Route::get('/update/{id}', [InformationController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [InformationController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [InformationController::class, 'destroy'])->name('delete');
        });
    });
});
