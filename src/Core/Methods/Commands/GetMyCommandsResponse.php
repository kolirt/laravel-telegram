<?php

namespace Kolirt\Telegram\Core\Methods\Commands;

use Kolirt\Telegram\Core\Responses\BaseResponse;
use Kolirt\Telegram\Core\Types\Commands\BotCommandType;

class GetMyCommandsResponse extends BaseResponse
{

    /**
     * @var BotCommandType[]
     */
    public array $result;

    public function __construct(array $response)
    {
        parent::__construct($response);

        if (isset($response['result'])) {
            $this->result = array_map(fn($item) => BotCommandType::from($item), $response['result']);
        }
    }

}
