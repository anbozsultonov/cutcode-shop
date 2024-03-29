<?php

namespace Support\Logging\Telegram;

use Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;

    protected string $token;

    public function __construct(array $config)
    {
        $this->chatId = (int)$config['chat_id'];
        $this->token = $config['token'];

        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);
    }

    public function write(array $record): void
    {
        TelegramBotApi::sendMessage(
            $this->token,
            $this->chatId,
            $record['formatted']
        );
    }
}
