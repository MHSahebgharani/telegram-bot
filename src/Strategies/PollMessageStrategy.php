<?php

namespace Telegram\Strategies;

use Telegram\Abstracts\TelegramBaseStrategy;
use Illuminate\Support\Facades\Http;
use Telegram\Contracts\TelegramStrategyInterface;

class PollMessageStrategy extends TelegramBaseStrategy implements TelegramStrategyInterface
{

    public function send(array $payload): array
    {
        return Http::withoutVerifying()->post(
            $this->apiUrl('sendPoll'),
            [
                'chat_id' => $payload['chat_id'],
                'question' => $payload['text'],
                'options' => $payload['options'],
                'is_anonymous' => $payload['is_anonymous'] ?? false,
                'reply_to_message_id' => $payload['reply_to_message_id'] ?? null,
                'allows_multiple_answers' => $payload['allows_multiple_answers'] ?? false,
            ]
        )->json();
    }
}
