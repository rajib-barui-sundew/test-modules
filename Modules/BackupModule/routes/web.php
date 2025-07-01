<?php

use Illuminate\Support\Facades\Route;
use Modules\BackupModule\Http\Controllers\BackupController;

Route::get('/db-backup', [BackupController::class, 'index'])->name('db-backup'); //Middleware Missed
