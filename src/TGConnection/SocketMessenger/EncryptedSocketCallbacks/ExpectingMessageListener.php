<?php

namespace TelegramOSINT\TGConnection\SocketMessenger\EncryptedSocketCallbacks;

use TelegramOSINT\MTSerialization\AnonymousMessage;
use TelegramOSINT\TGConnection\SocketMessenger\MessageListener;

class ExpectingMessageListener implements MessageListener
{
    /**
     * @var AnonymousMessage
     */
    private $expectingResponse;

    public function __construct(&$response)
    {
        $this->expectingResponse = &$response;
    }

    public function onMessage(AnonymousMessage $message)
    {
        $this->expectingResponse = $message;
    }
}
