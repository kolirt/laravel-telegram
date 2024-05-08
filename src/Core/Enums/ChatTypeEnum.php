<?php

namespace Kolirt\Telegram\Core\Enums;

enum ChatTypeEnum: string
{
    case PRIVATE = 'private';
    case GROUP = 'group';
    case SUPERGROUP = 'supergroup';
    case CHANNEL = 'channel';
}
