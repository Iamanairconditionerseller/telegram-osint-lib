<?php

namespace TelegramOSINT\TLMessage\TLMessage\ClientMessages\Api;

use TelegramOSINT\TLMessage\TLMessage\Packer;
use TelegramOSINT\TLMessage\TLMessage\TLClientMessage;

/**
 * Class get_all_chats
 *
 * @see https://core.telegram.org/method/messages.getAllChats
 */
class get_all_chats implements TLClientMessage
{
    const CONSTRUCTOR = -341307408; // 0xeba80ff0

    /** @var int[] */
    private $exceptIds;

    /**
     * @param int[] $exceptIds
     */
    public function __construct(array $exceptIds = [])
    {
        $this->exceptIds = $exceptIds;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'get_all_chats';
    }

    /**
     * @return callable
     */
    private function getElementGenerator()
    {
        return function ($exceptId) {
            return Packer::packInt((int) $exceptId);
        };
    }

    /**
     * {@inheritdoc}
     */
    public function toBinary()
    {
        return
            Packer::packConstructor(self::CONSTRUCTOR).
            Packer::packVector($this->exceptIds, $this->getElementGenerator());
    }
}
