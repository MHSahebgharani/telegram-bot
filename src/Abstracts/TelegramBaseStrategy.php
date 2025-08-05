<?php

namespace Telegram\Abstracts;

use Illuminate\Support\Facades\Http;

abstract class TelegramBaseStrategy
{
    protected function apiUrl(string $method): string
    {
        return "https://api.telegram.org/bot" . config('telegram.token') . "/{$method}";
    }
}
