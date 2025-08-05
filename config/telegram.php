<?php

return [
    'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR-BOT-TOKEN'),
    'certificate_path' => env('TELEGRAM_CERTIFICATE_PATH', 'YOUR-CERTIFICATE-PATH'),
    'webhook_url' => env('TELEGRAM_WEBHOOK_URL', 'YOUR-BOT-WEBHOOK-URL'),
    'commands' => [
        Telegram\Handlers\Commands\StartCommandHandler::class,
        //put your Command Handler hear
    ],
];
