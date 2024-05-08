<?php

namespace Kolirt\Telegram\Config\Traits;

trait Cancelable
{

    protected string $cancel_button_label = '❌ Cancel';

    public function setCancelButtonLabel(string $label): self
    {
        $this->cancel_button_label = $label;
        return $this;
    }

    public function getCancelButtonLabel(): string
    {
        return $this->cancel_button_label;
    }

}
