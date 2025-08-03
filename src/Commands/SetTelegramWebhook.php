<?php

namespace Telegram\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetTelegramWebhook extends Command
{
    protected $signature = 'telegram:set-webhook';
    protected $description = 'Register Telegram webhook URL with Telegram API';

    public function handle()
    {
        $token = config('telegram.bots.mybot.token');
        $url = config('telegram.bots.mybot.webhook_url');

        $res = Http::post("https://api.telegram.org/bot{$token}/setWebhook", [
            'url' => $url,
        ]);

        if ($res->successful()) {
            $this->info("✅ Webhook registered: {$url}");
        } else {
            $this->error("❌ Failed: " . $res->body());
        }
    }
}
