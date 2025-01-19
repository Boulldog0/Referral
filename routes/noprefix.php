<?php

use Azuriom\Plugin\Referral\Controllers\FromController;
use Illuminate\Support\Facades\Route;

Route::get('/from/{username}', [FromController::class, 'index'])->name('from');
