<?php

namespace Telegram\Helper;

use Telegram\Strategies\Base64MessageStrategy;
use Telegram\Strategies\DocumentMessageStrategy;
use Telegram\Strategies\FileMessageStrategy;
use Telegram\Strategies\PollMessageStrategy;
use Telegram\Strategies\TextMessageStrategy;
use Telegram\Enums\TelegramMessageType;
use Telegram\Contracts\TelegramStrategyInterface;

class TelegramStrategyResolver
{
    public function __construct(
        protected TextMessageStrategy     $text,
        protected FileMessageStrategy     $file,
        protected PollMessageStrategy     $poll,
        protected Base64MessageStrategy   $base64,
    )
    {}

    public function resolve(TelegramMessageType $type): TelegramStrategyInterface
    {
        return match ($type) {
            TelegramMessageType::TEXT => $this->text,
            TelegramMessageType::FILE => $this->file,
            TelegramMessageType::POLL => $this->poll,
            TelegramMessageType::BASE64 => $this->base64,
        };
    }
}
