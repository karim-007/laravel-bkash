<?php

use Illuminate\Support\Facades\Route;
use Karim007\LaravelBkash\Controllers\BkashPaymentController;

Route::group(['middleware' => ['web']], function () {

    // Payment Routes for bKash
    Route::get('/bkash/payment', [BkashPaymentController::class,'index']);
    Route::post('/bkash/get-token', [BkashPaymentController::class,'getToken'])->name('bkash-get-token');
    Route::post('/bkash/create-payment', [BkashPaymentController::class,'createPayment'])->name('bkash-create-payment');
    Route::post('/bkash/execute-payment', [BkashPaymentController::class,'executePayment'])->name('bkash-execute-payment');
    Route::get('/bkash/query-payment', [BkashPaymentController::class,'queryPayment'])->name('bkash-query-payment');
    Route::post('/bkash/success', [BkashPaymentController::class,'bkashSuccess'])->name('bkash-success');

    // Refund Routes for bKash
    Route::get('/bkash/refund', [BkashPaymentController::class,'refundPage'])->name('bkash-refund');
    Route::post('/bkash/refund', [BkashPaymentController::class,'refund'])->name('bkash-refund');

});
