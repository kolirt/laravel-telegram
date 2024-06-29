# Laravel telegram

# Structure

- [Getting started](#getting-started)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Setup](#setup)
- [Define bot commands](#define-bot-commands)
- [Console commands](#console-commands)
- [Telegram API implementation status](#telegram-api-implementation-status)
    - [Getting updates](#getting-updates)
        - [Types](#types)
        - [Methods](#methods)
    - [Available types](#available-types)
    - [Available methods](#available-methods)
- [FAQ](#faq)
- [License](#license)

<a href="https://www.buymeacoffee.com/kolirt" target="_blank">
  <img src="https://cdn.buymeacoffee.com/buttons/v2/arial-yellow.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;" >
</a>

# Getting started

## Requirements

- PHP >= 8
- Laravel >= 10


## Installation
```bash
composer require kolirt/laravel-telegram
```


## Setup

```bash
php artisan telegram:install

php artisan migrate

php artisan telegram:bot-create test {token}
```


# Define bot commands

You can configure bot commands in `routes/telegram.php`, which will be published after the installation, and then you can update the commands in bot using the `php aritsan telegram:bot-update-commands {bot_name}` command.
```php
$config->bot('test')
    ->commands(function (CommandBuilder $builder) {
        $builder->start(StartCommand::class, 'Start command description');
        $builder->command('info', InfoCommand::class, 'Info command description');
        $builder->command('test', [TestCommand::class, 'index'], 'Test command description');
    })
```

# Console commands

- `telegram:bot-create {bot_name}` - Create a new bot
- `telegram:bot-delete-commands {bot_name}` - Delete bot commands
- `telegram:bot-update-commands {bot_name}` - Update bot commands
- `telegram:install` - Installation the package
- `telegram:meta` - Generate metadata
- `telegram:publish-commands` - Publish example commands
- `telegram:publish-config` - Publish the config file
- `telegram:publish-migrations` - Publish migration files
- `telegram:publish-routes` - Publish the route file
- `telegram:serve {bot_name}` - Serve the bot without webhook


# Telegram API implementation status

### [Getting updates](https://core.telegram.org/bots/api#getting-updates)

#### Types

- [X] [Update](https://core.telegram.org/bots/api#update) - [[source code](src/Core/Types/Updates/UpdateType.php)]
- [X] [WebhookInfo](https://core.telegram.org/bots/api#webhookinfo) - [[source code](src/Core/Types/Updates/WebhookInfoType.php)]

#### Methods

- [X] [getUpdates](https://core.telegram.org/bots/api#getupdates) - [[source code](src/Core/Methods/Updates/GetUpdatesMethod.php)]
- [X] [setWebhook](https://core.telegram.org/bots/api#setwebhook) - [[source code](src/Core/Methods/Updates/SetWebhookMethod.php)]
- [X] [deleteWebhook](https://core.telegram.org/bots/api#deletewebhook) - [[source code](src/Core/Methods/Updates/DeleteWebhookMethod.php)]
- [X] [getWebhookInfo](https://core.telegram.org/bots/api#getwebhookinfo) - [[source code](src/Core/Methods/Updates/GetWebhookInfoMethod.php)]

### [Available types](https://core.telegram.org/bots/api#available-types)

- [x] [User](https://core.telegram.org/bots/api#user) - [[source code](src/Core/Types/UserType.php)]
- [X] [Chat](https://core.telegram.org/bots/api#chat) - [[source code](src/Core/Types/ChatType.php)]
- [X] [Message](https://core.telegram.org/bots/api#message) - [[source code](src/Core/Types/MessageType.php)]
- [ ] MessageId
- [ ] InaccessibleMessage
- [ ] MaybeInaccessibleMessage
- [ ] MessageEntity
- [ ] TextQuote
- [ ] ExternalReplyInfo
- [ ] ReplyParameters
- [ ] MessageOrigin
- [ ] MessageOriginUser
- [ ] MessageOriginHiddenUser
- [ ] MessageOriginChat
- [ ] MessageOriginChannel
- [ ] PhotoSize
- [ ] Animation
- [ ] Audio
- [ ] Document
- [ ] Story
- [ ] Video
- [ ] VideoNote
- [ ] Voice
- [ ] Contact
- [ ] Dice
- [ ] PollOption
- [ ] PollAnswer
- [ ] Poll
- [ ] Location
- [ ] Venue
- [ ] WebAppData
- [ ] ProximityAlertTriggered
- [ ] MessageAutoDeleteTimerChanged
- [ ] ChatBoostAdded
- [ ] ForumTopicCreated
- [ ] ForumTopicClosed
- [ ] ForumTopicEdited
- [ ] ForumTopicReopened
- [ ] GeneralForumTopicHidden
- [ ] GeneralForumTopicUnhidden
- [ ] SharedUser
- [ ] UsersShared
- [ ] ChatShared
- [ ] WriteAccessAllowed
- [ ] VideoChatScheduled
- [ ] VideoChatStarted
- [ ] VideoChatEnded
- [ ] VideoChatParticipantsInvited
- [ ] GiveawayCreated
- [ ] Giveaway
- [ ] GiveawayWinners
- [ ] GiveawayCompleted
- [ ] LinkPreviewOptions
- [ ] UserProfilePhotos
- [ ] File
- [ ] WebAppInfo
- [ ] ReplyKeyboardMarkup
- [ ] KeyboardButton
- [ ] KeyboardButtonRequestUsers
- [ ] KeyboardButtonRequestChat
- [ ] KeyboardButtonPollType
- [ ] ReplyKeyboardRemove
- [ ] InlineKeyboardMarkup
- [ ] InlineKeyboardButton
- [ ] LoginUrl
- [ ] SwitchInlineQueryChosenChat
- [ ] CallbackQuery
- [ ] ForceReply
- [ ] ChatPhoto
- [ ] ChatInviteLink
- [ ] ChatAdministratorRights
- [ ] ChatMemberUpdated
- [ ] ChatMember
- [ ] ChatMemberOwner
- [ ] ChatMemberAdministrator
- [ ] ChatMemberMember
- [ ] ChatMemberRestricted
- [ ] ChatMemberLeft
- [ ] ChatMemberBanned
- [ ] ChatJoinRequest
- [ ] ChatPermissions
- [ ] Birthdate
- [ ] BusinessIntro
- [ ] BusinessLocation
- [ ] BusinessOpeningHoursInterval
- [ ] BusinessOpeningHours
- [ ] ChatLocation
- [ ] ReactionType
- [ ] ReactionTypeEmoji
- [ ] ReactionTypeCustomEmoji
- [ ] ReactionCount
- [ ] MessageReactionUpdated
- [ ] MessageReactionCountUpdated
- [ ] ForumTopic
- [ ] BotCommand
- [ ] BotCommandScope
- [ ] Determining list of commands
- [ ] BotCommandScopeDefault
- [ ] BotCommandScopeAllPrivateChats
- [ ] BotCommandScopeAllGroupChats
- [ ] BotCommandScopeAllChatAdministrators
- [ ] BotCommandScopeChat
- [ ] BotCommandScopeChatAdministrators
- [ ] BotCommandScopeChatMember
- [ ] BotName
- [ ] BotDescription
- [ ] BotShortDescription
- [ ] MenuButton
- [ ] MenuButtonCommands
- [ ] MenuButtonWebApp
- [ ] MenuButtonDefault
- [ ] ChatBoostSource
- [ ] ChatBoostSourcePremium
- [ ] ChatBoostSourceGiftCode
- [ ] ChatBoostSourceGiveaway
- [ ] ChatBoost
- [ ] ChatBoostUpdated
- [ ] ChatBoostRemoved
- [ ] UserChatBoosts
- [ ] BusinessConnection
- [ ] BusinessMessagesDeleted
- [ ] ResponseParameters
- [ ] InputMedia
- [ ] InputMediaPhoto
- [ ] InputMediaVideo
- [ ] InputMediaAnimation
- [ ] InputMediaAudio
- [ ] InputMediaDocument
- [ ] InputFile
- [ ] Sending files
- [ ] Accent colors
- [ ] Profile accent colors
- [ ] Inline mode objects

### [Available methods](https://core.telegram.org/bots/api#available-methods)

- [X] [getMe](https://core.telegram.org/bots/api#getme) [[source code](src/Core/Methods/GetMeMethod.php)]
- [ ] logOut
- [ ] close
- [X] [sendMessage](https://core.telegram.org/bots/api#sendmessage) [[source code](src/Core/Methods/Messages/SendMessageMethod.php)]
- [ ] Formatting options
- [ ] forwardMessage
- [ ] forwardMessages
- [ ] copyMessage
- [ ] copyMessages
- [ ] [sendPhoto](https://core.telegram.org/bots/api#sendphoto) [[source code](src/Core/Methods/Photo/SendPhotoMethod.php)]
- [ ] sendAudio
- [ ] sendDocument
- [ ] sendVideo
- [ ] sendAnimation
- [ ] sendVoice
- [ ] sendVideoNote
- [ ] sendMediaGroup
- [ ] sendLocation
- [ ] sendVenue
- [ ] sendContact
- [ ] sendPoll
- [ ] sendDice
- [ ] sendChatAction
- [ ] setMessageReaction
- [ ] getUserProfilePhotos
- [ ] getFile
- [ ] banChatMember
- [ ] unbanChatMember
- [ ] restrictChatMember
- [ ] promoteChatMember
- [ ] setChatAdministratorCustomTitle
- [ ] banChatSenderChat
- [ ] unbanChatSenderChat
- [ ] setChatPermissions
- [ ] exportChatInviteLink
- [ ] createChatInviteLink
- [ ] editChatInviteLink
- [ ] revokeChatInviteLink
- [ ] approveChatJoinRequest
- [ ] declineChatJoinRequest
- [ ] setChatPhoto
- [ ] deleteChatPhoto
- [ ] setChatTitle
- [ ] setChatDescription
- [ ] pinChatMessage
- [ ] unpinChatMessage
- [ ] unpinAllChatMessages
- [ ] leaveChat
- [ ] getChat
- [ ] getChatAdministrators
- [ ] getChatMemberCount
- [ ] getChatMember
- [ ] setChatStickerSet
- [ ] deleteChatStickerSet
- [ ] getForumTopicIconStickers
- [ ] createForumTopic
- [ ] editForumTopic
- [ ] closeForumTopic
- [ ] reopenForumTopic
- [ ] deleteForumTopic
- [ ] unpinAllForumTopicMessages
- [ ] editGeneralForumTopic
- [ ] closeGeneralForumTopic
- [ ] reopenGeneralForumTopic
- [ ] hideGeneralForumTopic
- [ ] unhideGeneralForumTopic
- [ ] unpinAllGeneralForumTopicMessages
- [ ] answerCallbackQuery
- [ ] getUserChatBoosts
- [ ] getBusinessConnection
- [X] [setMyCommands](https://core.telegram.org/bots/api#setmycommands) [[source code](src/Core/Methods/Commands/SetMyCommandsMethod.php)]
- [X] [deleteMyCommands](https://core.telegram.org/bots/api#deletemycommands) [[source code](src/Core/Methods/Commands/DeleteMyCommandsMethod.php)]
- [X] [getMyCommands](https://core.telegram.org/bots/api#getmycommands) [[source code](src/Core/Methods/Commands/GetMyCommandsMethod.php)]
- [ ] setMyName
- [ ] getMyName
- [ ] setMyDescription
- [ ] getMyDescription
- [ ] setMyShortDescription
- [ ] getMyShortDescription
- [ ] setChatMenuButton
- [ ] getChatMenuButton
- [ ] setMyDefaultAdministratorRights
- [ ] getMyDefaultAdministratorRights
- [ ] Inline mode methods

# FAQ

Check closed [issues](#) to get answers for most asked questions

# License

[MIT](LICENSE.txt)
