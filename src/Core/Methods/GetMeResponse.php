<?php

namespace Kolirt\Telegram\Core\Methods;

use Kolirt\Telegram\Core\Responses\BaseResponse;
use Kolirt\Telegram\Core\Types\UserType;

class GetMeResponse extends BaseResponse
{

    public UserType $result;

    public function __construct(array $response)
    {
        parent::__construct($response);

        if (isset($response['result'])) {
            $this->result = UserType::from($response['result']);
        }
    }

}
