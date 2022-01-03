<?php
declare(ticks=1);

use ThenLabs\TaskLoop\Condition\TimeInterval;

use function ThenLabs\TickAsync\await;
use function ThenLabs\TickAsync\delay;

test(function () {
    $command = sprintf("php %s", __DIR__.'/project1.php');
    exec($command, $outputArray, $returnValue);

    $expected = [
        'async: 1',
        'main: 1',
        'async: 2',
        'main: 2',
        'async: 3',
        'main: 3',
        'async: 4',
        'async: 5',
    ];

    $this->assertSame(0, $returnValue);
    $this->assertEquals($expected, $outputArray);
});

test(function () {
    $command = sprintf("php %s", __DIR__.'/project2.php');
    exec($command, $outputArray, $returnValue);

    $expected = [
        'async1: 1',
        'async1: 2',
        'main: 1',
        'async2: 1',
        'main: 2',
        'async1: 3',
        'main: 3',
        'async2: 2',
        'async1: 4',
        'async2: 3',
        'async1: 5',
        'async2: 4',
        'async1: 6',
        'async2: 5',
        'async1: 7',
    ];

    $this->assertSame(0, $returnValue);
    $this->assertEquals($expected, $outputArray);
});

test(function () {
    $command = sprintf("php %s", __DIR__.'/project3.php');
    exec($command, $outputArray, $returnValue);

    $expected = [
        'main: 1',
        'main: 2',
        'main: 3',
        'async: 1',
        'async: 2',
        'main: 4',
        'main: 5',
        'main: 6',
        'main: 7',
    ];

    $this->assertSame(0, $returnValue);
    $this->assertEquals($expected, $outputArray);
});

test(function () {
    $command = sprintf("php %s", __DIR__.'/project4.php');
    exec($command, $outputArray, $returnValue);

    $expected = [
        'main: 1',
        'main: 2',
        'main: 3',
        'async: 1',
        'async: 2',
        'end',
        'main: 4',
        'main: 5',
        'main: 6',
        'main: 7',
    ];

    $this->assertSame(0, $returnValue);
    $this->assertEquals($expected, $outputArray);
});

test(function () {
    $dateTime1 = new DateTime();
    $condition = new TimeInterval('+1 second');

    await($condition);

    $dateTime2 = new DateTime();
    $diff = $dateTime2->diff($dateTime1);

    $this->assertEquals(1, $diff->s);
});

test(function () {
    $dateTime1 = new DateTime();

    delay('+1 second');

    $dateTime2 = new DateTime();
    $diff = $dateTime2->diff($dateTime1);

    $this->assertEquals(1, $diff->s);
});

test(function () {
    $command = sprintf("php %s", __DIR__.'/project5.php');
    exec($command, $outputArray, $returnValue);

    $expected = [
        'async: 1',
        'main: 1',
        'main: 2',
        'main: 3',
        'async: 2',
        'async: 3',
        'async: 4',
        'async: 5',
    ];

    $this->assertSame(0, $returnValue);
    $this->assertEquals($expected, $outputArray);
});

test(function () {
    $command = sprintf("php %s", __DIR__.'/project6.php');
    exec($command, $outputArray, $returnValue);

    $expected = [
        'async: 1',
        'main: 1',
        'async: 2',
        'main: 2',
        'async: 3',
        'main: 3',
        'async: 4',
        'main: 4',
        'async: 5',
        'main: 5',
        'main: 6',
        'main: 7',
        'main: 8',
        'async: 6',
        'main: 9',
        'async: 7',
        'main: 10',
        'async: 8',
        'async: 9',
        'async: 10',
    ];

    $this->assertSame(0, $returnValue);
    $this->assertEquals($expected, $outputArray);
});