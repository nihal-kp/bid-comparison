<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidComparisonController;

Route::get('/', [BidComparisonController::class, 'index'])->name('bid-comparison.index');
Route::post('bid-comparison/updated-version', [BidComparisonController::class, 'updatedVersion'])->name('bid-comparison.updated-version');