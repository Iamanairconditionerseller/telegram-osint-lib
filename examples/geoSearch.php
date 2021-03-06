<?php

declare(strict_types=1);

use TelegramOSINT\Client\InfoObtainingClient\Models\GeoChannelModel;
use TelegramOSINT\Scenario\GeoSearchScenario;
use TelegramOSINT\Scenario\GroupMembersScenario;
use TelegramOSINT\Scenario\ReusableClientGenerator;

require_once __DIR__.'/../vendor/autoload.php';

const INFO = '--info';

if (!isset($argv[1]) || $argv[1] === INFO || $argv[1] === '--help') {
    $msg = <<<'MSG'
usage: php geoSearch.php lat1,lon1,lat2,lon2,... [username] [limit] [--groups-only]
    lat/lon example: 55.2353
    if username specified, searches user in selected groups, otherwise prints group list only

MSG;

    die($msg);
}

$points = array_chunk(explode(',', $argv[1]), 2);
foreach($points as &$point) {
    foreach ($point as &$coord) {
        $coord = (float) $coord;
    }
}

$username = null;
if (isset($argv[2]) && $argv[2] != INFO && $argv[2] != '--') {
    $username = $argv[2];
}

$groupsOnlyKey = '--groups-only';
$groupsOnly = false;

$limit = 100;
if (isset($argv[3]) && $argv[3] != INFO && $argv[3] != $groupsOnlyKey) {
    $limit = (int) $argv[3];
}

if (isset($argv[3]) && $argv[3] == $groupsOnlyKey) {
    $groupsOnly = true;
}

if (isset($argv[4]) && $argv[4] == $groupsOnlyKey) {
    $groupsOnly = true;
}

$generator = new ReusableClientGenerator();

$finders = [];
$groupHandler = function (GeoChannelModel $model) use (&$generator, &$finders, $username) {
    $membersFinder = new GroupMembersScenario(
        $model->getGroupId(),
        null,
        $generator,
        100,
        $username
    );

    $membersFinder->startActions(false);
    $finders[] = $membersFinder;
};

/* @noinspection PhpUnhandledExceptionInspection */
$search = new GeoSearchScenario($points, $groupsOnly ? null : $groupHandler, $generator, $limit);
/* @noinspection PhpUnhandledExceptionInspection */
$search->startActions();
