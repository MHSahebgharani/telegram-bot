<?php

namespace Telegram\Handlers\Commands;

use Illuminate\Support\Facades\Cache;
use Telegram\Contracts\TelegramHandlerInterface;
use Telegram\TelegramMessageService;

class StartCommandHandler implements TelegramHandlerInterface
{
    public function __construct(protected TelegramMessageService $telegramMessageService)
    {
    }

    public function supports(array $callback): bool
    {
        return isset($callback['message']['text']) && $callback['message']['text'] === '/start';
    }

    public function handle(array $callback): void
    {
        $chatId = $callback['message']['chat']['id'];
        $authenticated = Cache::get("authenticated_{$chatId}");
        $text = 'Welcome! Tap to login:';
        if ($authenticated) {
            $phone = Cache::get("phone_{$chatId}");
            $text = 'Hello User-' . $phone;
            $keys = [['text' => '👋 logout', 'callback_data' => 'auth_logout']];
        } else {
            $keys = [['text' => '🔐 Authenticate', 'callback_data' => 'auth_start']];
        }

        $this->telegramMessageService->send([
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    $keys
                ]
            ])
        ]);
    }
}
