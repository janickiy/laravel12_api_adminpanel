<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataTableController;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');

Route::group(['prefix' => 'admins'], function () {
    Route::get('', [AdminController::class, 'index'])->name('admin.admins.index');
    Route::get('create', [AdminController::class, 'create'])->name('admin.admins.create');
    Route::post('store', [AdminController::class, 'store'])->name('admin.admins.store');
    Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admin.admins.edit')->where('id', '[0-9]+');
    Route::put('update', [AdminController::class, 'update'])->name('admin.admins.update');
    Route::post('destroy', [AdminController::class, 'destroy'])->name('admin.admins.destroy')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'notes'], function () {
    Route::get('', [NotesController::class, 'index'])->name('admin.notes.index');
    Route::get('edit/{id}', [NotesController::class, 'edit'])->name('admin.notes.edit')->where('id', '[0-9]+');
    Route::put('update', [NotesController::class, 'update'])->name('admin.notes.update');
    Route::post('destroy', [NotesController::class, 'destroy'])->name('admin.notes.destroy');
});

Route::group(['prefix' => 'datatable'], function () {
    Route::any('notes', [DataTableController::class, 'notes'])->name('admin.datatable.notes');
    Route::any('admin', [DataTableController::class, 'admin'])->name('admin.datatable.admin');
});
