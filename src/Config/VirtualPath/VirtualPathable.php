<?php

namespace Kolirt\Telegram\Config\VirtualPath;

trait VirtualPathable
{
    protected string $virtual_path = '';

    protected function getVirtualPath(): string
    {
        return $this->virtual_path;
    }

    /**
     * @param string $virtual_path
     * @return void
     */
    protected function setVirtualPath(?string $virtual_path): void
    {
        $this->virtual_path = $virtual_path ?? '';

        $this->personal_chat?->update(['virtual_path' => $this->virtual_path]);
        $this->getKeyboardBuilder()?->setPath($this->virtual_path);
    }

    /**
     * @return void
     */
    protected function resetVirtualPath(): void
    {
        $this->virtual_path = '';

        $this->personal_chat?->update(['virtual_path' => $this->virtual_path]);
        $this->getKeyboardBuilder()?->setPath($this->virtual_path);
    }
}
