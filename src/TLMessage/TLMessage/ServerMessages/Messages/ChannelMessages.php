<?php

declare(strict_types=1);

namespace TelegramOSINT\TLMessage\TLMessage\ServerMessages\Messages;

use TelegramOSINT\Client\InfoObtainingClient\Models\UserInfoModel;
use TelegramOSINT\MTSerialization\AnonymousMessage;
use TelegramOSINT\TLMessage\TLMessage\TLServerMessage;

class ChannelMessages extends TLServerMessage
{
    /**
     * {@inheritdoc}
     */
    public static function isIt(AnonymousMessage $tlMessage)
    {
        return $tlMessage->getType() === 'messages.channelMessages';
    }

    /**
     * @return UserInfoModel[]
     */
    public function getUsers(): array
    {
        $users = [];
        foreach ($this->getTlMessage()->getNodes('users') as $userNode) {
            $user = new UserInfoModel();
            $user->id = $userNode->getValue('id');
            $user->username = $userNode->getValue('username');
            $users[] = $user;
        }

        return $users;
    }

    public function getMessages(): array
    {
        $messages = [];
        foreach ($this->getTlMessage()->getNodes('messages') as $messageNode) {
            // TODO
        }

        return $messages;
    }
}
