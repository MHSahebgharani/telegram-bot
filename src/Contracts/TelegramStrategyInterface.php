<?php

namespace Telegram\Contracts;

interface TelegramStrategyInterface
{
    public function send(array $payload): array;
}
