<?php

use Telegram\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('telegram')->group(function () {
    Route::prefix('channel')->controller(Telegram\Http\Controllers\ChannelController::class)->group(function () {
        Route::post('post', 'createPost');
    });
    Route::post('webhook', [WebhookController::class, 'handle']);
    Route::get('webhook', [WebhookController::class, 'status']);
});
