<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use TelegramOSINT\Logger\Logger;
use TelegramOSINT\Scenario\GroupMessagesScenario;
use TelegramOSINT\Scenario\GroupResolverScenario;
use TelegramOSINT\Scenario\Models\GroupId;
use TelegramOSINT\Scenario\Models\GroupRequest;
use TelegramOSINT\Scenario\Models\OptionalDateRange;
use TelegramOSINT\Scenario\ReusableClientGenerator;

const INFO = '--info';

/** @var int|null $groupId */
$groupId = null;
/** @var string|null $username */
$username = null;
/** @var int|null $timestampStart */
$timestampStart = null;
/** @var int|null $timestampEnd */
$timestampEnd = null;
if (!isset($argv[1]) || isset($argv[1]) && $argv[1] === '--help') {
    echo <<<'TXT'
Usage: php parseGroupMessages.php groupId|deepLink [username] [timestampStart] [timestampEnd] [--info]
    deepLink ex.: https://t.me/vityapelevin
    if you do not need username filter (but need timestamp filter), please specify -- as value
TXT;
    die();
}

if ($argv[1] !== INFO) {
    if (is_numeric($argv[1])) {
        $groupId = (int) $argv[1];
    } else {
        $deepLink = $argv[1];
    }
}

if (isset($argv[2]) && $argv[2] !== INFO && $argv[2] !== '--') {
    $username = $argv[2];
}

if (isset($argv[3]) && $argv[3] !== INFO) {
    $timestampStart = (int) $argv[3];
}

if (isset($argv[4]) && $argv[4] !== INFO) {
    $timestampEnd = (int) $argv[4];
}
$generator = new ReusableClientGenerator();
$request = $groupId
    ? GroupRequest::ofGroupId($groupId)
    : GroupRequest::ofUserName($deepLink);

/**
 * @param ?int $groupId
 * @param ?int $accessHash
 */
$onGroupReady = function ($groupId, $accessHash = null) use ($timestampStart, $timestampEnd, $username, $generator) {
    if (!$groupId || !$accessHash) {
        Logger::log('parseGroupMessages', 'Group not found');

        return;
    }

    /** @var int $accessHash */
    $client = new GroupMessagesScenario(
        new GroupId($groupId, $accessHash),
        $generator,
        new OptionalDateRange(
            $timestampStart,
            $timestampEnd,
        ),
        null,
        $username,
        100,
        true
    );

    $client->startActions(false);
};

Logger::log(__FILE__, 'starting group resolver for '.$request);
$resolver = new GroupResolverScenario($request, $generator, $onGroupReady);
/** @noinspection PhpUnhandledExceptionInspection */
$resolver->startActions();
