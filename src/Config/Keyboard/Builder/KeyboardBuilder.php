<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder;

use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Config\Keyboard\Builder\Traits\Buttonable;
use Kolirt\Telegram\Config\Keyboard\Builder\Traits\Pathable;
use Kolirt\Telegram\Config\Keyboard\Builder\Traits\Runnable;
use Kolirt\Telegram\Config\Keyboard\Line\KeyboardLine;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardRemoveType;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use ReflectionMethod;

class KeyboardBuilder
{

    use Buttonable;
    use Pathable;
    use Runnable;

    /** @var KeyboardLine[] */
    protected array $lines = [];

    protected string|array $default_handler;


    public function line($fn): self
    {
        $line = new KeyboardLine();
        $this->lines[] = $line;
        $fn($line);
        return $this;
    }

    public function defaultHandler(string|array $default_handler): self
    {
        $this->default_handler = $default_handler;
        return $this;
    }

    public function runDefault(
        Bot          $bot,
        Telegram     $telegram,
        UpdateType   $context,
        Chat         $chat_model,
        User         $user_model,
        BotChatPivot $bot_chat_pivot_model,
        string       $input
    )
    {
        if (!$this->default_handler) {
            return;
        }

        $class = is_array($this->default_handler) ? $this->default_handler[0] : $this->default_handler;
        $method = is_array($this->default_handler) ? $this->default_handler[1] : '__invoke';
        $params = [];

        $handler = new $class(
            $bot,
            $telegram,
            $context,
            $chat_model,
            $user_model
        );

        $ref = new ReflectionMethod($handler, $method);
        $ref_params = $ref->getParameters();
        if (count($ref_params)) {
            $type = $ref->getParameters()[0]->getType();
            if ($type && class_exists($type->getName())) {
                $input = new ($type->getName())($input);
            }
            $params[] = $input;
        }

        call_user_func([$handler, $method], ...$params);
    }

    public function renderReplyKeyboardMarkup(): ReplyKeyboardMarkupType|ReplyKeyboardRemoveType
    {
        if (count($this->lines)) {
            return new ReplyKeyboardMarkupType(
                keyboard: [
                    ...array_map(fn(KeyboardLine $line) => $line->render(), $this->lines),
                    [
                        new KeyboardButtonType(
                            text: 'Назад'
                        )
                    ]
                ]
            );
        } else {
            return new ReplyKeyboardRemoveType(true);
        }
    }

    public function empty(): bool
    {
        return count($this->lines) === 0;
    }

    /**
     * @return KeyboardLine[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /*protected function getLines()
    {
        if ($this->path === '') {
            return $this->lines;
        }


        $explode = explode('/', preg_replace('/^\//', '', $this->path));

        $lines = $this->lines;
        foreach ($explode as $name) {
            $button = null;
            foreach ($lines as $line) {

//                dump($line);

                $button = $line->getButtonByName($name);
                dump($button);

                if ($button && $button->hasChildren()) {

                }

//                if ($button) {
//                    $lines = $button->getLines();
//                }
            }

            dump('=========');
        }

        dd($lines);

        $button = null;
        $explode = explode('/', preg_replace('/^\//', '',  $this->path));

        foreach ($explode as $name) {
            dump($name);
        }

        dd($this);
    }*/

}
