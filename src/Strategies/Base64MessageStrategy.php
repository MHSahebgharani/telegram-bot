<?php

namespace Telegram\Strategies;

use Illuminate\Support\Facades\Http;
use Telegram\Contracts\TelegramStrategyInterface;

class Base64MessageStrategy extends TextMessageStrategy implements TelegramStrategyInterface
{

    public function send(array $payload): array
    {
        $file = base64_decode($payload['base64']);

        return Http::withoutVerifying()->attach(
            'document', $file, $payload['filename']
        )->post($this->apiUrl('sendDocument'),
            [
                'chat_id' => $payload['chat_id'],
                'caption' => $payload['text'],
                'reply_to_message_id' => $payload['reply_to_message_id'] ?? null,
                'parse_mode' => 'HTML'
            ]
        )->json();
    }
}
