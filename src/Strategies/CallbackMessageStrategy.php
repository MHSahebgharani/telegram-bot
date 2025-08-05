<?php

namespace Telegram\Strategies;

use Telegram\Abstracts\TelegramBaseStrategy;
use Illuminate\Support\Facades\Http;
use Telegram\Contracts\TelegramStrategyInterface;

class CallbackMessageStrategy extends TelegramBaseStrategy implements TelegramStrategyInterface
{

    public function send(array $payload): array
    {
        return Http::withoutVerifying()->post(
            $this->apiUrl('answerCallbackQuery'),
            [
                'callback_query_id' => $payload['callback_query_id'],
                ...$payload
            ]
        )->json();
    }
}
