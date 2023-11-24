<?php

use Support\Flash\Flash;

function isProduction(): bool
{
    return app()->isProduction();
}

function isLocal(): bool
{
    return app()->isLocal();
}

function tgLog(string $text, ?string $level = 'debug'): void
{
    $channel = logger()
        ?->channel('telegram');

    if ($level) {
        $channel->{$level}($text);
    } else {
        $channel->debug($text);
    }
}

function flash(): Flash
{
    return app(Flash::class);
}


