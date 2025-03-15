<?php

namespace Kolirt\Telegram\Core\Traits;

use Kolirt\Telegram\Core\Types\Updates\UpdateType;

trait Updatable
{

    public UpdateType $update;

    public function setUpdate(UpdateType $update): self
    {
        $this->update = $update;
        return $this;
    }

    public function getChatId(): ?int
    {
        $chat_id = null;

        if ($this->update->message->chat) {
            $chat_id = $this->update->message->chat->id;
        }

        return $chat_id;
    }

}
