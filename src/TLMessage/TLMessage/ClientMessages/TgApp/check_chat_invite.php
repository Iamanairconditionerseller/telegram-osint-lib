<?php

declare(strict_types=1);

namespace TelegramOSINT\TLMessage\TLMessage\ClientMessages\TgApp;

use TelegramOSINT\TLMessage\TLMessage\Packer;
use TelegramOSINT\TLMessage\TLMessage\TLClientMessage;

/**
 * @see https://core.telegram.org/method/messages.checkChatInvite
 */
class check_chat_invite implements TLClientMessage
{
    const CONSTRUCTOR = 1051570619; // 0x3eadb1bb

    /** @var string */
    private $hash;

    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'check_chat_invite';
    }

    /**
     * {@inheritdoc}
     */
    public function toBinary()
    {
        return Packer::packConstructor(self::CONSTRUCTOR).
            Packer::packString($this->hash);
    }
}
