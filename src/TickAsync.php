<?php
declare(strict_types=1);

namespace ThenLabs\TickAsync;

use ThenLabs\TaskLoop\Loop;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 * @abstract
 */
abstract class TickAsync
{
    /**
     * @var Loop
     */
    protected static $loop;

    /**
     * @var boolean
     */
    protected static $shutdownFunctionRegistered = false;

    /**
     * @var boolean
     */
    protected static $tickFunctionRegistered = false;

    /**
     * @var boolean
     */
    protected static $activeTick = false;

    public static function getLoop(): Loop
    {
        if (null === static::$loop) {
            static::$loop = new Loop();
        }

        return static::$loop;
    }

    public static function registerShutdownFunction(): void
    {
        if (true === static::$shutdownFunctionRegistered) {
            return;
        }

        register_shutdown_function([static::class, 'shutdownFunction']);

        static::$shutdownFunctionRegistered = true;
    }

    public static function shutdownFunctionIsRegistered(): bool
    {
        return static::$shutdownFunctionRegistered;
    }

    public static function shutdownFunction(): void
    {
        if (! static::$loop instanceof Loop) {
            return;
        }

        $tasks = static::$loop->getTasks();

        while (count($tasks)) {
            static::$loop->runOne();
        }
    }

    public static function registerTask(AsyncTask $task): void
    {
        static::getLoop()->addTask($task);

        static::registerTickFunction();
        static::registerShutdownFunction();
    }

    public static function unregisterTask(AsyncTask $task): void
    {
        static::getLoop()->dropTask($task);
    }

    public static function registerTickFunction(): void
    {
        if (true === static::$tickFunctionRegistered) {
            return;
        }

        static::$tickFunctionRegistered = register_tick_function([
            static::class,
            'tickFunction'
        ]);
    }

    public static function unregisterTickFunction(): void
    {
        unregister_tick_function([static::class, 'tickFunction']);

        static::$tickFunctionRegistered = false;
    }

    public static function tickFunctionIsRegistered(): bool
    {
        return static::$tickFunctionRegistered;
    }

    public static function tickFunction(): void
    {
        static::$activeTick = true;
        static::$loop->runOne();
        static::$activeTick = false;
    }

    public static function hasActiveTick(): bool
    {
        return static::$activeTick;
    }
}
