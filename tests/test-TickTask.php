<?php
declare(strict_types=1);
declare(ticks=1);

use ThenLabs\TickTask\TickTask;

testCase(function () {
    test(function () {
        $counter = 5;

        $task = new TickTask(function ($task) use (&$counter) {
            $counter--;

            if (! $counter) {
                $task->terminate();
                return;
            }
        });

        $this->assertFalse($task->isStarted());

        $task->start();

        $this->assertTrue($task->isStarted());

        while ($counter) {
            $counter = $counter;
        }

        $this->assertTrue($task->isCompleted());
        $this->assertNull($task->getResult());
        $this->assertSame(0, $counter);
    });
});