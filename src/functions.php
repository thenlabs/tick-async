<?php
declare(strict_types=1);

namespace ThenLabs\TickAsync;

use ThenLabs\TaskLoop\Condition\AbstractCondition;
use ThenLabs\TaskLoop\Condition\TimeInterval;
use TypeError;

function async(callable $callable, bool $register = true): AsyncTask
{
    $task = new AsyncTask(TickAsync::getLoop(), $callable);

    if ($register) {
        $task->register();
    }

    return $task;
}

/**
 * @param AsyncTask|AbstractCondition $subject
 * @return mixed
 */
function await($subject)
{
    if ($subject instanceof AsyncTask) {
        $task = $subject;
        return $task->await();
    } elseif ($subject instanceof AbstractCondition) {
        $condition = $subject;

        while (! $condition->isFulfilled()) {
            $condition->update();
        }
    } else {
        throw new TypeError('The subject should be an instance of AsyncTask or AbstractCondition.');
    }
}

function delay(string $value): void
{
    await(new TimeInterval($value));
}

function suspendTicks(): void
{
    TickAsync::unregisterTickFunction();
}