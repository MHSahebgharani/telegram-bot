<?php

namespace Telegram\Contracts;

interface TelegramHandlerInterface
{
    public function supports(array $callback): bool;
    public function handle(array $callback): void;
}

