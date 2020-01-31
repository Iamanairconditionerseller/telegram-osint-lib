<?php

namespace TelegramOSINT\Client\InfoObtainingClient\Models;

class UserInfoModel
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $accessHash;
    /**
     * @var string|null
     */
    public $username;
    /**
     * @var string|null
     */
    public $bio;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var PictureModel
     */
    public $photo;
    /**
     * @var UserStatusModel
     */
    public $status;
    /**
     * @var int
     */
    public $commonChatsCount;
    /**
     * @var string
     */
    public $firstName;
    /**
     * @var string
     */
    public $lastName;
    /**
     * @var string
     */
    public $langCode;
}
