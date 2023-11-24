<?php

namespace Services\Telegram;

use Illuminate\Support\Facades\Http;

final class TelegramBotApi
{
    public const HOST = "https://api.telegram.org/bot";

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::get(
                self::HOST . $token . '/sendMessage',
                [
                    'chat_id' => $chatId,
                    'text' => $text
                ]
            );

            return $response['ok'] ?? false;

        } catch (\Exception $e) {
            return false;
        }
    }
}
