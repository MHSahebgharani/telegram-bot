<?php

namespace Telegram\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\TelegramDispatcher;

class WebhookController extends Controller
{

    public function __invoke(Request $request, TelegramDispatcher $dispatcher)
    {
        $dispatcher->dispatch($request->all());
        return response()->noContent();
    }

    public function status()
    {
        $botToken = config('telegram.token');

        $res = \Http::withoutVerifying()->get("https://api.telegram.org/bot{$botToken}/getWebhookInfo");

        return response()->json($res->json());
    }
}
