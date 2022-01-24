<?php

use Dcodegroup\LaravelMyobEmployee\Http\Controllers\SyncMyobEmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/{user}', SyncMyobEmployeeController::class)->name('sync');