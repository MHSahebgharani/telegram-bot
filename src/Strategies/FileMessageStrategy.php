<?php

namespace Telegram\Strategies;

use Telegram\Abstracts\TelegramBaseStrategy;
use Illuminate\Support\Facades\Http;
use Telegram\Contracts\TelegramStrategyInterface;

class FileMessageStrategy extends TelegramBaseStrategy implements TelegramStrategyInterface
{

    public function send(array $payload): array
    {
        $chatId = $payload['chat_id'];

        if (isset($payload['files']) && is_array($payload['files'])) {
            return $this->sendMediaGroup($chatId, $payload['files'], $payload);
        }

        return $this->sendSingleFile(
            $chatId,
            $this->getTelegramFileTypeFromPath($payload['file']), // default to photo
            $payload['file'],
            $payload
        );
    }

    public function getTelegramFileTypeFromPath(string $path): string
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'bmp', 'gif'];

        $extension = strtolower(pathinfo(parse_url($path, PHP_URL_PATH), PATHINFO_EXTENSION));

        return in_array($extension, $imageExtensions) ? 'photo' : 'document';
    }

    protected function sendSingleFile(string $chatId, string $type, string $file, array $payload): array
    {
        $apiMethod = $type === 'document' ? 'sendDocument' : 'sendPhoto';

        if (filter_var($file, FILTER_VALIDATE_URL)) {
            return Http::withoutVerifying()->post($this->apiUrl($apiMethod), [
                'chat_id' => $chatId,
                $type => $file,
                'caption' => $payload['text'],
                'parse_mode' => 'HTML',
                'reply_to_message_id' => $payload['reply_to_message_id'] ?? null,
            ])->json();
        }

        return Http::withoutVerifying()
            ->attach($type, file_get_contents($file), $payload['filename'])
            ->post($this->apiUrl($apiMethod), [
                'chat_id' => $chatId,
                'caption' => $payload['text'],
                'parse_mode' => 'HTML',
                'reply_to_message_id' => $payload['reply_to_message_id'] ?? null,
            ])->json();
    }

    protected function sendMediaGroup(string $chatId, array $files, array $payload): array
    {
        $media = [];
        $http = Http::withoutVerifying();

        foreach ($files as $index => $item) {
            $type = $this->getTelegramFileTypeFromPath($item); // default to photo
            $local = !filter_var($item, FILTER_VALIDATE_URL);
            $attachName = $type . $index;
            $media[] = [
                'type' => $type,
                'media' => $local ? "attach://{$attachName}" : $item,
                'caption' => $payload['text'] ?? null,
                'parse_mode' => 'HTML',
            ];

            if ($local) {
                $http->attach($attachName, file_get_contents($item, 'w'), $item->getClientOriginalName());
            }
        }

        return $http->post($this->apiUrl('sendMediaGroup'), [
            'chat_id' => $chatId,
            'media' => json_encode($media),
            'reply_to_message_id' => $payload['reply_to_message_id'] ?? null,
        ])->json();
    }
}
