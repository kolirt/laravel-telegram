<?php

namespace Kolirt\Telegram\Core\Methods\Updates;

use Kolirt\Telegram\Core\Responses\BaseResponse;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;

class GetUpdatesResponse extends BaseResponse
{

    /**
     * @var UpdateType[]
     */
    public array $result;

    public function __construct(array $response)
    {
        parent::__construct($response);

        if (isset($response['result'])) {
            $this->result = array_map(fn($update) => UpdateType::from($update), $response['result']);
        }
    }

}
