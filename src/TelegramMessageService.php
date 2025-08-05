<?php

namespace Telegram;

use Telegram\Helper\TelegramStrategyResolver;
use Telegram\Enums\TelegramMessageType;

class TelegramMessageService
{
    public function __construct(protected TelegramStrategyResolver $resolver)
    {
    }

    public function send(array $data): array
    {
        if (!isset($data['chat_id'])) {
            throw new \InvalidArgumentException('chat_id is required.');
        }

        $strategy = $this->resolver->resolve($this->detectType($data));
        return $strategy->send($data);
    }

    protected function detectType(array $data): TelegramMessageType
    {
        return match (true) {
            isset($data['base64']) => TelegramMessageType::BASE64,
            isset($data['options']) => TelegramMessageType::POLL,
            isset($data['files']) || isset($data['file']) => TelegramMessageType::FILE,
            isset($data['text']) => TelegramMessageType::TEXT,
            isset($data['callback_query_id']) => TelegramMessageType::CALLBACK,
            default => throw new \InvalidArgumentException('Unsupported message payload'),
        };
    }
}
