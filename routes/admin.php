<?php

use Azuriom\Plugin\Referral\Controllers\Admin\AdminSettingsController;
use Azuriom\Plugin\Referral\Controllers\Admin\AdminHistoryController;
use Azuriom\Plugin\Referral\Controllers\Admin\AdminStatisticsController;
use Azuriom\Plugin\Referral\Controllers\Admin\AdminRewardsController;
use Azuriom\Plugin\Referral\Controllers\Admin\AdminReferralsController;
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

Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
Route::post('/settings/save', [AdminSettingsController::class, 'save'])->name('settings.save');
Route::get('/rewards', [AdminRewardsController::class, 'index'])->name('rewards');
Route::post('/rewards/save', [AdminRewardsController::class, 'save'])->name('rewards.save');
Route::get('/history', [AdminHistoryController::class, 'index'])->name('history');
Route::get('/statistics', [AdminStatisticsController::class, 'index'])->name('statistics');
Route::post('/referrer/change/{id}', [AdminSettingsController::class, 'changeReferrer'])->name('referrer.change');
Route::post('/settings/resetdb', [AdminSettingsController::class, 'recreateReferralTables'])->name('settings.reset_db');
