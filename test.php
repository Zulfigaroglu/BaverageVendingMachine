<?php

require "autoloader.php";

use Test\BaseTest;
use Test\CabinetTest;
use Test\DoorTest;
use Test\ShelfTest;


$tests = [
    CabinetTest::class,
    ShelfTest::class,
    DoorTest::class,
];

$testCount = 0;
$passedCount = 0;
$failedCount = 0;

foreach ($tests as $test){

    /**
     * @var BaseTest $testInstance
     */
    $testInstance = new $test();

    $testCount += $testInstance->getTestCount();
    $passedCount += $testInstance->getPassedCount();
    $failedCount += $testInstance->getFailedCount();
}

echo $testCount . " tests made\n";
echo $passedCount . " passed (%" . ($passedCount * 100 / $testCount) . ") \n";
echo $failedCount  . " failed (%" . ($failedCount * 100 / $testCount) . ") \n";

