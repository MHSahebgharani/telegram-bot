<?php

namespace Telegram\Strategies;

use Telegram\Abstracts\TelegramBaseStrategy;
use Illuminate\Support\Facades\Http;
use Telegram\Contracts\TelegramStrategyInterface;

class TextMessageStrategy extends TelegramBaseStrategy implements TelegramStrategyInterface
{

    public function send(array $payload): array
    {
        return Http::withoutVerifying()->post(
            $this->apiUrl('sendMessage'),
            [
                'chat_id' => $payload['chat_id'],
                'text' => $payload['text'],
                'reply_to_message_id' => $payload['reply_to_message_id'] ?? null,
                'parse_mode' => 'HTML'
            ]
        )->json();
    }
}
