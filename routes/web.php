<?php

use Azuriom\Plugin\Referral\Controllers\ReferralRegisterController;
use Azuriom\Plugin\Referral\Controllers\ReferralRegisterSubmitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/register', [ReferralRegisterController::class, 'index'])->name('register');
Route::post('/register/submit', [ReferralRegisterSubmitController::class, 'submit'])->name('submit');
