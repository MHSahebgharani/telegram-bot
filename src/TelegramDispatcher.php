<?php

namespace Telegram;


use Telegram\Dispatchers\TelegramHandlerRegistry;

class TelegramDispatcher
{
    public function __construct(protected TelegramHandlerRegistry $registry){}

    public function dispatch(array $update): void
    {
        foreach ($this->registry->getHandlers() as $handler) {
            if ($handler->supports($update)) {
                $handler->handle($update);
                return;
            }
        }

        logger()->warning('No handler matched update', $update);
    }
}
