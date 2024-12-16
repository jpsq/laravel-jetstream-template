<?php

use App\Facades\Services;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaDownloadExternalController;
use App\Http\Controllers\MediaFetchGifsController;
use App\Http\Controllers\MediaFetchStockController;
use App\Http\Controllers\MediaFetchUploadsController;
use App\Http\Controllers\MediaUploadFileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Route::get('calendar/{date?}/{type?}', [CalendarController::class, 'index'])
    //     ->name('calendar')
    //     ->where('date', '^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$')
    //     ->where('type', '^(?:month|week)$');

    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::delete('/', [MediaController::class, 'destroy'])->name('delete');
        Route::get('fetch/uploaded', MediaFetchUploadsController::class)->name('fetchUploads');
        Route::get('fetch/stock', MediaFetchStockController::class)->name('fetchStock');
        Route::get('fetch/gifs', MediaFetchGifsController::class)->name('fetchGifs');
        Route::post('download', MediaDownloadExternalController::class)->name('download');
        Route::post('upload', MediaUploadFileController::class)->name('upload');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/', [SettingsController::class, 'update'])->name('update');
    });

    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ServicesController::class, 'index'])->name('index');
        Route::put('{service}', [ServicesController::class, 'update'])->name('update');
        Route::get('{service}/documentation', [ServicesController::class, 'documentation'])->name('documentation');
    });


    Route::prefix('courses')->name('courses.')->group(function () {
        Route::inertia('/create', 'Courses/create')->name('create');
    });


});
