<?php

namespace Telegram\Http\Controllers;

use App\Http\Controllers\Controller;
use Telegram\TelegramMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChannelController extends Controller
{
    public TelegramMessageService $telegram;

    public function __construct(TelegramMessageService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function createPost(Request $request)
    {

        $this->validate($request, [
            'chat_id' => 'required|string',
            'text' => 'nullable|string|max:2048',
            'document' => 'nullable|url',
            'base64' => 'nullable|string',
        ]);
        $chatId = '@trigatetest';

        $response = $this->telegram->send($request->all());

        return $response;
    }
}
