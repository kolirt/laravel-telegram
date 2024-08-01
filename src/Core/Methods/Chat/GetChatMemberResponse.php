<?php

namespace Kolirt\Telegram\Core\Methods\Chat;

use Kolirt\Telegram\Core\Responses\BaseResponse;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberAdministratorType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberBannedType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberLeftType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberMemberType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberOwnerType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberRestrictedType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberType;

class GetChatMemberResponse extends BaseResponse
{

    public ChatMemberOwnerType|ChatMemberAdministratorType|ChatMemberMemberType|ChatMemberRestrictedType|ChatMemberLeftType|ChatMemberBannedType $result;

    public function __construct(array $response)
    {
        parent::__construct($response);

        if (isset($response['result'])) {
            $this->result = ChatMemberType::from($response['result']);
        }
    }

}
