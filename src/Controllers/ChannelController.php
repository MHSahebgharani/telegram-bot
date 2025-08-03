<?php

namespace Telegram\Http\Controllers;

use App\Http\Controllers\Controller;
use Telegram\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChannelController extends Controller
{
    public TelegramService $telegram;

    public function __construct(TelegramService $telegram)
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

        return $this->telegram->send($request->all());
    }
}
