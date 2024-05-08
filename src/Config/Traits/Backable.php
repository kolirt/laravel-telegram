<?php

namespace Kolirt\Telegram\Config\Traits;

trait Backable
{

    protected string $back_button_label = '🔙 Back';

    public function setBackButtonLabel(string $label): self
    {
        $this->back_button_label = $label;
        return $this;
    }

    public function getBackButtonLabel(): string
    {
        return $this->back_button_label;
    }

}
