<?php

namespace Telegram\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\TelegramService;

class WebhookController extends Controller
{
    public TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle(Request $request)
    {
        $update = $request->all();

        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'] ?? '';

            // Example response: echo back

        }
        if (isset($update['poll_answer'])) {
            $poll = $update['poll_answer'];

            $userId = $poll['user']['id'];
            $userName = $poll['user']['first_name'] ?? 'User';
            $pollId = $poll['poll_id'];
            $optionIndexes = $poll['option_ids']; // 0-based array


            // Optional: Save to database
            // PollAnswer::create([...]);
        }


        return response()->noContent(); // 204
    }

    public function status()
    {
        $botToken = config('telegram.bots.mybot.token');

        $res = \Http::withoutVerifying()->get("https://api.telegram.org/bot{$botToken}/getWebhookInfo");

        return response()->json($res->json());
    }
}
