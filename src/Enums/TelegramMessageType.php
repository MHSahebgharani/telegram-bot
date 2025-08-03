<?php

// 1. Enum: app/Enums/TelegramMessageType.php
namespace Telegram\Enums;

enum TelegramMessageType: string
{
    case TEXT = 'text';
    case FILE = 'file';
    case DOCUMENT = 'document';
    case BASE64 = 'base64';
    case POLL = 'poll';
}
